<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CONFIGURACION CATED</title>
<link href="css/principal.css" media="screen" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-2.1.0.js"></script>
<script type="text/javascript" src="js/iniciar.js"></script>
<script type="text/javascript" src="js/moduloConfiguracion.js"></script>


<?php
function dameURL(){
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
return $url;
}
?>

<div id="contenedor">
  <div id="moduloConfiguracion_contenidos">
  	<!-- Menu  -->
    <div id="moduloConfiguracion_menu">
    	<a id="opcionMenuConfiguracion" class="enlace"> INICIO </a> <br>

    	<div id="div1" class="ocultoTexto">
	    	<ul class="moduloConfiguracion_opcionesMenu">
	    		<li><a id="opcionMenu_configuracion" href="#opcion_configuracion"> Configuracion </a></li>
	    		<li><a id="opcionMenu_procesos" href="#opcion_procesos"> Procesos </a></li>			    
			    <li><a id="opcionMenu_reemplzarAcentos" href="#opcion_reemplazarAcentos"> Reemplazar Acentos </a></li>
			    <li><a id="opcionMenu_reemplzarCadenas" href="#opcion_reemplazarCadenas"> Reemplazar Cadenas </a></li>
			    <li><a id="opcionMenu_ejecutarComandos" href="#opcion_ejecutarComandos"> Ejecutar Comandos</a></li>
			    <li><a id="opcionMenu_verArchivosCargados" href="#opcion_verArchivosCargados"> Ver archivos Cargados </a></li>

			    

			    <li><a id="opcionMenu_varios" href="#opcion_varios"> Varios </a></li>		    
			</ul>
		</div>

    </div>

    <!-- contenidosMenu1  -->
    <div id="moduloConfiguracion_contenidosMenu">
    	<div class="Contenedor">
		    <div id="moduloConfiguracionMenuBienvenida" class="moduloConfiguracion_contenidoMenu">
		    	Modulo de configuracion: <br>
		    	<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>

		    </div>
		    <div id="opcion_configuracion" class="moduloConfiguracion_contenidoMenu">		    	
		    	CONFIG
		    </div>

		    <div id="opcion_procesos" class="moduloConfiguracion_contenidoMenu">
		    	Procesos 
		    </div>
		    
		    <div id="opcion_info" Class="moduloConfiguracion_contenidoMenu" w>
		    	JJOJO		   		
				
		   </div>

		    <div id="opcion_reemplazarAcentos" Class="moduloConfiguracion_contenidoMenu">		    	
					Acentos	    	
		   </div>

		    <div id="opcion_reemplazarCadenas" Class="moduloConfiguracion_contenidoMenu">
		    	<form action="reemplazarcadenasBD.php" method="post">
				 <p>Ingrese cadanas a buscar: <input type="text" name="buscar" /></p>
				 <p>Ingrese cadanas a reemplazar: <input type="text" name="reemplazar" /></p>
				 <input type="submit" value="Ejecutar" />
				</form>   	
		   </div>




		    <div id="opcion_ejecutarComandos" Class="moduloConfiguracion_contenidoMenu">
		    	<form action="ejecutarComandos.php" method="post">
				 <p>Ingrese el comando a ejecutar: <input type="text" name="ejecutarComando" /></p>
				 <input type="submit" value="Ejecutar" />
				</form>   	
		   </div>

		    <div id="opcion_verArchivosCargados" Class="moduloConfiguracion_contenidoMenu">
		    	opcion_verArchivosCargados
		   </div>



		    <div id="opcion_varios" Class="moduloConfiguracion_contenidoMenu">		    	
				<span class="texto"> Herramientas del sistema</span>
				<li><a target="_blank" href="<?=dameURL();?>reemplazarAcentosBD.php"> Reemplazar Acentos </a></li>
				<li><a target="_blank" href="<?=dameURL();?>phpmyadmin"> PHPMYADMIN </a></li>
				<li><a target="_blank" href="<?=dameURL();?>phpinfo.php"> INFO PHP </a></li>
				<li><a target="_blank" href="<?=dameURL();?>subirArchivos"> Subir Archivos </a></li>

				<li><a target="_blank" href="<?=dameURL();?>comandos/Comando1/"> Comando 1 </a></li>
				<li><a target="_blank" href="<?=dameURL();?>comandos/Comando2/"> Comando 2 </a></li>
				<li><a target="_blank" href="<?=dameURL();?>comandos/Comando3/"> Comando 3 </a></li>

		   </div>

		</div>
    </div>

  </div>
</div>










