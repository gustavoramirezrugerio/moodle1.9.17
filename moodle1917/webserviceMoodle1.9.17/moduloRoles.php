<?php
function modulorolesAgregarRol(){
	//TODO generar funcion para WS
}

function modulorolesObtenerRoles($idRole) {
	return get_record('role', 'id', $idRol['id']);
}

function modulorolesEditarRol(){
	//TODO generar funcion para WS
}

function modulorolesEliminarRol(){
	//TODO generar funcion para WS
}

//----
function modulorolesAsignarRol($data) {
	$asingrol = new stdClass();
	$asingrol->roleid = utf8_encode($data['roleid']);
	$asingrol->userid = utf8_encode($data['userid']);
	$asingrol->contextid = 1;
	$asingrol->hidden = 0; // if $data->parent = 0, the new category will be a top-level category
	$asingrol->timestart = time();
	$asingrol->timeend = 0;
	$asingrol->timemodified = time();
	$asingrol->tmodifierid = 0;
	$asingrol->enrol ="manual";
	$asingrol->sortorder = 0;

	$USER = get_record('user', 'id', 2);
	if (!$asingrol->id = insert_record('role_assignments', $asingrol)) {
		throw new Exception("Could not insert the new category '$asingrol->roleid' ");
	} else {
		$asingrol->context = get_context_instance(CONTEXT_COURSE, $asingrol->id);
		mark_context_dirty($asingrol->context->path);
		$data['id']=$asingrol->id;
		fix_course_sortorder();
	}
	return $data;
}

function modulorolesQuitarRol($data) {
	return delete_records('role_assignments','roleid',$data['roleid'], 'userid', $data['userid']);
}



function modulorolesObtenerTodosRoles() {
	ob_start(); //Para evitar que imprima los echos
	$sql= get_records_select("role");
	foreach ($sql as $rol) {
		$roles['roles'][] = obj2array($rol);
	}
	ob_end_clean();//Para que no imprima los echos
	return obj2array($roles);
}

//$roles = modulorolesObtenerTodosRoles();
//print_object($roles);


function modulorolesAdmin() {
	ob_start(); //Para evitar que imprima los echos
	$rolAdmin = get_record('role', 'shortname', 'admin');
	ob_end_clean();//Para que no imprima los echos
	return obj2array($rolAdmin);
}
//$rolesAdmin = modulorolesAdmin();
//print_object($rolesAdmin);


function modulorolesTeacher() {
	ob_start(); //Para evitar que imprima los echos
	$rolTeacher = get_record('role', 'shortname', 'teacher');
	ob_end_clean();//Para que no imprima los echos
	return obj2array($rolTeacher);
}
//$rolesteacher = modulorolesTeacher();
//print_object($rolesteacher);

function modulorolesStudent() {
	ob_start(); //Para evitar que imprima los echos
	$rolstudent = get_record('role', 'shortname', 'student');
	ob_end_clean();//Para que no imprima los echos
	return obj2array($rolstudent);
}
//$rolesteacher = modulorolesStudent();
//print_object($rolesteacher);






?>