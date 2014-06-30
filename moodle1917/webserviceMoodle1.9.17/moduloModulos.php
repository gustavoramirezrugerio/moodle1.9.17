<?php
/////////////////////////////////////////	Registro de modulos 	/////////////////////////////////
function modulomodulosRegistrarChat($data){
	$newchat = new stdClass();
	$newchat->course = utf8_encode($data['course']);
	$newchat->name = utf8_encode($data['name']);
	$newchat->intro = utf8_encode($data['intro']);
	$newchat->keepdays = 0;
	$newchat->studentlogs = 0;
	$newchat->chattime = time();
	$newchat->schedule = 0;
	$newchat->timemodified = time();
	$newchat->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);
	if (!$newchat->id = insert_record('chat', $newchat) ) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newchat->context = get_context_instance(CONTEXT_COURSE, $newchat->id);
		mark_context_dirty($newchat->context->path);
		$data['id']=$newchat->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newchat->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newchat->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = chat;
	$newevent->instance = $newchat->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();
	$newevent->id_gestor = utf8_encode($data['id_gestor']);

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);
	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert chat '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newchat->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);
	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);

		$instance['id']=$newinstance->id;

		
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
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		
	}
	return $instance;
}

/*
 $chat = array(  'course' => '129', 'name' => 'CHAT ', 'intro'=> 'asdsada', 'section'=>'434');
 $resultado4 = modulomodulosRegistrarChat($chat);
 echo "<pre>";
 print("modulomodulos Registrar Chat\n");
 print_r($resultado4);
 echo "</pre>";
 */

//--------------

function modulomodulosRegistrarWiki($data){
	revisionParametros($data);
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);
	$newwiki->modulename = 'wiki';
	$newwiki->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('wiki', $newwiki) ) {
		throw new Exception("Could not insert wiki '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = wiki;
	$newevent->instance = $newwiki->id;
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

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert chat '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		

		$instance['id']=$newevent->id;

		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert wiki '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;
	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	return $instance;
}

/*
 $data = array(  'name' => 'Registar WIKI', 'summary' => 'WIKI summary ', 'pagename'=> 'pagenameWIKI SW', 'course'=>'129', 'section'=>'434', 'id_gestor'=>'5050');
 $resultado4 = modulomodulosRegistrarWiki($data);
 echo "<pre>";
 print("modulomodulos Registrar WIKI\n");
 print_r($resultado4);
 echo "</pre>";
 */

//-------------

function modulomodulosRegistraForo($data){
	//id 	course 	type 	name 	intro 	assessed 	assesstimestart 	assesstimefinish 	scale 	maxbytes 	forcesubscribe 	trackingtype 	rsstype 	rssarticles 	timemodified 	warnafter 	blockafter 	blockperiod
	$newchat = new stdClass();
	$newchat->course = utf8_encode($data['course']);
	$newchat->type = utf8_encode($data['type']);
	$newchat->name = utf8_encode($data['name']);
	$newchat->intro = utf8_encode($data['intro']);
	$newchat->timemodified = time();
	$newchat->id_gestor = utf8_encode($data['id_gestor']);
	$USER = insert_record('user', 'id', 2);
	if (!$newchat->id = insert_record('forum', $newchat) ) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newchat->context = get_context_instance(CONTEXT_COURSE, $newchat->id);
		mark_context_dirty($newchat->context->path);
		$data['id']=$newchat->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newchat->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newchat->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = forum;
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

	$USER = insert_record('user', 'id', 2);
	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert chat '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
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
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	return $instance;
}



function modulomodulosRegistraBase($data){
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);
	$newwiki->modulename = 'data';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('data', $newwiki) ) {
		throw new Exception("Could not insert quiz '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = data;
	$newevent->instance = $newwiki->id;
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
		throw new Exception("Could not insert quiz '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert quiz '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;
	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	revisionParametros($instance);
	return $instance;
}

/*
 $data = array(  'name' => 'Registar BASE',  'section'=>'434', 'course'=>'129');
 $resultado4 = modulomodulosRegistraBase($data);
 echo "<pre>";
 print("modulomodulos Registrar BASE\n");
 print_r($resultado4);
 echo "</pre>";
 */



function modulomodulosRegistraGlosario($data){
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->module = utf8_encode($data['module']);
	//CAMBIO
	$newwiki->modulename = 'glossary';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);

	$newwiki->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);
	if (!$newwiki->id = insert_record('glossary', $newwiki) ) {
		//CAMBIO
		throw new Exception("Could not insert data '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}
	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = glossary;
	$newevent->instance = $newwiki->id;

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
		throw new Exception("Could not insert Glosario '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		

		$instance['id']=$newevent->id;

		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	//CAMBIO
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;

	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);
	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);

		$instance['id']=$newinstance->id;

		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;

	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);
	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);

		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	return $instance;
}

/*
 $data = array(  'name' => 'Registar Glosario',  'section'=>'434', 'course'=>'129');
 $resultado4 = modulomodulosRegistraGlosario($data);
 echo "<pre>";
 print("modulomodulos Registrar BASE\n");
 print_r($resultado4);
 echo "</pre>";
 */


