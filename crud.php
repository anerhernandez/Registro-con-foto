<?php
session_start();

function read($conn,$email)
{
    $stmt = $conn->prepare("SELECT Email FROM usuarios WHERE Email LIKE ?");
    $stmt->execute([$email]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt;
}

function create() {}

function delete() {}
