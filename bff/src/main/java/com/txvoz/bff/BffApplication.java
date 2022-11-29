/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.context.properties.EnableConfigurationProperties;
import org.springframework.cloud.openfeign.EnableFeignClients;

@EnableFeignClients(basePackages = { "com.txvoz.bff.feign" })
@EnableConfigurationProperties
@EnableAutoConfiguration
@SpringBootApplication
public class BffApplication {

	public static void main(String[] args) {
		SpringApplication.run(BffApplication.class, args);
	}

}
