<?php 
// 1. Konekcija i zaglavlje
include 'config/db.php';
include 'includes/header.php'; 

// 2. DODAVANJE NOVOG ZADATKA (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $description);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}

// 3. PROMENA STATUSA ZADATKA U "ZAVRŠENO" (Update)
if (isset($_GET['complete_id'])) {
    $complete_id = (int)$_GET['complete_id'];
    $conn->query("UPDATE tasks SET status = 'zavrseno' WHERE id = $complete_id");
    header("Location: index.php");
    exit();
}

// 4. BRISANJE ZADATKA (Delete)
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM tasks WHERE id = $delete_id");
    header("Location: index.php");
    exit();
}

// 5. PRIKAZIVANJE SVIH ZADATAKA (Read)
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
?>

<h2>Upravljanje Zadacima</h2>

<!-- Forma za dodavanje -->
<div class="card" style="margin-bottom: 30px;">
    <h3>Dodaj Novi Zadatak</h3>
    <form action="index.php" method="POST">
        <div style="margin-bottom: 15px;">
            <label for="title" style="display:block; margin-bottom: 5px; font-weight: bold;">Naziv zadatka:</label>
            <input type="text" id="title" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="description" style="display:block; margin-bottom: 5px; font-weight: bold;">Opis (opciono):</label>
            <textarea id="description" name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"></textarea>
        </div>
        <button type="submit" name="add_task" style="background: #0284c7; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">
            + Dodaj Zadatak
        </button>
    </form>
</div>

<!-- Lista zadataka sa dugmićima -->
<h3>Tvoji Zadaci</h3>
<?php if ($result && $result->num_rows > 0): ?>
    <div style="display: grid; gap: 15px;">
        <?php while ($task = $result->fetch_assoc()): ?>
            <div style="border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; background: #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <strong style="font-size: 18px; color: #0f172a; <?php echo ($task['status'] === 'zavrseno') ? 'text-decoration: line-through; opacity: 0.6;' : ''; ?>">
                        <?php echo htmlspecialchars($task['title']); ?>
                    </strong>
                    <p style="margin: 5px 0 0 0; color: #475569;"><?php echo htmlspecialchars($task['description']); ?></p>
                    <small style="color: #94a3b8;">Kreirano: <?php echo $task['created_at']; ?></small>
                </div>
                
                <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="edit.php?id=<?php echo $task['id']; ?>" 
                          style="background: #0284c7; color: white; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: bold;">
                          ✎ Izmeni
                    </a>

                    <?php if ($task['status'] !== 'zavrseno'): ?>
                        <a href="index.php?complete_id=<?php echo $task['id']; ?>" 
                           style="background: #16a34a; color: white; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: bold;">
                           ✓ Završi
                        </a>
                    <?php else: ?>
                        <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            Završeno
                        </span>
                    <?php endif; ?>

                    <a href="index.php?delete_id=<?php echo $task['id']; ?>" 
                       onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj zadatak?');"
                       style="background: #dc2626; color: white; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: bold;">
                       ✕ Obriši
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p style="color: #64748b;">Trenutno nema unesenih zadataka.</p>
<?php endif; ?>

<?php 
include 'includes/footer.php'; 
?>