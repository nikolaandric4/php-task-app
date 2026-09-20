<?php 
include 'config/db.php';
include 'includes/header.php'; 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        // Enkripcija lozinke radi bezbednosti
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success = "Uspešno ste se registrovali! <a href='login.php'>Prijavite se ovde</a>.";
        } else {
            $error = "Korisničko ime ili email već postoje.";
        }
        $stmt->close();
    } else {
        $error = "Sva polja su obavezna!";
    }
}
?>

<h2>Registracija</h2>

<?php if ($error): ?>
    <div style="background: #f87171; color: white; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><?php echo $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="background: #4ade80; color: #064e3b; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><?php echo $success; ?></div>
<?php endif; ?>

<div class="card">
    <form action="register.php" method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px; font-weight: bold;">Korisničko ime:</label>
            <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px; font-weight: bold;">Email:</label>
            <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px; font-weight: bold;">Lozinka:</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        <button type="submit" name="register" style="background: #0284c7; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Registruj se
        </button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>