<?php


function modulousuariosObtenerUsuariosGrupo($grupo){
	ob_start(); //Para evitar que imprima los echos
	if($grupo['id']==-1){
		$curso['id'] = $grupo['courseid'];
		$usuarios = modulousuariosObtenerUsuariosRegistrados($curso);
		if(!empty($usuarios)){
			$grupo['usuarios'] = $usuarios['usuarios'];
		}
		return obj2array($grupo);
	}
	if (!$ogroup = get_record('groups', 'id', $grupo['id'])) {
		throw new Exception('Group ID was incorrect');
	}
	$context = get_context_instance(CONTEXT_COURSE, $ogroup->courseid);
	$roles = get_roles_on_exact_context($context);
	$usuarios = get_group_users($ogroup->id);
	foreach($usuarios as $ousuario){
		$tmpRols = get_user_roles($context, $ousuario->id);
		foreach($tmpRols as $rol){
			$ousuario->rol = $roles[$rol->roleid];
			break;
		}
	}
	foreach($usuarios as $tmpuser){
		$ogroup->usuarios[] = $tmpuser;
	}
	ob_end_clean();//Para que no imprima los echos
	return obj2array($ogroup);
}
/*
 $valores = array('id' => '33');
 $modulousuariosObtenerUsuariosGrupo = modulousuariosObtenerUsuariosGrupo($valores);
 echo "<pre>";
 print(" modulo usuarios Obtener Usuarios Gruposssssssss");
 print_r($modulousuariosObtenerUsuariosGrupo);
 echo "</pre>";
 */


function modulousuariosObtenerUsuariosRegistrados($curso){
	ob_start(); //Para evitar que imprima los echos
	global $CFG;
	//echo CONTEXT_COURSE." .. ".$curso['id'];
	$context = get_context_instance(CONTEXT_COURSE, $curso['id']);

	get_users_from_role_on_context($roles[4],$context);
	//print_r($context); exit;
	$profesores = get_users_from_role_on_context($roles[4],$context);
	$alumnos = get_users_from_role_on_context($roles[5],$context);
	//$usuarios['name'] = print_r($profesores,true);
	foreach($profesores as $cusuario){
		$ousuario = get_record("user","id",$cusuario->id);
		$ousuario->rol = $roles[$cusuario->roleid];
		$usuarios['usuarios'][] = $ousuario;
	}

	foreach($alumnos as $cusuario){
		$ousuario = get_record("user","id",$cusuario->id);
		$ousuario->rol = $roles[$cusuario->roleid];
		$usuarios['usuarios'][] = $ousuario;
	}
	ob_end_clean();//Para que no imprima los echos
	return $usuarios;
}

/*
 $idcurso = array('id' => 129);
 $modulousuariosObtenerUsuariosRegistrados = modulousuariosObtenerUsuariosRegistrados($idcurso);
 echo "<pre>";
 print(" modulousuariosObtenerUsuariosRegistrados \n");
 print_r($modulousuariosObtenerUsuariosRegistrados);
 echo "</pre>";
 */



function modulousuariosObtenerPerfilUsuario($usuario){
	ob_start(); //Para evitar que imprima los echos
	return  get_record("user", "id", $usuario['id']);
	ob_end_clean();//Para que no imprima los echos
}


function modulousuariosEditarUsuario($data){
	ob_start(); //Para evitar que imprima los echos
	$edituser = new stdClass();
	$edituser->id = utf8_encode($data['id']);
	$edituser->username = utf8_encode($data['username']);
	$edituser->password = utf8_encode($data['password']);
	$edituser->email = utf8_encode($data['email']);
	$edituser->firstname = utf8_encode($data['firstname']);
	$edituser->lastname = utf8_encode($data['lastname']);
	$edituser->country = utf8_encode($data['country']); // PAIS
	$edituser->description = utf8_encode($data['description']);
	$edituser->institution = utf8_encode($data['institution']);

	$edituser->city = utf8_encode($data['city']); // ESTADO
	$edituser->colonia = utf8_encode($data['colonia']);
	$edituser->municipio = utf8_encode($data['municipio']);
	$edituser->fecha_nacimiento = utf8_encode($data['fecha_nacimiento']);

	$edituser->phone1 = utf8_encode($data['phone1']);
	$edituser->address= utf8_encode($data['address']);
	$edituser->rol = utf8_encode($data['rol']);

	if (!$edituser->id = update_record('user', $edituser)) {
		throw new Exception("Could not edit the course'$edituser->fullname' ");
	} else {
		$edituser->context = get_context_instance(CONTEXT_COURSE, $edituser->id);
		mark_context_dirty($edituser->context->path);
		$data['id']=$edituser->id;
		fix_course_sortorder();
	}
	return $data;

	ob_end_clean();//Para que no imprima los echos
}

