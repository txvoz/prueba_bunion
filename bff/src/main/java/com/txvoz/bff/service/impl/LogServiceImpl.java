package com.txvoz.bff.service.impl;

import java.io.File;
import java.nio.file.NoSuchFileException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.logging.FileHandler;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.logging.SimpleFormatter;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.txvoz.bff.config.LogProps;
import com.txvoz.bff.service.api.ILogService;

@Service
public class LogServiceImpl implements ILogService{
	
	@Autowired
	private ObjectMapper mapper;
	
	@Autowired
	private LogProps propertiesData;
	
	private static Logger logger = Logger.getLogger(LogServiceImpl.class.getName());

	@Override
	public void writeGenericLog(Level level, String idTrx, String message) {
		if(!propertiesData.getEnable()) {
			return;
		}
		
		if(!level.equals(Level.INFO) && !level.equals(Level.WARNING) && !level.equals(Level.SEVERE)) {
			return;
		}
		
		logger.setLevel(Level.ALL);
        logger.setUseParentHandlers(propertiesData.getConsole());
        
		Date date = new Date();  
	    SimpleDateFormat formatterTime = new SimpleDateFormat("dd-MM-yyyy");  
	    String strDate = formatterTime.format(date);
	    
		SimpleDateFormat formatterTimeMili = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss.SSS");  
		String strDateMili = formatterTimeMili.format(date);
		StringBuilder builder = new StringBuilder(1000);
		builder.append(strDateMili).append(" - ");
        builder.append("[").append("com.txvoz.bff.log").append("] - ");
        builder.append("[").append(propertiesData.getPrefix()).append("] - ");
        builder.append("[").append(level).append("] - ");
        builder.append(idTrx + " - ");
        builder.append(message);
        
        try {	
        	String basePath = propertiesData.getPathInfo();
        	if(Level.SEVERE.equals(level)) {
        		basePath = propertiesData.getPathError();
        	}
        	
			final String FILE_PATH =  basePath + propertiesData.getPrefix() + "-" + strDate + ".log";
			try {
				FileHandler fh = new FileHandler(FILE_PATH, true);
				 logger.addHandler(fh);
				 SimpleFormatter formatter = new SimpleFormatter();  
				 fh.setFormatter(formatter);  
				 logger.info(builder.toString());
	            fh.close();
			} catch(NoSuchFileException e) {
				try {
					File NEW_FILE_PATH = new File(FILE_PATH);
					if(NEW_FILE_PATH.createNewFile()) {
						System.out.println("Archivo creado: " + FILE_PATH);
					}
					writeGenericLog(level, idTrx, message);
				} catch (Exception f) {
					logger.log(level, builder.toString());
					System.out.println("Error al escribir log " + level + " SrvGMF:  " + f.getLocalizedMessage() + " "  + FILE_PATH );
				}
			}
		} catch (Exception e) {
			logger.log(level, builder.toString());
			System.out.println("Error al escribir log " +level+ " SrvGMF:  " + e.getLocalizedMessage() );
		}
	}
	
	@Override
	public <T> void writeObjectLog(Level info, String message, T object) {
		String decode = "";
		
		if(object instanceof String) {
			decode = (String)object;
		} else {
			try {
				decode = mapper.writeValueAsString(object);	
			} catch (JsonProcessingException e) {
				decode = "Error decode object";
				e.printStackTrace();
			}
		}
		
		writeGenericLog(info, message, decode);
	}

}
