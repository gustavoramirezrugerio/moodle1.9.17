<?php
function modulocursosRegistrarCurso($curso) {
	ob_start();
	//Para evitar que imprima los echos
	global $CFG;
	//global $USER;
	$maxbyte = 0;
	foreach (get_max_upload_sizes($CFG->maxbytes) as $max => $tmp) {
		$maxbyte = $max;
		break;
	}
	$curso['MAX_FILE_SIZE'] = $maxbyte;
	$curso["timemodified"] = time();
	$curso['fullname'] = utf8_encode($curso['fullname']);
	$curso['shortname'] = utf8_encode($curso['shortname']);
	$curso['summary'] = utf8_encode($curso['summary']);
	$curso['category'] = utf8_encode($curso['category']);
	$curso['idnumber'] = utf8_encode($curso['idnumber']);
	$curso["format"]      = "weekssae";
	$curso["numsections"] = 52;
	//$curso["startdate"] 	= time(); //[Fecha de inicio del curso (time() + 3600 * 24)]
	$curso["startdate"] = strtotime($curso['startdate']);
	// convertimos la fecha a time
	$curso["hiddensections"] = 1;
	$curso["newsitems"]      = 5;
	$curso["showgrades"]     = 1;
	$curso["showreports"]    = 0;
	$curso["maxbytes"]       = $maxbyte;
	$curso["metacourse"]     = 0;
	$curso["enrol"]          = "manual";
	//[vacio para que se enrolen de cualquier manera]
	$curso["defaultrole"] = 0;
	$curso["enrollable"]  = 0;
	//[Para indicar si el curso esta abirto o no]
	$curso["enrolstartdate"]     = 0;
	$curso["enrolstartdisabled"] = 1;
	$curso["enrolenddate"]       = 0;
	$curso["enrolenddisabled"]   = 1;
	$curso["enrolperiod"]        = 0;
	$curso["expirynotify"]       = 0;
	$curso["notifystudents"]     = 0;
	$curso["expirythreshold"]    = 864000;
	$curso["groupmode"]          = 1;
	$curso["groupmodeforce"]     = 0;
	$curso["visible"]            = 0;
	$curso["guest"]              = 0;
	$curso["restrictmodules"]    = 0;
	$curso[id]                   = 0;
	$curso[teacher] = get_string('defaultcourseteacher');
	$curso[teachers] = get_string('defaultcourseteachers');
	$curso[student] = get_string('defaultcoursestudent');
	$curso[students] = get_string('defaultcoursestudents');
	$data = (object) $curso;
	if (!$course = create_course($data)) {
		throw new Exception(get_string('coursenotcreated'));
	} else {
		$curso['id'] = $course->id;
		$context = get_context_instance(CONTEXT_COURSE, $course->id);
		// assign default role to creator if not already having permission to manage course assignments
		if (!has_capability('moodle/course:view', $context) or !has_capability('moodle/role:assign', $context)) {
			//TODO verificar la asignacion del rol
			//-->role_assign($CFG->creatornewroleid, 2, 0, $context->id); //El 2 es del usuario admin. Si se envia otro usuario, se enrola como profesor del grupo

		}
		// ensure we can use the course right after creating it
		// this means trigger a reload of accessinfo...
		mark_context_dirty($context->path);
	}
	$curso["urlportada"] = urlportada().'/'.$curso['shortname'];
	$curso["urlcurso"] = urlcurso()."/course/view.php?id=".$curso["id"];
	$week = optional_param('week', -1, PARAM_INT);
	if ($week != -1) {
		$displaysection = course_set_display($course->id, $week);
	} else {
		$displaysection = course_set_display($course->id, 0);
	}
	$timenow = time();
	$weekdate = $course->startdate;
	// this should be 0:00 Monday of that week
	$weekdate += 7200;
	// Add two hours to avoid possible DST problems
	$section = 1;
	$sectionmenu = array();
	$weekofseconds = 604800;
	$course->enddate = $course->startdate+($weekofseconds*$course->numsections);
	while ($weekdate < $course->enddate) {
		$nextweekdate = $weekdate+($weekofseconds);
		$weekday = userdate($weekdate, $strftimedateshort);
		$endweekday = userdate($weekdate+518400, $strftimedateshort);
		if (!empty($sections[$section])) {
			$thissection = $sections[$section];
		} else {
			unset($thissection);
			$thissection->course = $course->id;
			// Create a new week structure
			$thissection->section = $section;
			$thissection->summary = '';
			$thissection->visible = 1;
			if (!$thissection->id = insert_record('course_sections', $thissection)) {
				notify('Error inserting new week!');
			}
		}
		if (!empty($displaysection) and $displaysection != $section) {
			// Check this week is visible
			if ($showsection) {
				$sectionmenu['week='.$section] = s("$strweek $section |     $weekday - $endweekday");
			}
			$section++;
			$weekdate = $nextweekdate;
			continue;
		}
		if ($showsection) {
			$currentweek = (($weekdate <= $timenow) && ($timenow < $nextweekdate));
			$currenttext = '';
			if (!$thissection->visible) {
				$sectionstyle = ' hidden';
			} elseif ($currentweek) {
				$sectionstyle = ' current';
				$currenttext = get_accesshide(get_string('currentweek', 'access'));
			} else {
				$sectionstyle = '';
			}
			$weekperiod = $weekday.' - '.$endweekday;
		}
		$section++;
		$weekdate = $nextweekdate;
	}

	ob_end_clean();
	//Para que no imprima los echos
	return $curso;
}
/* CONSUMO DE SERVICIOS WEB :: MODULO :: CURSOS */
/*
$curso = array(
	'category' => '66',
	'fullname' => 'Curso de revision WS',
	'shortname' => date(),
	'summary' => 'Curso creado para validar WS'.time()
);
$resultado1 = modulocursosRegistrarCurso($curso);
echo "<pre>";
print_r($resultado1);
exit;
*/

