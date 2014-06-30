<?php

require_once ('../config.php');
define('HOST', $CFG->dbhost ); // Nombre del HOST
define('DB', $CFG->dbname ); // Nombre de la BD
define('USER', $CFG->dbuser ); // Usuario de la BD
define('PASS', $CFG->dbpass ); // Contraseña de la BD
header('Content-type: text/plain');
/* Habrá que asegurarse que estos arreglos tengan la misma cantidad de elementos */
$obtengoCadenasBuscar = $_POST['buscar'];
$obtengoCadenasRemplazar = $_POST['reemplazar'];

$cadenasBuscar = explode("," , $obtengoCadenasBuscar);
$cadenasReemplazar = explode("," , $obtengoCadenasRemplazar);


// $textoBuscado = array( $cadenasBuscar[0], $cadenasBuscar[1] );
// $textoReemplazo = array(  $cadenasReemplazar[0],$cadenasReemplazar[1] );

$textoBuscado = array( $cadenasBuscar[0], $cadenasBuscar[1], $cadenasBuscar[2], $cadenasBuscar[3], $cadenasBuscar[4], $cadenasBuscar[5], $cadenasBuscar[6], $cadenasBuscar[7], $cadenasBuscar[8], $cadenasBuscar[9], $cadenasBuscar[10] );
$textoReemplazo = array(  $cadenasReemplazar[0], $cadenasReemplazar[1], $cadenasReemplazar[2], $cadenasReemplazar[3], $cadenasReemplazar[4], $cadenasReemplazar[5], $cadenasReemplazar[6], $cadenasReemplazar[7], $cadenasReemplazar[8], $cadenasReemplazar[9], $cadenasReemplazar[10] );



$k = 0;
/* Conector con base de datos */
$conexion = mysql_connect(HOST, USER, PASS) or trigger_error(mysql_error(), E_USER_ERROR);
@mysql_query("SET NAMES 'utf8'");
mysql_select_db(DB, $conexion);
 
for ($i = 0; $i < count($textoBuscado); $i++)
{
  /* Generar encabezado */
  echo "\nReemplazando texto [" . utf8_encode ($textoBuscado[$i]) . "] en '" . DB . "'...\n";
 
  /* Obtener listado de tablas */
  $query_tablas = "SHOW TABLES";
  $tablas = mysql_query($query_tablas, $conexion) or die(mysql_error());
  $row_tablas = mysql_fetch_assoc($tablas);
  $totalRows_tablas = mysql_num_rows($tablas);
 
  /* Si existen tablas en la base de datos */
  //TODO realizar operacion de los datos
  if ($totalRows_tablas > 0)
  {
    do
    {
      /* Obtener información de columnas */
      $query_columnas = sprintf("DESCRIBE `%s`", $row_tablas['Tables_in_' . DB]);
      $columnas = mysql_query($query_columnas, $conexion) or die(mysql_error());
      // echo $columnas; 
      // echo " --> ";
      $row_columnas = mysql_fetch_assoc($columnas);
      // echo $row_columnas; 
      $totalRows_columnas = mysql_num_rows($columnas);
      // echo $totalRows_columnas; 
      do
      {
        /* Si la columna es de tipo texto */
        if (strpos($row_columnas['Type'], 'char') !== false || $row_columnas['Type'] == 'text')
        {
 
          /* Construir la consulta de reemplazo para la columna específica */
          $query_rep = sprintf("UPDATE `%s` SET `%s`.`%s` = REPLACE(`%s`, '%s', '%s')",
            $row_tablas['Tables_in_' . DB],
            $row_tablas['Tables_in_' . DB],
            $row_columnas['Field'],
            $row_columnas['Field'],
            $textoBuscado[$i],
            $textoReemplazo[$i]);
          //TODO yuyi operacion de los datos
 
          $rep = mysql_query($query_rep, $conexion) or die(mysql_error());
 
          /* Obtener cantidad de filas actualizadas */
          $j = mysql_affected_rows();
 
          /* Mostrar cantidad de filas actualizadas */
          if ($j > 0)
	      printf("Registros actualizados en columna [`%s`][`%s`] = %d\n",
              $row_tablas['Tables_in_' . DB],
              $row_columnas['Field'], $j);
 
          /* Acumular filas actualizadas */
          $k += $j;
        }
      } while ($row_columnas = mysql_fetch_assoc($columnas));
 
    } while ($row_tablas = mysql_fetch_assoc($tablas));
  }
 
  /* Escribir cantidad total de filas modificadas */
  echo 'En total se actualizaron ' . $k .' registros que contengan el texto [' . $textoBuscado[$i] . '] por ['.$textoReemplazo[$i].'].';
  $k = 0;
}

?>
