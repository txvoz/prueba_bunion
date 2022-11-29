package com.txvoz.bff.service.api;

import java.util.logging.Level;

public interface ILogService {
	
	<T> void writeObjectLog(Level info, String message, T object);
	
	void writeGenericLog(Level info, String idTx, String string);

}
