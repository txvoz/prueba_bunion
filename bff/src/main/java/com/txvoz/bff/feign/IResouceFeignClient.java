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

import feign.HeaderMap;
import feign.RequestLine;

@FeignClient(
	name = "RESTCLIENT",
	configuration = FeignConfiguration.class 	
)
public interface IResouceFeignClient {

    @RequestLine("GET")
    public String getMethod(URI baseUri, @HeaderMap Map<String, String> headers); 
 
    @RequestLine("DELETE")
    public String deleteMethod(URI baseUri, @HeaderMap Map<String, String> headers);
    
    @RequestLine("POST")
    public String postMethod(URI baseUri, @HeaderMap Map<String, String> headers, @RequestBody String body);
    
    @RequestLine("PUT")
    public String putMethod(URI baseUri, @HeaderMap Map<String, String> headers, @RequestBody String body);

}
