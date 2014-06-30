<?php
function modulobloquesAgregarBloque($data){
	//$consulta= get_record('block_instance' ,'id', $block['id']);
	//id 	name 	version 	cron 	lastcron 	visible 	multiple
	//id 	blockid 	pageid 	pagetype 	position 	 	visible 	configdata
	$addblock = new stdClass();
	$addblock->blockid = utf8_encode($data['id']);
	$addblock->pageid = utf8_encode($data['pageid']);
	$addblock->pagetype = "course-view";
	$addblock->position ="r"; // if $data->parent = 0, the new category will be a top-level category
	$addblock->weight = 2;
	$addblock->visible = 1;

	$USER = get_record('user', 'id', 2);
	if (!$addblock->id = insert_record('block_instance', $addblock)) {
		throw new Exception("Could not insert the block '$addblock->id' ");
	} else {
		$addblock->context = get_context_instance(CONTEXT_COURSECAT, $addblock->id);
		mark_context_dirty($addblock->context->path);
		$data['id']=$addblock->id;
		fix_course_sortorder();
	}
	return $data;
}

function modulobloquesEditarBloque(){
	//TODO trabajar WS
}

function modulobloquesEliminarBloque($idblock) {
	return delete_records('block_instance', 'id', $idblock['id']);
}

function modulobloquesOcultarMostrarBloques($block) {
	$consulta= get_record('block_instance' ,'id', $block['id']);
	if($consulta->visible==1){
		return set_field('block_instance', 'visible', 0 , 'id',$block['id']);
	}else{
		return set_field('block_instance', 'visible', 1 , 'id',$block['id']);
	}
}

function modulobloquesMoveLeftRightBlock($block) {
	$consulta= get_record('block_instance' ,'id', $block['id']);
	if($consulta->position==l){
		return set_field('block_instance', 'position', r , 'id',$block['id']);
	}else{
		return set_field('block_instance', 'position', l , 'id',$block['id']);
	}
}


// $courseid = 39;
// $obtenerCategorias = get_all_sections($courseid);
// $obtenerCategorias($courseid);
// print_r($obtenerCategorias);


?>