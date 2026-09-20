<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Flow - Upravljanje Zadacima</title>
    <link rel="stylesheet" href="assets/css/style.css?v=2.0">
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="index.php" class="brand">TaskFlow</a>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php" style="margin-right: 15px; text-decoration: none; color: var(--text);">Početna</a>
                    <span style="color: var(--text-muted); margin-right: 15px;">Zdravo, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Korisnik'); ?></span>
                    <a href="logout.php" class="btn btn-danger" style="padding: 0.4rem 0.8rem;">Odjavi se</a>
                <?php else: ?>
                    <a href="login.php" class="btn" style="margin-right: 10px;">Prijava</a>
                    <a href="register.php" class="btn" style="background-color: transparent; color: var(--primary); border: 1px solid var(--primary);">Registracija</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">