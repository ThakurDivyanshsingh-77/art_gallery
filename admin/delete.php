<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT image FROM artworks WHERE id=$id");
$row = mysqli_fetch_assoc($result);

unlink("uploads/" . $row['image']); // delete image file

mysqli_query($conn, "DELETE FROM artworks WHERE id=$id");
header("Location: dashboard.php");