/*
 $valores = array('category' => '26', 'fullname'=> 'LO que sea JPCP ');
 $editarSecciones = modulocursosRegistrarCurso($valores);
 echo "<pre>";
 print("modulocursosRegistrarCurso");
 print_r($editarSecciones);
 echo "</pre>";
 */
/*
 function modulocursosDetallesCurso($idCurso){
 ob_start(); //Para evitar que imprima los echos
 $oCurso = get_record('course', 'id', $idCurso['id']);
 print_r($oCurso); exit;
 //$oCurso = get_record('course', 'shortname', $idCurso['shortname']);
 $curso['id'] = utf8_decode($oCurso->id);
 $curso['fullname'] = utf8_decode($oCurso->fullname);
 $curso['shortname'] = utf8_decode($oCurso->shortname);
 $curso['summary'] = utf8_decode($oCurso->summary);
 $curso['category'] = utf8_decode($oCurso->category);
 $curso['format'] = utf8_decode($oCurso->format);
 $curso['numsections'] = utf8_decode($oCurso->numsections);
 $curso['visible'] = utf8_decode($oCurso->visible);
 $curso['timemodified'] = utf8_decode($oCurso->timemodified);

 $curso['apertura'] = utf8_decode($oCurso->apertura);
 $curso['cierre'] = utf8_decode($oCurso->cierre);

 $curso['enrolstartdate'] = utf8_decode($oCurso->enrolstartdate);
 $curso['enrolenddate'] = utf8_decode($oCurso->enrolenddate);

 $curso["urlportada"] = urlportada().'/'.$curso['shortname'];
 $curso["urlcurso"] = urlcurso()."/course/view.php?id=".$curso["id"];
 ob_end_clean();//Para que no imprima los echos
 return $curso;
 }
 */
function modulocursosDetallesCurso($idCurso) {
	ob_start();
	//Para evitar que imprima los echos
	$oCurso = get_record('course', 'id', $idCurso['id']);
	//$oCurso = get_record('course', 'shortname', $idCurso['shortname']);
	$curso['id'] = utf8_decode($oCurso->id);
	$curso['fullname'] = utf8_decode($oCurso->fullname);
	$curso['shortname'] = utf8_decode($oCurso->shortname);
	$curso['summary'] = utf8_decode($oCurso->summary);
	$curso['category'] = utf8_decode($oCurso->category);
	$curso['format'] = utf8_decode($oCurso->format);
	$curso['numsections'] = utf8_decode($oCurso->numsections);
	$curso['visible'] = utf8_decode($oCurso->visible);
	$curso['timemodified'] = utf8_decode($oCurso->timemodified);
	$curso["urlportada"] = urlportada().'/'.$curso['shortname'];
	$curso["urlcurso"] = urlcurso()."/course/view.php?id=".$curso["id"];
	$curso['apertura'] = utf8_decode($oCurso->apertura);
	$curso['cierre'] = utf8_decode($oCurso->cierre);
	$curso['enrolstartdate'] = utf8_decode($oCurso->enrolstartdate);
	$curso['enrolenddate'] = utf8_decode($oCurso->enrolenddate);
	ob_end_clean();
	//Para que no imprima los echos
	return $curso;
}
/*
 $valores = array('id' => '2');
 $curso = modulocursosDetallesCurso($valores);
 echo "<pre>";
 print("modulo cursos Detalles Curso");
 print_r($curso);
 echo "</pre>";
 exit;
 */
