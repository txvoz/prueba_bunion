/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.dto;

import java.io.Serializable;
import java.util.Map;

import com.txvoz.bff.config.ResourceProps.JwtConfig;
import com.txvoz.bff.config.ResourceProps.RsaConfig;
import com.txvoz.bff.constant.ERequestMethod;

import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;

/**
 * Resource DTO
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@Data
@Builder
@AllArgsConstructor
@NoArgsConstructor
public class ServerResourceDto implements Serializable{

	private static final long serialVersionUID = -2579304211012508257L;
	
	private String host;
	private ERequestMethod method;
	private String serviceName;
	private String path;
	private String originPath;
	private String resourcePath;
	private String finalPath;
	private String finaFullPath;
	private String suffixPath;
	private String suffixParams;
	private String[] partsOtPath;
	private Map<String, String> headers;
	private Map<String, String[]> queryParams;
	private String body;
	private boolean needValidateJwt;
	private boolean jwtExcluded;
	private boolean needDecrypt;
	private boolean decryptExcluded;
	private RsaConfig rsaConfig;
	private JwtConfig jwtConfig;
}
