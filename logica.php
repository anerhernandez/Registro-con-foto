<?php
session_start();
require("conexion.php");

//Comprobación de POST

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
function datos_registro($nombre, $apellidos, $email, $fecha, $hashedPasssword)
{
    $datos2 = array(
        "nombre" => $nombre,
        "apellidos" => $apellidos,
        "email" => $email,
        "fecha" => $fecha,
        "hashedPasssword" => password_hash($hashedPasssword, PASSWORD_DEFAULT),
        "imagen" => $_FILES['imagen']['name']
    );
    return $datos2;
}
$nombre = sanizar_input($_POST["nombre"]);
$apellidos = sanizar_input($_POST["apellidos"]);
$email = sanizar_input($_POST["email"]);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$fecha = ($_POST["fecha"]);
$password = $_POST["password"]; 
$password_conf = $_POST["password_conf"];

if (
    preg_match('/[\d\W_]/', $_POST["nombre"]) || preg_match('/[\d\W_]/', $_POST["apellidos"]) ||
    !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\S]{8,20}$/', $_POST["password"]) ||
    !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\S]{8,20}$/', $_POST["password_conf"])
) {
    //Si entra aquí significa que alguno de los campos no fue correcto
    $_SESSION["error"] = "No se pudieron validar los campos correctamente. Inténtelo de nuevo";
    header("location: registro.php");
    die();
} else {
    //Si entra aquí significa que el formulario se validó correctamente
    $ruta_imagenes = "../ImagenesUsuarios/";
    $nombreImagen =basename($_FILES['imagen']['name']);
    $ruta_imagenes = $ruta_imagenes . $nombreImagen;
    $imageFileType = strtolower(pathinfo($ruta_imagenes, PATHINFO_EXTENSION));

    if (!$_FILES['imagen']['name'] == 0) {
        $imagenload = "true";
        $imagen_size = $_FILES['imagen']["size"];
        if ($_FILES["imagen"]["size"] > 2000000) {
            echo "El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
            $imagenload = "false";
        }
        if (!($_FILES["imagen"]["type"] == "image/jpeg" or $_FILES["imagen"]["type"] == "image/png" or $_FILES["imagen"]["type"] == "image/jpg")) {
            echo " Tu archivo tiene que ser JPG o PNG. Otros archivos no son permitidos<BR>";
            $imagenload = "false";
        }
        if ($imagenload == "true") {
            if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagenes)) {
                echo "Error al subir el archivo";
            }
        }
    }
    if ($email == false || $password !== $password_conf) {
        header("location: registro.php");
    } else {
            $hashedPasssword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Selects
            $stmt = $conn->prepare("SELECT Email FROM usuarios WHERE Email LIKE ?");
            $stmt->execute([$email]);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->fetch() != false) {
                echo "Ya existe ese usuario";
            }else{
                //Insert
                $stmt = $conn->prepare("INSERT INTO usuarios (Nombre, Apellidos, Email, Fecha, Passw, NombreImagen) VALUES (?,?,?,?,?,?)");
                $stmt->execute([$nombre, $apellidos, $email, $fecha, $hashedPasssword, $nombreImagen]);
    
                header("location: index.php");
                die();
            }
    }
}
