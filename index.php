<?php
include 'includes/header.php';
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obrada dodavanja novog zadatka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $title, $description);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}

// Dohvatanje zadataka prijavljenog korisnika
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card">
    <h2>Dodaj Novi Zadatak</h2>
    <form action="index.php" method="POST" style="margin-top: 1rem;">
        <div class="form-group">
            <label for="title">Naziv zadatka:</label>
            <input type="text" id="title" name="title" required placeholder="Unesi naziv zadatka...">
        </div>
        <div class="form-group">
            <label for="description">Opis (opciono):</label>
            <textarea id="description" name="description" rows="3" placeholder="Unesi detaljniji opis..."></textarea>
        </div>
        <button type="submit" name="add_task" class="btn">+ Dodaj Zadatak</button>
    </form>
</div>

<div class="card">
    <h2>Tvoji Zadaci</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Naziv</th>
                    <th>Opis</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['title']); ?></strong></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn" style="padding: 0.4rem 0.8rem; background-color: #f59e0b;">Izmeni</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger" style="padding: 0.4rem 0.8rem;" onclick="return confirm('Da li ste sigurni?')">Obriši</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="margin-top: 1rem; color: var(--text-muted);">Nemate unetih zadataka.</p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
include 'includes/footer.php';
?>