function modulocursosDetallesCursoXnombreCorto($nombreCortoCurso) {
	ob_start();
	//Para evitar que imprima los echos
	$oCurso = get_record('course', 'shortname', $nombreCortoCurso['shortname']);
	//$oCurso = get_record('course', 'shortname', $idCurso['shortname']);
	$curso['id'] = utf8_decode($oCurso->id);
	$curso['fullname'] = utf8_decode($oCurso->fullname);
	$curso['shortname'] = utf8_decode($oCurso->shortname);
	$curso['summary'] = utf8_decode($oCurso->summary);
	$curso['category'] = utf8_decode($oCurso->category);
	$curso['format'] = utf8_decode($oCurso->format);
	$curso['numsections'] = utf8_decode($oCurso->numsections);
	$curso['visible'] = utf8_decode($oCurso->visible);
	$curso['timemodified'] = utf8_decode($oCurso->timemodified);
	$curso["urlportada"] = urlportada().'/'.$curso['shortname'];
	$curso["urlcurso"] = urlcurso()."course/view.php?id=".$curso["id"];
	ob_end_clean();
	//Para que no imprima los echos
	return $curso;
}
//  $valores = array('id' => '56');
//  //$valores = array('shortname'=> 'C_D');
//  $curso = modulocursosDetallesCurso($valores);
//  echo "<pre>";
//  print("modulo cursos Detalles Curso");
//  print_r($curso);
//  echo "</pre>";
///  Funcional
function modulocursosObtenerCursos($categoria) {
	ob_start();
	//Para evitar que imprima los echos
	if (!$category = get_record("course_categories", "id", $categoria['id'])) {
		throw new Exception(get_string("Category not known!"));
	}
	if (!is_object($category) && $category == 0) {
		$categories = get_child_categories(0);
		// Parent = 0   ie top-level categories only
		if (is_array($categories) && count($categories) == 1) {
			$category = array_shift($categories);
			$courses = get_courses_wmanagers($category->id, 'c.sortorder ASC', array('password', 'summary', 'currency'));
		} else {
			$courses = get_courses_wmanagers('all', 'c.sortorder ASC', array('password', 'summary', 'currency'));
		}
		unset($categories);
	} else {
		$courses = get_courses_wmanagers($category->id, 'c.sortorder ASC', array('password', 'summary', 'currency'));
	}
	$categoria['name'] = utf8_decode($category->name);
	$categoria['description'] = utf8_decode($category->description);
	$categoria['cursos'] = array();
	if ($courses) {
		foreach ($courses as $course) {
			$categoria['cursos'][] = obj2array($course);
		}
	}

	ob_end_clean();
	//Para que no imprima los echos
	return $categoria;
}
// $valores = array('id' => '1');
//  $curso = modulocursosObtenerCursos($valores);
//  echo "<pre>";  print_r($curso); exit;
function modulocursosEditarCurso($data) {
	ob_start();
	//Para evitar que imprima los echos
	$newcourse = new stdClass();
	$newcourse->id = utf8_encode($data['id']);
	$newcourse->visible = $data['visible'];
	if (!empty($data['fullname'])) {
		$newcourse->fullname = utf8_encode($data['fullname']);
	}
	if (!empty($data['shortname'])) {
		$newcourse->shortname = utf8_encode($data['shortname']);
	}
	if (!empty($data['summary'])) {
		$newcourse->summary = utf8_encode($data['summary']);
	}
	if (!empty($data['numsections'])) {
		$newcourse->numsections = utf8_encode($data['numsections']);
	}
	if (!empty($data['startdate'])) {
		$newcourse->fullname = utf8_encode($data['startdate']);
	}
	$USER = get_record('user', 'id', 2);
	if (!$newcourse->id = update_record('course', $newcourse)) {
		throw new Exception("Could not edit the course'$newcourse->fullname' ");
	} else {
		$newcourse->context = get_context_instance(CONTEXT_COURSE, $newcourse->id);
		mark_context_dirty($newcourse->context->path);
		$data['id'] = $newcourse->id;
		fix_course_sortorder();
	}

	ob_end_clean();
	//Para que no imprima los echos
	return $data;
}
function modulocursosEliminarCurso($idCurso) {
	ob_start();
	//Para evitar que imprima los echos
	return delete_records('course', 'id', $idCurso['id']);
	ob_end_clean();
	//Para que no imprima los echos

}
function modulocursosOcultarMostrarCurso($curso) {
	ob_start();
	//Para evitar que imprima los echos
	$consulta = get_record('course', 'id', $curso['id']);
	if ($consulta->visible == 1) {
		return set_field('course_categories', 'visible', 0, 'id', $curso['id']);
	} else {
		return set_field('course_categories', 'visible', 1, 'id', $curso['id']);
	}

	ob_end_clean();
	//Para que no imprima los echos

}
function modulocursosMoverArribaCurso($idCurso) {
	ob_start();
	//Para evitar que imprima los echos
	$consulta = get_record('course', 'id', $idCurso['id']);
	if ($consulta->sortorder != 0 and $consulta->parent == 0 and $consulta->category == $idCurso['category']) {
		$nueva = $consulta->sortorder;
		$primera = set_field('course', 'sortorder', $consulta->sortorder-2, 'id', $idCurso['id']);
		$consulta2 = get_record('course', 'category', $idCurso['category'], 'sortorder', $nueva);
		$nueva2 = $consulta2->sortorder+1;
		$idnue  = $consulta2->id;
		$segunda = set_field('course', 'sortorder', $nueva2, 'id', $idnue);
		return $segunda.$primera;
	} else {
		return get_record('course', 'id', $idCurso['id']);
	}

	ob_end_clean();
	//Para que no imprima los echos

}
function modulocursosMoverAbajoCurso($idCurso) {
	ob_start();
	//Para evitar que imprima los echos
	$consulta = get_record('course', 'id', $idCurso['id']);
	if ($consulta->parent == 0 and $consulta->category == $idCurso['category']) {
		$nueva = $consulta->sortorder;
		$primera = set_field('course', 'sortorder', $consulta->sortorder+1, 'id', $idCurso['id']);
		$consulta2 = get_record('course', 'category', $idCurso['category'], 'sortorder', $nueva);
		$nueva2 = $consulta2->sortorder-1;
		$idnue  = $consulta2->id;
		$segunda = set_field('course', 'sortorder', $nueva2, 'id', $idnue);
		return $segunda.$primera;
	} else {
		return get_record('course', 'id', $idCurso['id']);
	}

	ob_end_clean();
	//Para que no imprima los echos

}
function modulocursosObtenerRecursosActividades() {
	ob_start();
	//Para evitar que imprima los echos
	global $CFG;
	$obtenerModulos = obj2array($allmods = get_records("modules", "visible", 1));
	foreach ($obtenerModulos as $obtenerModulos => $modulos) {
		$libfile = $CFG->dirroot."/mod/".$modulos['name']."/lib.php";
		if (!file_exists($libfile)) {
			continue;
		}
		include_once ($libfile);
		$gettypesfunc = $modulos['name'].'_get_types';
		if (function_exists($gettypesfunc)) {
			$types = $gettypesfunc();
			foreach ($types as $type) {
				$contador += 1;
				if (!isset($type->modclass) or !isset($type->typestr)) {
					debugging('Incorrect activity type in '.$modulos['name']);
					continue;
				}
				if ($type->type != 'assignment_group_start' && $type->type != 'assignment_group_end') {
					if ($type->modclass == MOD_CLASS_RESOURCE) {
						$resources[$type->type] = $type->typestr;
					} else {
						$activities[$type->type] = $type->typestr;
					}
				}
			}
		} else {
			// all mods without type are considered activity
			$activities[$modulos['name']] = get_string('modulename', $modulos['name']);;
		}
	}
	$conteoActividades = 0;
	/*        foreach($activities as $clave => $valor) {
	 $tmpActividades[$conteoActividades++] = array($clave => $valor);
	 }*/
	foreach ($activities as $clave => $valor) {
		if (($clave != "sae") && ($clave != "feedback") && ($clave != "survey")) {
			$tmpActividades['clave']         = $clave;
			$tmpActividades['valor']         = $valor;
			$actividades[$conteoActividades] = $tmpActividades;
			$conteoActividades++;
		}
	}
	$conteoRecursos = 0;
	foreach ($resources as $clave => $valor) {
		if ($clave != "label") {
			$tmpResources['clave']     = $clave;
			$tmpResources['valor']     = $valor;
			$recursos[$conteoRecursos] = $tmpResources;
			$conteoRecursos++;
		}
	}
	$output['actividades'] = $actividades;
	$output['recursos']    = $recursos;
	revisionParametros($output);
	return $output;
	ob_end_clean();
	//Para que no imprima los echos

}
/*
$ObteberRecursosActividades = modulocursosObtenerRecursosActividades();
echo "<pre>";
print_r($ObteberRecursosActividades);
*/
/*
function modulocursosRegistrarBackup($parametros) {
	//ob_start (); // Para evitar que imprima los echos
	global $COURSE, $CFG, $SESSION, $USER;
	define('BACKUP_SILENTLY', 1);
	define('RESTORE_SILENTLY_NOFLUSH', 1);
	$course = get_record ( "course", "id", $parametros['id']); // Curso
	$prefs['backup_users'] = 2;
	$resultado = backup_course_silently( $course->id,$prefs);
	$result = substr($resultado, strrpos( $resultado,'/' )+1);
	//ob_end_clean (); // Para que no imprima los echos
	return $result;
}
*/
function modulocursosRegistrarBackup($parametros) {
	ob_start();
	// Para evitar que imprima los echos
	global $COURSE, $CFG, $SESSION, $USER;
	define('BACKUP_SILENTLY', 1);
	define('RESTORE_SILENTLY_NOFLUSH', 1);
	$course = get_record("course", "id", $parametros['id']);
	// Curso
	$prefs['backup_users']             = 1;
	$prefs['backup_logs']              = 0;
	$prefs['backup_user_files']        = 1;
	$prefs['backup_course_files']      = 1;
	$prefs['backup_site_files']        = 1;
	$prefs['backup_gradebook_history'] = 0;
	$resultado = backup_course_silently($course->id, $prefs);
	$result = substr($resultado, strrpos($resultado, '/')+1);
	ob_end_clean();
	// Para que no imprima los echos
	return $result;
}
// $parametros = array('id' => 222);
// echo $generarBackup = modulocursosRegistrarBackup($parametros); exit;
/*function modulocursosRestaurarCurso($parametros){
	revisionParametros($parametros);
	ob_start (); // Para evitar que imprima los echos
	global $COURSE, $CFG, $SESSION, $USER;
	$fuente = $CFG->dataroot . '/' . $parametros ['id'] . '/backupdata/' . $parametros ['archivo'];
	$result = import_backup_file_silently ( $fuente, $parametros ['id_destino'], false, false, $preferences);
	//print_r($result); exit;
	ob_end_clean (); // Para que no imprima los echos
	return "se restauro el sitio";
}*/
// function modulocursosRestaurarCurso($parametros){
// 	revisionParametros($parametros);
// 	ob_start (); // Para evitar que imprima los echos
// 	global $COURSE, $CFG, $SESSION, $USER;
// 	$fuente = $CFG->dataroot . '/' . $parametros ['id'] . '/backupdata/' . $parametros ['archivo'];
// 	$result = import_backup_file_silently ( $fuente, $parametros ['id_destino'], false, false, $preferences);
// 	//print_r($result); exit;
// 	ob_end_clean (); // Para que no imprima los echos
// 	return "se restauro el sitio: ".$result->id;
// }
function modulocursosRestaurarCurso($parametros) {
	//echo "<pre>"; print_r($parametros); exit;
	revisionParametros($parametros);
	ob_start();
	// Para evitar que imprima los echos
	global $COURSE, $CFG, $SESSION, $USER;
	//$preferences = new array();
	$preferences['restore_course_files'] = 1;
	$preferences['backup_site_files']    = 1;
	$preferences['backup_user_files']    = 1;
	$preferences['restoreto']            = 1;
	$fuente                              = $CFG->dataroot.'/'.$parametros['id'].'/backupdata/'.$parametros['archivo'];
	$result = import_backup_file_silently($fuente, $parametros['id_destino'], false, false, $preferences);
	$direccion     = $CFG->dataroot."/".$result."/scriptsAgregados.xml";
	$url           = $direccion;
	$contenido_xml = "";
	if ($d = @fopen($url, "r")) {
		while ($aux = fgets($d, 4096)) {
			$idcursoBackup  = $parametros['id'];
			$idcursoDestino = $result;
			$linea = str_replace($idcursoBackup, $idcursoDestino, $aux);
			$contenido_xml .= $linea;
		}
		@fclose($d);
	}
	if ($d = @fopen($url, "r+")) {
		fwrite($d, $contenido_xml);
		@fclose($d);
	}
	/*  // para ver el contenido del XML
	if ( $xml = simplexml_load_string($contenido_xml) )  {
			print_r($xml);
			exit;
		}
	*/
	ob_end_clean();
	// Para que no imprima los echos
	return $result;
}
/*
 $parametros = array('id' => 200, 'id_destino' => '', 'archivo' => 'copia_de_seguridad-pens_707-s01-20130530-1330.zip');
 $generarBackup = modulocursosRestaurarCurso($parametros);
 echo "<pre>";
 print_r($generarBackup);
 echo "</pre>";
*/
function modulocursosEditarSeccion($data) {
	ob_start();
	//Para evitar que imprima los echos
	$edicion = new stdClass();
	$edicion->id = utf8_encode($data['id']);
	$edicion->summary = utf8_encode($data['summary']);
	if (!empty($edicion->summary)) {
		set_field("course_sections", "summary", $edicion->summary, "id", $edicion->id);
		//echo "Actualizado";

	} else {
		throw new Exception("No se puede editar la seccion'$edicion->summary' ");
	}
	return $data;
	ob_end_clean();
	//Para que no imprima los echos

}
/*
 $valores = array( 'id' =>1, 'summary'=> 'VALORES  para la seccion');
 $editarSecciones = modulocursosEditarSeccion($valores);
 echo "<pre>";
 //print("editar Secciones");
 print_r($editarSecciones);
 echo "</pre>";
 */
