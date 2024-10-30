<?php
/*
Plugin Name: Compartir en Tuenti
Version: 1.1.7
Plugin URI: http://www.tecnocaos.com/compartir-en-tuenti/
Description: Coloca junto a los contenidos de tu blog un boton para compartir en Tuenti, con muchas opciones
Author: Martin Chamarro
Author URI: http://www.TecnoCaos.com/
*/


/*
 *	FUNCION QUE ANADE EL BOTON AL CODIGO
 */
function compartir_en_tuenti($contenido){
	$configuracion = get_option('configuracion');
	if(strcmp($configuracion["abrir_enlace"], "popup") != 0){
		$boton = "
		<!--Inicio de Compartir en Tuenti-->
			<div style = '".$configuracion["estilo"]."'>
				<a href='http://www.tuenti.com/share?url=".urlencode(get_permalink())."' target='".$configuracion["abrir_enlace"]."' ".$configuracion["nofollow"].">
					<img src='".get_bloginfo(wpurl)."/wp-content/plugins/compartir-en-tuenti/imagenes/".$configuracion['tipo_boton'].".png' alt='Compartir en Tuenti ".get_the_title()."'/>
				</a>
			</div>
		<!--Fin de Compartir en Tuenti-->";
	}else{
			$boton = "
			<!--Inicio de Compartir en Tuenti-->
				<script src='".get_bloginfo(wpurl)."/wp-content/plugins/compartir-en-tuenti/javascript/popup.js'></script>
				<div style = '".$configuracion["estilo"]."'>
					<a onclick='lanzarPopup(\"".get_permalink()."\")'>
						<img src='".get_bloginfo(wpurl)."/wp-content/plugins/compartir-en-tuenti/imagenes/".$configuracion['tipo_boton'].".png' alt='Compartir en Tuenti ".get_the_title()."'/>
					</a>
				</div>
			<!--Fin de Compartir en Tuenti-->";
	}	
	if( (is_front_page() && $configuracion["portada"]) || (is_single() && $configuracion["entradas"]) || (is_page() && $configuracion["paginas"]) ){
		if(strcmp($configuracion['posicion'], "debajo") == 0){
			$contenido .= $boton;
		}else{
			$contenido = $boton . $contenido;
		}
	}
	return $contenido;
}


/*
 *	FUNCION PARA PINTAR LA PAGINA DE CONFIGURACION EN EL MENU DE AJUSTES
 */
