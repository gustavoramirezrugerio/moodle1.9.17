/**
 * Funciones del modulo Inicial.
 * 
 * Archivo para funcionalidad del modulo inicio.
 * 
 * @author Gustavo
 * @copyright
 */

var moduloConfiguracion_contenidoMenu = "moduloConfiguracion_contenidoMenu";
var moduloConfiguracion_opcionesMenu = "moduloConfiguracion_opcionesMenu";



function moduloConfiguracion() {
	console.log("--moduloConfiguracion");
	moduloConfiguracion_MenuConfiguracion();
	moduloConfiguracion_menuInicio();
	//opciones para cargar los archivos externos
	moduloConfiguracion_opcionConfig();
	moduloConfiguracion_opcionInfo();
	moduloConfiguracion_opcionProcesos();
	moduloConfiguracion_opcionReemplazarAcentos();
	moduloConfiguracion_verArchivos();
}


function moduloConfiguracion_MenuConfiguracion() {
	$("#opcionMenuConfiguracion").click(function() {
		$("#moduloConfiguracionMenuBienvenida").show();
		$("#opcion_configuracion").hide();
		$("#opcion_procesos").hide();
		$("#opcion_info").hide();
		$("#opcion_reemplazarAcentos").hide();
		$("#opcion_reemplazarCadenas").hide();
		$("#opcion_varios").hide();
	});
}

function moduloConfiguracion_menuInicio() {
	console.log("moduloConfiguracion_menuInicio");
	$("."+moduloConfiguracion_contenidoMenu).hide(); //Para ocultar los DIV's con contenido
	$("ul."+moduloConfiguracion_opcionesMenu+" li:first").addClass("active").show(); //Activamos el primer elemento
	$("."+moduloConfiguracion_contenidoMenu+":first").show(); //Muestra el contenido respectivo al primer elemento
	//Al clickar sobre los elementos
	$("ul."+moduloConfiguracion_opcionesMenu+" li").click(function() {
		$("ul."+moduloConfiguracion_opcionesMenu+" li").removeClass("active"); //Anula todas las selecciones
		$(this).addClass("active"); //Asigna la clase Active al elemento seleccionado
		$("."+moduloConfiguracion_contenidoMenu).hide(); //Esconde todo el contenido de los elementos
		var elementosActivos = $(this).find("a").attr("href"); //Ubica los valores HREF y A para enlazarlos y activarlos
		$(elementosActivos).fadeIn(); //Habilita efecto Fade en la transición de contenidos
		return false;
	});
}


function moduloConfiguracion_ejecutarScrip(idEnlace, idElementoCargarInformacion, archivo) {
    $("#" + idEnlace).click(function(event) {
        $("#" + idElementoCargarInformacion).load(archivo);
    });
}

function moduloConfiguracion_opcionConfig() {
    moduloConfiguracion_ejecutarScrip("opcmoduloConfiguracion_opcionConfigionMenu_configuracion", "opcion_configuracion", "phpconfig.php");
}

function moduloConfiguracion_opcionReemplazarAcentos() {
	moduloConfiguracion_ejecutarScrip( "opcionMenu_reemplzarAcentos", "opcion_reemplazarAcentos", "reemplazarAcentosBD.php" );	
}

function moduloConfiguracion_opcionInfo() {
	moduloConfiguracion_ejecutarScrip( "opcionMenu_info", "ver_phpinfo", "phpinfo.php" );	
}


function moduloConfiguracion_opcionProcesos() {
	moduloConfiguracion_ejecutarScrip( "opcionMenu_procesos", "opcion_procesos", "phpprocesos.php" );	
}
function moduloConfiguracion_verArchivos() {
	moduloConfiguracion_ejecutarScrip( "opcionMenu_verArchivosCargados", "opcion_verArchivosCargados", "verArchivosCargados.php" );	
}