function modulocursosObtenerRecursosActividadesCurso($curso) {
	ob_start();
	//Para evitar que imprima los echos
	$obtenerRecursosActividades = obj2array(get_array_of_activities($curso['id']));
	//echo "<pre>"; print_r($obtenerRecursosActividades); exit;
	foreach ($obtenerRecursosActividades as $elementos) {
		if (($elementos['section'] != '0') && ($elementos['mod'] != 'label') && ($elementos['mod'] != 'sae')) {
			$curso['elementos'][] = obj2array($elementos);
		}
	}
	$ObtenerSemanas = get_all_sections($curso['id']);
	foreach ($ObtenerSemanas as $semana) {
		$curso['semanas'][] = obj2array($semana);
	}

	ob_end_clean();
	//Para que no imprima los echos
	return $curso;
}
//  $curso = array( 'id' =>447);
//  $modulocursosObtenerSeccion = modulocursosObtenerRecursosActividadesCurso($curso);
// // echo urldecode($modulocursosObtenerSeccion ['elementos'][0]['name']); exit;
//  echo "<pre>"; print_r($modulocursosObtenerSeccion); exit;
function modulocursosObtenerSemanas($courseid) {
	ob_start();
	//Para evitar que imprima los echos
	$ObtenerSemanas = get_all_sections($courseid['id']);
	foreach ($ObtenerSemanas as $semana) {
		$curso['semanas'][] = obj2array($semana);
	}
	unset($curso['semanas'][0]);
	return $curso;
	ob_end_clean();
	//Para que no imprima los echos

}
// $curso = array( 'id' => 447 );
// $modulocursosObtenerSemanas = modulocursosObtenerSemanas($curso);
// echo "<pre>"; print_r($modulocursosObtenerSemanas); exit;
function modulocursosRegistarSemanas($section, $courseid) {
	ob_start();
	//Para evitar que imprima los echos
	get_course_section($section, $courseid['id']);
	return "";
	ob_end_clean();
	//Para que no imprima los echos

}
/*
 $curso = array( 'id' =>122);
 $modulocursosRegistarSemanas = modulocursosRegistarSemanas($section=5 ,$curso);
 echo "<pre>";
 print_r($modulocursosRegistarSemanas);
 echo "</pre>";
 */
