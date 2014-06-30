<?php

function modulocalificacionesUsuario($usuario,$curso){
	//ob_start();
	global $CFG, $USER;
	$curso = get_record('course', 'id', $curso['id']);

	$actividades = get_records('grade_items','courseid',$curso->id,'sortorder','id, itemname, itemtype, itemmodule, sortorder, grademax');
	foreach($actividades as $actividad){
		$calificaciones['actividades']['actividad'][] = $actividad;
	}

	$calificaciones['curso'] = $curso;

	if( $usuario['username'] ){//Si es solo un usuario

		$usuarios = get_complete_user_data('username', $usuario['username']);
		$sql = "SELECT gg.id, gg.itemid, gg.userid, gg.rawgrademax, gg.rawgrademin, gg.rawgrade, gg.finalgrade, gg.timecreated, gg.timemodified
	FROM  mdl_grade_grades gg, mdl_grade_items gi WHERE gg.itemid=gi.id AND gg.userid = {$usuarios->id} AND gi.courseid={$curso->id} order by gi.sortorder" ;
		
		
		$grades = $DB->get_records_sql($sql);
		//$calificaciones['calificacion'][$i]['usuario'] = $DB->get_record('user', array('id'=>  $ousuario->id) );
		$calificaciones['calificacion']['usuario'] = $DB->get_record('user', array('id'=>  $usuarios->id) );
		foreach($grades as $grade){
			$calificaciones['calificacion']['grade'][] = $grade;
		}

		//echo "<pre>"; print_r($usuarios); exit;
		// $obj = new stdClass();
		// $obj->userid = $usuario['id'];
		// $usuarios = array(0 => $obj);
	}else {//Si son todos los usuarios del curso

		$sqlUsuarios = "SELECT gg.userid
FROM  mdl_grade_grades gg, mdl_grade_items gi
WHERE gg.itemid=gi.id AND gi.courseid={$curso->id}";
		$usuarios = obtenerUsuarios($curso->id,0);
		//$calificaciones['curso']->fullname = print_r($usuarios2,true);
	}
	$i=0;
	foreach($usuarios as $ousuario){
		$sql = "SELECT gg.id, gg.itemid, gg.userid, gg.rawgrademax, gg.rawgrademin, gg.rawgrade, gg.finalgrade, gg.timecreated, gg.timemodified
	FROM  mdl_grade_grades gg, mdl_grade_items gi
	WHERE gg.itemid=gi.id AND gg.userid = {$ousuario->id} AND gi.courseid={$curso->id} order by gi.sortorder" ;
		$grades = get_records_sql($sql);
		//$calificaciones['curso']->fullname = print_r($grades,true);
		$calificaciones['calificacion'][$i]['usuario'] = get_record('user', 'id', $ousuario->id);
		//echo $curso->id." ---- ".$ousuario->id; exit;

		$datos = groups_get_user_groups($curso->id, $ousuario->id );
		//echo "<pre>GRUPOS---"; print_r($datos);
		$contando = 0;
		$datosGrupos = null;
		if ( count($datos[0]) > 1 ) {

			foreach ($datos[0] as $key) {
				//if ($contando > 0 ) {
					//$datosGrupos = groups_get_group_name($datos[0][$contando])."|".groups_get_group_name($key); 
					$datosGrupos = $datosGrupos.groups_get_group_name($key)."|"; 
				//}
				//echo $contando." -- ".$key;
				$contando++;		
			}//foreach
			$datos[0][0] = substr( $datosGrupos, 0, -1);
			
		}else{
			$datos[0][0] = groups_get_group_name($datos[0][0]);			
		}

		$calificaciones['calificacion'][$i]['usuario']->address = $datos[0][0];

		
		
		foreach($grades as $grade){
			$calificaciones['calificacion'][$i]['grade'][] = $grade;
		}
		$i++;
	}
	//ob_end_clean();
	//echo "<pre>";print_r($calificaciones); exit;


	return $calificaciones;
}

// $usuario = array('id' => '0');
// $curso = array('id' => '179');
// $calificaciones = modulocalificacionesUsuario($usuario, $curso);
// echo "<pre>";	print_r($calificaciones); exit;


function obtenerUsuarios($courseid,$groupid){
	global $CFG;
	$courseid = $courseid;
	$roleid = 5;
	$currentgroup = $groupid;

	if (! $course = get_record('course', 'id', $courseid)) {
		error("Course ID is incorrect");
	}
	if (! $context = get_context_instance(CONTEXT_COURSE, $course->id)) {
		error("Context ID is incorrect");
	}

	$sitecontext = get_context_instance(CONTEXT_SYSTEM);
	$frontpagectx = get_context_instance(CONTEXT_COURSE, SITEID);

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

	//	$select = 'SELECT DISTINCT u.*';
	$select = 'SELECT DISTINCT u.id, u.username, u.firstname, u.lastname,
	u.email, u.city, u.country, u.picture,
	u.lang, u.timezone, u.emailstop, u.maildisplay, u.imagealt,
	COALESCE(ul.timeaccess, 0) AS lastaccess,
	r.hidden,
	ctx.id AS ctxid, ctx.path AS ctxpath,
	ctx.depth AS ctxdepth, ctx.contextlevel AS ctxlevel ';
	$select .= $course->enrolperiod?', r.timeend ':'';

	$from   = "FROM {$CFG->prefix}user u
	LEFT OUTER JOIN {$CFG->prefix}context ctx
	ON (u.id=ctx.instanceid AND ctx.contextlevel = ".CONTEXT_USER.")
	JOIN {$CFG->prefix}role_assignments r
	ON u.id=r.userid
	LEFT OUTER JOIN {$CFG->prefix}user_lastaccess ul
	ON (r.userid=ul.userid and ul.courseid = $course->id) ";

	$where  = "WHERE (r.contextid = $context->id OR r.contextid in $listofcontexts)
	AND u.deleted = 0 $selectrole
	AND (ul.courseid = $course->id OR ul.courseid IS NULL)
	AND u.username != 'guest'";

	if ($currentgroup) {    // Displaying a group by choice
		// FIX: TODO: This will not work if $currentgroup == 0, i.e. "those not in a group"
		$from  .= 'LEFT JOIN '.$CFG->prefix.'groups_members gm ON u.id = gm.userid ';
		$where .= ' AND gm.groupid = '.$currentgroup;
	}

	$sort .= ' ORDER BY r.hidden DESC';

	//Obtenemos nuevamente todo el listado pero ahora para el archivo de excel.
	$listado_usuarios = get_records_sql($select.$from.$where.$wheresearch.$sort);

	return $listado_usuarios;
}
?>
