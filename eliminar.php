<?php
session_start();
require("conexion.php");
require("crud.php");


if (delete($conn, $_SESSION["datos_usuario"]["Email"])) {
    
    if($_SESSION["datos_usuario"]["NombreImagen"] != "Default.png"){
        //La imagen usada es distinta la foto default, por lo tanto, se debe eliminar tambien
        if (file_exists("../ImagenesUsuarios/" . $_SESSION["datos_usuario"]["NombreImagen"]) && unlink("../ImagenesUsuarios/" . $_SESSION["datos_usuario"]["NombreImagen"])) {
            //Se consiguió eliminar la foto
        }
    }
    
    echo "Se ha eliminado al usuario correctamente";
}
session_destroy();
echo "<br><br><a href=' . 'index.php' . '>Volver a inicio de sesión</a>";
?>