function pintar_pagina_configuracion() { 
	$configuracion = get_option('configuracion');
	$tuenti = get_option('tuenti');
	
	if ($_POST['accion']){ ?>
		<br><center><b style="color:red;">Opciones guardadas</b></center><br>
	<?php } ?>
	<br>
	<style type="text/css">
		p.titulo {
			font-weight:bold;
			margin-top:15px;
		}
		
		fieldset.grande {
			border:2px ridge;
			padding: 10px;
			width:700px;
			margin-right:auto;
			margin-left:auto;
		}
		
		legend {
			text-align:center;
			font-weight:bold;
		}
		
		div.menu {
			float:left;
			margin: 20px 0px 25px 50px;
			width:300px;
		}
		
		div.enviar {
			width: 125px;
			margin-top: 20px;
			margin-right:auto;
			margin-left:auto;
		}
		
		div.firma {
			float:right;
			font-weight:bold;
		}
		
		div.cambio_estado {
			width: 700px;
			padding: 20px 0px 20px 0px;
			clear: both;
			margin-right: auto;
			margin-left: auto;
		}
		
		fieldset.cambio_estado {
			border-top: 2px ridge;
			padding: 20px;
			width:650px;
		}
		
		a.firma {
			color:black;
		}
		
		input.estilo{
			width:250px;
		}
		
		p.cambio_estado{
			font-weight:bold;
			margin-top:10px;
		}
		
		p.estado_cambiado{
			margin-top:10px;
		}
		
		legend.titulo{
			text-align:center;
			font-weight:bold;
			font-size:20px;
		}
		input.cambio_estado {
			width: 250px;
		}
		
		div.cambio_estado_menu {
			float:left;
			margin-left:50px;
			margin-top:20px;
			width:250px;
		}
		
		div.cambio_estado_boton {
			float:left;
			margin-top: 50px;
			margin-left: 120px;
			width:100px;
		}
	
	</style>
	<div>
		<fieldset class='grande'>
			<legend class='titulo'>&nbsp;<img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/logo.png' />&nbsp;Opciones de "Compartir en Tuenti"&nbsp;</legend>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
				
				<div class="menu">
				
					<input type="hidden" name="accion" value="guardar_configuracion" />
				
					<!-- Seleccion de tipo de boton -->
					<p class='titulo'>Tipo de bot&oacute;n:</p>
					<input type="radio" name="tipo_boton" value="oscuro_castellano" <?php if ($configuracion["tipo_boton"] == "oscuro_castellano") { echo " checked"; } ?> /> <img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/oscuro_castellano.png' /> <br>
					<input type="radio" name="tipo_boton" value="oscuro_ingles" <?php if ($configuracion["tipo_boton"] == "oscuro_ingles") { echo " checked"; } ?> /> <img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/oscuro_ingles.png' /> <br>
					<input type="radio" name="tipo_boton" value="oscuro_euskera" <?php if ($configuracion["tipo_boton"] == "oscuro_euskera") { echo " checked"; }  ?> /> <img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/oscuro_euskera.png' /> <br>
					<input type="radio" name="tipo_boton" value="claro_castellano" <?php if ($configuracion["tipo_boton"] == "claro_castellano") { echo " checked"; } ?> /> <img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/claro_castellano.png' /> <br>
					<input type="radio" name="tipo_boton" value="claro_ingles" <?php if ($configuracion["tipo_boton"] == "claro_ingles") { echo " checked"; } ?> /> <img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/claro_ingles.png' /> <br>
					<input type="radio" name="tipo_boton" value="claro_euskera" <?php if ($configuracion["tipo_boton"] == "claro_euskera") { echo " checked"; } ?> /> <img src='<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/compartir-en-tuenti/imagenes/claro_euskera.png' /> <br>
				
				
					<!-- Seleccion de posicion en la pagina -->
					<p class='titulo'>Posici&oacute;n respecto al contenido:</p>
					<input type="radio" name="posicion" value="encima" <?php if ($configuracion["posicion"] == "encima") { echo " checked"; } ?> /> Encima <br>
					<input type="radio" name="posicion" value="debajo" <?php if ($configuracion["posicion"] == "debajo") { echo " checked"; }  ?> /> Debajo <br>
				
				</div>
				<div class="menu">
					<!-- Seleccion de lugares -->
					<p class='titulo'>Selecci&oacute;n de lugares:</p>
					<input type="checkbox" name="entradas" value="entradas" <?php if ($configuracion["entradas"]) { echo " checked"; } ?> /> Entradas <br>
					<input type="checkbox" name="portada" value="portada" <?php if ($configuracion["portada"]) { echo " checked"; }  ?> /> Portada <br>
					<input type="checkbox" name="paginas" value="paginas" <?php if ($configuracion["paginas"]) { echo " checked"; }  ?> /> P&aacute;ginas <br>
				
					<!-- Seleccion comportamiento click -->
					<p class='titulo'>Abrir enlace del bot&oacute;n en:</p>
					<input type="radio" name="abrir_enlace" value="_blank" <?php if (strcmp($configuracion["abrir_enlace"],"_blank") == 0) { echo " checked"; }  ?> /> Una p&aacute;gina nueva <br>
					<input type="radio" name="abrir_enlace" value="popup" <?php if (strcmp($configuracion["abrir_enlace"],"popup") == 0) { echo " checked"; } ?> /> Un popup <br>
					<input type="radio" name="abrir_enlace" value="" <?php if (strcmp($configuracion["abrir_enlace"],"") == 0) { echo " checked"; } ?> /> La misma p&aacute;gina <br>
				
					<!-- CSS del div que contiene el boton -->
					<p class='titulo'>CSS del &lt;div&gt; que contiene el bot&oacute;n:</p>
					<input class="estilo" type="text" name="estilo" value="<?php echo $configuracion["estilo"]; ?>" />
				
					<!-- Configuracion del nofollow -->
					<p class='titulo'>Enlaces a Tuenti con <a href='http://es.wikipedia.org/wiki/Nofollow'>nofollow</a>:  <input type="checkbox" name="nofollow" value="nofollow" <?php if (strcmp($configuracion["nofollow"], '') != 0) { echo " checked"; }  ?> /> </p>
				
				</div><br>
				
				<div class="enviar">
					<p class="submit">
						<input class="submit" type="submit" name="Submit" value="Actualizar Opciones &raquo;" />
					</p>
				</div>

			</form>
				
			<div class='cambio_estado'>
				<fieldset class='cambio_estado'>
					<legend class='normal'>
						<b style='color:red;'>¡Nuevo!</b> Compartir en Tuenti autom&aacute;ticamente
					</legend>
					<?php if(!$tuenti["cambiar_estado"]){ ?>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
							<input type="hidden" name="accion" value="cambio_estado_activado" />
							<p>
								Este es el nuevo sistema para compartir autom&aacute;ticamente los enlaces de tus nuevos post en Tuenti.
								Cada vez que publiques una entrada en tu blog se cambiar&aacute; tu estado en la red social, incluyendo un enlace.
								Para ello se emplea <a style='color:black; font-weight:bold;' href='http://es.wikipedia.org/wiki/CURL'>cURL</a>,
								por lo tanto deber&aacute;s tenerlo instalado en tu servidor para emplearlo.
								Al igual que hacen muchas aplicaciones, el password de tu cuenta de Tuenti se almacenar&aacute; en tu base de datos (codificado con algoritmo reversible), pero podr&aacute;s
								borrarlo cuando quieras dando al bot&oacute;n "Desactivar cambio de estado".
								Si utilizas este sistema es bajo tu responsabilidad. Si tienes alguna sugerencia o problema, comenta <a style='color:black; font-weight:bold;' href='http://www.tecnocaos.com/compartir-en-tuenti/'>aqu&iacute;</a>.
							</p>
							<div class='cambio_estado_menu'>
								<p class='cambio_estado'>Email: <input class="cambio_estado" type="text" name="email_tuenti"  /></p>	
								<p class='cambio_estado'>Password: <input class="cambio_estado" type="password" name="pass_tuenti"  /></p>
								<p class='cambio_estado'>Estado (máx. 140 caracteres): <input class="cambio_estado" type="text" name="estado_tuenti" value='' /></p>
							</div>
							<div class='cambio_estado_boton'>
								<p class="submit">
									<input class="submit" type="submit" name="Submit" value="Activar cambio de estado" />
								</p>
							</div>
						</form>
					<?php }else{ ?>
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
							<input type="hidden" name="accion" value="cambio_estado_desactivado" />
							<div class='cambio_estado_menu'>
								<p class='estado_cambiado'><b>Email: </b><?php echo $tuenti["email"]; ?></p>
								<p class='estado_cambiado'><b>Password: </b> **********</p>
								<p class='estado_cambiado'><b>Estado: </b><?php echo $tuenti["estado"]; ?></p>
							</div>
							<div class='cambio_estado_boton'>
								<p class="submit">
									<input class="submit" type="submit" name="Submit" value="Desactivar cambio de estado" />
								</p>
							</div>
						</form>
					<?php } ?>
				</fieldset>
			</div>
		
			<div class='firma'>
				by <a class='firma' href='http://www.TecnoCaos.com'>TecnoCaos</a>
			</div>
		</fieldset>
	</div>
<?php
}


