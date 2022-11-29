package com.txvoz.bff.service.impl;

import java.net.URI;
import java.net.URISyntaxException;
import java.util.logging.Level;

import javax.servlet.http.HttpServletRequest;

import org.springframework.cloud.openfeign.FeignClientsConfiguration;
import org.springframework.context.annotation.Import;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;

import com.txvoz.bff.dto.ServerResourceDto;
import com.txvoz.bff.exception.RemoteException;
import com.txvoz.bff.feign.IResouceFeignClient;
import com.txvoz.bff.service.api.IBFFService;

import feign.Feign;
import feign.FeignException;
import feign.Logger;
import feign.jackson.JacksonDecoder;
import feign.jackson.JacksonEncoder;
import feign.slf4j.Slf4jLogger;

@Service
@Import(FeignClientsConfiguration.class)
public class BFFServiceImpl extends BaseBffService implements IBFFService {
	
	@Override
	public String exectute(HttpServletRequest httpRequest) {
		ServerResourceDto resource = validateRequest(httpRequest);
		
		//Validate if is need validate jwt
		validateJwtToken(resource);
		
		//Validate if is need decrypt request
		/*String request = convertRequest(resource).trim();
		resource.setBody(request);
		this.logService.writeObjectLog(Level.INFO, ">>> FINAL RESOURCE OBJECT", resource);*/

		IResouceFeignClient client = Feign.builder()
				.logger(new Slf4jLogger("INFO"))
				.logLevel(Logger.Level.HEADERS)
				.target(IResouceFeignClient.class, resource.getFinaFullPath());

		String result = null;
		
		try {
			
			switch (resource.getMethod()) {
			case POST:
			case PUT:
				resource.getHeaders().remove("content-length");
				resource.getHeaders().remove("Content-Length");
				result = client.postMethod(new URI(resource.getFinaFullPath()), resource.getHeaders(),
						resource.getBody().trim());
				break;
			default:
				result = client.getMethod(new URI(resource.getFinaFullPath()), resource.getHeaders());
				break;
			}

		} catch (Exception e) {
			this.logService.writeGenericLog(Level.INFO, ">>> EXCEPTION CALLING METHOD", e.getMessage());
			e.printStackTrace();
			if(e instanceof FeignException) {
				FeignException fe = (FeignException) e;
				throw new RemoteException(new String(fe.responseBody().get().array()), HttpStatus.valueOf(fe.status()));
			}
			
			throw new RemoteException();
		}
		
		
		this.logService.writeObjectLog(Level.INFO, ">>> API RESPONSE ", result);
		return result;
	}

	

}