/*
 $editarusuario = array('id' =>130, 'username'=>'EDITADO001' ,'email'=>'EDITADOemail001', 'firstname'=>'Editando firstname001', 'city'=>'Editando ciudad001');
 $modulousuariosEditarUsuario = modulousuariosEditarUsuario($editarusuario);
 echo "<pre>";
 print("Editar grupos \n");
 print_r($modulousuariosEditarUsuario);
 echo "</pre>";
 */



function modulousuariosMatricularUsuariosCursoGrupo($usuarios, $grupos) {
	ob_start(); //Para evitar que imprima los echos
	$context = get_context_instance(CONTEXT_COURSE, $grupos['courseid']);
	$context= obj2array($context);
	//$usuarios=$usuarios['usuarios'];
	$i=0;
	foreach ($usuarios as $usuario) {
		$user = get_complete_user_data('username', $usuario['username']);
		//$user = create_user_record($usuario['username'], 'manual');
		if (!$user) {
			$user = create_user_record($usuario['username'], '', 'ldap');
			if (!$user) {
				throw new Exception('Los datos de un usuario no son correctos');
			}
		}
		//--asigno su rol correspondiente en la plataforma
		$asignarRoles = role_assign($usuario['rol']['id'], $user->id , 0 , $context['id']);
		//--Agregar usuarios aun grupo
		groups_add_member($grupos['id'], $user->id);
		//--Editar usuario
		$edituser = new stdClass();
		$edituser->id = $user->id;
		$edituser->firstname = utf8_encode($usuario['firstname']);
		$edituser->lastname = utf8_encode($usuario['lastname']);
		$edituser->email = utf8_encode($usuario['email']);
		//--Actualizo hasta aqui el resto de infirmacion que me envia el cliente mediante el WS
		update_record('user', $edituser);
	}

	$ogrupo= modulousuariosObtenerUsuariosGrupo($grupos);
	ob_end_clean();//Para que no imprima los echos
	return $ogrupo;
}

/*
 $usuarioslistas = array();//Asignar el resultado de la base de datos a la variable
 $usuarioslistas[0]->username = "CHANO01q";
 $usuarioslistas[0]->email = "CHANO01q";
 $usuarioslistas[0]->password = md5("CHANO01");
 $usuarioslistas[0]->firstname = "CHANO01";
 $usuarioslistas[0]->lastname = "CHANO01";
 $usuarioslistas[0]->rol['id']=5;

 $usuarioslistas = array();//Asignar el resultado de la base de datos a la variable
 $usuarioslistas[0]->username = "CHANO02q";
 $usuarioslistas[0]->email = "CHANO02q";
 $usuarioslistas[0]->password = md5("CHANO02");
 $usuarioslistas[0]->firstname = "CHANO02";
 $usuarioslistas[0]->lastname = "CHANO02";
 $usuarioslistas[0]->rol['id']=5;

 $idcurso = array('id' => 129);
 $grupo = array();
 $grupo['id'] = 33;
 $grupo['courseid'] = 129;

 $matriculacionUsuarios = modulousuariosMatricularUsuariosCursoGrupo($usuarioslistas, $grupo);
 echo "<pre>";
 print_r($matriculacionUsuarios);
 echo "</pre>";
 */



//------------------------------- Trabajar y revisar



