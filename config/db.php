<?php
$host = 'localhost';
$user = 'root';
$password = ''; // U XAMPP-u je lozinka po podrazumevanju prazna
$dbname = 'moj_projekat_db';

// Kreiranje konekcije
$conn = new mysqli($host, $user, $password, $dbname);

// Provera konekcije
if ($conn->connect_error) {
    die("Konekcija sa bazom nije uspela: " . $conn->connect_error);
}
?>