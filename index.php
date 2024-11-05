<?php 
    session_start();
    require("conexion.php");
?>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1 style="text-align: center;">Página de Inicio de sesión</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <input type="email" name="email" id="email" placeholder="Email"><br><br>
            <input type="password" name="password" id="password" placeholder="Contraseña"><br><br>
            <input type="submit" name="submit" id="enviar" value="Enviar"><br><br>
        </form>
            <p>¿No tienes cuenta?</p>    
            <a href="registro.php">Registrate aquí</a>
            <br>
        <?php
        $_SESSION["error"] = "";
        //Comprobación sobre si ha escrito todos los campos
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if (file_exists("../../Usuarios/usuarios.json")) {
                $datos_json = json_decode(file_get_contents("../../Usuarios/usuarios.json"), 1);
                //Comprobación sobre si el email que se ha escrito existe en el json
                if (array_key_exists($_POST['email'], $datos_json)) {
                    //Comprobación sobre si la contraseña es correcta
                    if ((password_verify($_POST['password'], $datos_json[$_POST['email']]["hashedPasssword"]))) {
                        $_SESSION["datos_usuario"] = ($datos_json[$_POST['email']]); 
                        header("location: muestra.php");
                    }else{
                        echo "Algún dato es incorrecto, try again";
                    }
                }else{
                    echo "No se ha registrado su usuario en esta super pagina chula, regístrese con el botón más arriba";
                }
            }else{
                echo "Aún  hay registros de usuario guardados, regístrese para ser el primero";
            }
        }else{
            echo "\"Rellene todos los campos para iniciar sesión\"";
        }
        ?>
    </body>
</html>