var funcion;
function ajaxForm(formulario,ancho,alto,titulo,icono)
{
    new Ajax.Request('formularios/'+formulario+'.php',
    {
      parameters  : "formulario="+formulario+"&ancho="+ancho+"&alto="+alto+"&titulo="+titulo+"&icono="+icono,
      onSuccess   : function(r)  { $('envoltura').insert("<div id=" + formulario + " class='formulario'></div>");
                                   $(formulario).update(r.responseText).setStyle("display:block"); 
                                   new Draggable(formulario,{handle:formulario+'_barra'});
                                   arriba(formulario);
				   
				   switch(formulario)
				   {
					case '100opensource':
					    initializemarquee();
					    $(formulario).setStyle('left:150px;top:150px');
					break;
					case 'serviciosLeon':
					    $(formulario).setStyle('left:340px;top:370px');
					break;				    
				   }
				     
				     
				   
                                 }            
    });
}

function ajax(archivo)
{
    new Ajax.Request(archivo, {
    method       : 'get',
    onSuccess    : resultado 
    });
}

function resultado(r)
{
  switch(funcion)
  {
    case 'noticias':
      $("noticias").update(r.responseText); 
    break;
    case 'comandos':
      $('comandos').update(r.responseText); 
      $('comandos').setStyle("display:block");
    break;
    case 'aleatorios':
      $("articulosAleatorios").update(r.responseText); 
    break;
    case 'video':
      $("videoYoutube").update(r.responseText);
    break;
    case 'ejecutar':
      $("tablaregistros").update(r.responseText);
    break;
    case 'ejecutar2':
      $("tablaregistros").update(r.responseText);
    break;
    case 'enlaces':
      $("sitiosyenlaces").update(r.responseText);
    break;
    case 'enlaces2':
      $("sitiosyenlaces").update(r.responseText);
    break;  
    case 'indice':
      $("indice").update(r.responseText);
      $("indice").setStyle('display:block');
    break;
    case 'servicios':
      estado_servicios(r.responseText);
    break;
  }
}
function ejecutar_ajax2(archivo)
{
  var bus=$F("txt_buscar");funcion='ejecutar';ajax(archivo+bus);
}
function ejecutar_ajax(archivo)
{
  funcion='ejecutar2';ajax(archivo);  
}
function ejecutar_enlaces2(archivo)
{
  var bus=$F("txt_buscar_e");funcion='enlaces';ajax(archivo+bus);
}
function ejecutar_enlaces(archivo)
{
  funcion='enlaces2';ajax(archivo);  
}
function noticias(archivo2)
{
  funcion = 'noticias';ajax(archivo2);
}
function articulosAleatorios()
{
  funcion='aleatorios';ajax("portada/articulosAleatorios.php");
}
function otro_comando(archivo)
{
  funcion='comandos';ajax(archivo);
}
function otro_video()
{
  var video=$F('lstVideos');if (video=='--') return;funcion ='video';ajax("portada/youtube2.php?video="+video+"&tipo=v");
}
function ejecutar_ajax_indice(archivo)
{
  funcion = 'indice';ajax(archivo);
}
function ejecutar_ajax_servicios(archivo)
{
  funcion = 'servicios';ajax(archivo);
}
function estado_servicios(r)
{ 
$("temporal").update(r);
var sele1=$("s1").value;
var sele2=$("s2").value;	
var sele3=$("s3").value;
var sele4=$("s4").value;	
var sele5=$("s5").value;	
var sele6=$("s6").value;
if (sele1 == 1){
$("masinfo1").update(r);
$("masinfo1").setStyle('display:block');
$("masinfo2","masinfo3","masinfo4","masinfo5","masinfo6").invoke('setStyle','display:none');}	
if (sele2 == 1){
$("masinfo2").update(r);
$("masinfo2").setStyle('display:block');
$("masinfo1","masinfo3","masinfo4","masinfo5","masinfo6").invoke('setStyle','display:none');}		
if (sele3 == 1){
$("masinfo3").update(r);
$("masinfo3").setStyle('display:block');
$("masinfo1","masinfo2","masinfo4","masinfo5","masinfo6").invoke('setStyle','display:none');}	
if (sele4 == 1){
$("masinfo4").update(r);
$("masinfo4").setStyle('display:block');
$("masinfo1","masinfo2","masinfo3","masinfo5","masinfo6").invoke('setStyle','display:none');}	
if (sele5 == 1){
$("masinfo5").update(r);
$("masinfo5").setStyle('display:block');
$("masinfo1","masinfo2","masinfo3","masinfo4","masinfo6").invoke('setStyle','display:none');}
if (sele6 == 1){
$("masinfo6").update(r);
$("masinfo6").setStyle('display:block');
$("masinfo1","masinfo2","masinfo3","masinfo4","masinfo5").invoke('setStyle','display:none');	}
}
function enlaceDesc(x)
{
  if($('sitiosyenlacesDesc')==null)
  {
    $('sitiosyenlaces').insert("<div id='sitiosyenlacesDesc' style='height:60px; padding:2px; border:1px solid;font-size:8pt'></div>");
  }
  
  $('sitiosyenlacesDesc').update('<span style="color:#00f;font-weight:bold"><a href="'+$F('enlace'+x)+'" target="_blank">'+$F('sitio'+x)+'</a></span> '+$F('desc'+x));
}
function renglones(div)
{
  //var tabla = $("registros");
  var tabla = $(div);  
  var los_tr = tabla.getElementsByTagName("tr");
  for (var i in los_tr)
  {
    los_tr[i].onmouseover = function() { this.style.backgroundColor = "yellow"; }
    los_tr[i].onmouseout = function() { this.style.backgroundColor = ""; }
  }
}
function enlaces(accion)
{
  switch(accion)
  {
    case 'abrir':
      $('noticias').setStyle('height:680px');
      $('sitiosyenlaces').setStyle('height:265px');
      $('btnEnlaces').update("<input type='button' value='cerrar enlaces' style='font-size:7pt;font-weight:bold;color:#00f' onclick=\"enlaces('cerrar')\" />");
    break;
    case 'cerrar':
      $('noticias').setStyle('height:945px');
      $('sitiosyenlaces').setStyle('height:0px');
      $('btnEnlaces').update("<input type='button' value='abrir enlaces' style='font-size:7pt;font-weight:bold;color:#00f' onclick=\"enlaces('abrir')\" />");
    break;
  }
}
function recargarNoticias()
{
  $('noticias').update("<div style='height:35px; font-weight:bold; text-align:center; padding-top:15px' ><img src='imagenes/cargando.gif' >&nbsp;&nbsp;C A R G A N D O &nbsp;&nbsp; F E E D S....</div>");
  noticias('portada/noticias_noticias.php');
}

