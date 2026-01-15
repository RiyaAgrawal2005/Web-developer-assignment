<?php
require 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM contacts WHERE id=$id");
header("Location: index.php");
