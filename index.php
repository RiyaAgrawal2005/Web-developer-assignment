<?php
require 'db.php';

$search = "";
if (isset($_GET['search']) && $_GET['search'] !== "") {
    $search = trim($_GET['search']);

    $stmt = $conn->prepare(
        "SELECT * FROM contacts 
         WHERE name LIKE ? OR email LIKE ?
         ORDER BY id DESC"
    );
    $like = "%" . $search . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM contacts ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Contacts Manager</title>
</head>
<body>

<h2>Contacts Manager</h2>

<!-- Search box -->
<form method="get" style="margin-bottom:15px;">
    <input 
        type="text" 
        name="search" 
        placeholder="Search by name or email"
        value="<?= htmlspecialchars($search) ?>"
    >
    <button type="submit">Search</button>
    <a href="index.php" style="margin-left:10px;">Reset</a>
</form>

<a href="create.php">Add Contact</a>

<table>
<tr>
<th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
</tr>

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td>
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete contact?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="4">No contacts found</td>
    </tr>
<?php endif; ?>

</table>

</body>
</html>

