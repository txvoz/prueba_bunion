package com.txvoz.bff.config;


import org.springframework.boot.context.properties.ConfigurationProperties;
import org.springframework.stereotype.Component;

import lombok.Data;

@Data
@ConfigurationProperties("logs")
@Component
public class LogProps {
	
	private String prefix;
	
	private Boolean console;
	
	private Boolean enable;
	
	private String pathInfo;
	
	private String pathError;
}