function modulousuariosMatricularUsuarios($usuarios, $grupos) {
	// Revisado con Julio  APROBADO NO TOCAR CHINGAUS
	revisionParametros($usuarios);
	ob_start(); //Para evitar que imprima los echos
	$context = get_context_instance(CONTEXT_COURSE, $grupos['courseid']);
	$context= obj2array($context);
	//$usuarios=$usuarios['usuarios']; // usando con PHP
	foreach ($usuarios as $usuario) {
		$usuario= obj2array($usuario);
		$user = get_complete_user_data('username', $usuario['username']);
		if (!$user) {
			$user = create_user_record($usuario['username'], '', 'ldap');
			if (!$user) {
				throw new Exception('Los datos de un usuario no son correctos');
			}
		}
		$user= obj2array($user);
		$asignarRoles = role_assign($usuario['rol']['id'], $user['id'] ,  0  , $context['id'], 0, 0, 0, 'webservice','');
		groups_add_member($grupos['id'], $user['id']);
	}
	$ogrupo= modulousuariosObtenerUsuariosGrupo($grupos);
	ob_end_clean();//Para que no imprima los echos
	return $ogrupo;
}

/*
 $usuarioslistas = array();//Asignar el resultado de la base de datos a la variable
 $usuarioslistas['usuarios'][0]->id = '';
 $usuarioslistas['usuarios'][0]->idnumber = 19;
 $usuarioslistas['usuarios'][0]->username = "disenador";
 $usuarioslistas['usuarios'][0]->rol['id']=5;

 $usuarioslistas['usuarios'][1]->id = '';
 $usuarioslistas['usuarios'][1]->idnumber = 35;
 $usuarioslistas['usuarios'][1]->username = "HEMG9312036P4";
 $usuarioslistas['usuarios'][1]->rol['id']=5;
 //$usuarioslistas= obj2array($usuarioslistas);

 $grupo = array();
 $grupo['id'] = 33;
 $grupo['courseid'] = 129;

 $matriculacionUsuarios = modulousuariosMatricularUsuarios($usuarioslistas, $grupo);
 echo "<pre>";
 print_r($matriculacionUsuarios);
 echo "</pre>";
 */




function modulousuariosMatricularResponsables($usuarios, $idcurso) {
	revisionParametros($usuarios);
	ob_start(); //Para evitar que imprima los echos
	$context = get_context_instance(CONTEXT_COURSE, $idcurso);
	//$context= obj2array($context);
	//$usuarios=$usuarios['usuarios']; // usando con PHP
	foreach ($usuarios as $usuario) {
		$usuario= obj2array($usuario);
		//print_r($usuario); exit;
		$user = get_complete_user_data('username', $usuario['username']);
		revisionParametros($user);
		//print_r($user); exit;
		if (!$user) {
			$user = create_user_record($usuario['username'], '', 'ldap');
			if (!$user) {
				throw new Exception('Los datos de un usuario no son correctos');
			}
		}
		$user= obj2array($user);
		//$asignarRoles = role_assign(2, $user['id'] , 0, $context['id']);
		$asignarRoles = role_assign(2, $user['id'] , 0, 353);
		//print_r($user['id']); exit;
		$edituser = new stdClass();
		$edituser->id = $user['id'];
		$edituser->firstname = utf8_encode($usuario['firstname']);
		$edituser->lastname = utf8_encode($usuario['lastname']);
		$edituser->email = utf8_encode($usuario['email']);
		//--Actualizo hasta aqui el resto de infirmacion que me envia el cliente mediante el WS
		//print_r($edituser); exit;
		update_record('user', $edituser);
	}
	//$ogrupo= modulousuariosObtenerUsuariosGrupo($grupos);
	ob_end_clean();//Para que no imprima los echos
	return modulousuariosObtenerUsuariosRegistrados($idcurso);
}

/*
 $usuarioslistas = array();//Asignar el resultado de la base de datos a la variable
 $usuarioslistas[0]->username = "username0";
 $usuarioslistas[0]->password = "password0";
 $usuarioslistas[0]->email = "email0";
 $usuarioslistas[0]->firstname = "firstname0";
 $usuarioslistas[0]->lastname = "lastname0";

 $usuarioslistas[1]->username = "username1";
 $usuarioslistas[1]->password = "password1";
 $usuarioslistas[1]->email = "email1";
 $usuarioslistas[1]->firstname = "firstname1";
 $usuarioslistas[1]->lastname = "lastname1";
 $usuarioslistas= obj2array($usuarioslistas);

 $curso = array('id' => 129);

 $modulousuariosMatricularResponsables = modulousuariosMatricularResponsables($usuarioslistas, $curso);
 echo "<pre>";
 print_r($modulousuariosMatricularResponsables);
 echo "</pre>";

 */



