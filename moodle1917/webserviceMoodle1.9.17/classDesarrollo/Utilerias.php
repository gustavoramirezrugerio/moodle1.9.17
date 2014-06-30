<?php
/* - - - - - - - - - - - - - - - - - - - - -
 Titulo : Utilerias para la optimizacion de procesos
 Autor : Gustavo Ramirez Rugerio
 URL :
 Ultima modificación : 15 de mayo 2014
 Descripción : Esta clase permite validar los procesos de nuestras operaciones ejecutadas del ladao del servidor
- - - - - - - - - - - - - - - - - - - - - */

class Utilerias {
	/**
 * Funciones principales
 *
 * Funcion que recibe un objeto y lo convierte en Arrary
 *
 * @author Gustavo Ramirez Rugerio <gustavo_ramirez@cuaed.unam.mx> , <gustavoramirezrugerio@gmail.com>
 * @copyright 01 - Febrero - 2014, Gustavo Ramirez Rugerio
 * @param obj $object objeto que se recibe
 * @return array $param regresa un arreglo
 */
	function obj2array($object) {
		if (is_array($object) || is_object($object)) {
			$array = array();
			foreach ($object as $key => $value) {
				$array[$key] = obj2array($value);
			}
			//Foreach
			return $array;
		}
		//IF
		return utf8_encode($object);
	}
	//function obj2array
	/**
 * Funciones principales
 *
 * Funcion que recibe un array y lo convierte a object
 *
 * @author Gustavo Ramirez Rugerio <gustavo_ramirez@cuaed.unam.mx> , <gustavoramirezrugerio@gmail.com>
 * @copyright 01 - Febrero - 2014, Gustavo Ramirez Rugerio
 * @param array $datosEntrada recibe un arreglo
 * @return obj $datosEntrada regresa un objeto
 */
	function array2obj($datosEntrada) {
		if (!is_object($datosEntrada)) {
			return $datosEntrada = (object) $datosEntrada;
		}
	}
	//function array2obj
	//
	function fechaActual() {
		$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$arrayDias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
		return $arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y');
	}
	//function fechaActual

}
// class Utilerias
/*
$para = "Holaaaa";
$ejecutar = Utilerias::fechaActual();
print_r($ejecutar);
*/
