<?php
$conn = new mysqli("localhost", "root", "", "contacts_manager");

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
