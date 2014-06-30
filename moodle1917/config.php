<?php  /// Moodle Configuration File 

unset($CFG);

$CFG = new stdClass();
$CFG->dbtype    = 'mysql';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodles_1917';
$CFG->dbuser    = 'root';
$CFG->dbpass    = 'gustavo';
$CFG->dbpersist =  false;
$CFG->prefix    = 'mdl_';

$CFG->wwwroot   = 'http://localhost/moodles/moodle1917';
$CFG->dirroot   = '/var/www/html/moodles/moodle1917';
$CFG->dataroot  = '/var/www/moodles/1917';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode

$CFG->passwordsaltmain = 'V<_-,Jm!H8.ydF,by3OI7`@>R]%9l9';

require_once("$CFG->dirroot/lib/setup.php");
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>
