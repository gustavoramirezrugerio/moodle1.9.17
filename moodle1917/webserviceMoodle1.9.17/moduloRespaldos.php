<?php
function moduloEncuestasRegistrarEncuestas($data){
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
		$instance['module']= $newevent->modulename;
		fix_course_sortorder();
	}
	return $instance;
}

/*
 $datosEncuesta = array(  'course' => '5','section'=>'40', 'name' => 'Nombre de la Encuesta', 'intro'=> 'Intro de la encuesta');
 $registrarEncuestas = moduloEncuestasRegistrarEncuestas($datosEncuesta);
 echo "Id Encuesta: ";
 print_r($registrarEncuestas);exit;*/

function modulosMoodle($datos){
	$modulos = get_records('modules');
	foreach ($modulos as $modulo) {
		if ("'".$modulo->name."'" == "'".$datos->name."'" ){
			return $modulo->id;
		}
	}
}

	/*
	$instancename = format_string($modinfo->cms[$modnumber]->name, true,  $course->id);
	print_r($instancename);//GUSS_TRAE EL NOMBRE DE LOS ELEMENTOS
	*/
function moduloEncuestasObtenerEncuestas($datosCurso){
	/*
	$section = get_record_sql("SELECT * FROM mdl_course_sections WHERE course = 2");
	$course = get_record_sql("SELECT * FROM mdl_course WHERE id = 2");
	$modinfo = get_fast_modinfo($course);
	$sectionmods = explode(",", $section->sequence);
	foreach ($sectionmods as $modnumber) {
		$instancename = format_string($modinfo->cms[$modnumber]->name, true,  $datosCurso['course']);
	}
	//echo "<pre>"; print_r($instancename); exit;
	 */
	$course = get_record_sql("SELECT * FROM mdl_course WHERE id = 2");
	$modinfo = get_fast_modinfo($course);
	$sectiones = $modinfo->cms;
	//echo "<pre>"; print_r($sectiones); exit;
	$contador = 0;
	
	foreach ($sectiones as $section) {
		//echo "<pre>"; print_r($section); exit;
		//Identificamos los elementos tipo QUIZ
		if($section->modname == 'quiz' ){
			//echo "Salio"; exit;
			//$instancename = format_string($modinfo->cms[$section]->name, true,  $datosCurso['course']);
			//echo "<pre>"; print_r($instancename); exit;
			$valores['id'] =  $section->id;
			$valores['name'] =  $section->name;
			$almacenarQuiz[$contador] = $valores;
			$contador++;

		}
	}
	echo "<pre>"; print_r($almacenarQuiz); exit;


	
	
	
	//echo "<pre>"; print_r($datos); exit;
	
		
	/*
	//Validar el quiz en BD 
	$datos = new stdClass();
	$datos->name = 'quiz';
	$idQuiz = modulosMoodle($datos);
	//Obtenemos todos los recuros y actividades de la seccion 
	$sectiones = get_records_sql("SELECT * FROM mdl_course_modules WHERE course = ".$datosCurso['course']." AND section = ".$datosCurso['section']);
	$contador = 0;
	foreach ($sectiones as $section) {
		//Identificamos los elementos tipo QUIZ  
		if($section->module == $idQuiz ){
			//echo "Salio"; exit;
			//$instancename = format_string($modinfo->cms[$section]->name, true,  $datosCurso['course']);
			//echo "<pre>"; print_r($instancename); exit;
			$valores['id'] =  $section->id;
			$valores['name'] =  "nombre del quiz".$section->id;
			$almacenarQuiz[$contador] = $valores;
			$contador++;
				
		}
	}
	echo "<pre>"; print_r($almacenarQuiz); exit;
	*/
}


$datosCurso = array( 'course' => '2','section'=>'2');
$course = array( 'courseid' => '2');
$obtenerEncuestas = moduloEncuestasObtenerEncuestas($datosCurso, $course);
echo "<pre>";
print_r($obtenerEncuestas);
echo "</pre>";
exit;

































?>
