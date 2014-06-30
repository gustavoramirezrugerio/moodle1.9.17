<?php
function moduloEncuestasRegistrarEncuestas($data){
	revisionParametros($data);
	ob_start(); //Para evitar que imprima los echos
	$newchat = new stdClass();
	$newchat->course = utf8_encode($data['course']);
	$newchat->name = utf8_encode($data['name']);
	$newchat->intro = utf8_encode($data['intro']);
	$newchat->timemodified = time();
	$newchat->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newchat->id = insert_record('quiz', $newchat) ) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newchat->context = get_context_instance(CONTEXT_COURSE, $newchat->id);
		mark_context_dirty($newchat->context->path);
		$data['id']=$newchat->id;
		fix_course_sortorder();
	}
	$newevent = new stdClass();
	$newevent->courseid =  $newchat->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newchat->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = quiz;
	$newevent->instance = $newchat->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();
	$newevent->id_gestor =  utf8_encode($data['id_gestor']);

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);
	revisionParametros($idRecursoActividad);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert chat '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		mark_context_dirty($newevent->context->path);
		$instance['id']=$newevent->id;
		fix_course_sortorder();
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newchat->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		fix_course_sortorder();
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newchat->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;
	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$idEncuesta = $instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		$instance['url']= urlcurso()."/mod/quiz/view.php?id=".$idEncuesta;
		$instance['course']= $data['course'];
		//$instance['module']= $newevent->modulename; //TODO revisar wel tipo de dato que se esta regresando
		$instance['module']= 0;
		fix_course_sortorder();
	}
	ob_end_clean();//Para que no imprima los echos
	return $instance;
}

/*
 $datosEncuesta = array(  'course' => '5','section'=>'40', 'name' => 'Nombre de la Encuesta', 'intro'=> 'Intro de la encuesta');
 $registrarEncuestas = moduloEncuestasRegistrarEncuestas($datosEncuesta);
 echo "Id Encuesta: ";
 print_r($registrarEncuestas);exit;*/

function moduloEncuestasObtenerEncuestas($datosCurso){
	ob_start(); //Para evitar que imprima los echos
	//revisionParametros($datosCurso);
	$course = get_record_sql("SELECT * FROM mdl_course WHERE id = ".$datosCurso['course']);
	$modinfo = get_fast_modinfo($course);
	$sectiones = $modinfo->cms;
	//echo "<pre>"; print_r($sectiones); exit;
	$contador = 0;
	foreach ($sectiones as $section) {
		if($datosCurso['section'] == null ){
			if($section->modname == 'quiz' ){
				$valores['id'] =  $section->id;
				$valores['name'] =  $section->name;
				$valores['url'] =  urlcursomoodle()."/mod/quiz/view.php?id=".$section->id."&AA=".$datosCurso['idAA'];
				$almacenarQuiz[$contador] = $valores;
				$contador++;
			}
		}elseif ($datosCurso['section'] == $section->sectionnum){
			if($section->modname == 'quiz' ){
				$valores['id'] =  $section->id;
				$valores['name'] =  $section->name;
				//$valores['url'] =  urlcursomoodle()."/mod/quiz/view.php?id=".$section->id;
				$valores['url'] =  urlcursomoodle()."/mod/quiz/view.php?id=".$section->id."&AA=".$datosCurso['idAA'];
				$almacenarQuiz[$contador] = $valores;
				$contador++;
			}
		} //elseif
	}//For
	$output['encuestas'] = $almacenarQuiz;
	ob_end_clean();//Para que no imprima los echos
	return $output;
}
/*
 $datosCurso = array( 'course' => '2','section'=>'');
 $obtenerEncuestas = moduloEncuestasObtenerEncuestas($datosCurso);
 echo "<pre>";
 print_r($obtenerEncuestas);
 echo "</pre>";
 exit;
 */

function moduloEncuestasObtenerTiposEncuestasGenerales($datosCurso){
	revisionParametros($datosCurso);
	ob_start(); //Para evitar que imprima los echos
	$course = get_records_sql("SELECT * FROM mdl_course_sections WHERE course = ".$datosCurso['course']);
	$sectiones = $course;
	$contador = 0;
	foreach ($sectiones as $section) {
		//echo "<pre>"; print_r($sectiones); exit;
		if(!empty($section->summary)  ){
			$valores['id'] =  $section->id;
			$valores['course'] =  $section->course;
			$valores['section'] =  $section->section;
			$valores['summary'] =  $section->summary;
			$valores['sequence'] =  $section->sequence;
			$valores['visible'] =  $section->visible;
			$almacenarTiposEncuestas[$contador] = $valores;
			$contador++;
		}
	}//For
	$output['tiposencuestas'] = $almacenarTiposEncuestas;
	//revisionParametros($output);
	ob_end_clean();//Para que no imprima los echos
	return $output;
}

/*
 $datosCurso = array( 'course' => '2');
 $obtenerTiposEncuestas = moduloEncuestasObtenerTiposEncuestasGenerales($datosCurso);
 echo "<pre>";
 print_r($obtenerTiposEncuestas);
 echo "</pre>";
 exit;
 */

