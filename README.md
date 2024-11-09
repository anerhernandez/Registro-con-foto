# Registro-con-foto
Registro usando PhP y base de datos

Pautas por archivo:
CONEXION.PHP:   
    1. El archivo de conexion lleva la conexión a la base de datos "prueba"
CRUD.PHP:
    Contiene 3 funciones, una para leer otra para insertar y otra para eliminar.
    Usan PDO y evitarán inyecciones SQL usando ? como parámetros.
    
REGISTRO.PHP:
    1. Existe una validación primaria que sería javascript. Validará los campos y comprobará que no se escriban carácteres especiales ni números
    en el nombre ni apellidos, que la fecha sea de mayor de edad, que la contraseá cumpla con la expresión regular y que la comprobación de la contraseña
    sea la misma que la contraseña. El email se verifica solo con etiquetas de html (y también en servidor) y un último campo de foto opcional.
    
    2. Este último campo si no se rellena, nos guardará en el servidor una foto de perfil "Default.png".Si se rellena el campo de foto, en el servidor hará comprobaciones sobre si el archivo es jpeg jpg o png y su tamaño. Si cualquiera de los dos falla, nos llevará a la pestaña de registro y nos devolverá el error en una sesión

    3. Todos los campos que no se lleguen a validar nos los marcará en rojo y los validados en verde

LOGICA.PHP:
    En este archivo se harán las comprobaciones de los datos enviados por POST. SI por alguna razón no se realizan las validaciones por javascript (como desactivar el propio javascript) también se harán comprobaciones en el servidor, sin embargo la devolución de errores no será tan precisa como en js
    así que sólo nos devolverá una aviso de que los campos no se llegaron a validar completamente.
    1. Habrá dos funciones, una para sanizar los campos de texto como nombre apellidos y email y otro para guardar los datos en un array que se usará más adelante.

    2. Cuando se sanicen los datos de nombre apellidos y email, se guardará en una variable la diferencia de edad para saber si es mayor de edad y luego las contraseñas por POST. Luego se hará un pregmatch para nombre y apellidos otro para la contraseña y confirmación de contraseña, otro que comprueba si la contraseña y confirmar contraseña son iguales y otro más para veriicar si es mayor de edad. Si alguno falla nos guardará en la sesión de errores que no se lelgó a validar y nos devolverá a REGISTRO.PHP

    3. En el caso de que los datos sean correctos, habrá que comprobar la foto opcional. Esta foto se guardará en la carpeta ../ImagenesUsuarios/
    Si no se envió nada por POST sobre la foto, se guardará una por defecto "Default.png" (dada en el repositorio).

    4. Si se envió algo por POST, ahora habrá que comprobar que lo que se envió es de formato jpeg, jpg o png, y que su tamaño sea válido
    Si falla alguna de las verificaciones, nos devolverá por sesión un error específico, como que la iamgen es demasiado grande o el formato no es válido.

    5. Al final del todo hará comprobaciones en la base de datos:
    Se realizará un select con el email que se escribió por POST y si ya existía en la base de datos, nos devolverá un error por sesión diciéndonos que ya existe el usuario. En caso contrario, intentará hacer una inserción en la base de datos llamando a la función datos_registro que tomará los valores ya sanizados y validados y los guardará en una array (hasheando la contraseña y guardando el nombre de la imagen que s eenvió por POST)

    6. Al realizar con éxito la inserción nos llevará a INDEX.PHP

INDEX.PHP:
    1. La página se abrirá directamente en index (inicio de sesión).

    2. Nos pedirá un email y una contraseña, si el usuario existe y la contraseña es incorrecta, nos pedirá que la insertemos de nuevo.

    3. Si no se escriben todos los datos, nos pedirá que rellenemos todos los campos.

    4. Si el email existe en la base de datos y la contraseña coincide con el hash guardado en la base de datos, guardará en un array los datos y los guardará en una sesión. Luego nos llevará a la pestaña de muestra.

MUESTRA.PHP
    En la pestaña de muestra nos volcará todos los datos de sesión directamente en la página y generará código javascript con DOM para un botón de eliminar cuenta.
    Si pulsamos este botón nos saltará una aviso sobre si estamos seguros de que queremos eliminar la cuenta con dos opciones. Eliminar y cancelar
    Si eliminamos nos llevará a una página ELIMINAR.PHP donde comprobará que ese usuario existe en la base dedatos y eliminará sus datos. También nos eliminará la foto en ../ImagenesUsuarios/, a no ser que la imagen sea la de default "Default.png". A continuación nos mostrará que el usuario ha sido eliminado y nos destruirá la sesión para eliminar completamente todos los datos guardados de ese usuario.
