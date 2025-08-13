<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO artworks (title, image) VALUES ('$title', '$image')";
        mysqli_query($conn, $sql);
        $msg = "✅ Artwork uploaded successfully!";
    } else {
        $msg = "❌ Failed to upload artwork.";
    }
}

$artworks = mysqli_query($conn, "SELECT * FROM artworks ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Art Gallery Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    🎨 Art Gallery Admin
    <form action="logout.php" method="post" style="display:inline;">
        <button class="btn btn-error" style="position: absolute; right: 20px; top: 20px;">Logout</button>
    </form>
</header>

<div class="gallery-container">
    <?php if (!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

    <div class="form-container">
        <h3 class="form-title">Upload New Artwork</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Artwork Title" required>
            </div>
            <div class="form-group">
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
        </form>
    </div>

    <h3 class="gallery-title">Gallery</h3>
    <div class="gallery">
        <?php while ($row = mysqli_fetch_assoc($artworks)) { ?>
            <div class="card">
                <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="card-img">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $row['title']; ?></h4>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-error">Delete</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