function modulocursos_get_studentshtml($curso) {
	ob_start();
	//Para evitar que imprima los echos
	global $CFG;
	// 		$sort        = "u.idnumber";
	// 		$sqlusuarios = "SELECT DISTINCT u.id, u.firstname, u.lastname, u.imagealt, u.picture, u.idnumber
	// 		FROM {$CFG->prefix}user u
	// 		JOIN {$CFG->prefix}role_assignments ra ON u.id = ra.userid
	// 		WHERE ra.roleid in (5)
	// 		ORDER BY $sort";
	//		return $sqlusuarios;
	$usurios = get_course_students($curso['id']);
	$idsUsuarios = array_keys($usurios);
	//$usurios = get_records_sql($sqlusuarios);
	//print_object($usurios);
	foreach ($idsUsuarios as $userid) {
		//echo "<br>".$userid;
		//$aver = grade_report_user_profilereport($curso['id'], $userid);
		/*print_object($aver);
			exit;
			echo "<br>---------<br>";*/
		$sql = "
			select gi.id, gg.itemid, gg.userid, gg.finalgrade, gi.itemname, gi.courseid
			from {$CFG->prefix
	}

	grade_items gi LEFT JOIN {$CFG->prefix
}

grade_grades gg ON(gi.id = gg.itemid)
			where gg.userid=$userid
			AND gi.courseid={$curso['id']
}

			order by gi.id";
//return $sql;
//$grades= get_records_sql($sql);
//print_object($grades);
$grades[$userid] = get_records_sql($sql);
}
//exit;
//$conteo=0;
/*
		foreach ($usurios as $userid => $user) {
		$sql = "
		select gi.id, gg.itemid, gg.userid, gg.finalgrade, gi.itemname, gi.courseid
		from {$CFG->prefix}grade_items gi LEFT JOIN {$CFG->prefix}grade_grades gg ON(gi.id = gg.itemid)
		where gg.userid=$userid
		AND gi.courseid={$curso['id']}
		order by gi.id";
		//return $sql;
		// $grades= get_records_sql($sql);
		$grades[$conteo++]  = get_records_sql($sql);
		}*/
return obj2array($grades);
ob_end_clean();
//Para que no imprima los echos

}
// 	$curso = array( 'id' =>97);
// 	print_object(modulocursos_get_studentshtml($curso));
function modulocursosLimpiarCurso($parametros) {
	ob_start();
	// Para evitar que imprima los echos
	global $CFG;
	$id_curso = $parametros['id'];
	$sql      = "SELECT id FROM {$CFG->prefix
}

