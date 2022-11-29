/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.service.api;

import java.util.Map;

import com.txvoz.bff.config.ResourceProps.JwtConfig;

/**
 * Abstraction to validate Jwt token
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
public interface IJwtService {
	
	boolean validateToken(JwtConfig config, Map<String, String> headers);

}
