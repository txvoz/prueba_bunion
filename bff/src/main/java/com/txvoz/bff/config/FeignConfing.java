/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 22/10/2022
 */
package com.txvoz.bff.config;

import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.http.converter.json.MappingJackson2HttpMessageConverter;

import com.fasterxml.jackson.databind.DeserializationFeature;
import com.fasterxml.jackson.databind.ObjectMapper;

/**
 * Configurarion to feign clients
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@Configuration
public class FeignConfing {
	
	  @Bean
	  public ObjectMapper objectMapper() {
	    ObjectMapper mapper = new ObjectMapper();
	    mapper.configure(DeserializationFeature.FAIL_ON_UNKNOWN_PROPERTIES, false);
	    return mapper;
	  }

	  @Bean
	  public MappingJackson2HttpMessageConverter converter() {
	    final MappingJackson2HttpMessageConverter converter = new MappingJackson2HttpMessageConverter();
	    converter.setObjectMapper(objectMapper());
	    return converter;
	  }

	  @Bean
	  public ObjectMapper mapper() {
		  return new ObjectMapper();
	  }
}