function noticias_mas_menos()
{$('noticias').style.display='block';
$("masmenos").innerHTML="<img src='imagenes/menos.png' onclick='noticias_menos_mas()' style='cursor:pointer' alt='Menos...'>";}
function noticias_menos_mas()
{$('noticias').style.display='none';
$("masmenos").innerHTML="<img src='imagenes/mas.png' onclick='noticias_mas_menos()' style='cursor:pointer' alt='Más...'>";}
function noticias_mas_menos_full()
{$('noticias').style.display='block';
$("masmenosfull").innerHTML="<table border='0'><tr><td style='border:0px'><h1><font color='red'><span onclick='noticias_menos_mas_full()' style='cursor:pointer'>NOTICIAS (contraer)</span></font></h1></td><td style='border:0px'><img src='imagenes/menos.png' onclick='noticias_menos_mas_full()' style='cursor:pointer' alt='Más...'></td></tr>";}
function noticias_menos_mas_full()
{$('noticias').style.display='none';
$("masmenosfull").innerHTML="<table border='0'><tr><td style='border:0px'><h1><font color='red'><span onclick='noticias_mas_menos_full()' style='cursor:pointer'>NOTICIAS (expander)</span></font></h1></td><td style='border:0px'><img src='imagenes/mas.png' onclick='noticias_mas_menos_full()' style='cursor:pointer' alt='Más...'></td></tr></table>";}
function enlaces_mas_menos()
{$('enlaces').style.display='block';
$("masmenosenlaces").innerHTML="<table border='0'><tr><td style='border:0px'><h1><font color='red'><span onclick='enlaces_menos_mas()' style='cursor:pointer'>ENLACES (contraer)</span></font></h1></td><td style='border:0px'><img src='imagenes/menos.png' onclick='enlaces_menos_mas()' style='cursor:pointer' alt='Más...'></td></tr>";}
function enlaces_menos_mas()
{$('enlaces').style.display='none';
$("masmenosenlaces").innerHTML="<table border='0'><tr><td style='border:0px'><h1><font color='red'><span onclick='enlaces_mas_menos()' style='cursor:pointer'>ENLACES (expander)</span></font></h1></td><td style='border:0px'><img src='imagenes/mas.png' onclick='enlaces_mas_menos()' style='cursor:pointer' alt='Más...'></td></tr></table>";}

