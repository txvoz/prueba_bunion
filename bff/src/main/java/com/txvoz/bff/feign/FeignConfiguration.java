/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 22/10/2022
 */
package com.txvoz.bff.feign;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.context.annotation.Bean;
import com.fasterxml.jackson.databind.ObjectMapper;

import feign.Response;
import feign.Util;
import feign.codec.ErrorDecoder;

/**
 * Feign configuration
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
public class FeignConfiguration implements ErrorDecoder {
	private ErrorDecoder errorDecoder = new Default();
	
	private final Logger log = LoggerFactory.getLogger(getClass());
	
	ObjectMapper mapper = new ObjectMapper();

	@Override
	public Exception decode(String methodKey, Response response) {
		log.error("Error status in FiatFeignConfiguration::", methodKey);
		
		System.out.println(">> MethodKey " + methodKey);
		
		String body;
		try {
			body = Util.toString(response.body().asReader());
		} catch  (Exception e) {
			log.error("Error status in IFiatFeignClient::getCommerce", e.getCause());
			return new RuntimeException("Generic Fiat api error, not read body from request");
		}
		
		System.out.println("Body Response > " + body);
		 return errorDecoder.decode(methodKey, response);
	}
	
	@Bean
	public ErrorDecoder errorDecoder() {
	    return new FeignConfiguration();
	}
	
}
