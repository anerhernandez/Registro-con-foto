<?php

function read($conn,$email)
{
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE Email LIKE ?");
    $stmt->execute([$email]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt;
}

function create($conn, $datos) {
    $stmt = $conn->prepare("INSERT INTO usuarios (Nombre, Apellidos, Email, Fecha, Passw, NombreImagen) VALUES (?,?,?,?,?,?)");
    return $stmt->execute($datos);
}

function delete($conn, $email) {
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE Email LIKE ?");
    return $stmt->execute([$email]);
}