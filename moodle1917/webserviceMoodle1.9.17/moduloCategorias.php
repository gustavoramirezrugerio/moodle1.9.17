<?php
function modulocategoriasRegistrarCategoria($datosEntrada) {
	$datosProcesados = moduloPrincipalFuncionesInicio($datosEntrada);
	if ($datosProcesados['CERTIFICADO'] != $datosEntrada['CERTIFICADO']) {
		$salida = $datosEntrada['CERTIFICADO'] = $datosProcesados['CERTIFICADO'];
		moduloPrincipalImprimirSalidaLog($datosEntrada);
		return $salida;
	} else {//Aquí tenemos que meter el codigo de moodle para nuestros WS
		//validamos si existe la categoria
		$categoria = get_record('course_categories', 'id', $datosProcesados['parent']);
		if (empty($categoria->id)) {
			$datosProcesados['ERROR'] = "no existe categoria: ".$datosProcesados['parent'];
			moduloPrincipalImprimirSalidaLog($datosProcesados);
			return $datosProcesados;
		}
		if (!empty($datosProcesados['parent']) && !empty($datosProcesados['name'])) {
			//-->moodle1917/course/editcategory.php LINEA:76
			$newcategory              = new stdClass();
			$newcategory->name        = $datosProcesados['name'];
			$newcategory->description = $datosProcesados['description'];
			$newcategory->parent      = $datosProcesados['parent'];// if $datosProcesados->parent = 0, the new category will be a top-level category
			$newcategory->theme       = $datosProcesados['theme'];
			// Create a new category.
			$newcategory->sortorder = 999;
			if (!$newcategory->id = insert_record('course_categories', $newcategory)) {

				$datosProcesados['ERROR'] = "Could not insert the new category '$newcategory->name";
				moduloPrincipalImprimirSalidaLog($datosProcesados);

				error("Could not insert the new category '$newcategory->name' ");
			}
			$newcategory->context = get_context_instance(CONTEXT_COURSECAT, $newcategory->id);
			mark_context_dirty($newcategory->context->path);
			fix_course_sortorder();// Required to build course_categories.depth and .path.
			return moduloPrincipalFuncionesCierre($datosProcesados, $newcategory->id);
		} else {
			return $ERROR = errorRegistro($datosProcesados);
		}//else $datosProcesados['CERTIFICADO'] = !$datosProcesados['CERTIFICADO']
	}//else
}//function

$modulocategoriasObtenerCategorias = modulocategoriasRegistrarCategoria($parametros);
imprimirSalida($modulocategoriasObtenerCategorias);

//function modulocategoriasObtenerCategorias( $datosEntrada ){
function modulocategoriasObtenerCategorias($categoria) {
	//$datosEntrada = moduloPrincipalFuncionesInicio( $datosEntrada );
	$validarCategoria = get_record('course_categories', 'id', $categoria['id']);
	if (empty($validarCategoria['id'])) {
		return $validarCategoria['ERROR'] = "no existe categoria: ".$categoria['id'];
	}
	$obtenerCategoriaPadre = get_record('course_categories', 'id', $categoria['id']);
	$categorias            = get_records('course_categories', 'parent', $categoria['id']);
	$categoria['name']     = utf8_decode($obtenerCategoriaPadre->name);
	$categoria['parent']   = $obtenerCategoriaPadre->parent;
	if ($categorias) {
		foreach ($categorias as $categorie) {
			$categoria['categorias'][] = modulocategoriasObtenerCategorias(obj2array($categorie));
		}
	}
	return $categoria;
}

/*
$paremetros = funcionParametros();
$modulocategoriasObtenerCategorias = modulocategoriasObtenerCategorias( $paremetros );
echo "<pre>";
print_r( $modulocategoriasObtenerCategorias );
exit;
 */

