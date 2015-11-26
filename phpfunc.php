<?php
require_once("config.php");
function conector_bbdd() {
        $condb=new mysqli($serv, $usua, $pass, $bbdd);

        if($condb->connect_error) {
                die("Error en la conexion: ".$condb->connect_error);
        }

	return $condb;
}
?>