/*
 *	FUNCION PARA ANADIR PAGINA DE CONFIGURACION
 */
function anadir_pagina_configuracion() {
	add_options_page('Compartir en Tuenti', 'Compartir en Tuenti', 10, __FILE__, 'pintar_pagina_configuracion');
}


/*
 *	FUNCION PARA GUARDAR LA CONFIGURACION
 */
function guardar_configuracion() {
	$configuracion["tipo_boton"] = htmlentities($_POST["tipo_boton"]);
	$configuracion["posicion"] = $_POST["posicion"];
    $configuracion["entradas"] = (isset($_POST["entradas"])) ? TRUE : FALSE;
    $configuracion["portada"] = (isset($_POST["portada"])) ? TRUE : FALSE;
    $configuracion["paginas"] = (isset($_POST["paginas"])) ? TRUE : FALSE;
	$configuracion["nofollow"] = (isset($_POST["nofollow"])) ? 'rel="nofollow"' : '';
	$configuracion["estilo"] = htmlentities($_POST["estilo"]);
	$configuracion["abrir_enlace"] = htmlentities($_POST["abrir_enlace"]);
	update_option('configuracion', $configuracion);
}

/*
 *	BORRA LOS DATOS DE LA CUENTA DE TUENTI
 */
function cancelar_cambio_estado(){
	$tuenti["cambiar_estado"] = FALSE;
	$tuenti["email"] = '';
	$tuenti["pass"] = '';
	$tuenti["estado"] = '';
	update_option('tuenti', $tuenti);
}