function modulomodulosRegistraLeccion($data){
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();

	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);
	$newwiki->modulename = 'lesson';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->id_gestor = utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('lesson', $newwiki) ) {
		throw new Exception("Could not insert lesson '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = 'lesson';
	$newevent->instance = $newwiki->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();
	$newevent->id_gestor =  utf8_encode($data['id_gestor']);

	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert chat '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;
	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	return $instance;
}
/*
 $data = array(  'name' => 'Registar lesson',  'section'=>'434', 'course'=>'129');
 $resultado4 = modulomodulosRegistraLeccion($data);
 echo "<pre>";
 print("modulomodulos Registrar lesson\n");
 print_r($resultado4);
 echo "</pre>";
 */


//-------------


//-------------
function modulomodulosRegistraCuestionario($data){
	$newchat = new stdClass();
	$newchat->course = utf8_encode($data['course']);
	$newchat->name = utf8_encode($data['name']);
	$newchat->intro = utf8_encode($data['intro']);
	$newchat->timemodified = time();
	$newchat->id_gestor = utf8_encode($data['id_gestor']);

	//$USER = insert_record('user', 'id', 2);

	if (!$newchat->id = insert_record('quiz', $newchat) ) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newchat->context = get_context_instance(CONTEXT_COURSE, $newchat->id);
		//mark_context_dirty($newchat->context->path);
		$data['id']=$newchat->id;
		// //TODO revisar si no le afecta esta funcion
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
	//revisionParametros($idRecursoActividad);

	//$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert chat '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
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

	//$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		//mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		//
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

	//$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		//mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		//
	}
	//Actualizar mdl_grade_items

	/*UPDATE mdl_grade_items SET 
	courseid = '2',	categoryid = '1',	itemname = 'MIQUIZ',	itemtype = 'mod',
	itemmodule = 'quiz',	iteminstance = '1',	itemnumber = '0',	iteminfo = NULL,
	idnumber = '',	calculation = NULL,	gradetype = '1',	grademax = '10',
	grademin = '0',	scaleid = NULL,	outcomeid = NULL,	gradepass = '0.00000',
	multfactor = '1',	plusfactor = '0',	aggregationcoef = '0',	sortorder = '2',
	display = '0',	decimals = NULL, hidden = '1',   locked = '0',
	locktime = '0',  needsupdate = '0',  timecreated = '1381875130',  timemodified = '1381875216' 
	WHERE id = 2

	$gradesItems = new stdClass();
	$gradesItems->courseid = 2;

	if (!$addsection->id = update_record('mdl_grade_items', $addsection)) {
		throw new Exception("Could not insert chat '$newchat->name' ");
	} */

	return $instance;
}

// $Quiz = array(  'course' => '3', 'section'=>'13', 'name' => 'WS_WS_02', 'intro'=> 'WS_WS_01');
// $resultado4 = modulomodulosRegistraCuestionario($Quiz);
// echo "<pre>"; print_r($resultado4); exit;


