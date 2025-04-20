<?php
// Bắt đầu session
session_start();

// Gán giá
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Session</title>
</head>
<body>
    <h1>Thông tin Session</h1>
    <p>
        <?php
        // In giá trị session ra HTML
        if (isset($_SESSION['id'])) {
            echo "Người dùng: " . htmlspecialchars($_SESSION['id']);
            echo "vai trò: " . htmlspecialchars($_SESSION['role']);

        } else {
            echo "Không có thông tin session.";
        }
        ?>
    </p>
</body>
</html>