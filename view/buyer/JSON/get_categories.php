<?php
header('Content-Type: application/json');
require_once '../../../model/connect.php';

$conn = (new clsketnoi())->moKetNoi();
$conn->set_charset("utf8");

$sql = "SELECT id, CONCAT(UPPER(LEFT(name, 1)), LOWER(SUBSTRING(name, 2))) AS name FROM categories;"; // code = 'vegetables', 'fruits'...

$result = $conn->query($sql);
$categories = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'categories' => $categories
]);
$stmt->close();
    $conn->close();
?>
