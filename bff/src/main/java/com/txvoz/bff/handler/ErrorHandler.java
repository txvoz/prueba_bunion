package com.txvoz.bff.handler;

import java.util.ArrayList;
import java.util.logging.Level;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.Ordered;
import org.springframework.core.annotation.Order;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ExceptionHandler;
import org.springframework.web.context.request.WebRequest;
import org.springframework.web.servlet.mvc.method.annotation.ResponseEntityExceptionHandler;

import com.txvoz.bff.exception.BasicException;
import com.txvoz.bff.service.api.ILogService;

import feign.FeignException;

/**
 * Error Handler
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
@SuppressWarnings({ "unchecked", "rawtypes" })
@Order(Ordered.HIGHEST_PRECEDENCE)
@ControllerAdvice
public class ErrorHandler extends ResponseEntityExceptionHandler {
	
	@Autowired
	ILogService logService;
	
	private final Logger log = LoggerFactory.getLogger(getClass());

	@ExceptionHandler(Exception.class)
	public ResponseEntity<Object> handleGenericException(Exception ex, WebRequest request) {

		log.error("Exception::handleGenericException", ex);
		
		if(ex instanceof FeignException) {
			FeignException feignException = (FeignException) ex;
			feignException.responseBody().get().asReadOnlyBuffer();
			
			String response = new String(feignException.responseBody().get().array());
			
			logService.writeObjectLog(Level.SEVERE, ">>> Error - handleGenericException::FeignException", response);
			
			return super.handleExceptionInternal(ex, response , new org.springframework.http.HttpHeaders(),
					HttpStatus.valueOf(feignException.status()), request);
		}
		
		if(ex instanceof BasicException) {
			BasicException basicException = (BasicException) ex;
			org.springframework.http.HttpHeaders headers = new org.springframework.http.HttpHeaders();

			;
			headers.put("Content-Type", new ArrayList<String>(){{
				   add("application/json");
				}});
			
			String response = basicException.getMessage();
			
			logService.writeObjectLog(Level.SEVERE, ">>> Error - handleGenericException::BasicException", response);
			
			return super.handleExceptionInternal(ex, response, headers,
					basicException.getStatus(), request);
		}

		logService.writeObjectLog(Level.SEVERE, ">>> Error - handleGenericException", request);
		
		return super.handleExceptionInternal(ex, "Undefined", new org.springframework.http.HttpHeaders(),
				HttpStatus.BAD_GATEWAY, request);
	}

}
