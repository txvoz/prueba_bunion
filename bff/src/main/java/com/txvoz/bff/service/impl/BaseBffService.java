package com.txvoz.bff.service.impl;

import java.io.IOException;
import java.util.Arrays;
import java.util.Collections;
import java.util.Map;
import java.util.Objects;
import java.util.logging.Level;
import java.util.stream.Collectors;

import javax.servlet.http.HttpServletRequest;

import org.apache.commons.io.IOUtils;
import org.apache.logging.log4j.util.Strings;
import org.springframework.beans.factory.annotation.Autowired;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonMappingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.txvoz.bff.config.ResourceProps;
import com.txvoz.bff.config.ResourceProps.Resource;
import com.txvoz.bff.constant.ERequestMethod;
import com.txvoz.bff.dto.ServerResourceDto;
import com.txvoz.bff.exception.UnauthorizedException;
import com.txvoz.bff.service.api.IJwtService;
import com.txvoz.bff.service.api.ILogService;
import com.txvoz.bff.service.api.IRsaService;

import feign.FeignException.NotFound;
import lombok.Getter;

@Getter
public abstract class BaseBffService {
	@Autowired
	ILogService logService;

	@Autowired
	private ResourceProps props;
	
	@Autowired
	private IRsaService rsaService;
	
	@Autowired
	private IJwtService jwtService;

	@Autowired
	private ObjectMapper mapper;
	
	
	public void validateJwtToken(ServerResourceDto resource) {
		if(resource.isNeedValidateJwt()) {	
			if(!jwtService.validateToken(resource.getJwtConfig(), resource.getHeaders())) {
				throw new UnauthorizedException();
			}
		}
	}
	
	public String convertRequest(ServerResourceDto resource) {
		if (resource.getMethod().equals(ERequestMethod.POST) || resource.getMethod().equals(ERequestMethod.PUT)) {
			this.logService.writeGenericLog(Level.INFO, ">>> ORIGIN BODY ", resource.getBody());
			
			if (!resource.isNeedDecrypt()) {
				return resource.getBody();
			}

			try {
				String[] data = mapper.readValue(resource.getBody(), String[].class);
				StringBuilder strBuilder = new StringBuilder();
				
				for (String encryptValue : data) {
					strBuilder.append(rsaService.decrypt(encryptValue, resource.getRsaConfig()).getPlaintext());
				}
				
				String decryptValue = strBuilder.toString().replaceAll("'", "\"");
				this.logService.writeGenericLog(Level.INFO, ">>> DECRYPT BODY ", decryptValue);
				
				return decryptValue;

			} catch (JsonMappingException e) {
				e.printStackTrace();
			} catch (JsonProcessingException e) {
				e.printStackTrace();
			}
			return Strings.EMPTY;
		}
		return Strings.EMPTY;
	}

	public ServerResourceDto validateRequest(HttpServletRequest httpRequest) {
		

		String serviceName = getServiceName(httpRequest);
		this.logService.writeGenericLog(Level.INFO, ">>> SERVICE NAME", serviceName);
		
		Resource configResource = validateServiceName(serviceName);
		this.logService.writeObjectLog(Level.INFO, ">>> CONFIG RESOUCE", configResource);

		ServerResourceDto resource = ServerResourceDto.builder()
				.serviceName(serviceName)
				.host(configResource.getHost())
				.headers(getHeaders(httpRequest))
				.queryParams(getQueryParams(httpRequest))
				.method(ERequestMethod.findByLabel(httpRequest.getMethod()))
				.partsOtPath(getPartsOfPath(httpRequest))
				.path(getFullURL(httpRequest))
				.originPath(new String(httpRequest.getRequestURL()))
				.resourcePath(getResourcePath(httpRequest, configResource, false, false))
				.finalPath(getResourcePath(httpRequest, configResource, true, false))
				.finaFullPath(getResourcePath(httpRequest, configResource, true, true))
				.suffixPath(getSuffixPath(httpRequest, serviceName))
				.suffixParams(httpRequest.getQueryString())
				.needValidateJwt(isJwtActive(getSuffixPath(httpRequest, serviceName), configResource, httpRequest))
				.needDecrypt(isDecriptActive(getSuffixPath(httpRequest, serviceName), configResource, httpRequest))
				.jwtExcluded(isJwtExcluded(getSuffixPath(httpRequest, serviceName), configResource))
				.decryptExcluded(isDecryptExcluded(getSuffixPath(httpRequest, serviceName), configResource))
				.rsaConfig(configResource.getRsaConfig())
				.jwtConfig(configResource.getJwtConfig())
				.body(getBody(httpRequest)).build();
		
		this.logService.writeObjectLog(Level.INFO, ">>> RESOURCE OBJECT", resource);
		return resource;
	}

