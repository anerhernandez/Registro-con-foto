<?php
session_start();
require("conexion.php");

echo "Información de cliente <b>" .   $_SESSION["datos_usuario"]["Email"] . "</b> de inicio de sesión: <br><br><br>";
echo "Nombre: " . $_SESSION["datos_usuario"]["Nombre"] . "<br>";
echo "Apellidos: " . $_SESSION["datos_usuario"]["Apellidos"] . "<br>";
echo "email: " . $_SESSION["datos_usuario"]["Email"] . "<br>";
echo "fecha: " . $_SESSION["datos_usuario"]["Fecha"] . "<br>";
echo "imagen: " . $_SESSION["datos_usuario"]["NombreImagen"] . "<br>";
echo "<img src='../ImagenesUsuarios/" . $_SESSION["datos_usuario"]["NombreImagen"] . "' height='40px'>";


echo "<br><br><a href=" . "\"cerrar.php\"" . ">Cerrar de sesión</a>";


echo "<br><br>";
echo "<form action=\"muestra.php\">
    <button id='eliminar' type='submit'  name='eliminar' value='Eliminar' style='color: white; background-color: red;  height: 30px;'>
        Eliminar cuenta
    </button>
    </form>";

echo "<script>
        document.getElementById('eliminar').addEventListener('click', (event) => {
        event.preventDefault();
            let text = '¿Está seguro de que desea eliminar la cuenta? Este cambio es irreversible, no se podrán recuperar sus datos';
            if (confirm(text) == true) {
                text = 'Su cuenta ha sido eliminada';
                location.href = 'eliminar.php'
            } else {
                text = 'Ha cancelado la operación';
            }
        })
        </script>"
?>