var preload='<img src="http://localhost/plataforma/images/preload.gif" id="cargando" width="100" heigth="100">';
var cargador = "cargador";

$(document).ready(inicializarJs);

function inicializarJs() {
	try{
		funcionesGenerales();
		moduloConfiguracion();
	}
	catch(err){
		console.log(err);
	}//catch
}// function inicializarJs

function funcionesGenerales() {
	console.log("funcionesGenerales");
}






//::::::::::::::::: Menu de modulos
$(function() {
var d=300;
$('#navigation a').each(function(){
	$(this).stop().animate({
    'marginTop':'-80px'
    },d+=150);
 });
$('#navigation > li').hover(
	function () {
    	$('a',$(this)).stop().animate({
           'marginTop':'-2px'
        },200);
    },
    function () {
        $('a',$(this)).stop().animate({
           'marginTop':'-80px'
        },200);
 }
);
});