function modulocategoriasEditarCategoria($data) {
	$categoryadd = 1;
	if ($categoryadd and !$data['parent']) {// Show Add category form: if $id is given, it is used as the parent category
		$strtitle = get_string("addnewcategory");
		$context  = get_context_instance(CONTEXT_SYSTEM);
		$category = null;
	} elseif ($categoryadd and $data['parent']) {
		$strtitle = get_string("addnewcategory");
		$context  = get_context_instance(CONTEXT_COURSECAT, $data['parent']);
		$category = null;
	}
	$newcategory              = new stdClass();
	$newcategory->id          = utf8_encode($data['id']);
	$newcategory->name        = utf8_encode($data['name']);
	$newcategory->description = utf8_encode($data['description']);
	$newcategory->sortorder   = 999;
	$newcategory->parent      = $data['parent'];// if $data->parent = 0, the new category will be a top-level category
	$newcategory->visible     = 1;
	$USER                     = get_record('user', 'id', 2);
	if (!$newcategory->id = update_record('course_categories', $newcategory)) {
		throw new Exception("Could not insert the new category '$newcategory->name' ");
	} else {
		$newcategory->context = get_context_instance(CONTEXT_COURSECAT, $newcategory->id);
		mark_context_dirty($newcategory->context->path);
		$data['id'] = $newcategory->id;
		fix_course_sortorder();
	}
	return $data;
}

function modulocategoriasDepurarCategoriaCursos($idCategory) {
	return category_delete_full('course_categories', 'id', $idCategory['id']);
}

function modulocategoriasEliminarCategoriaMoverCursosCategoria($idCategory) {
	return category_delete_full('course_categories', 'id', $idCategory['id']);
}

function moduloCategoriasEliminarCategoria($idCategory) {
	return delete_records('course_categories', 'id', $idCategory['id']);
}

// --------
function moduloCategoriasOcultarMostrarCategoria($category) {
	$consulta = get_record('course_categories', 'id', $category['id']);
	if ($consulta->visible == 1) {
		return set_field('course_categories', 'visible', 0, 'id', $category['id']);

	} else {
		return set_field('course_categories', 'visible', 1, 'id', $category['id']);

	}
}

function modulocategoriasObtenerProyectos($institucion) {
	$cat      = $institucion['categoria'];
	$cat_inst = get_record('course_categories', 'name', utf8_encode($cat['name']));
	if (!$cat_inst) {//Si no exite la categoria de la intitucion la agregamos
		$cat['parent'] = 1;
		$cat           = modulocategoriasRegistrarCategoria($cat);
		$cat_inst      = get_record('course_categories', 'id', $cat['id']);
	}
	$inst = get_record('course_categories', 'name', utf8_encode($institucion['nombre']), 'parent', $cat_inst->id);
	if (!$inst) {//Si no exite la categoria de la intitucion la agregamos
		$tmpi['name']   = $institucion['nombre'];
		$tmpi['parent'] = $cat_inst->id;
		$inst           = modulocategoriasRegistrarCategoria($tmpi);
		$inst           = get_record('course_categories', 'id', $inst['id']);
	}
	$categorias               = get_records('course_categories', 'parent', $inst->id);
	$categoria['name']        = utf8_decode($inst->name);
	$categoria['description'] = utf8_decode($inst->description);
	$categoria['parent']      = $cat_inst->id;
	$categoria['id']          = $inst->id;
	if ($categorias) {
		foreach ($categorias as $ocategoria) {
			$categoria['categorias'][] = obj2array($ocategoria);
		}
	}
	return $categoria;
}

// $categoria = array( 'id' =>25);
// $modulocategoriasObtenerProyectos = modulocategoriasObtenerProyectos($categoria);
// echo "<pre>";
// print_r($modulocategoriasObtenerProyectos);
// echo "</pre>";

function modulocategoriasMoverArribaCategoria($idCategory) {

	$consulta = get_record('course_categories', 'id', $idCategory['id']);
	if ($consulta->sortorder != 0 and $consulta->parent == 0) {
		$nueva     = $consulta->sortorder;
		$primera   = set_field('course_categories', 'sortorder', $consulta->sortorder-2, 'id', $idCategory['id']);
		$consulta2 = get_record('course_categories', 'parent', 0, 'sortorder', $nueva);
		$nueva2    = $consulta2->sortorder+1;
		$idnue     = $consulta2->id;
		$segunda   = set_field('course_categories', 'sortorder', $nueva2, 'id', $idnue);
		return $segunda.$primera;
	} else {
		return get_record('course_categories', 'id', $idCategory['id']);
	}
}