//------------------------------------- TODO TRABAJARLO solo  falta regresar los usuarios del curo
function modulousuariosMatricularUsuariosSingrupo($usuarios, $grupos) {
	revisionParametrosReiniciar("");
	revisionParametros(":::::::::::::::::::::::::::::::modulousuariosMatricularUsuariosSingrupo");
	// Revisado con Julio  APROBADO NO TOCAR CHINGAUS
	revisionParametros($usuarios);
	ob_start(); //Para evitar que imprima los echos
	$context = get_context_instance(CONTEXT_COURSE, $grupos['courseid']);
	$context= obj2array($context);
	//$usuarios=$usuarios['usuarios']; // usando con PHP
	revisionParametros($usuarios);
	foreach ($usuarios as $usuario) {
		revisionParametros($usuario);
		$usuario= obj2array($usuario);
		$user = get_complete_user_data('username', $usuario['username']);
		if (!$user) {
			$user = create_user_record($usuario['username'], '', 'ldap');
			if (!$user) {
				throw new Exception('Los datos de un usuario no son correctos');
			}
		}
		$user= obj2array($user);
		$asignarRoles = role_assign($usuario['rol']['id'], $user['id'] ,  0  , $context['id'], 0, 0, 0, 'webservice','');
		//groups_add_member($grupos['id'], $user['id']);
	}
	//$ogrupo= modulousuariosObtenerUsuariosGrupo($grupos);
	ob_end_clean();//Para que no imprima los echos
	return true;
}

/*
 $usuarioslistas = array();//Asignar el resultado de la base de datos a la variable
 $usuarioslistas[0]->id = '';
 $usuarioslistas[0]->idnumber = 19;
 $usuarioslistas[0]->username = "disenador";
 $usuarioslistas[0]->rol['id']=5;

 $usuarioslistas[1]->id = '';
 $usuarioslistas[1]->idnumber = 35;
 $usuarioslistas[1]->username = "HEMG9312036P4";
 $usuarioslistas[1]->rol['id']=5;


 $grupo = array();
 $grupo['id'] = 140;
 $grupo['courseid'] = 188;

 $matriculacionUsuarios = modulousuariosMatricularUsuariosSingrupo($usuarioslistas, $grupo);
 echo "<pre>";
 print_r($matriculacionUsuarios);
 echo "</pre>";
*/



//Desmatricula al usuario de todos los cursos que tengan el rol que se le envia 
function modulousuariosDesmatricularUsuarios( $usuarios, $idcurso ) {
	ob_start(); //Para evitar que imprima los echos
	//revisionParametros( $usuarios ); exit;
	//$noUsuarios = 0;
	$contador = 0;
	foreach ( $usuarios as $usuario ) {
		if ( $usuarios['usuarios'][$contador++] ) {
			//revisionParametros("mucho usuarios"); exit;
			$usuarios =  $usuarios['usuarios']; 
			$context = get_context_instance(CONTEXT_COURSE, $idcurso['courseid']);
			foreach ( $usuarios as $usuario ) {
				//revisionParametros( '-----' ); 
				$user = obj2array( get_complete_user_data( 'username' , $usuario['username'] ) );
				if ( ($user['id'] != 0 )  && ($usuario['rol']['id'] != 0 ) ) {
					role_unassign( $usuario['rol']['id'] , $user['id'], 0, $context->id);
					revisionParametros( $user['id']." -- ".$usuario['rol']['id'] ); 

				}
			}
		}else {
			//Si solo es un usuario
			//revisionParametros("Un usuarios"); exit;
			foreach ( $usuarios as $usuario ) {
				//revisionParametros(  $usuario ); 
				//revisionParametros(  '******' ); 
				$user = obj2array( get_complete_user_data( 'username' , $usuario['username'] ) );
				if ( ($user['id'] != 0 )  && ($usuario['rol']['id'] != 0 ) ) {
					role_unassign( $usuario['rol']['id'] , $user['id'], 0, $context->id);
					revisionParametros( $user['id']." -- ".$usuario['rol']['id'] ); 
				}//if
			}//foreach
		}//else
	}
	ob_end_clean();//Para que no imprima los echos
	return modulousuariosObtenerUsuariosGrupo( $idcurso );
	
}









