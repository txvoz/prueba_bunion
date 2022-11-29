/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 22/10/2022
 */
package com.txvoz.bff.exception;

import org.springframework.http.HttpStatus;

import feign.FeignException;
import lombok.Getter;

/**
 * Remote Exception
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@Getter
public class RemoteException extends BasicException {
	
	private static final long serialVersionUID = -6232084L;

	public RemoteException() {
		super("Remote connection exception", HttpStatus.BAD_GATEWAY);

	}
	
	public RemoteException(String message, HttpStatus status) {
		super(message, status);
	}

}