//-------------
function modulomodulosRegistrarAgregarRecurso($data){

	$newResource = new stdClass();
	$newResource->course = utf8_encode($data['course']);
	$newResource->name = utf8_encode($data['name']);
	$newResource->type = utf8_encode($data['type']);
	switch ($module->type){
		case 'text':
			// Compose a text page
			$newResource->reference  = utf8_encode($data['reference']);
			$newResource->summary = utf8_encode($data['summary']);
			$newResource->alltext = utf8_encode($data['alltext']);
			break;
		case 'html':
			// Compose a web page
			$newResource->summary = utf8_encode($data['summary']);
			$newResource->alltext = utf8_encode($data['alltext']);
			break;
		case 'file':
			// Link to a file or website
			$newResource->reference  = utf8_encode($data['reference']);
			$newResource->summary = utf8_encode($data['summary']);
			break;
		case 'directory':
			// Display a directory
			$newResource->summary = utf8_encode($data['summary']);
			break;
		case 'ims':
			// Add an IMS Content Package
			$newResource->summary = utf8_encode($data['summary']);
			$newResource->alltext = utf8_encode($data['alltext']);
			break;
	}

	$newResource->popup = "";
	$newResource->options = "";
	$newResource->timemodified = time();

	$USER = insert_record('user', 'id', 2);
	//echo "<pre>"; print_r($newResource); exit;
	$newResource->id = insert_record('resource', $newResource);
	/*TODO revisar la insercion del modulo RECURSOS
	if (!$newResource->id = insert_record('resource', $newResource) ) {
		throw new Exception("Could not insert resource '$newResource->name' ");
	} else {
		$newResource->context = get_context_instance(CONTEXT_COURSE, $newResource->id);
		mark_context_dirty($newResource->context->path);
		$data['id']=$newResource->id;
		
	}
	echo "0000"; exit;
	*/

	$newevent = new stdClass();
	$newevent->courseid =  $newResource->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = utf8_encode($data['summary']);
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = resource;
	$newevent->instance = $newResource->id;
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
		throw new Exception("Could not insert resource '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newResource->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert resource '$newResource->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newResource->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;
	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert resource '$newResource->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$newevent->id;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	return $instance;
}

//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso text ::','type' => 'text', 'reference'=> 'http://localhost/#', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso html ::','type' => 'html', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso file ::','type' => 'file', 'filter.htm', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso directory ::','type' => 'directory', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
/*
 $recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso ims ::','type' => 'ims', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
 $resultado4 = modulomodulosRegistrarAgregarRecurso($recurso);
 echo "<pre>"; print_r($resultado4); echo "</pre>";
*/


function modulomodulosRegistrarEtiqueta($data){
	$newResource = new stdClass();
	$newResource->course = utf8_encode($data['course']);
	$newResource->name = utf8_encode($data['name']);
	$newResource->type = "file";
	$newResource->content = utf8_encode($data['content']);
	$newResource->alltext = "";
	$newResource->popup = "";
	$newResource->options = "";
	$newResource->timemodified = time();
	$newResource->id_gestor = utf8_encode($data['id_gestor']);
	$USER = insert_record('user', 'id', 2);
	if (!$newResource->id = insert_record('label', $newResource) ) {
		throw new Exception("Could not insert label '$newResource->name' ");
	} else {
		$newResource->context = get_context_instance(CONTEXT_COURSE, $newResource->id);
		mark_context_dirty($newResource->context->path);

		$data['id']=$newResource->id;

		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newResource->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->content = utf8_encode($data['content']);
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = label;
	$newevent->instance = $newResource->id;

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
		throw new Exception("Could not insert label '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		

		$instance['id']=$newevent->id;

		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = 9;
	$newinstance->instance = $newResource->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;

	$newinstance->id_gestor =utf8_encode($data['id_gestor']);


	$USER = insert_record('user', 'id', 2);
	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert label '$newResource->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);

		$instance['id']=$newinstance->id;

		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;

	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newResource->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);
	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert label '$newResource->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$newevent->id;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;

		
	}
	return $instance;
}

/*
 $chat = array(  'course' => '129', 'name' => 'ETIQUETASSSS ', 'content'=> 'content :: assssdsadaddddddddddddd', 'section'=>'433');
 $resultado4 = modulomodulosRegistrarEtiqueta($chat);
 echo "<pre>";
 print("modulomodulos Registrar Chat\n");
 print_r($resultado4);
 echo "</pre>";
 */


function modulomodulosRegistraConsulta($data){
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);

	$newwiki->modulename = 'choice';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->text = utf8_encode($data['text']);
	$newwiki->name = utf8_encode($data['name']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('choice', $newwiki) ) {
		throw new Exception("Could not insert choice '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->text = $newwiki->text;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = choice;
	$newevent->instance = $newwiki->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert  '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor  = $data['id_gestor'];

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert choice '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert chat '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['text']=$addsection->text;
		$instance['instance']=$newinstance->id;
		
	}
	return $instance;
}

/*
 $data = array(  'name' => 'Registar Consulta',  'section'=>'433', 'course'=>'129');
 $resultado4 = modulomodulosRegistraConsulta($data);
 echo "<pre>";
 print_r($resultado4);
 echo "</pre>";
 */


function modulomodulosRegistraEncuesta($data){
	//revisionParametros($data);
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);
	$newwiki->modulename = 'survey';
	$newwiki->template = 4;
	$newwiki->groupmode = 1;
	$newwiki->groupmode = 1;
	$newwiki->groupmode = 1;

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('survey', $newwiki) ) {
		throw new Exception("Could not insert survey '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = survey;
	$newevent->instance = $newwiki->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);
	revisionParametros($newinstance);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert survey '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor  = $data['id_gestor'];;


	$USER = insert_record('user', 'id', 2);
	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert survey '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);

		$instance['id']=$newinstance->id;

		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;

	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$USER = insert_record('user', 'id', 2);
	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert survey '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);

		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		
	}
	return $instance;
}

/*
 $data = array(  'name' => 'Registar survey', 'summary' => 'Registar survey',  'section'=>'54', 'course'=>'3');
 $resultado4 = modulomodulosRegistraEncuesta($data);
 echo "<pre>";
 print_r($resultado4);
 echo "</pre>";
 */

function modulomodulosRegistraModuloEncuesta($data){
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);

	$newwiki->modulename = 'survey';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->text = utf8_encode($data['text']);
	$newwiki->name = utf8_encode($data['name']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('survey', $newwiki) ) {
		throw new Exception("Could not insert survey '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->text = $newwiki->text;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = choice;
	$newevent->instance = $newwiki->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert  '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor  = $data['id_gestor'];

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert survey '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert survey '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['text']=$addsection->text;
		$instance['instance']=$newinstance->id;
		
	}
	return $instance;
}

/*
 $data = array(  'name' => 'Registar feedbak', 'summary' => 'Registar feedback summary',  'section'=>'433', 'course'=>'129');
 $resultado4 = modulomodulosRegistraModuloEncuesta($data);
 echo "<pre>";
 print_r($resultado4);
 echo "</pre>";
 */



function modulomodulosRegistraScorm($data){ // CHOISE
	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->timemodified = time();
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->module = utf8_encode($data['module']);
	$newwiki->modulename = 'scorm';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('scorm', $newwiki) ) {
		throw new Exception("Could not insert choice '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = scorm;
	$newevent->instance = $newwiki->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);
	revisionParametros($idRecursoActividad);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert scorm '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor  = $data['id_gestor'];

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert choice '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert scorm '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		
	}
	return $instance;
}

