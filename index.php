<?php
session_start();
require("conexion.php");
require("crud.php");
?>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <h1 style="text-align: center;">Página de Inicio de sesión</h1>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
        <input type="email" name="email" id="email" placeholder="Email" required><br><br>
        <input type="password" name="password" id="password" placeholder="Contraseña" required><br><br>
        <input type="submit" name="submit" id="enviar" value="Enviar"><br><br>
    
        <?php
        $_SESSION["error"] = "";
        //Comprobación sobre si ha escrito todos los campos
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $stmt = read($conn, $_POST['email']);
            $resultado = ($stmt->fetch(PDO::FETCH_ASSOC));
            //Comprobación sobre si el email existe en la DB
            if ($resultado == false) {
                $_SESSION["error"] = "No existe un usuario con ese email";
                //Verificar que la contraseña escrita se verifica con el hash guardado en la DB
            }elseif (password_verify($_POST['password'], $resultado["Passw"])) {
                $_SESSION["datos_usuario"] = $resultado;
                header("location: muestra.php");
                die();
            }else{
                echo "La contraseña no está bien escrita";
            } 
        } else {
            echo "\"Rellene todos los campos para iniciar sesión\"";
        }
        ?>
    </form>
    <p>¿No tienes cuenta?</p>
    <a href="registro.php">Registrate aquí</a>
    <br>

    
</body>

</html>