function modulocategoriasMoverAbajoCategoria($idCategory) {
	$consulta = get_record('course_categories', 'id', $idCategory['id']);
	if ($consulta->parent == 0) {
		$nueva     = $consulta->sortorder;
		$primera   = set_field('course_categories', 'sortorder', $consulta->sortorder+1, 'id', $idCategory['id']);
		$consulta2 = get_record('course_categories', 'parent', 0, 'sortorder', $nueva);
		$nueva2    = $consulta2->sortorder-1;
		$idnue     = $consulta2->id;
		$segunda   = set_field('course_categories', 'sortorder', $nueva2, 'id', $idnue);
		return $segunda.$primera;
	} else {
		return get_record('course_categories', 'id', $idCategory['id']);
	}
}

function urlcursoCategoria() {
	global $CFG;
	$salida = $CFG->wwwroot;
	return $salida;
}

function modulocategoriasObtenerCategoriasConCursos() {
	revisionParametrosReiniciar("");
	revisionParametros("modulocategoriasObtenerCategoriasConCursos");
	$categorias = get_records('course_categories', '', '', 'depth');
	revisionParametros($categorias);
	$categoria['name'] = "TODAS LAS CATEGORIAS";
	//print_r($categorias,true);
	if (!empty($categorias)) {
		$i        = 0;
		$contador = 0;
		foreach ($categorias as $ocategoria) {
			$categoria['categorias'][] = obj2array($ocategoria);
			$ocourses                  = get_courses($ocategoria->id);
			foreach ($ocourses as $ocurso) {
				$categoria['cursos'][]                      = obj2array($ocurso);
				$categoria['cursos'][$contador]['urlcurso'] = urlcursoCategoria()."/course/view.php?id=".$ocurso->id;
				;
				$contador++;
			}
		}
	}

	return $categoria;
	$categorias        = get_records('course_categories', 'parent', $categoria['id']);
	$categoria['name'] = print_r($categorias, true);
	//utf8_decode($ocategoria->name);
	$categoria['description'] = utf8_decode($ocategoria->description);
	$categoria['parent']      = $ocategoria->parent;
}

// $idcategoria = array('id' => 1);
// $modulocategoriasObtenerCategorias = modulocategoriasObtenerCategoriasConCursos($idcategoria);
// echo"<pre>";
//print_r($modulocategoriasObtenerCategorias);
//exit;

//REVISAR ESTAS FUNCIONES

function modulocategoriasMoverCurso($curso, $categoria) {
	$id     = $curso['category'];//categoria en la que estaba
	$moveto = $categoria['id'];
	if ($moveto == $id) {
		return $curso;
	}
	global $USER;
	$USER = get_record('user', 'id', 2);
	if (!$context = get_context_instance(CONTEXT_COURSECAT, $id)) {
		error("Category not known!");
	}
	require_capability('moodle/category:manage', $context);
	require_capability('moodle/category:manage', get_context_instance(CONTEXT_COURSECAT, $moveto));
	if (!$destcategory = get_record('course_categories', 'id', $moveto)) {
		error('Error finding the category');
	}
	$courses = array();
	array_push($courses, $curso['id']);
	move_courses($courses, $moveto);
	$curso['fullname'] = "Malditaaa seaaa".$moveto;
	return $curso;
}
/*
function modulocategoriasMoverCategoria($data) {
global $USER;
$newcategory              = new stdClass();
$newcategory->id          = $data['id'];
$newcategory->description = utf8_encode($data['description']);
$newcategory->sortorder   = 999;
$newcategory->parent      = $data['parent'];// if $data->parent = 0, the new category will be a top-level category
$newcategory->visible     = 1;

if (!$category = get_record('course_categories', 'id', $newcategory->id)) {
$newcategory->name = "Categoria desconocida";
//error("Category not known!");
}
$newcategory->description = print_r($category, true);

$USER = get_record('user', 'id', 2);
// Update an existing category.
if ($newcategory->parent != $category->parent) {
// check category manage capability if parent changed
require_capability('moodle/category:manage', get_category_or_system_context((int) $newcategory->parent));
$parent_cat = get_record('course_categories', 'id', $newcategory->parent);
move_category($newcategory, $parent_cat);
fix_course_sortorder();
}
}*/

?>