/* BIEN EN PHP Local 
function modulousuariosDesmatricularUsuarios($listaUsuarios, $idcurso) {
	revisionParametros($idcurso);
	ob_start(); //Para evitar que imprima los echos
	$usuarios= $listaUsuarios;

	//$usuarios=$usuarios['usuarios'];  // usando con PHP
	$context = get_context_instance(CONTEXT_COURSE, $idcurso['id']);
	foreach ($usuarios as $usuario) {
		$usuario= obj2array($usuario);
		$user = get_complete_user_data('username', $usuario['username']);
		$res = role_unassign( $usuario['rol'] , $user->id, 0, $context->id, 0, 0, 0, 'webservice');
	}
	$ogrupo= modulousuariosObtenerUsuariosGrupo($idcurso);
	ob_end_clean();//Para que no imprima los echos
	return $ogrupo;
}
*/
/*
 $usuarios = array();//Asignar el resultado de la base de datos a la variable
 $usuarios[0] = new stdClass();
 $usuarios[0]->id = 3;
 $usuarios[0]->username = 'HEGN820311CL2';
 $usuarios[0]->rol = 5;

 $usuarios[1] = new stdClass();
 $usuarios[1]->id = 3;
 $usuarios[1]->username = 'UAAR940401P1A';
 $usuarios[1]->rol = 4;
 $listaUsuarios = obj2array($usuarios);
 //echo "<pre>"; print_object($listaUsuarios); exit;

 $idcurso = array('id' => 3, 'courseid' => 49);
 $desmatriculacionUsuarios = modulousuariosDesmatricularUsuarios($listaUsuarios, $idcurso);
 echo "<pre>";
 print_r($desmatriculacionUsuarios);
 echo "</pre>";
*/

//------------------- correcto
function modulousuariosDesmatricularUsuariosGrupo($listaUsuarios, $idgrupo) {
	ob_start(); //Para evitar que imprima los echos
	revisionParametros($listaUsuarios);
	$usuarios= $listaUsuarios;
	//$usuarios=$usuarios['usuarios'];
	//revisionParametros($usuarios);
	foreach ($usuarios as $usuario) {
		$usuario= obj2array($usuario);
		$user = get_complete_user_data('username', $usuario['username']);
		//revisionParametros($user);
		$user =obj2array($user);
		//revisionParametros($user);
		$datos = groups_remove_member($idgrupo['id'], $user['id']);

		//role_unassign($usuario['rol']['id'], $user['id'], 0, $context['id']);
	}
	ob_end_clean();//Para que no imprima los echos
	return modulousuariosObtenerUsuariosGrupo($idgrupo);
	//comentearoi
}


/*
 $usuarios = array();
 $usuarios['usuarios'][0]->username = "HEMG9312036P4";
 $usuarios['usuarios'][1]->username = "disenador";
 $idgrupo = array('id' => '163');
 $desmatriculacionUsuariosGrupo = modulousuariosDesmatricularUsuariosGrupo($usuarios, $idgrupo);
 echo "<pre>";
 print_r($desmatriculacionUsuariosGrupo);
 echo "</pre>";
 */




function modulousuariosObtenerCalificacionesUsuario($userid){
	ob_start(); //Para evitar que imprima los echos
	return grade_get_grades($userid['id']);
	ob_end_clean();//Para que no imprima los echos
}

//TODO preguntar esta funcion

function modulomatriculacionGet_course_users_by_role($courseid, $roleid=0) {
	ob_start(); //Para evitar que imprima los echos
	global $CFG;

	if (! $course = get_record('course', 'id', $courseid)) {
		error("Course ID is incorrect");
	}

	if (! $context = get_context_instance(CONTEXT_COURSE, $course->id)) {
		error("Context ID is incorrect");
	}

	// we are looking for all users with this role assigned in this context or higher
	if ($usercontexts = get_parent_contexts($context)) {
		$listofcontexts = '('.implode(',', $usercontexts).')';
	} else {
		$listofcontexts = '('.$sitecontext->id.')'; // must be site
	}

	if ($roleid > 0) {
		$selectrole = " AND r.roleid = $roleid ";
	} else {
		$selectrole = " ";
	}

	//Armar la consulta para obtener a los usuarios
	$select = 'SELECT DISTINCT u.id, u.username, u.firstname, u.lastname ';
	$from   = "FROM {$CFG->prefix}user u
                LEFT OUTER JOIN {$CFG->prefix}context ctx
                    ON (u.id=ctx.instanceid AND ctx.contextlevel = ".CONTEXT_USER.")
                JOIN {$CFG->prefix}role_assignments r
                    ON u.id=r.userid ";
	$where = "WHERE (r.contextid = $context->id OR r.contextid in $listofcontexts)
                AND u.deleted = 0 $selectrole
                AND u.username != 'guest' AND r.roleid NOT IN (1) ";

	//echo $select.$from.$where;
	return get_records_sql($select.$from.$where);
	ob_end_clean();//Para que no imprima los echos
}

