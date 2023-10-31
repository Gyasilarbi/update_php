<?php

include "config.php";
// Define error variables
$item_nameErr = $item_typeErr = $item_colorErr = $priceErr = $item_tallyErr = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data
    // $item_id = $_POST["item_id"];
    $item_name = $_POST["item_name"];
    $item_type = $_POST["item_type"];
    $item_color = $_POST["item_color"];
    $price = $_POST["Price"];
    $item_tally = $_POST["item_tally"];
    $productCode = $_POST["updateKey"];

    // Example validation for the price field
    if (!is_numeric($price)) {
        $priceErr = "Price must be a valid number.";
    }

    // If all fields are valid, you can update the item data in your database using PDO
    if (empty($item_nameErr) && empty($item_typeErr) && empty($item_colorErr) && empty($priceErr) && empty($item_tallyErr)) {
        // $servername = "localhost"; //127.0.0.1
        // $database = "getclothed";
        // $username = "root";
        // $password = "root";

        try {
            $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL query to update the database (replace 'your_table' and 'your_item_id' with actual values)
            $sql = "UPDATE Items SET ITEM_NAME = :item_name, ITEM_TYPE = :item_type, ITEM_COLOR = :item_color, PRICE = :price, ITEM_TALLY = :item_tally WHERE PRODUCT_NO = :product_no";
            
            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':product_no', $productCode);
            $stmt->bindParam(':item_name', $item_name);
            $stmt->bindParam(':item_type', $item_type);
            $stmt->bindParam(':item_color', $item_color);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':item_tally', $item_tally);
            
            // var_dump($productCode,$item_color,$item_name);
            // exit;
            // Execute the statement
            $stmt->execute();

            header("location: admin_page.php");
            die();
            // You can also redirect the user to a success page here

        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
        }

        // Close the database connection
        $pdo = null;
    }
}
?>