	public boolean validatePath(String suffixPath, String[] data) {
		return Arrays.asList(data).stream().filter(exc -> {

			if (suffixPath.length() >= exc.length()) {

				StringBuilder strB = new StringBuilder();
				int index = 0;
				char x = suffixPath.charAt(0);
				while (index < suffixPath.length()) {
					x = suffixPath.charAt(index);
					strB.append(x);
					if (index >= exc.length() && x == '/') {
						break;
					}
					index++;
				}

				String suffixPart = strB.toString();

				if (exc.charAt(0) != '/') {
					exc = '/' + exc;
				}

				if (exc.charAt(exc.length() - 1) != '/') {
					exc = exc + '/';
				}

				if (suffixPart.charAt(0) != '/') {
					suffixPart = '/' + suffixPart;
				}

				if (suffixPart.charAt(suffixPart.length() - 1) != '/') {
					suffixPart = suffixPart + '/';
				}

				return exc.equalsIgnoreCase(suffixPart);
			}

			return false;

		}).findFirst().isPresent();
	}

	public boolean isJwtActive(String suffixPath, Resource configResource, HttpServletRequest httpRequest) {
		if (Objects.isNull(configResource.getJwtConfig())) {
			return false;
		}

		if (Objects.isNull(configResource.getJwtConfig().getExcluded())) {
			return configResource.getJwtConfig().isActivate();
		}

		if (configResource.getJwtConfig().getExcluded().length == 0) {
			return configResource.getJwtConfig().isActivate();
		}

		return configResource.getJwtConfig().isActivate() && !isJwtExcluded(suffixPath, configResource);
	}

	public boolean isJwtExcluded(String suffixPath, Resource configResource) {
		if (Objects.isNull(configResource.getJwtConfig())) {
			return false;
		}
		
		if (configResource.getJwtConfig().getExcluded() == null || configResource.getJwtConfig().getExcluded().length == 0) {
			return false;
		}
		
		return validatePath(suffixPath, configResource.getJwtConfig().getExcluded());
	}

	public boolean isDecriptActive(String suffixPath, Resource configResource, HttpServletRequest httpRequest) {
		if (Objects.isNull(configResource.getRsaConfig())) {
			return false;
		}

		if (configResource.getRsaConfig().getExcluded() == null) {
			return configResource.getRsaConfig().isActivate();
		}

		if (configResource.getRsaConfig().getExcluded().length == 0) {
			return configResource.getRsaConfig().isActivate();
		}

		return configResource.getRsaConfig().isActivate() && !isDecryptExcluded(suffixPath, configResource);
	}

	public boolean isDecryptExcluded(String suffixPath, Resource configResource) {
		if (Objects.isNull(configResource.getRsaConfig())) {
			return false;
		}
		
		if (configResource.getRsaConfig().getExcluded() == null || configResource.getRsaConfig().getExcluded().length == 0) {
			return false;
		}
		return validatePath(suffixPath, configResource.getRsaConfig().getExcluded());
	}

	public String getBody(HttpServletRequest httpRequest) {
		ERequestMethod method = ERequestMethod.findByLabel(httpRequest.getMethod());
		if (ERequestMethod.POST.equals(method) || ERequestMethod.PUT.equals(method)) {
			try {
				return IOUtils.toString(httpRequest.getReader());
			} catch (IOException e) {
				return "";
			}
		}
		return "";
	}

	public String getSuffixPath(HttpServletRequest httpRequest, String serviceName) {
		String path = httpRequest.getServletPath().replace(serviceName, "");
		if (path.charAt(0) == '/' && path.charAt(1) == '/') {
			return path.substring(1);
		}
		return path;
	}

