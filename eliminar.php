<?php
session_start();
$datosJSON = file_get_contents("../../Usuarios/usuarios.json");
$datosJSON = json_decode($datosJSON, 1);

$emailSincomillas = $_SESSION["emailCliente"];
$emailSincomillas = str_replace("\"", "", $emailSincomillas);


if (in_array(json_decode($_SESSION["emailCliente"]), $datosJSON[$emailSincomillas])) {
    unset($datosJSON[json_decode($_SESSION["emailCliente"])]);
    echo "Se han eliminado sus datos";
    echo "<br><br><a href=" . "\"index.php\"" . ">Volver a inicio de sesión</a>";
}

file_put_contents("../../Usuarios/usuarios.json", json_encode($datosJSON, JSON_PRETTY_PRINT));
