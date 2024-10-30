<?php
/*
Author: Martin Chamarro
Author URI: http://www.TecnoCaos.com/
*/

	class Tuenti{
		
		var $handler;
		var $response;
		var $ruta_cookie;
		var $cookie;
		var $csfr;
		var $user_id;
		
		function crearCookie(){
			$this->ruta_cookie = "cookie.txt";
			$fp = fopen($this->ruta_cookie, "w");
			fclose($fp);
			chmod($this->ruta_cookie, 0777);
		}
		
		function __construct(){
			$this->handler = curl_init();
			
			curl_setopt($this->handler, CURLOPT_COOKIESESSION, true );
			curl_setopt($this->handler, CURLINFO_HEADER_OUT, true );
			curl_setopt($this->handler, CURLOPT_COOKIEJAR, $this->ruta_cookie);
			curl_setopt($this->handler, CURLOPT_COOKIEFILE, $this->ruta_cookie);
			curl_setopt($this->handler, CURLOPT_FAILONERROR, false );
			curl_setopt($this->handler, CURLOPT_TIMEOUT, false );
			curl_setopt($this->handler, CURLOPT_AUTOREFERER, true);
			curl_setopt($this->handler, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($this->handler, CURLOPT_VERBOSE, false );
			curl_setopt($this->handler, CURLOPT_USERAGENT,"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_4; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.127 Safari/533.4");  
			curl_setopt($this->handler, CURLOPT_HTTPHEADER, array("Accept-Language: es-ES,es;q=0.8", "Accept: application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5", "Proxy-Connection: keep-alive", "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.3"));
		    curl_setopt($this->handler, CURLOPT_POST, false);
			curl_setopt($this->handler, CURLOPT_HEADER, true);
			curl_setopt($this->handler, CURLOPT_CONNECTTIMEOUT, false);
			curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
		}	
		
		function iniciarSesionTuenti($login, $pass){
	
			$url_base = "http://www.tuenti.com/?m=login";
		
			//Primera carga de la pagina
			curl_setopt($this->handler, CURLOPT_POST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_base);
			$this->response = curl_exec ($this->handler);
		
			//Mostrar el formulario de login
			curl_setopt($this->handler, CURLOPT_POST, false);
			$this->cookie = "manual_logout=deleted; ue=deleted; em=deleted; fa=deleted; et=deleted; domain=.tuenti.com; expires=Sun, 30-Aug-2020 12:11:30 GMT; path=/;";
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			curl_setopt($this->handler, CURLOPT_URL, $url_base);
			$this->response = curl_exec ($this->handler);	
		
			//Iniciar sesion
			$url_login = "https://www.tuenti.com/?m=Login&func=do_login";
			curl_setopt($this->handler, CURLOPT_POST, true);
			curl_setopt($this->handler, CURLOPT_POSTFIELDS, "email=$login&remember=1&timezone=2&input_password=$pass"); 
			$this->cookie = "ourl=deleted; manual_logout=deleted; ue=deleted; em=deleted; fa=deleted; et=deleted; domain=.tuenti.com; expires=Sun, 30-Aug-2020 12:11:30 GMT; path=/;";
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_login);
			$this->response = curl_exec ($this->handler);
			$resultados = array();
			preg_match('/sid=([a-zA-Z0-9]*);/', $this->response, $resultados);
			$sid = $resultados[1];
		
			//Entrar en el perfil";
			$url_hash = "https://www.tuenti.com/";
			curl_setopt($this->handler, CURLOPT_POST, false);
			$this->cookie = "sid=$sid; lang=es_ES; ourl=deleted; manual_logout=deleted; ue=deleted; em=deleted; fa=deleted; et=deleted; domain=.tuenti.com; expires=Sun, 30-Aug-2020 12:11:30 GMT; path=/;";
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_hash);
			$this->response = curl_exec ($this->handler);
		
			//Tener hash;
			$url_hash = "https://www.tuenti.com/";
			curl_setopt($this->handler, CURLOPT_POST, false);
			$this->cookie = "redirect_url=m=home&func=view_home; tempHash=m=home&func=view_home;  max-age=30; sid=$sid; lang=es_ES; ourl=deleted; manual_logout=deleted; ue=deleted; em=deleted; fa=deleted; et=deleted; domain=.tuenti.com; expires=Sun, 30-Aug-2020 12:11:30 GMT; path=/;";
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_hash);
			$this->response = curl_exec ($this->handler);
			$resultados = array();
			preg_match('/user_id=([0-9]*)"/', $this->response, $resultados);
			$this->user_id = $resultados[1];
		}
		
		function compartirEnlace($url_post, $mensaje){
			$url_base = "http://www.tuenti.com/?m=Share&func=index&url=".urlencode($url_post);
		
			//Primera carga de la pagina
			curl_setopt($this->handler, CURLOPT_POST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_base);
			$this->cookie .=" redirect_url=deleted; lp=1;";
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			$this->response = curl_exec ($this->handler);
			$resultados = array();
			preg_match('/CSFR: \'([a-zA-Z0-9]*)\'/', $this->response, $resultados);
			$this->csfr = $resultados[1];
		
			//Envio de nuevo estado
			$url_envio = "https://wwwb21.tuenti.com/?m=Share&func=process_share_status&ajax=1&store=0&ajax_target=canvas";
			curl_setopt($this->handler, CURLOPT_POST, true);
			curl_setopt($this->handler, CURLOPT_POSTFIELDS, "url=".urlencode($url_post)."&csfr=".$this->csfr."&status_body=".urlencode($mensaje)."&lang=es_ES"); 
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_envio);
			$this->response = curl_exec ($this->handler);
		}
		
		function cerrarSesion(){
			//Cerrar sesion
			$url_envio = "https://wwwb21.tuenti.com/?m=Logout&func=log_out&ajax=1&store=0&ajax_target=canvas";
			curl_setopt($this->handler, CURLOPT_POST, true);
			curl_setopt($this->handler, CURLOPT_POSTFIELDS, "user_id=".$this->user_id."&csfr=".$this->csfr); 
			curl_setopt($this->handler, CURLOPT_COOKIE, $this->cookie);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($this->handler, CURLOPT_URL, $url_envio);
			$this->response = curl_exec ($this->handler);
		}
		
		function salir(){
			unlink($this->ruta_cookie);
			curl_close($this->handler);
			unset($this->response);
		}
		
	}

?>