function moduloEncuestasRegistrarTiposEncuestasGenerales($datosCurso){
	revisionParametros($datosCurso);
	ob_start(); //Para evitar que imprima los echos
	$sectionesA = 0 ;
	$course = get_records_sql("SELECT * FROM mdl_course_sections WHERE course = ".$datosCurso['course']);
	foreach ($course as $sectionA) {
		if(empty($sectionA->summary)){
			$valores['id'] =  $sectionA->id;
			$valores['course'] =  $sectionA->course;
			$valores['section'] =  $sectionA->section;
			$valores['summary'] =  $sectionA->summary;
			break;
			//usleep(5000000);
		}
	}//For

	//Actualizo/agrego la nueva encuesta
	$actualizacion = set_field("course_sections", "summary", $datosCurso['summary'], "id", $valores['id']);
	//sleep(30);
	$datoscourse = get_records_sql("SELECT * FROM mdl_course_sections WHERE course = ".$datosCurso['course']);
	//$sectiones = $course;
	$contador = 0;
	foreach ($datoscourse as $section) {
		if(!empty($section->summary)){
			$valoresActualizados['id'] =  $section->id;
			$valoresActualizados['course'] =  $section->course;
			$valoresActualizados['section'] =  $section->section;
			$valoresActualizados['summary'] =  $section->summary;
			$valoresActualizados['sequence'] =  $section->sequence;
			$valoresActualizados['visible'] =  $section->visible;
			$almacenarTiposEncuestas[$contador] = $valoresActualizados;
			$contador++;
		}
	}//For
	$output['tiposencuestas'] = $almacenarTiposEncuestas;
	revisionParametros($output);
	ob_end_clean();//Para que no imprima los echos
	return $output;
}

/*
 $datosCurso = array( 'course' => '2', 'summary' => 'MALDITA summary 00445500 ');
 $obtenerTiposEncuestas = moduloEncuestasRegistrarTiposEncuestasGenerales($datosCurso);
 echo "<pre>";
 print_r($obtenerTiposEncuestas);
 echo "</pre>";
 exit;
 */


function moduloEncuestasActualizarTiposEncuestasGenerales($datosCurso){
	revisionParametros($datosCurso);
	ob_start(); //Para evitar que imprima los echos
	$sectionesA = 0 ;
		$modulos = get_record('course_sections', 'id', $datosCurso['section']);
	$course = get_records_sql("SELECT * FROM mdl_course_sections WHERE course = ".$datosCurso['course']." AND section =".$modulos->section);
	foreach ($course as $sectionA) {
		$valores['id'] =  $sectionA->id;
		$valores['course'] =  $sectionA->course;
		$valores['section'] =  $sectionA->section;
		$valores['summary'] =  $sectionA->summary;
	}//For
	//Actualizo/agrego la nueva encuesta
	$actualizacion = set_field("course_sections", "summary", $datosCurso['summary'], "id", $valores['id']);
	$datoscourse = get_records_sql("SELECT * FROM mdl_course_sections WHERE course = ".$datosCurso['course']);
	$contador = 0;
	foreach ($datoscourse as $section) {
		if(!empty($section->summary)){
			$valoresActualizados['id'] =  $section->id;
			$valoresActualizados['course'] =  $section->course;
			$valoresActualizados['section'] =  $section->section;
			$valoresActualizados['summary'] =  $section->summary;
			$valoresActualizados['sequence'] =  $section->sequence;
			$valoresActualizados['visible'] =  $section->visible;
			$almacenarTiposEncuestas[$contador] = $valoresActualizados;
			$contador++;
		}
	}//For
	$output['tiposencuestas'] = $almacenarTiposEncuestas;
	revisionParametros($output);
	ob_end_clean();//Para que no imprima los echos
	return $output;
}

/*
$datosCurso = array( 'course' => '2', 'summary' => 'BONITA summary 00445500', 'section'=>40);
$obtenerTiposEncuestas = moduloEncuestasActualizarTiposEncuestasGenerales($datosCurso);
echo "<pre>";
print_r($obtenerTiposEncuestas);
echo "</pre>";
exit;
*/



function moduloEncuestasDireccionarEncuestas($datosCurso){
	ob_start(); //Para evitar que imprima los echos
	$url =  urlcursomoodle()."/mod/quiz/index.php?id=".$datosCurso['id']."&AA=".$datosCurso['id'];
	ob_end_clean();//Para que no imprima los echos
	return $url;
}
/*
$datosCurso = array( 'course' => '2');
$obtenerDireccionEncuestas = moduloEncuestasDireccionarEncuestas($datosCurso);
echo "<pre>"; print_r($obtenerDireccionEncuestas); exit;
*/


function moduloEncuestasResponderEncuesta($idEncuesta){
	ob_start(); //Para evitar que imprima los echos
	$responder =  urlcursomoodle()."/mod/quiz/attempt.php?id=".$idEncuesta['id']."&AA=".$idEncuesta['idAA'];
	return $responder;
}
/*
$idEncuesta = array( 'id' => '416');
$obtenerDireccionEncuestas = moduloEncuestasResponderEncuesta($idEncuesta);
echo "<pre>"; print_r($obtenerDireccionEncuestas); exit;
*/













?>