course WHERE id = ".$id_curso;
$dato = get_record_sql($sql);
if ($dato) {
	return $result = "si";
} else {
	return $result = "no";
}

ob_end_clean();
//Para que no imprima los echos

}
/*
 $parametros = array('id' => 129);
 $limpiarcurso = modulocursosLimpiarCurso($parametros);
 echo "<pre>";
 print("modulocursosLimpiarCurso \n ");
 print_r($limpiarcurso);
 echo "</pre>";
 */
function modulousuariosMatricularUsuariosDelete($usuarios, $grupo) {
	ob_start();
	//Para evitar que imprima los echos
	//---- VALIDAR LA INFORMACION DE ENTRADA ----------------
	foreach ($usuarios as $usuario) {
		if (!$usuario['idnumber'] || !$usuario['username'] || !$usuario['rol']['id']) {
			return new soap_fault('Client', '', 'Los datos de un usuario no son correctos'.print_r($usuario, true));
		} else {
			//---- SI NO EXISTE EL USUARIO, IMPORTO SUS DATOS DE LDAP
			$user = get_complete_user_data('username', $usuario['username']);
			if (!$user) {
				$user = create_user_record($usuario['username'], '', 'ldap');
				//$authplugin->sync_roles($user);
				if (!$user) {
					throw new Exception('Los datos de un usuario no son correctos');
				}
			}
		}
	}
	if ($grupo['id'] != -1) {
		if (!$ogroup = get_record('groups', 'id', $grupo['id'])) {
			return new soap_fault('Client', '', 'Group ID was incorrect');
		}
		if (!$course = get_record('course', 'id', $ogroup->courseid)) {
			return new soap_fault('Client', '', 'Group ID was incorrect');
		}
	} else {
		if (!$course = get_record('course', 'id', $grupo['courseid'])) {
			return new soap_fault('Client', '', 'Group ID was incorrect');
		}
	}
	$context = get_context_instance(CONTEXT_COURSE, $course->id);
	foreach ($usuarios as $usuario) {
		$user = get_complete_user_data('username', $usuario['username']);
		// ------- ENROLAR --------
		$extendbase = 0;
		// Para especificar la fecha limite de enrolamiento.
		switch ($extendbase) {
			case 0:
				$timestart = $course->startdate;
				break;
			case 3:
				$timestart = $today;
				break;
			case 4:
				$timestart = $course->enrolstartdate;
				break;
			case 5:
				$timestart = $course->enrolenddate;
				break;
		}
		if ($extendperiod > 0) {
			$timeend = $timestart+$extendperiod;
		} else {
			$timeend = 0;
		}
		if ($grupo['id'] == -1) {
			if (!role_assign($usuario['rol']['id'], $user->id, 0, $context->id, $timestart, $timeend, 0, 'webservice')) {
				return new soap_fault('Client', '', "Could not add user with id {$user->id
			}

			 to this role!");
		}
	}
	if ($grupo['id'] != -1 && (!groups_add_member($ogroup->id, $user->id))) {
		return new soap_fault('Client', '', 'erroraddremoveuser');
	}
}

ob_end_clean();
//Para que no imprima los echos
return obtenerUsuarios($grupo);
}
function modulocursosReiniciarCurso($parametros) {
	// function reset_course_userdata
	revisionParametros($parametros);
	global $CFG, $USER, $COURSE;
	ob_start();
	// Para evitar que imprima los echos
	$id = $dato->id = utf8_encode($parametros['id']);
	$roles = array();
	$roles[0] = 3;
	$roles[1] = 4;
	$roles[2] = 5;
	$roles[3] = 6;
	$noRegistrados = array();
	$noRegistrados[0]                   = 3;
	$noRegistrados[1]                   = 5;
	$noRegistrados[2]                   = 9;
	$noRegistrados[3]                   = 84;
	$data->MAX_FILE_SIZE                = 2097152;
	$data->reset_start_date             = 0;
	$data->reset_events                 = 1;
	$data->reset_logs                   = 1;
	$data->reset_notes                  = 1;
	$data->reset_roles                  = $roles;
	$data->mform_showadvanced_last      = 1;
	$data->reset_roles_local            = 1;
	$data->reset_gradebook_grades       = 1;
	$data->reset_groups_remove          = 1;
	$data->reset_assignment_submissions = 1;
	$data->reset_chat                   = 1;
	$data->reset_choice                 = 1;
	$data->reset_data_ratings           = 1;
	$data->reset_data_comments          = 1;
	$data->reset_forum_all              = 1;
	$data->reset_forum_subscriptions    = 1;
	$data->reset_glossary_ratings       = 1;
	$data->reset_glossary_comments      = 1;
	$data->reset_lesson                 = 1;
	$data->reset_quiz_attempts          = 1;
	$data->reset_scorm                  = 1;
	$data->reset_survey_answers         = 1;
	$data->feedback_reset_data_6        = 1;
	$data->id                           = $id;
	$data->submitbutton                 = 'Reset course';
	$data->reset_start_date_old         = 0;
	$data->courseid                     = $id;
	$data->timeshift                    = 0;
	//$data->unenrolled            = $noRegistrados; // TODO Revisar su funcoinalidad
	$context = get_context_instance(CONTEXT_COURSE, $data->courseid);
	$data->timeshift = 0;
	$status = array();
	$componentstr = get_string('general');
	$data->reset_logs = 1;
	if (!empty($data->reset_logs)) {
		delete_records('log', 'course', $data->courseid);
		$status[] = array(
			'component' => $componentstr,
			'item' => get_string('deletelogs'),
			'error' => false,
		);
	}
	$data->reset_events = 1;
	if (!empty($data->reset_events)) {
		delete_records('event', 'courseid', $data->courseid);
		$status[] = array(
			'component' => $componentstr,
			'item' => get_string('deleteevents',
			'calendar'),
			'error' => false,
		);
	}
	$data->reset_events = 1;
	if (!empty($data->reset_notes)) {
		require_once ($CFG   ->dirroot.'/notes/lib.php');
		note_delete_all($data->courseid);
		$status[] = array(
			'component' => $componentstr,
			'item' => get_string('deletenotes',
			'notes'),
			'error' => false,
		);
	}
	$componentstr = get_string('roles');
	$data->reset_roles_local = 1;
	if (!empty($data->reset_roles_local)) {
		$children = get_child_contexts($context);
		foreach ($children as $child) {
			role_unassign(0, 0, 0, $child->id);
		}
		//force refresh for logged in users
		mark_context_dirty($context->path);
		$status[] = array(
			'component' => $componentstr,
			'item' => get_string('deletelocalroles',
			'role'),
			'error' => false,
		);
	}
	// First unenrol users - this cleans some of related user data too, such as forum subscriptions, tracking, etc.
	$roles = array();
	$roles[1] = 3;
	$roles[2] = 4;
	$roles[3] = 5;
	$roles[4] = 6;
	$data->unenrolled = array();
	if (!empty($roles)) {
		foreach ($roles as $roleid) {
			if ($users = get_role_users($roleid, $context, false, 'u.id', 'u.id ASC')) {
				foreach ($users as $user) {
					role_unassign($roleid, $user->id, 0, $context->id);
					if (!has_capability('moodle/course:view', $context, $user->id)) {
						$data->unenrolled[$user->id] = $user->id;
					}
				}
			}
		}
	}
	if (!empty($data->unenrolled)) {
		$status[] = array(
			'component' => $componentstr,
			'item' => get_string('unenrol').' ('.count($data->unenrolled).')',
			'error' => false,
		);
	}
	$componentstr = get_string('groups');
	// remove all group members
	groups_delete_group_members($data->courseid);
	$status[] = array(
		'component' => $componentstr,
		'item' => get_string('removegroupsmembers',
		'group'),
		'error' => false,
	);
	// remove all groups
	groups_delete_groups($data->courseid, false);
	$status[] = array(
		'component' => $componentstr,
		'item' => get_string('deleteallgroups',
		'group'),
		'error' => false,
	);
	// remove all grouping members
	groups_delete_groupings_groups($data->courseid, false);
	$status[] = array(
		'component' => $componentstr,
		'item' => get_string('removegroupingsmembers',
		'group'),
		'error' => false,
	);
	// remove all groupings
	groups_delete_groupings($data->courseid, false);
	$status[] = array(
		'component' => $componentstr,
		'item' => get_string('deleteallgroupings',
		'group'),
		'error' => false,
	);
	// Look in every instance of every module for data to delete
	$unsupported_mods = array();
	if ($allmods = get_records('modules')) {
		foreach ($allmods as $mod) {
			$modname = $mod->name;
			if (!count_records($modname, 'course', $data->courseid)) {
				continue;
				// skip mods with no instances

			}
			$modfile           = $CFG->dirroot.'/mod/'.$modname.'/lib.php';
			$moddeleteuserdata = $modname.'_reset_userdata';
			// Function to delete user data
			if (file_exists($modfile)) {
				//include_once($modfile);
				if (function_exists($moddeleteuserdata)) {
					$modstatus = $moddeleteuserdata($data);
					if (is_array($modstatus)) {
						$status = array_merge($status, $modstatus);
					} else {
						debugging('Module '.$modname.' returned incorrect staus - must be an array!');
					}
				} else {
					$unsupported_mods[] = $mod;
				}
			} else {
				debugging('Missing lib.php in '.$modname.' module!');
			}
		}
	}
	// mention unsupported mods
	if (!empty($unsupported_mods)) {
		foreach ($unsupported_mods as $mod) {
			$status[] = array(
				'component' => get_string('modulenameplural',
				$mod->name),
				'item' => '',
				'error' => get_string('resetnotimplemented')
			);
		}
	}
	/*TODO  Solo falta revisar este fragmento de Calificaciones si funciona con el curso
	 $componentstr = get_string('gradebook', 'grades');
	 // reset gradebook
	 if (!empty($data->reset_gradebook_items)) {
	 remove_course_grades($data      ->courseid, false);
	 grade_grab_course_grades($data  ->courseid);
	 grade_regrade_final_grades($data->courseid);
	 $status[] = array('component'=>$componentstr, 'item'=>get_string('removeallcourseitems', 'grades'), 'error'=>false);

	 } else if (!empty($data->reset_gradebook_grades)) {
	 grade_course_reset($data->courseid);
	 $status[] = array('component'=>$componentstr, 'item'=>get_string('removeallcoursegrades', 'grades'), 'error'=>false);
	 }
	 */
	ob_end_clean();
	//Para que no imprima los echos
	return "se reinicio el curso: ".$parametros['id'];
}
/*
 $parametros = array('id' => 129);
 $reiniciarCurso = modulocursosReiniciarCurso($parametros);
 echo "<pre>";
 print("modulocursosReiniciarCurso \n ");
 print_r($reiniciarCurso);
 echo "</pre>";
 */
//REVISARLOS ESTOS
function modulocursosExisteCurso($shortname) {
	//revisionParametros($shortname);
	$foundcourses = get_records('course', 'shortname', $shortname);
	if (!empty($foundcourses)) {
		return true;
	}
	return false;
}
?>
