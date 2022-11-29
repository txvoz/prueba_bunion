/*
 * Copyright 2022, Banco Union S.A. Gerencia de InnovaciOn y Estrategia Digital / Subgerencia TransformaciOn Digital
 * https://bancounion.com
 * 
 * All rights reserved Date: 01/10/2022
 */
package com.txvoz.bff.service.api;

import com.txvoz.bff.config.ResourceProps.RsaConfig;
import com.txvoz.bff.dto.RsaResponseDto;

/**
 * Abstraction to validate Rsa encrypted data
 * 
 * @author Gustavo Rodriguez
 * @since 1.0
 * @version 1.0
 */
public interface IRsaService {
	
	RsaResponseDto decrypt(String encryptValue, RsaConfig config);

}
