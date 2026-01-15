<?php
require 'db.php';
$id = $_GET['id'];

$result = $conn->query("SELECT * FROM contacts WHERE id=$id");
$contact = $result->fetch_assoc();

if ($_POST) {
    $stmt = $conn->prepare(
        "UPDATE contacts SET name=?, email=?, phone=? WHERE id=?"
    );
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $id
    ]);
    header("Location: index.php");
}
?>

<form method="post">
<h3>Edit Contact</h3>
<input name="name" value="<?= $contact['name'] ?>" required>
<input name="email" value="<?= $contact['email'] ?>" required>
<input name="phone" value="<?= $contact['phone'] ?>" required>
<button>Update</button>
</form>