/*
 *	GUARDA LOS DATOS DE LA CUENTA DE TUENTI
 */
function activar_cambio_estado(){
	if(isset($_POST["email_tuenti"]) && isset($_POST["pass_tuenti"])){
		$tuenti["cambiar_estado"] = TRUE;
		$tuenti["email"] = $_POST["email_tuenti"];
		$tuenti["pass"] = base64_encode($_POST["pass_tuenti"]);
		$estado = $_POST["estado_tuenti"];
		if(strlen($estado) > 140){
			$estado = substr($estado, 0, 140);
		}
		$tuenti["estado"] = $estado;
		update_option('tuenti', $tuenti);
	}
}

/*
 *	CAMBIAR EL ESTADO DE TUENTI
 */
function cambiar_estado($post_ID){
	$config = get_option('tuenti');
	if($config["cambiar_estado"]){
		require_once "tuenti.php";
		$tuenti = new Tuenti();
		$tuenti->crearCookie();
		$tuenti->iniciarSesionTuenti($config["email"], base64_decode($config["pass"]));
		$tuenti->compartirEnlace(external_or_permalink($post_ID), $config["estado"]);
		$tuenti->cerrarSesion();
		$tuenti->salir();
		unset($tuenti);
	}
}

/*
 *	CONFIGURACION, FILTROS Y ACCIONES
 */
function iniciar(){
	if (!get_option('configuracion')){
		$configuracion["tipo_boton"] = 'oscuro_castellano';
		$configuracion["posicion"] = 'debajo';
		$configuracion["entradas"] = TRUE;
		$configuracion["portada"] = TRUE;
		$configuracion["paginas"] = FALSE;
		$configuracion["estilo"] = 'width:85px;';
		$configuracion["abrir_enlace"] = "_blank";
		$configuracion["nofollow"] = 'rel="nofollow"';
		$tuenti["cambiar_estado"] = FALSE;
		$tuenti["email"] = '';
		$tuenti["pass"] = '';
		$tuenti["estado"] = '';
		update_option('configuracion', $configuracion);
		update_option('tuenti', $tuenti);
	}
		
	add_action('future_to_publish', 'cambiar_estado');
	add_action('new_to_publish', 'cambiar_estado');
	add_action('draft_to_publish', 'cambiar_estado');
	add_action('pending_to_publish', 'cambiar_estado');
	add_action('admin_menu', 'anadir_pagina_configuracion');
	add_filter('the_content', 'compartir_en_tuenti', 10);
	
}

iniciar();

/*
 *	COMPROBACION DE POST
 */
if ($_POST['accion'] == 'guardar_configuracion'){
	guardar_configuracion();
}else if($_POST['accion'] == 'cambio_estado_activado'){
	activar_cambio_estado();
}else if($_POST['accion'] == 'cambio_estado_desactivado'){
	cancelar_cambio_estado();
}

?>