	public String[] getPartsOfPath(HttpServletRequest httpRequest) {
		String servletPath = httpRequest.getServletPath();

		if (servletPath.charAt(0) == '/') {
			servletPath = servletPath.substring(1);
		}

		if (servletPath.charAt(servletPath.length() - 1) == '/') {
			servletPath = servletPath.substring(0, servletPath.length() - 1);
		}

		String[] parts = servletPath.split("/");

		return Arrays.copyOfRange(parts, 1, parts.length);
	}

	public Resource validateServiceName(String serviceName) {
		return props.getResources().stream().filter(resource -> resource.getServiceName().equals(serviceName))
				.findFirst().orElseThrow(() -> new NotFound("Not found", null, null));
	}

	public String getServiceName(HttpServletRequest httpRequest) {
		String servletPath = httpRequest.getServletPath();

		if (servletPath.charAt(0) == '/') {
			servletPath = servletPath.substring(1);
		}

		if (servletPath.charAt(servletPath.length() - 1) == '/') {
			servletPath = servletPath.substring(0, servletPath.length() - 1);
		}
		String[] parts = servletPath.split("/");

		return parts[0];
	}

	public Map<String, String> getHeaders(HttpServletRequest httpRequest) {
		return Collections.list(httpRequest.getHeaderNames()).stream()
				.collect(Collectors.toMap(h -> h, httpRequest::getHeader));
	}

	public Map<String, String[]> getQueryParams(HttpServletRequest httpRequest) {
		Map<String, String[]> params = httpRequest.getParameterMap();
		return params;
	}
	
	public static String getFullURL(HttpServletRequest httpRequest) {
		StringBuilder requestURL = new StringBuilder(httpRequest.getRequestURL().toString());
		String queryString = httpRequest.getQueryString();

		if (queryString == null) {
			return requestURL.toString();
		} else {
			return requestURL.append('?').append(queryString).toString();
		}
	}

	public String getResourcePath(HttpServletRequest httpRequest, Resource configResource, boolean withSuffixPath,
			boolean withParams) {

		StringBuilder strBuild = new StringBuilder();
		strBuild.append(configResource.getHost());
		strBuild.append("/");
		strBuild.append(configResource.getServiceName());
		strBuild.append("/");

		if (withSuffixPath) {
			ERequestMethod method = ERequestMethod.findByLabel(httpRequest.getMethod());
			
			String[] parts = getPartsOfPath(httpRequest);
			strBuild.append("?");
			strBuild.append("c="+parts[0]);
			
			//POST methods
			if(ERequestMethod.POST.equals(method) && parts.length == 1) {
				if(!parts[0].equalsIgnoreCase("jwt")) {
					strBuild.append("&a=actionCreate");
				}
			}
			
			//POST methods
			else if(ERequestMethod.PUT.equals(method) && parts.length == 2) {
				if(!parts[0].equalsIgnoreCase("jwt")) { 
					strBuild.append("&a=actionDetail");
					strBuild.append("&acc="+parts[1]);
				} else {
					strBuild.append("&a=validate");
				}
			}
			
			//Get methods
			else if(ERequestMethod.GET.equals(method) && parts.length == 1) {
				strBuild.append("&a=actionList");
			}
			
			else if(ERequestMethod.GET.equals(method) && parts.length == 2) {
				strBuild.append("&a=actionDetail");
				strBuild.append("&acc="+parts[1]);
			}
			
			else if(ERequestMethod.GET.equals(method) && parts.length == 3) {
				strBuild.append("&a="+parts[1]);
				strBuild.append("&paramId="+parts[2]);
			}
			
			
			//Delete method
			else if(ERequestMethod.DELETE.equals(method) && parts.length == 2) {
				strBuild.append("&a=actionDelete");
				strBuild.append("&acc="+parts[1]);
			}
			
			else {
				throw new UnauthorizedException();
			}
			
			//strBuild.append(getSuffixPath(httpRequest, configResource.getServiceName()));
		}

		if (withParams && Strings.isNotEmpty(httpRequest.getQueryString())) {
			strBuild.append("&");
			strBuild.append(httpRequest.getQueryString());
		}

		return strBuild.toString();
	}
	
}
