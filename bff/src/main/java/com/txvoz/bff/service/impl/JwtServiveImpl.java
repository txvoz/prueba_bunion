package com.txvoz.bff.service.impl;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.HashMap;
import java.util.Map;
import java.util.logging.Level;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.txvoz.bff.config.ResourceProps.JwtConfig;
import com.txvoz.bff.dto.JwtRequestDto;
import com.txvoz.bff.feign.IJwtFeignClient;
import com.txvoz.bff.service.api.IJwtService;
import com.txvoz.bff.service.api.ILogService;

import feign.Feign;
import feign.Logger;
import feign.jackson.JacksonDecoder;
import feign.jackson.JacksonEncoder;
import feign.slf4j.Slf4jLogger;

@Service
public class JwtServiveImpl implements IJwtService {
	@Autowired
	ILogService logService;

	@Override
	public boolean validateToken(JwtConfig config, Map<String, String> requestHeaders) {
		logService.writeGenericLog(Level.INFO, ">>> JWT IDENTIFIER", config.getIdentifierValue());
		
		String token = requestHeaders.get(config.getIdentifierValue());
		logService.writeGenericLog(Level.INFO, ">>> JWT TOKEN", token);
		
		IJwtFeignClient client = Feign.builder()
				.logger(new Slf4jLogger("INFO"))
				.logLevel(Logger.Level.HEADERS)
				.encoder(new JacksonEncoder())
				.decoder(new JacksonDecoder())
				.target(IJwtFeignClient.class, config.getPath());
		
		JwtRequestDto request = JwtRequestDto.builder()
				.token(token)
				.scope(config.getScope())
				.build();
		
		logService.writeGenericLog(Level.INFO, ">>> JWT SCOPE", request.getScope());
	
		try {
			
			HashMap<String, String> headers = new HashMap<>();
			headers.put("Content-Type", "application/json");
			
			boolean isAuthorized = client.validate(
					new URI(config.getPath()), 
					headers,
					request).isActive();
			
			logService.writeGenericLog(Level.INFO, ">>> JWT STATUS", isAuthorized+"");
			
			return isAuthorized;
		} catch (URISyntaxException e) {
			logService.writeGenericLog(Level.INFO, ">>> JWT EXCEPTION ", e.getMessage());
			e.printStackTrace();
		}
		
		return false;
	}

}