function modulousuariosRegistrarUsuario($usuario){
	ob_start(); //Para evitar que imprima los echos
	//TODO trabar el WS
	$usuario['id']=123;
	return $usuario;
	ob_end_clean();//Para que no imprima los echos
}

function modulousuariosEliminarUsuario($usuario){
	ob_start(); //Para evitar que imprima los echos
	$usuario = obj2array($usuario);
	if (!$ousuario = get_record('user', 'id', $usuario['id'])) {
		throw new Exception('User ID was incorrect');
	}
	if (!groups_delete_group($ousuario->id)) {
		throw new Exception(get_string('erroreditgroup'));
	}
	$curso['id']=$ouser->courseid;
	$curso = obterGrupos($curso);
	ob_end_clean(); //Para que no imprima los echos
	return $curso;
	ob_end_clean();//Para que no imprima los echos
}


function modulousuariosMatricularUsuariosCurso($curso, $listaUsuarios, $rol, $groupid) {
	ob_start(); //Para evitar que imprima los echos
	//$context = get_context_instance(CONTEXT_COURSE, $curso->id);
	$contextid = CONTEXT_COURSE;
	foreach ($listaUsuarios as $usuario) {
		echo "----> ". $enrolar = role_assign($roleid['id'], $userid['id'], $groupid, $contextid); exit;
	}
	print_object($enrolar); exit;
	ob_end_clean();//Para que no imprima los echos
	//return obtenerUsuarios($grupo);
}



function modulousuariosRegistrarUsuarios($usuarioslistas, $curso) {
	ob_start(); //Para evitar que imprima los echos
	$usuarios = $usuarioslistas;
	foreach ($usuarios as $usuario) {
		$usuario= obj2array($usuario);


	}
	ob_end_clean();//Para que no imprima los echos
	return $ogrupo;
}

/*
 $usuarioslistas = array();//Asignar el resultado de la base de datos a la variable
 $usuarioslistas[0]->username = "username0";
 $usuarioslistas[0]->password = "password0";
 $usuarioslistas[0]->email = "email0";
 $usuarioslistas[0]->firstname = "firstname0";
 $usuarioslistas[0]->lastname = "lastname0";

 $usuarioslistas[1]->username = "username1";
 $usuarioslistas[1]->password = "password1";
 $usuarioslistas[1]->email = "email1";
 $usuarioslistas[1]->firstname = "firstname1";
 $usuarioslistas[1]->lastname = "lastname1";
 $usuarioslistas= obj2array($usuarioslistas);

 $curso = array('id' => 129);


 //print_r($usuarioslistas); exit;
 //print_r($curso); exit;

 $modulousuariosRegistrarUsuarios = modulousuariosRegistrarUsuarios($usuarioslistas, $curso);
 echo "<pre>";
 print_r($modulousuariosRegistrarUsuarios);
 echo "</pre>";

 */
//REVISAR ESTE NO LO TENIA

function modulousuariosObtenerTodosUsuarios(){
	$users= get_record_sql('SELECT * FROM mdl_user' );
	$user['id'] = utf8_decode($users->id);
	$user['username'] = utf8_decode($users->username);
	$user['confirmed'] = utf8_decode($users->confirmed);
	$user['password'] = utf8_decode($users->password);
	$user['email'] = utf8_decode($users->email);
	$user[]= array();

	foreach($users as $cusuario){
		$ousuario = $cusuario;
		$user['usuarios'][] = $ousuario;
	}
	return $user;
}


?>
