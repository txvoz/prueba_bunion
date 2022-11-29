/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.constant;

import java.util.Arrays;

import lombok.AllArgsConstructor;
import lombok.Getter;

/**
 * Enum to types of methods
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@AllArgsConstructor
@Getter
public enum ERequestMethod {
	POST("POST"),
	PUT("PUT"),
	DELETE("DELETE"),
	GET("GET");
	
	private String label;
	
	public static ERequestMethod findByLabel(String code) {
		return Arrays.stream(values())
		          .filter(bl -> bl.label.equalsIgnoreCase(code))
		          .findFirst()
		          .orElse(POST);
	}
}
