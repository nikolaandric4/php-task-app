<?php 
include 'config/db.php';
include 'includes/header.php'; 

// Proveravamo da li je prosleđen ID zadatka koji menjamo
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$task_id = (int)$_GET['id'];

// Obrada izmene zadatka kad se pošalje forma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if (!empty($title)) {
        $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $status, $task_id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit();
    }
}

// Izvlačimo trenutne podatke o tom zadatku iz baze
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();
$stmt->close();

if (!$task) {
    echo "<h3>Zadatak nije pronađen.</h3>";
    include 'includes/footer.php';
    exit();
}
?>

<h2>Izmeni Zadatak</h2>

<div class="card">
    <form action="edit.php?id=<?php echo $task_id; ?>" method="POST">
        <div style="margin-bottom: 15px;">
            <label for="title" style="display:block; margin-bottom: 5px; font-weight: bold;">Naziv zadatka:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="description" style="display:block; margin-bottom: 5px; font-weight: bold;">Opis:</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="status" style="display:block; margin-bottom: 5px; font-weight: bold;">Status:</label>
            <select id="status" name="status" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                <option value="na_waitu" <?php echo ($task['status'] === 'na_waitu') ? 'selected' : ''; ?>>Na čekanju</option>
                <option value="u_toku" <?php echo ($task['status'] === 'u_toku') ? 'selected' : ''; ?>>U toku</option>
                <option value="zavrseno" <?php echo ($task['status'] === 'zavrseno') ? 'selected' : ''; ?>>Završeno</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" name="update_task" style="background: #0284c7; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                Sačuvaj izmene
            </button>
            <a href="index.php" style="background: #64748b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; display: inline-block;">
                Odustani
            </a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>