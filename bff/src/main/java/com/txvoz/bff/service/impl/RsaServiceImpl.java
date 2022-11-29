package com.txvoz.bff.service.impl;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.HashMap;
import java.util.UUID;
import java.util.logging.Level;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.txvoz.bff.config.ResourceProps.RsaConfig;
import com.txvoz.bff.dto.RsaRequestDto;
import com.txvoz.bff.dto.RsaResponseDto;
import com.txvoz.bff.exception.UndecryptedException;
import com.txvoz.bff.feign.IRsaFeignClient;
import com.txvoz.bff.service.api.ILogService;
import com.txvoz.bff.service.api.IRsaService;

import feign.Feign;
import feign.Logger;
import feign.jackson.JacksonDecoder;
import feign.jackson.JacksonEncoder;
import feign.slf4j.Slf4jLogger;

@Service
public class RsaServiceImpl implements IRsaService {
	@Autowired
	ILogService logService;

	@Override
	public RsaResponseDto decrypt(String encryptValue, RsaConfig config) {
		logService.writeGenericLog(Level.INFO, ">>> RSA CALLING", encryptValue);
		
		IRsaFeignClient client = Feign.builder()
				.logger(new Slf4jLogger("INFO"))
				.logLevel(Logger.Level.HEADERS)
				.encoder(new JacksonEncoder())
				.decoder(new JacksonDecoder())
				.target(IRsaFeignClient.class, config.getPath());
		
		RsaRequestDto request = RsaRequestDto.builder()
				.idTx(UUID.randomUUID().toString())
				.decryptText(encryptValue)
				.nameKeyPar(config.getKeyPar())
				.build();
		
		logService.writeGenericLog(Level.INFO, ">>> RSA IDTX", request.getIdTx());
		logService.writeGenericLog(Level.INFO, ">>> RSA KEY_PAR", request.getNameKeyPar());
	
		try {
			HashMap<String, String> headers = new HashMap<>();
			headers.put("Content-Type", "application/json");
			
			RsaResponseDto rsaResponse = client.decript(
					new URI(config.getPath()), 
					headers,
					request);
			
			logService.writeGenericLog(Level.INFO, ">>> RSA STATUS", rsaResponse.isSuccess()+"");
			if(!rsaResponse.isSuccess()) {
				throw new UndecryptedException();
			}
			return rsaResponse;
		} catch (Exception e) {
			logService.writeGenericLog(Level.INFO, ">>> RSA EXCEPTION", e.getMessage());
			e.printStackTrace();
		}
		
		throw new UndecryptedException();
	}

}
