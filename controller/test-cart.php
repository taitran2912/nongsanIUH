<?php
session_start();
include_once '../model/mCart.php';

// Set user ID for testing
$_SESSION['id'] = 1; // Replace with a valid user ID

// Create model instance
$cartModel = new mCart();

// Test getting cart items
$sql = "SELECT * FROM cart WHERE customer_id = {$_SESSION['id']}";
$result = $cartModel->mCart($sql);

echo "<h2>Cart Items</h2>";
if ($result && $result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Product ID</th><th>Quantity</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['product_id']}</td>";
        echo "<td>{$row['quantity']}</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>No items in cart</p>";
}

// Test updating cart item
echo "<h2>Test Update Cart</h2>";
echo "<form method='post' action='update-cart.php'>";
echo "<input type='hidden' name='action' value='update'>";
echo "Product ID: <input type='number' name='product_id' required><br>";
echo "Quantity: <input type='number' name='quantity' value='1' min='1' required><br>";
echo "<button type='submit'>Update Cart</button>";
echo "</form>";

// Test removing cart item
echo "<h2>Test Remove Item</h2>";
echo "<form method='post' action='update-cart.php'>";
echo "<input type='hidden' name='action' value='remove'>";
echo "Product ID: <input type='number' name='product_id' required><br>";
echo "<button type='submit'>Remove Item</button>";
echo "</form>";

// Test clearing cart
echo "<h2>Test Clear Cart</h2>";
echo "<form method='post' action='update-cart.php'>";
echo "<input type='hidden' name='action' value='clear'>";
echo "<button type='submit'>Clear Cart</button>";
echo "</form>";
?>