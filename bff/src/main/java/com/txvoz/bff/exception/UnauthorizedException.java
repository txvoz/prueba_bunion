/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 22/10/2022
 */
package com.txvoz.bff.exception;

import org.springframework.http.HttpStatus;

import lombok.Getter;

/**
 * Unauthorized Exception
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@Getter
public class UnauthorizedException extends BasicException {
	/**
	 * 
	 */
	private static final long serialVersionUID = -1749937115467232084L;

	public UnauthorizedException() {
		super("Unauthorized", HttpStatus.UNAUTHORIZED);
	}

	
}
