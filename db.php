<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "crm_test";

$connexion = new mysqli($server, $user, $password, $db);

if ($connexion->connect_error) {
    die("Échec de la connexion à la base de données : " . $connexion->connect_error);
}