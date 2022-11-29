package com.txvoz.bff.service.impl;

import java.io.File;
import java.io.InputStream;
import java.net.URI;

import javax.servlet.http.HttpServletRequest;

import org.apache.commons.io.FileUtils;
import org.springframework.stereotype.Service;

import com.txvoz.bff.dto.ServerResourceDto;
import com.txvoz.bff.exception.RemoteException;
import com.txvoz.bff.feign.IResouceFileFeignClient;
import com.txvoz.bff.service.api.IBFFFileService;

import feign.Feign;
import feign.Logger;
import feign.Response;
import feign.slf4j.Slf4jLogger;

@Service
public class BFFFileServiceImpl extends BaseBffService implements IBFFFileService {
	
	private static final String path = "/var/tmp";
	//private static final String path = "E:\\\\workspace\\\\tmp\\\\";
	

	@Override
	public byte[] exectute(HttpServletRequest httpRequest) {
		
		ServerResourceDto resource = validateRequest(httpRequest);

		// Validate if is need validate jwt
		validateJwtToken(resource);

		// Validate if is need decrypt request
		String request = convertRequest(resource);
		System.out.println("Request convertido " + request);
		resource.setBody(request);

		IResouceFileFeignClient client = Feign
				.builder()
				.logger(new Slf4jLogger("INFO"))
				.logLevel(Logger.Level.HEADERS)
				.target(IResouceFileFeignClient.class, resource.getFinaFullPath().replace("/resource", ""));

		byte[] result = null;

		try {

			resource.getHeaders().remove("content-length");
			resource.getHeaders().remove("Content-Length");
			
			Response response = client.getPDF(new URI(resource.getFinaFullPath().replace("/resource", "")), resource.getHeaders(), request.trim());
			if (response.status() == 200) {
			    File downloadFile = new File(path, "test_download.pdf");
			    FileUtils.copyInputStreamToFile(response.body().asInputStream(), downloadFile);
			    return FileUtils.readFileToByteArray(downloadFile);
			}
			
			return null;
			
		} catch (Exception e) {
			System.out.println("Error al llamar al servicio rest => " + e.getMessage());
			e.printStackTrace();
			throw new RemoteException();
		}
	}

}
