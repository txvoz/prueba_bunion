/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.config;

import java.util.List;

import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.stereotype.Component;

import lombok.Data;

/**
 * Resource Properties
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@Data
@ConfigurationProperties("gateway")
@Component
public class ResourceProps {
	
	private List<Resource> resources;
	
	@Data
	public static class Resource {
		
		private String host;
		private String serviceName;
		private JwtConfig jwtConfig;
		private RsaConfig rsaConfig;
	
	}
	
	@Data
	public static class JwtConfig {
	
		private String path;
		private boolean activate;
		private String scope;
		private String identifierValue;
		private String[] excluded;
	
	}
	
	@Data
	public static class RsaConfig {
	
		private String path;
		private boolean activate;
		private String keyPar;
		private String[] excluded;
	
	}

}
