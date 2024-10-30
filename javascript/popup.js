		function lanzarPopup(direccion){
			var ancho_popup = 600;
			var alto_popup = 500;
			ventana = window.open ("http://www.tuenti.com/share?url="+encodeURIComponent(direccion), "mywindow", "location=0,status=0,scrollbars=0,width="+ancho_popup+",height="+alto_popup);
			var tamano = [0,0];
			tamano = TamVentana();
			x = (tamano[0] / 2) - (ancho_popup / 2);
			y = (tamano[1] / 2) - (alto_popup / 2);
			ventana.moveTo(x,y);
		}
		
		function TamVentana() {  
		  var Tamanyo = [0, 0];  
		  if (typeof window.innerWidth != 'undefined')  
		  {  
		    Tamanyo = [  
		        window.innerWidth,  
		        window.innerHeight  
		    ];  
		  }  
		  else if (typeof document.documentElement != 'undefined'  
		      && typeof document.documentElement.clientWidth !=  
		      'undefined' && document.documentElement.clientWidth != 0)  
		  {  
		 Tamanyo = [  
		        document.documentElement.clientWidth,  
		        document.documentElement.clientHeight  
		    ];  
		  }  
		  else   {  
		    Tamanyo = [  
		        document.getElementsByTagName('body')[0].clientWidth,  
		        document.getElementsByTagName('body')[0].clientHeight  
		    ];  
		  }  
		  return Tamanyo;  
		}