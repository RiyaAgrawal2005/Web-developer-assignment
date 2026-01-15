<!-- <?php
// require 'db.php';
// $error = "";

// if ($_POST) {
//     if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
//         $error = "Invalid email format";
//     } else {
//         $stmt = $conn->prepare(
//             "INSERT INTO contacts (name,email,phone) VALUES (?,?,?)"
//         );
//         if (!$stmt->execute([
//             $_POST['name'],
//             $_POST['email'],
//             $_POST['phone']
//         ])) {
//             $error = "Email already exists";
//         } else {
//             header("Location: index.php");
//         }
//     }
// }
// ?>

<form method="post">
<h3>Add Contact</h3>
<p style="color:red"><?= $error ?></p>
<input name="name" required placeholder="Name">
<input name="email" required placeholder="Email">
<input name="phone" required placeholder="Phone">
<button>Add</button>
</form> -->













<?php
require 'db.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error = "Phone number must contain exactly 10 digits";
    } else {

        // check email exists
        $check = $conn->prepare("SELECT id FROM contacts WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered";
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)"
            );
            $stmt->bind_param("sss", $name, $email, $phone);
            $stmt->execute();
            header("Location: index.php");
            exit;
        }
    }
}
?>
<form method="post">
    <?php if ($error): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<h3>Add Contact</h3>
<!-- <p style="color:red"><?= $error ?></p> -->
<input name="name" required placeholder="Name">
<input name="email" required placeholder="Email">
<!-- <input name="phone" required placeholder="Phone"> -->
<input type="text" name="phone" id="phone" placeholder="Phone (10 digits)" required>

<button>Add</button>
</form>
<script>
document.getElementById("phone").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