/***********************************************
* Bookmark site script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
function favoritos(titulo,url){
if (window.sidebar) // firefox
window.sidebar.addPanel(titulo, url, "");
else if(window.opera && window.print){ // opera
var elem = document.createElement('a');
elem.setAttribute('href',url);
elem.setAttribute('title',titulo);
elem.setAttribute('rel','sidebar');
elem.click();
} 
else if(document.all)// ie
window.external.AddFavorite(url, titulo);
}

function loadFeedControl()
{
      var options = {
        numResults  : 9,
        displayTime : 5000,
        stacked     : true,
        title       : "FEEDS FAVORITOS DE LINUXTOTAL"
      }

	var feeds = [
 	{title: 'ALCANCELIBRE (FAVORITO)',
	 url: 'http://www.alcancelibre.org/backend/index.rss'
	}, 
	{title: 'DIARIOTI',
	 url: 'http://www.diarioti.com/inc/titulares_rss.xml'
	},
	{title: 'BARRAPUNTO',
	 url: 'http://barrapunto.com/index.rss'
	},
	{title: 'SLASHDOT (FAVORITO)',
	 url: 'http://slashdot.org/slashdot.rdf'
	},	
        {title: 'WIRED',
	 url: 'http://feeds.wired.com/wired/index'
	},
	{title: 'LINUXTODAY',
	 url: 'http://www.linuxtoday.com/backend/biglt.rss'
	}      
        ];

    var fg = new GFdynamicFeedControl(feeds, "noticias", options);
  }

function minimizarMaximizar(formulario,ancho,alto,accion)
{
   var ma = formulario + "_maximizar";
   var mi = formulario + "_minimizar";
   if (accion == 'minimizar')
   {
        $(ma).show();
        $(mi).hide();
   }
   if (accion == 'maximizar')
   {
        $(ma).hide();
        $(mi).show();
   }
   $(formulario).setStyle('width:' + ancho);
   $(formulario).setStyle('height:' + alto);
}

function cerrarFormulario(formulario)
{
    Effect.Squish(formulario);
    $(formulario).remove();
}

function arriba(formulario)
{
    var f=$$('.formulario');
    f.each(function(e){
            e.setStyle("z-index:0");
            var fNombre = $(e).identify() + '_barra';
            if($(fNombre) != null ) $(fNombre).setStyle("background-color:#eaeaea"); 
    })

    $(formulario).setStyle("z-index:10");
    fNombre = $(formulario).identify() + '_barra';
    if($(fNombre) != null ) $(formulario + '_barra').setStyle("background-color:#99ff33");
}

/***********************************************
* Cross browser Marquee II- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/

var delayb4scroll=1200; //Specify initial delay before marquee starts to scroll on page (2000=2 seconds)
var marqueespeed=1; //Specify marquee scroll speed (larger is faster 1-10)
var pauseit=1; //Pause marquee onMousever (0=no. 1=yes)?

////NO NEED TO EDIT BELOW THIS LINE////////////

var copyspeed=marqueespeed;
var pausespeed=(pauseit==0)? copyspeed: 0;
var actualheight='';

function scrollmarquee()
{
if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8))
cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px";
else
cross_marquee.style.top=parseInt(marqueeheight)+8+"px";
}

function initializemarquee()
{
cross_marquee=$("vmarquee");
cross_marquee.style.top=0;
marqueeheight=$("marqueecontainer").offsetHeight;
actualheight=cross_marquee.offsetHeight;
if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1)
{ //if Opera or Netscape 7x, add scrollbars to scroll and exit
cross_marquee.style.height=marqueeheight+"px";
cross_marquee.style.overflow="scroll";
return;
}
setTimeout('lefttime=setInterval("scrollmarquee()",30)', delayb4scroll);
}

function imagen100()
{
  i = $('img100').src;
  //alert(i);
  //console.log(manza);
  ii = i.split("/");
  largo = ii.length;
  cual=ii[largo - 1];

  if(cual=="100.jpg")
  {
     $('img100').src = "imagenes/100r.jpg";
     return;
  }
  if(cual=="100r.jpg")
  {
     $('img100').src = "imagenes/100.jpg";
	 return;
  }  
  
}