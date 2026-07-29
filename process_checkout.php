<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AdarshDatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$full_name = $_POST['name'] ?? '';
$table_number = $_POST['table_no'] ?? '';
$mobile_number = $_POST['mob_no'] ?? '';
$total_quantity = 5;  // This should be dynamically calculated based on cart items
$total_price = 110.00;  // This should be dynamically calculated based on cart items

// Retrieve cart items from cookie if 'listCart' cookie is set
if (isset($_COOKIE['listCart'])) {
    $cart_items = json_decode($_COOKIE['listCart'], true);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO orders (full_name, table_number, mobile_number, total_quantity, total_price, product_name) VALUES (?, ?, ?, ?, ?, ?)");
    $product_name="";
    foreach ($cart_items as $item) {
        $product_name = $item['name'] ?? ''; // Extract product name from cart item
        // Execute the query 
    } 
    $stmt->bind_param("sssids", $full_name, $table_number, $mobile_number, $total_quantity, $total_price, $product_name);
       

    if ($stmt->execute() === TRUE) {
        $stmt->close();
        $conn->close();
        // Redirect to success page with customer's name and order time as URL parameters
        header("Location: index.html?name=" . urlencode($full_name) . "&time=" . urlencode(date("h:i A")));
        exit();
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();// Make sure to exit after redirection
} 
}else {
    echo "No cart items found.";}
?>
