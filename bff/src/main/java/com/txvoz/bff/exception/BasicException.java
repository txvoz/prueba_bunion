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
 * Basic Exception
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@Getter
public class BasicException extends RuntimeException {
	
	private static final long serialVersionUID = 4626320923907664175L;
	
	private HttpStatus status;
	
	public BasicException(String message, HttpStatus status) {
		super(message);
		this.status = status;
	}

}
