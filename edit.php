<?php
include 'includes/header.php';
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? null;

if (!$task_id) {
    header("Location: index.php");
    exit();
}

// Obrada izmene zadatka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $priority = $_POST['priority'] ?? 'medium';
    $status = $_POST['status'] ?? 'pending';
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : NULL;

    if (!empty($title)) {
        $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, priority = ?, status = ?, due_date = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sssssii", $title, $description, $priority, $status, $due_date, $task_id, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}

// Dohvatanje trenutnih podataka o zadatku
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();
$stmt->close();

if (!$task) {
    header("Location: index.php");
    exit();
}
?>

<div class="card">
    <h2>Izmeni Zadatak</h2>
    <form action="edit.php?id=<?= $task_id; ?>" method="POST" style="margin-top: 1rem;">
        <div class="form-group">
            <label for="title">Naziv zadatka:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Opis (opciono):</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($task['description']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="priority">Prioritet:</label>
                <select id="priority" name="priority" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
                    <option value="low" <?= $task['priority'] === 'low' ? 'selected' : ''; ?>>Nizak</option>
                    <option value="medium" <?= $task['priority'] === 'medium' ? 'selected' : ''; ?>>Srednji</option>
                    <option value="high" <?= $task['priority'] === 'high' ? 'selected' : ''; ?>>Visok</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
                    <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : ''; ?>>Na čekanju</option>
                    <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : ''; ?>>U toku</option>
                    <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : ''; ?>>Završeno</option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Rok za završetak:</label>
                <input type="date" id="due_date" name="due_date" value="<?= $task['due_date']; ?>" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
            </div>
        </div>

        <button type="submit" name="update_task" class="btn" style="margin-top: 1rem;">Sačuvaj Izmene</button>
        <a href="index.php" class="btn" style="background-color: #64748b; text-decoration: none; margin-left: 10px;">Otkaži</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>