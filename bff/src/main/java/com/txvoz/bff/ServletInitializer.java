/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff;

import org.springframework.boot.builder.SpringApplicationBuilder;
import org.springframework.boot.web.servlet.support.SpringBootServletInitializer;


//public class ServletInitializer {}
public class ServletInitializer extends SpringBootServletInitializer {

	@Override
	protected SpringApplicationBuilder configure(SpringApplicationBuilder application) {
		return application.sources(BffApplication.class);
	}

}
