/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 22/10/2022
 */
package com.txvoz.bff.feign;

import java.net.URI;
import java.util.Map;

import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.web.bind.annotation.RequestBody;

import com.txvoz.bff.dto.JwtRequestDto;
import com.txvoz.bff.dto.JwtResponseDto;
import com.txvoz.bff.dto.RsaRequestDto;
import com.txvoz.bff.dto.RsaResponseDto;

import feign.HeaderMap;
import feign.RequestLine;

/**
 * Jwt Feign Client
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@FeignClient(
	name = "JWTCLIENT",
	configuration = FeignConfiguration.class 
)
public interface IJwtFeignClient {

    @RequestLine("POST")
    public JwtResponseDto validate(URI baseUri, @HeaderMap Map<String, String> headers, @RequestBody JwtRequestDto body);

}
