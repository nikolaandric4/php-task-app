<?php
session_start();

// Ako korisnik nije prijavljen, preusmeri na login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config/db.php';

// Proveravamo da li je prosleđen ID zadatka kroz URL (npr. delete.php?id=5)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $task_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Brišemo zadatak SAMO ako pripada trenutno prijavljenom korisniku
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Nakon brisanja, vraćamo korisnika na početnu stranicu
header("Location: index.php");
exit();
?>