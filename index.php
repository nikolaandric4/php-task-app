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
    $priority = $_POST['priority'] ?? 'medium';
    $status = $_POST['status'] ?? 'pending';
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : NULL;

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, priority, status, due_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $title, $description, $priority, $status, $due_date);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}

// Parametri za filtriranje i pretragu
$search = trim($_GET['search'] ?? '');
$filter_status = $_GET['filter_status'] ?? '';
$filter_priority = $_GET['filter_priority'] ?? '';

// Dinamičko građenje SQL upita
$sql = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$user_id];
$types = "i";

if (!empty($search)) {
    $sql .= " AND (title LIKE ? OR description LIKE ?)";
    $search_param = "%" . $search . "%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

if (!empty($filter_status)) {
    $sql .= " AND status = ?";
    $params[] = $filter_status;
    $types .= "s";
}

if (!empty($filter_priority)) {
    $sql .= " AND priority = ?";
    $params[] = $filter_priority;
    $types .= "s";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
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
            <textarea id="description" name="description" rows="2" placeholder="Unesi detaljniji opis..."></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="priority">Prioritet:</label>
                <select id="priority" name="priority" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
                    <option value="low">Nizak</option>
                    <option value="medium" selected>Srednji</option>
                    <option value="high">Visok</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
                    <option value="pending" selected>Na čekanju</option>
                    <option value="in_progress">U toku</option>
                    <option value="completed">Završeno</option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Rok za završetak:</label>
                <input type="date" id="due_date" name="due_date" style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ccc;">
            </div>
        </div>

        <button type="submit" name="add_task" class="btn" style="margin-top: 1rem;">+ Dodaj Zadatak</button>
    </form>
</div>

<!-- Pretraga i Filteri -->
<div class="card" style="padding: 1.2rem;">
    <form action="index.php" method="GET" class="form-row" style="align-items: flex-end; margin-bottom: 0;">
        <div class="form-group" style="flex: 2;">
            <label for="search">Pretraži zadatke:</label>
            <input type="text" id="search" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Unesi pojam za pretragu...">
        </div>
        
        <div class="form-group">
            <label for="filter_status">Status:</label>
            <select id="filter_status" name="filter_status" style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #ccc;">
                <option value="">Svi statusi</option>
                <option value="pending" <?= $filter_status === 'pending' ? 'selected' : ''; ?>>Na čekanju</option>
                <option value="in_progress" <?= $filter_status === 'in_progress' ? 'selected' : ''; ?>>U toku</option>
                <option value="completed" <?= $filter_status === 'completed' ? 'selected' : ''; ?>>Završeno</option>
            </select>
        </div>

        <div class="form-group">
            <label for="filter_priority">Prioritet:</label>
            <select id="filter_priority" name="filter_priority" style="width: 100%; padding: 0.75rem; border-radius: 6px; border: 1px solid #ccc;">
                <option value="">Svi prioriteti</option>
                <option value="low" <?= $filter_priority === 'low' ? 'selected' : ''; ?>>Nizak</option>
                <option value="medium" <?= $filter_priority === 'medium' ? 'selected' : ''; ?>>Srednji</option>
                <option value="high" <?= $filter_priority === 'high' ? 'selected' : ''; ?>>Visok</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn">Filtriraj</button>
            <a href="index.php" class="btn" style="background-color: #64748b; text-decoration: none;">Poništi</a>
        </div>
    </form>
</div>

<div class="card">
    <h2>Tvoji Zadaci</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="task-table">
            <thead>
                <tr>
                    <th>Naziv i Opis</th>
                    <th>Prioritet</th>
                    <th>Status</th>
                    <th>Rok</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($row['title']); ?></strong>
                            <?php if (!empty($row['description'])): ?>
                                <br><small style="color: var(--text-muted);"><?= htmlspecialchars($row['description']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-<?= $row['priority']; ?>">
                                <?= ucfirst($row['priority']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= $row['status']; ?>">
                                <?= str_replace('_', ' ', ucfirst($row['status'])); ?>
                            </span>
                        </td>
                        <td><?= $row['due_date'] ? date('d.m.Y.', strtotime($row['due_date'])) : '-'; ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn" style="padding: 0.4rem 0.8rem; background-color: #f59e0b;">Izmeni</a>
                            <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger" style="padding: 0.4rem 0.8rem;" onclick="return confirm('Da li ste sigurni?')">Obriši</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="margin-top: 1rem; color: var(--text-muted);">Nema pronađenih zadataka.</p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
include 'includes/footer.php';
?>