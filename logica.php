<?php
session_start();
require("conexion.php");
require("crud.php");

//Regexs
// Regex No se admiten carácteres especiales ni números /[\d\W_]/
// Regex para tener mayúsculas minúsculas al menos un número, un carácter especial y de tamañao 8 a 20 carácteres 
// ^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@#€{}'"¿?!$%^&.:;+-><_=*])(?=\S+$).{8,20}$

function sanizar_input($datos)
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}
function datos_registro($nombre, $apellidos, $email, $fecha, $password, $nombreImagen)
{
    return [$nombre, $apellidos, $email, $fecha, password_hash($password, PASSWORD_DEFAULT), $nombreImagen];
}
$nombre = sanizar_input($_POST["nombre"]);
$apellidos = sanizar_input($_POST["apellidos"]);
$email = sanizar_input($_POST["email"]);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$fechaNacimiento = $_POST['fecha'];
$fechaNacimiento_date = new DateTime($fechaNacimiento);
$fechaActual = new DateTime();
$diferencia = $fechaActual->diff($fechaNacimiento_date);
$password = $_POST["password"];
$password_conf = $_POST["password_conf"];

//Comprobación sobre si el nombre y apellidos están bien escritos, las contraseñas son iguales y cumplen la expresión regular y la edad es mayor a 18
if (
    preg_match('/[\d\W_]/', $_POST["nombre"]) || preg_match('/[\d\W_]/', $_POST["apellidos"]) ||
    !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\S]{8,20}$/', $_POST["password"]) ||
    !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\S]{8,20}$/', $_POST["password_conf"]) ||
    $password !== $password_conf ||
    $diferencia->y < 18 ||
    $email == false
) {
    //Si entra aquí significa que alguno de los campos no fue correcto (El js mostrará detalladamente qué fue mal antes de mandar nada al servidor,
    //Esto es una segunda capa de seguridad ya que js se puede desactivar)
    $_SESSION["error"] = "No se pudieron validar los campos correctamente. Inténtelo de nuevo";
    header("location: registro.php");
    die();
} else {
    //Si entra aquí significa que el formulario se validó correctamente, quedaría la imagen, que es opcional
    $ruta_imagenes = "../ImagenesUsuarios/";
    $nombreImagen = basename($_FILES['imagen']['name']);
    $ruta_imagenes = $ruta_imagenes . $nombreImagen;
    $imageFileType = strtolower(pathinfo($ruta_imagenes, PATHINFO_EXTENSION));

    //Comprobación sobre si la imagen existe, tiene tamaño válido y es de tipo válido, en el caso de que no, se usará la foto Default
    if (!$_FILES['imagen']['name'] == 0 or "" or null) {
        $imagenload = "true";
        $imagen_size = $_FILES['imagen']["size"];
        if ($_FILES["imagen"]["size"] > 2000000) {
            echo "El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
            $imagenload = "false";
            $nombreImagen = "Default.png";
        }
        if (!($_FILES["imagen"]["type"] == "image/jpeg" || $_FILES["imagen"]["type"] == "image/png" || $_FILES["imagen"]["type"] == "image/jpg")) {
            echo " Tu archivo tiene que ser JPG o PNG. Otros archivos no son permitidos<BR>";
            $imagenload = "false";
            $nombreImagen = "Default.png";
        }
        if ($imagenload == "true") {
            if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagenes)) {
                echo "Error al subir el archivo";
                $nombreImagen = "Default.png";
            }
        }
    } else {
        $nombreImagen = "Default.png";
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Select para ver si el email que escribió ya existe
    $stmt = read($conn, $email);
    if ($stmt->fetch() != false) {
        $_SESSION["error"] = "Ya existe un usuario con ese email";
        header("location: registro.php");
        die();
    } else {
        //Insert
        $datos = datos_registro($nombre, $apellidos, $email, $fechaNacimiento, $password, $nombreImagen);
        if (!create($conn, $datos)) {
            $_SESSION["error"] = "Ocurrió un error inesperado al insertar los datos. Inténtelo de nuevo";
            header("location: registro.php");
            die();
        } else {
            header("location: index.php");
            die();
        }
    }
}
