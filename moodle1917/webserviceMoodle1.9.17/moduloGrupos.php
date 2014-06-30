<?php
/*
 * Archivo que se encara todo lo relacionado a grupos en MOODLE
 * */

function modulogruposRegistrarGrupo($grupo) {
	//ob_start(); //Para evitar que imprima los echos
	$grupo = obj2array($grupo);
	$ogrupo = (object) $grupo;
	$ogrupo->hidepicture = 0;
	if (!$id = groups_create_group($ogrupo, false)) {
		throw new Exception('Error creating group');
	}
	$grupo['id'] = $id;
	$curso['id']=$ogrupo->courseid;
	$curso = modulogruposObtenerGrupos($curso);
	//ob_end_clean(); //Para que no imprima los echos
	return $curso;
}

function modulogruposEliminarGrupo($grupo){
	ob_start(); //Para evitar que imprima los echos
	$grupo = obj2array($grupo);
	if (!$ogroup = get_record('groups', 'id', $grupo['id'])) {
		throw new Exception('Group ID was incorrect');
	}
	if (!groups_delete_group($ogroup->id)) {
		throw new Exception(get_string('erroreditgroup'));
	}
	$curso['id']=$ogroup->courseid;
	$curso = modulogruposObtenerGrupos($curso);
	ob_end_clean(); //Para que no imprima los echos
	return $curso;
}

function modulogruposEditarGrupo($grupo){
	ob_start(); //Para evitar que imprima los echos
	$grupo = obj2array($grupo);
	if (!$ogroup = get_record('groups', 'id', $grupo['id'])) {
		throw new Exception('Group ID was incorrect');
	}
	if (!groups_update_group($grupo, false)) {
		throw new Exception('Error updating group');
	}
	$curso['id']=$grupo['courseid'];
	$curso = modulogruposObtenerGrupos($curso);
	ob_end_clean(); //Para que no imprima los echos
	return $curso;
}

function modulogruposObtenerGrupos($curso) {
	ob_start(); //Para evitar que imprima los echos
	//$curso = obj2array($curso);
	$groups = groups_get_all_groups($curso['id']);
	if ($groups) {
		// Print out the HTML
		foreach ($groups as $group) {
			$curso['grupos'][] = obj2array($group);
		}
	}
	ob_end_clean(); //Para que no imprima los echos
	return $curso;
}

/*$idcategoria = array('id' => 15);
 $modulogruposObtenerGrupos = modulogruposObtenerGrupos($idcategoria);
 echo "<pre>";
 print_r($modulogruposObtenerGrupos);
 echo "</pre>";
 */


function modulogruposEnrolarEnGrupo($usuario, $grupo){
	$usuario = obj2array($usuario);
	$grupo = obj2array($grupo);
	//---- SI NO EXISTE EL USUARIO, IMPORTO SUS DATOS DE LDAP
	$user = get_complete_user_data('username', $usuario['username']);
	if (!$user) {
		$user = create_user_record($usuario['username'], '', 'ldap');
		//$authplugin->sync_roles($user);
		if(!$user){
			return false;
		}
	}
}

function modulogruposRegistrarGrupoAuto($grupo) {
	ob_start(); //Para evitar que imprima los echos
	$grupo = obj2array($grupo);

	$ogrupo = (object) $grupo;
	$ogrupo->hidepicture = 0;

	if($ogrupo->car=='#'){
		$a=1;
		while ($a <= $ogrupo->nume) {
			$ogrupo->name=$a;
			if (!$id = groups_create_group($ogrupo, false)) {
				throw new Exception('Error creating group');
			}
			$grupo['id'] = $id;
			$curso['id']=$ogrupo->courseid;
			$curso = modulogruposObtenerGrupos($curso);
			//ob_end_clean(); //Para que no imprima los echos
			$a++;
		}
		return $curso;
	}

	if($ogrupo->car=='@'){
		$a="1";

		for ($i="A", $a=1 ; $i!="AA" && $a<=$ogrupo->nume  ; $i++, $a++) {
			 
			$ogrupo->name=$i;
			if (!$id = groups_create_group($ogrupo, false)) {
				throw new Exception('Error creating group');
			}
			$grupo['id'] = $id;
			$curso['id']=$ogrupo->courseid;
			$curso = modulogruposObtenerGrupos($curso);
			ob_end_clean(); //Para que no imprima los echos

		}
		return $curso;
	}

}


?>