/*
 $data = array(  'name' => 'Registar scorm-----------------',  'section'=>'433', 'course'=>'129');
 $resultado4 = modulomodulosRegistraScorm($data);
 echo "<pre>";
 print_r($resultado4);
 echo "</pre>";
 */


function modulomodulosRegistraTarea($data){

	$newwiki = new stdClass();
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->intro = utf8_encode($data['intro']);
	$newwiki->keepdays = 0;
	$newwiki->studentlogs = 0;
	$newwiki->chattime = time();
	$newwiki->schedule = 0;
	$newwiki->assignmenttype = utf8_encode($data['assignmenttype']);

	switch ($module->type){
		case 'upload':
			// Subida avanzada de archivos (upload)
			$newwiki->assignmenttype = utf8_encode($data['assignmenttype']);
			$newwiki->resubmit = '1';
			break;
		case 'online':
			// Texto en linea (online)
			$newwiki->assignmenttype = utf8_encode($data['assignmenttype']);
			$newwiki->resubmit = '0';
			break;
		case 'uploadsingle':
			// Subir solo un archivo (uploadsingle)
			$newwiki->assignmenttype = utf8_encode($data['assignmenttype']);
			$newwiki->resubmit = '0';
			break;
		case 'offline':
			// Actividad no en linea (offline)
			$newwiki->assignmenttype = utf8_encode($data['assignmenttype']);
			$newwiki->resubmit = '0';
			break;
	}

	$newwiki->description = utf8_encode($data['description']);
	$newwiki->timemodified = time();
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->summary = utf8_encode($data['summary']);
	$newwiki->wtype = utf8_encode($data['wtype']);
	$newwiki->ewikiprinttitle = 1;
	$newwiki->ewikiprinttitleewikiprinttitle = 0;
	$newwiki->pagename = utf8_encode($data['pagename']);
	$newwiki->course = utf8_encode($data['course']);
	$newwiki->module = utf8_encode($data['module']);
	$newwiki->modulename = 'assignment';
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);
	$newwiki->name = utf8_encode($data['name']);

	$USER = insert_record('user', 'id', 2);

	if (!$newwiki->id = insert_record('assignment', $newwiki) ) {
		throw new Exception("Could not insert assignment '$newwiki->name' ");
	} else {
		$newwiki->context = get_context_instance(CONTEXT_COURSE, $newwiki->id);
		mark_context_dirty($newwiki->context->path);
		$data['id']=$newwiki->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newwiki->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = $newwiki->intro;
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = assignment;
	$newevent->instance = $newwiki->id;
	$newevent->eventtype  =0;
	$newevent->timestart = time();
	$newevent->timeduration = 0;
	$newevent->visible  = 1;
	$newevent->uuid  ="";
	$newevent->sequence  = 1;
	$newevent->timemodified = time();

	//Obtenemos el ID del modulo
	$datos = new stdClass();
	$datos->name =  $newevent->modulename;
	$idRecursoActividad = idRecursoActividad($datos);

	$USER = insert_record('user', 'id', 2);

	if (!$newevent->id = insert_record('event', $newevent)) {
		throw new Exception("Could not insert assignment '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newwiki->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor  = $data['id_gestor'];

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert assignment '$newwiki->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newwiki->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert assignment '$newwiki->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$addsection->id;
		$instance['name']=$addsection->name;
		$instance['intro']=$addsection->intro;
		$instance['instance']=$newinstance->id;
		
	}
	return $instance;
}

//$data = array(  'name' => 'Registar Tarea :: upload','assignmenttype'=>'upload','description'=>'description :: upload', 'section'=>'433', 'course'=>'129');
//$data = array(  'name' => 'Registar Tarea :: online','assignmenttype'=>'online','description'=>'description::online', 'section'=>'433', 'course'=>'129');
//$data = array(  'name' => 'Registar Tarea :: uploadsingle','assignmenttype'=>'uploadsingle','description'=>'description::uploadsingle', 'section'=>'433', 'course'=>'129');
//$data = array(  'name' => 'Registar Tarea :: offline','assignmenttype'=>'offline','description'=>'description :: offline', 'section'=>'433', 'course'=>'129');

/*
 $resultado4 = modulomodulosRegistraTarea($data);
 echo "<pre>";
 print_r($resultado4);
 echo "</pre>";
 */


///////////////////////////////////////	Eliminar de modulos 	/////////////////////////////////


function modulomodulosEliminarModulos($idRecursoActividad) {
	$modulos=get_record('course_modules', 'id', $idRecursoActividad['id']);
	if($modulos){
		$delete=$modulos->instance;

		if($modulos->module==4){
			delete_records('data', 'id', $delete);
		}

		if($modulos->module==2){
			delete_records('chat', 'id', $delete);
		}

		if($modulos->module==3){
			delete_records('choice', 'id', $delete);
		}

		if($modulos->module==12){
			delete_records('quiz', 'id', $delete);
		}

		if($modulos->module==5){
			delete_records('forum', 'id', $delete);
		}

		if($modulos->module==6){
			delete_records('glossary', 'id', $delete);
		}

		if($modulos->module==11){
			delete_records('lesson', 'id', $delete);
		}

		if($modulos->module==15){
			delete_records('scorm', 'id', $delete);
		}

		if($modulos->module==17){
			delete_records('wiki', 'id', $delete);
		}
		if($modulos->module==19){
			delete_records('feedback', 'id', $delete);
		}

		delete_course_module($idRecursoActividad['id']);
		$idRecursoActividad['eliminado'] = 1;
		return $idRecursoActividad;
	}
	else {
		$idRecursoActividad['eliminado'] = 0;
		return $idRecursoActividad;
	}
}

/*
 $idRecursoActividad = array(   'id' => '231');
 $resultado5 = modulomodulosEliminarModulos($idRecursoActividad);
 echo "<pre>";
 print("eliminarModulos chat\n");
 print_r($resultado5);
 echo "</pre>";
 */


///////////////////////////////////////	OCULTAR / MOSTRAR modulos 	/////////////////////////////////


function modulomodulosOcultarMostrarMoulo($modulo) {
	revisionParametros($modulo);
	$consulta= get_record('course_modules' ,'id', $modulo['id']);
	if($consulta->visible==1){
		return set_field('course_modules', 'visible', 0 , 'id',$modulo['id']);
	}else{
		return set_field('course_modules', 'visible', 1 , 'id',$modulo['id']);
	}
}


///////////////////////////////////////	EDITAR modulos 	/////////////////////////////////
function modulomodulosEditarModulos($data,$mod){ // vhackero 18/12/12 vhackero@gmail.com
	//return $mod;
	ob_start (); // Para evitar que imprima los echos
	global $COURSE, $CFG;
	require_once ($CFG->dirroot.'/course/moodleform_mod.php');
	$update = $data['id'];
	$cm = get_record("course_modules", "id", $update); // Instancia del mÃ³dulo que se estÃ¡ editando

	//revisionParametros($data);
	$estructuraDidactica = new stdClass();
	$estructuraDidactica->id  = $data['id'];
	$estructuraDidactica->id_gestor  = $data['id_gestor'];
	$actualizoestructuraDidactica = update_record('course_modules', $estructuraDidactica);
	revisionParametros($actualizo);


	$course = get_record("course", "id", $cm->course); // Curso
	$module = get_record("modules", "id", $cm->module); // Datos del mÃ³dulo a esditar
	$form = get_record($module->name, "id", $cm->instance); // Datos para modificar
	$cw = get_record("course_sections", "id", $cm->section); // Datos de la secciÃ³n en la que se encuentra
	$modlib = "$CFG->dirroot/mod/$module->name/lib.php";
	if (file_exists($modlib)) {
		include_once($modlib);
	} else {
		error("En el servicio web :: ¡Imposible obtener la libreria al editar módulo! ($modlib)");
	}
	$form->coursemodule     = $cm->id;
	$form->section          = $cw->section;  // The section number itself - relative!!! (section column in course_sections)
	$form->visible          = $cm->visible; //??  $cw->visible ? $cm->visible : 0; // section hiding overrides
	$form->cmidnumber       = $cm->idnumber;          // The cm IDnumber
	$form->groupmode        = groups_get_activity_groupmode($cm); // locked later if forced
	$form->groupingid       = $cm->groupingid;
	$form->groupmembersonly = $cm->groupmembersonly;
	$form->course           = $course->id;
	$form->module           = $module->id;
	$form->modulename       = $module->name;
	$form->instance         = $cm->instance;
	$form->update           = $update;

	//$form->reference = utf8_encode($mod['reference']);

	switch ($module->name){
		case 'chat':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;
		case 'data':
			$form->name = utf8_encode($mod['name']);
			$form->timemodified = time();
			break;
		case 'choice':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;
		case 'quiz':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;
		case 'survey':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;
		case 'feedback':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;
		case 'lesson':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;

		case 'scorm':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;

		case 'assignment':
			$form->name = utf8_encode($mod['name']);
			$form->intro = utf8_encode($mod['intro']);
			$form->chattime = time();
			break;

		case 'wiki':
			$form->name = utf8_encode($mod['name']);
			$form->chattime = time();
			break;

		case 'forum':
			$form->name = utf8_encode($mod['name']);
			$form->timemodified = time();

			break;

		case 'glossary':
			//$form->type ="file";
			$form->name = utf8_encode($mod['name']);
			$form->windowpopup = 0;
			$form->mform_showadvanced_last = 0;
			$form->width = 620;
			$form->height = 450;

			break;
		case 'label':
			$form->name = utf8_encode($mod['name']);
			$form->content = utf8_encode($mod['content']);
			$form->timemodified = time();
			break;

		case 'resource':
			$form->name = utf8_encode($mod['name']);
			$form->type = utf8_encode($mod['type']);
			break;
	}

	$CFG->pagepath = 'mod/'.$module->name;
	if (!empty($form->type)) {
		$CFG->pagepath .= '/'.$form->type;
	} else {
		$CFG->pagepath .= '/mod';
	}
	$updateinstancefunction = $form->modulename."_update_instance";
	//return $updateinstancefunction

	$returnfromfunc = $updateinstancefunction($form);
	if (!$returnfromfunc) {
		error("Desde el Servicio Web no se pudo actualizar el ".utf8_encode($mod['name']), "view.php?id=$course->id");
	}

	if (is_string($returnfromfunc)) {
		error($returnfromfunc, "view.php?id=$course->id");
	}

	set_coursemodule_visible($form->coursemodule, $form->visible);
	set_coursemodule_groupmode($form->coursemodule, $form->groupmode);
	set_coursemodule_groupingid($form->coursemodule, $form->groupingid);
	set_coursemodule_groupmembersonly($form->coursemodule, $form->groupmembersonly);

	if (isset($form->cmidnumber)) {
		set_coursemodule_idnumber($form->coursemodule, $form->cmidnumber);
	}

	add_to_log($course->id, "course", "update mod desde ws ","../mod/$form->modulename/view.php?id=$form->coursemodule","$form->modulename $form->instance");
	add_to_log($course->id, $form->modulename, "update desde ws","view.php?id=$form->coursemodule","$form->instance", $form->coursemodule);

	rebuild_course_cache($course->id);
	//print_r($form); exit;
	ob_end_clean (); // Para que no imprima los echos
	return $data;
}

/*
 $mod = array('name' => 'Recurso :: text', 'type'=> 'text', 'summary'=> 'summary ws');
 $mod = array('name' => 'Recurso :: html', 'type'=> 'html', 'summary'=> 'summary ws');
 $mod = array('name' => 'Recurso :: file', 'type'=> 'file', 'summary'=> 'summary ws');
 $mod = array('name' => 'Recurso :: directory', 'type'=> 'directory', 'summary'=> 'summary ws');
 $mod = array('name' => 'Recurso :: ims', 'type'=> 'ims', 'summary'=> 'summary ws');
 */


/*
 $mod = array('name' => 'Recurso :: file', 'type'=> 'file', 'reference'=> 'http://google.com/');
 $chat = array('id' => '281');
 $resultado5 =modulomodulosEditarModulos($chat,$mod);
 echo "<pre>";
 print("Editar modulo\n");
 print_r($resultado5);
 echo "</pre>";
 */


function modulomodulosAgregarModulos($data) {// vhackero 18/12/12 vhackero@gmail.com
	global $COURSE, $CFG;

	require_once ($CFG->dirroot.'/course/moodleform_mod.php');

	$course = get_record("course", "id", $data['course']); // Curso
	$context = get_context_instance(CONTEXT_COURSE, $course->id); // COntexto de este curso
	$module = get_record("modules", "name", $data['add']);
	$cw = get_course_section($data['section'], $course->id);

	$modlib = "$CFG->dirroot/mod/$module->name/lib.php";
	if (file_exists($modlib)) {
		include_once($modlib);
	} else {
		error("En el servicio web :: Imposible obtener la libreria al crear modulo ($modlib)");
	}

	$cm = null;

	$form->section          = $data['section'];  // The section number itself - relative!!! (section column in course_sections)
	$form->visible          = $cw->visible;
	$form->course           = $course->id;
	$form->module           = $module->id;
	$form->modulename       = $module->name;
	$form->groupmode        = $course->groupmode;
	$form->groupingid       = $course->defaultgroupingid;
	$form->groupmembersonly = 0;
	$form->instance         = '';
	$form->coursemodule     = '';
	$form->add              = $data['add'];

	$form->name = utf8_encode($data ['name']);

	switch ($module->name){
		case 'chat':
			$form->intro = utf8_encode($data['intro']);
			$form->chattime = time();
			$form->keepdays = 0;
			$form->studentlogs = 0;
			$form->schedule = 0;
			break;
		case 'forum':
			$form->intro = utf8_encode($data['intro']);
			// Por hacer... -->
			$form->assessed = 5;
			$form->scale = 50;
			$form->ratingtime = 1;
			$form->assesstimestart = time(); // Hoy
			$form->assesstimefinish = time() + (7 * 24 * 60 * 60); // más una semana
			$form->blockperiod = 518400;
			$form->blockafter = 1;
			$form->warnafter = 1;
			// Por hacer <--

			break;
		case 'resource':
			$form->type ="file";
			$form->summary = utf8_encode($data['intro']);
			$form->reference = utf8_encode($data['reference']);
			$form->windowpopup = 1;
			$form->mform_showadvanced_last = 0;
			$form->width = 620;
			$form->height = 450;
			break;
		case 'glossary':
			$form->type ="file";
			$form->summary = utf8_encode($data['intro']);
			$form->reference = utf8_encode($data['url']);
			break;
		case 'label':
			$form->type ="file";
			$form->summary = utf8_encode($data['intro']);
			$form->reference = utf8_encode($data['url']);
			break;
		case 'quiz':
			$form->intro = utf8_encode($data['intro']);
			$form->timeopen =  time(); // Forzar Hoy
			$form->timeclose = time() + (7 * 24 * 60 * 60); // Forzar m�s una semana
			$form->created = time(); // Forzar ahora
			$form->timelimit = $CFG->quiz_timelimit;
			$form->timelimitenable = !empty($CFG->quiz_timelimit);
			$form->delay1 = $CFG->quiz_delay1;
			$form->delay2 = $CFG->quiz_delay2;
			$form->questionsperpage = $CFG->quiz_questionsperpage;
			$form->shufflequestions = $CFG->quiz_shufflequestions;
			$form->shuffleanswers = $CFG->quiz_shuffleanswers;
			$form->attempts = $CFG->quiz_attempts;
			$form->attemptonlast = $CFG->quiz_attemptonlast;
			$form->adaptive = $CFG->quiz_optionflags & QUESTION_ADAPTIVE;
			$form->grademethod = $CFG->quiz_grademethod;
			$form->penaltyscheme = $CFG->quiz_penaltyscheme;
			$form->decimalpoints = $CFG->quiz_decimalpoints;
			$form->responsesimmediately = $CFG->quiz_review & QUIZ_REVIEW_RESPONSES & QUIZ_REVIEW_IMMEDIATELY;
			$form->answersimmediately = $CFG->quiz_review & QUIZ_REVIEW_ANSWERS & QUIZ_REVIEW_IMMEDIATELY;
			$form->feedbackimmediately = $CFG->quiz_review & QUIZ_REVIEW_FEEDBACK & QUIZ_REVIEW_IMMEDIATELY;
			$form->generalfeedbackimmediately = $CFG->quiz_review & QUIZ_REVIEW_GENERALFEEDBACK & QUIZ_REVIEW_IMMEDIATELY;
			$form->scoreimmediately = $CFG->quiz_review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_IMMEDIATELY;
			$form->overallfeedbackimmediately = $CFG->quiz_review & QUIZ_REVIEW_OVERALLFEEDBACK & QUIZ_REVIEW_IMMEDIATELY;
			$form->responsesopen = $CFG->quiz_review & QUIZ_REVIEW_RESPONSES & QUIZ_REVIEW_OPEN;
			$form->answersopen = $CFG->quiz_review & QUIZ_REVIEW_ANSWERS & QUIZ_REVIEW_OPEN;
			$form->feedbackopen = $CFG->quiz_review & QUIZ_REVIEW_FEEDBACK & QUIZ_REVIEW_OPEN;
			$form->generalfeedbackopen = $CFG->quiz_review & QUIZ_REVIEW_GENERALFEEDBACK & QUIZ_REVIEW_OPEN;
			$form->scoreopen = $CFG->quiz_review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_OPEN;
			$form->overallfeedbackopen = $CFG->quiz_review & QUIZ_REVIEW_OVERALLFEEDBACK & QUIZ_REVIEW_OPEN;
			$form->responsesclosed = $CFG->quiz_review & QUIZ_REVIEW_RESPONSES & QUIZ_REVIEW_CLOSED;
			$form->answersclosed = $CFG->quiz_review & QUIZ_REVIEW_ANSWERS & QUIZ_REVIEW_CLOSED;
			$form->feedbackclosed = $CFG->quiz_review & QUIZ_REVIEW_FEEDBACK & QUIZ_REVIEW_CLOSED;
			$form->generalfeedbackclosed = $CFG->quiz_review & QUIZ_REVIEW_GENERALFEEDBACK & QUIZ_REVIEW_CLOSED;
			$form->scoreclosed = $CFG->quiz_review & QUIZ_REVIEW_SCORES & QUIZ_REVIEW_CLOSED;
			$form->overallfeedbackclosed = $CFG->quiz_review & QUIZ_REVIEW_OVERALLFEEDBACK & QUIZ_REVIEW_CLOSED;
			$form->popup = $CFG->quiz_popup;
			$form->quizpassword = $CFG->quiz_password;
			$form->subnet = $CFG->quiz_subnet;
			// Por hacer <--
			break;

	}

	// Turn off default grouping for modules that don't provide group mode
	if($data['add']=='resource' || $data['add']=='glossary' || $data['add']=='label') {
		$form->groupingid=0;
	}

	if (!empty($data['type'])) {
		$form->type = $data['type'];
	}

	$CFG->pagepath = 'mod/'.$module->name;
	if (!empty($data['type'])) {
		$CFG->pagepath .= '/'.$data['type'];
	} else {
		$CFG->pagepath .= '/mod';
	}

	$addinstancefunction    = $form->modulename."_add_instance";
	$returnfromfunc = $addinstancefunction( $form );

	if (! $returnfromfunc) {
		error ( "Desde el Servicio Web no se pudo agregar el ".$data['add'], "view.php?id=$course->id");
	}
	if (is_string($returnfromfunc)) {
		error($returnfromfunc, "view.php?id=$course->id");
	}

	$form->instance = $returnfromfunc;
	$form->coursemodule = add_course_module($form);
	$sectionid = add_mod_to_section($form) ;
	set_field("course_modules", "section", $sectionid, "id", $form->coursemodule);

	set_coursemodule_visible($form->coursemodule, $form->visible);
	if (isset($form->cmidnumber)) { //label
		set_coursemodule_idnumber($form->coursemodule, $form->cmidnumber);
	}

	add_to_log($course->id, "course", "add mod desde ws ",
                       "../mod/$form->modulename/view.php?id=$form->coursemodule",
                       "$form->modulename $form->instance");
	add_to_log($course->id, $form->modulename, "add ws",
                       "view.php?id=$form->coursemodule",
                       "$form->instance", $form->coursemodule);
	rebuild_course_cache($course->id);

	return $data;
}

// $chat = array(  'course' => '15', 'add' => 'chat', 'name' => 'Primer chat', 'intro'=> 'Mi Primer chat', 'section'=>'5');
// $forum = array(  'course' => '15', 'add' => 'forum', 'name' => 'Primer foro', 'intro'=> 'Mi Primer foro', 'type'=>'general', 'section'=>'5');
// $resource = array(  'course' => '15', 'add' => 'resource', 'name' => 'Primer recurso', 'intro'=> 'Mi Primer recurso', 'type'=>'file', 'reference'=>'http://www.google.com','section'=>'5');
// $quiz = array(  'course' => '15', 'add' => 'quiz', 'name' => 'Primer Quiz', 'intro'=> 'Mi Primer Quiz', 'section'=>'7');

// $resultado5 = modulomodulosAgregarModulos($quiz);
// echo "<pre>";
// print("Agregar modulo\n");
// print_r($resultado5);
// echo "</pre>";






//-------------
function modulomodulosRegistrarSae($data){
	$newResource = new stdClass();
	$newResource->course = utf8_encode($data['course']);
	$newResource->name = utf8_encode($data['name']);
	$newResource->summary = utf8_encode($data['summary']);
	$newResource->url = utf8_encode($data['url']);

	$newResource->popup = "";
	$newResource->options = "";
	$newResource->timemodified = time();

	$USER = insert_record('user', 'id', 2);

	if (!$newResource->id = insert_record('sae', $newResource) ) {
		throw new Exception("Could not insert sae '$newResource->name' ");
	} else {
		$newResource->context = get_context_instance(CONTEXT_COURSE, $newResource->id);
		mark_context_dirty($newResource->context->path);
		$data['id']=$newResource->id;
		
	}

	$newevent = new stdClass();
	$newevent->courseid =  $newResource->course;
	$newevent->name = utf8_encode($data['name']);
	$newevent->description = utf8_encode($data['summary']);
	$newevent->groupid = 0;
	$newevent->userid = 0;
	$newevent->repeatid = 0;
	$newevent->modulename = sae;
	$newevent->instance = $newResource->id;
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
		throw new Exception("Could not insert sae '$newevent->name' ");
	} else {
		$newevent->context = get_context_instance(CONTEXT_COURSE, $newevent->id);
		
		$instance['id']=$newevent->id;
		
	}

	$newinstance = new stdClass();
	$newinstance->course = $newevent->courseid;
	$newinstance->module = $idRecursoActividad;
	$newinstance->instance = $newResource->id;
	$newinstance->section =utf8_encode($data['section']);
	$newinstance->idnumber="";
	$newinstance->added = time();
	$newinstance->visible  = 1;
	$newinstance->id_gestor =utf8_encode($data['id_gestor']);

	$USER = insert_record('user', 'id', 2);

	if (!$newinstance->id = insert_record('course_modules', $newinstance)) {
		throw new Exception("Could not insert sae '$newResource->name' ");
	} else {
		$newinstance->context = get_context_instance(CONTEXT_COURSE, $newinstance->id);
		mark_context_dirty($newinstance->context->path);
		$instance['id']=$newinstance->id;
		
	}

	$modulos=get_record('course_sections', 'id', $newinstance->section);
	$anterior=$modulos->sequence ;
	$addsection = new stdClass();
	$addsection->id = $newinstance->section;
	$addsection->course = $newResource->course;
	$siguiente=$newinstance->id;
	$addsection->sequence =$anterior.','.$siguiente;
	$addsection->visible  = 1;
	$addsection->id_gestor  = $newinstance->id_gestor;

	$USER = insert_record('user', 'id', 2);

	if (!$addsection->id = update_record('course_sections', $addsection)) {
		throw new Exception("Could not insert resource '$newResource->name' ");
	} else {
		$addsection->context = get_context_instance(CONTEXT_COURSE, $addsection->id);
		mark_context_dirty($addsection->context->path);
		$instance['id']=$newevent->id;
		$instance['instance']=$newinstance->id;
		$instance['id_gestor']=$newinstance->id_gestor;
		
	}
	return $instance;
}

//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso text ::','type' => 'text', 'reference'=> 'http://localhost/#', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso html ::','type' => 'html', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso file ::','type' => 'file', 'filter.htm', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '129','section'=>'437','name' => 'Recurso directory ::','type' => 'directory', 'summary'=>'El nomrbe del recurso', 'id_gestor'=> '80');
//$recurso = array(  'course' => '39','section'=>'1039','name' => 'Recurso sae2', 'summary'=>'El nomrbe del recurso SAE', 'url'=>'investigaciones/index.html', 'id_gestor'=> '80');

/*
 $resultado4 = modulomodulosRegistrarSae($recurso);
 echo "<pre>";
 print("registrar modulomodulosRegistraRecurso \n");
 print_r($resultado4);
 echo "</pre>";
*/





?>
