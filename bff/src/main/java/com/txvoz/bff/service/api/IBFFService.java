/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.service.api;

import javax.servlet.http.HttpServletRequest;

import com.txvoz.bff.dto.ServerResourceDto;

/**
 * Abstraction to validate request
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
public interface IBFFService {

	String exectute(HttpServletRequest httpRequest);
	
}
