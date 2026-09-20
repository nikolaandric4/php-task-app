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
    <title>Moj Projekat</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="logo">MojSajt</div>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php">Početna</a>
                <span style="color: #38bdf8; margin-left: 15px;">Zdravo, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" style="color: #f87171;">Odjavi se</a>
            <?php else: ?>
                <a href="login.php">Prijava</a>
                <a href="register.php">Registracija</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>