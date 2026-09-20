<?php 
session_start();
include 'config/db.php';
include 'includes/header.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Pogrešna lozinka!";
            }
        } else {
            $error = "Korisnik ne postoji!";
        }
        $stmt->close();
    } else {
        $error = "Popunite sva polja!";
    }
}
?>

<h2>Prijava</h2>

<?php if ($error): ?>
    <div class="alert-error"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Korisničko ime:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Lozinka:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Prijavi se</button>
    </form>
    <p style="margin-top: 15px;">Nemate nalog? <a href="register.php">Registrujte se ovde</a>.</p>
</div>

<?php include 'includes/footer.php'; ?>