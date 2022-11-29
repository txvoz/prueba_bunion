/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.controller;

import java.util.logging.Level;

import javax.servlet.http.HttpServletRequest;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.txvoz.bff.service.api.IBFFFileService;
import com.txvoz.bff.service.api.IBFFService;
import com.txvoz.bff.service.api.ILogService;


/**
 * Gateway controller
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */

@RestController
@RequestMapping("*")
@CrossOrigin(origins = "*" )
public class RestRepresentationController {
	
	@Autowired
	ILogService logService;
	
	@Autowired
	private IBFFService service;
	
	@Autowired
	private IBFFFileService fileService;
	
	/*@GetMapping(value = "/{controller}")
	public Object getMethod(HttpServletRequest httpRequest) {
		
		System.out.println("Llego");
		
		Object response;
		logService.writeGenericLog(Level.INFO, "****** INIT BFF-METHOD ", httpRequest.getMethod() + " ******");
		String data = service.exectute(httpRequest);
		response = ResponseEntity.ok()
				.contentType(MediaType.APPLICATION_JSON)
	            .body(data);
		
		logService.writeObjectLog(Level.INFO, ">>> RESPONSE", data);
		logService.writeGenericLog(Level.INFO, "****** END BFF-METHOD ", httpRequest.getMethod() + " ******");
		
		return response;
	}*/

	
	@RequestMapping(value = { "/*", "/*/*", "/*/*/*", "/*/*/*/*", "/*/*/*/*/*" })
	public Object method(HttpServletRequest httpRequest) {
		
		Object response;
		
		if(httpRequest.getRequestURL().toString().contains("/printer/generate-voucher")) {
			logService.writeGenericLog(Level.INFO, "****** INIT ", "GENERATE-VOUCHER ******");
			byte[] resource = fileService.exectute(httpRequest);
			response = ResponseEntity.ok()
		            .contentLength(resource.length)
		            .contentType(MediaType.APPLICATION_PDF)
		            .body(resource);
			
			logService.writeObjectLog(Level.INFO, ">>> RESPONSE", "THIS IS FILE");
		} else {
			logService.writeGenericLog(Level.INFO, "****** INIT GATEWAY-METHOD ", httpRequest.getMethod() + " ******");
			String data = service.exectute(httpRequest);
			response = ResponseEntity.ok()
					.contentType(MediaType.APPLICATION_JSON)
		            .body(data);
			
			logService.writeObjectLog(Level.INFO, ">>> RESPONSE", data);
		}
	
		logService.writeGenericLog(Level.INFO, "****** END GATEWAY-METHOD ", httpRequest.getMethod() + " ******");
		
		return response;
	}
	
}
