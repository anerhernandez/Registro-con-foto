<?php
session_start();
require("conexion.php");
?>

<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <h1 style="text-align: center;">Página de registro</h1>
    <?php
    if (isset($_SESSION["error"])) {
        echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION["error"]);
    }
    ?>
    <form enctype="multipart/form-data" action="logica.php" method="POST" id="formulario">
        <p id="error_nombre"></p>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre"><br>
        <p id="error_apellido"></p>
        <input type="text" name="apellidos" id="apellidos" placeholder="Apellidos"><br><br>
        <input type="email" name="email" id="email" placeholder="Email" required><br><br>
        <label for="fecha">Fecha de nacimiento</label><br>
        <p id="error_fecha"></p>
        <input type="date" name="fecha" id="fecha"><br>
        <hr>
        <p>La contraseña debe tener:<p>
        <i>
            Al menos de 8 a 20 carácteres, Al menos una mayúscula, al menos una minúscula, al menos un número y al menos un carácter especial ("+-*%$...")
        </i><br>
        <p id="error_pass"></p>
        <input type="password" name="password" id="password" placeholder="Contraseña" required><br>
        <p id="error_pass_conf"></p>
        <input type="password" name="password_conf" id="password_conf" placeholder="Confirmar contraseña" required><br><br>
        <p id="samePass"></p>
        <div style="border: solid 1px; padding: 1%; width: fit-content; margin-bottom: 1%">
            <p><b>OPCIONAL</b> Sólo se permiten archivos de tipo PNG, JPG y JPEG</p>
            <input type="file" name="imagen" id="imagen"><br><br>
        </div>
        <input type="submit" name="submit" id="enviar" value="Enviar"><br><br>
    </form>
<!--
    
    <script>
        let formulario = document.getElementById("formulario");
        document.getElementById("enviar").addEventListener('click', (event) => {
            let formulario = document.getElementById("formulario");
            let nombreform = 0;
            let apellidoform = 0;
            let passwform = 0;
            let passwConfform = 0;
            let samePassform = 0;

            if (formulario["nombre"].value == "") {
                document.getElementById("error_nombre").innerHTML = "Rellene el campo";
                document.getElementById("error_nombre").style.color = "red";
            } else {
                if ((formulario["nombre"].value).match(/\d+/g)) {
                    document.getElementById("error_nombre").innerHTML = "No se admiten números ni nombres compuestos";
                    document.getElementById("error_nombre").style.color = "red";
                } else {
                    document.getElementById("error_nombre").innerHTML = "Sa validado el campo";
                    document.getElementById("error_nombre").style.color = "green";
                    nombreform = 1;
                }
            }



            if (formulario["apellidos"].value == "") {
                document.getElementById("error_apellido").innerHTML = "Rellene el campo";
                document.getElementById("error_apellido").style.color = "red";
            } else {
                if ((formulario["apellidos"].value).match(/\d+/g)) {
                    document.getElementById("error_apellido").innerHTML = "No se admiten números ni nombres compuestos";
                    document.getElementById("error_apellido").style.color = "red";
                } else {
                    document.getElementById("error_apellido").innerHTML = "Sa validado el campo";
                    document.getElementById("error_apellido").style.color = "green";
                    apellidoform = 1;
                }
            }

            if (formulario["password"].value == "") {
                document.getElementById("error_pass").innerHTML = "Rellene el campo";
                document.getElementById("error_pass").style.color = "red";
            } else {
                if (!(formulario["password"].value).match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\S]{8,20}$/)) {
                    document.getElementById("error_pass").innerHTML = "Se deben validar primero los campos";
                    document.getElementById("error_pass").style.color = "red";
                } else {
                    document.getElementById("error_pass").innerHTML = "Sa validado el campo";
                    document.getElementById("error_pass").style.color = "green";
                    passwform = 1;
                }
            }


            if (formulario["password_conf"].value == "") {
                document.getElementById("error_pass_conf").innerHTML = "Rellene el campo";
                document.getElementById("error_pass_conf").style.color = "red";
            } else {
                if (!(formulario["password_conf"].value).match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\S]{8,20}$/)) {
                    document.getElementById("error_pass_conf").innerHTML = "Se deben validar primero los campos";
                    document.getElementById("error_pass_conf").style.color = "red";
                } else {
                    document.getElementById("error_pass_conf").innerHTML = "Sa validado el campo";
                    document.getElementById("error_pass_conf").style.color = "green";
                    passwConfform = 1;
                }
            }

            if (formulario["password"].value == "" || formulario["password_conf"].value == "") {
                document.getElementById("samePass").innerHTML = "Hay campos de contraseñas sin rellenar";
                document.getElementById("samePass").style.color = "red";
                passwConfform = 0;
            } else {
                if (formulario["password"].value === formulario["password_conf"].value) {
                    if (passwConfform == 0 || passwform == 0) {
                        document.getElementById("samePass").innerHTML = "Hay que validar las contraseñas primero";
                        document.getElementById("samePass").style.color = "red";
                        samePassform = 0;
                    } else {
                        samePassform = 1;
                        document.getElementById("samePass").innerHTML = "Las contraseñas son iguales";
                        document.getElementById("samePass").style.color = "green";
                    }
                } else {
                    document.getElementById("samePass").innerHTML = "Las contraseñas NO son iguales";
                    document.getElementById("samePass").style.color = "red";
                    samePassform = 0;
                }
            }
            if (nombreform == 1 && apellidoform == 1 && passwform == 1 && passwConfform == 1 && samePassform == 1) {
                location.href = "logica.php";
            } else {
                event.preventDefault();
                
            }
        })
    </script>
-->
    <p>¿Ya tienes cuenta?</p>
    <a href="index.php">Inicia sesión aquí</a>
</body>

</html>