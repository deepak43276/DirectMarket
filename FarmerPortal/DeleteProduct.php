<?php
include("../Includes/db.php");
session_start();

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product from the database
    $delete_product = "DELETE FROM products WHERE product_id = '$product_id'";
    $run_delete = mysqli_query($con, $delete_product);

    if ($run_delete) {
        // Optionally delete the image file from the server if needed
        // $image_query = "SELECT product_image FROM products WHERE product_id = '$product_id'";
        // $result = mysqli_query($con, $image_query);
        // $row = mysqli_fetch_assoc($result);
        // $image_path = "../Admin/product_images/" . $row['product_image'];
        // if (file_exists($image_path)) {
        //     unlink($image_path);
        // }

        echo "<script>alert('Product deleted successfully!');</script>";
        echo "<script>window.open('MyProducts.php', '_self');</script>"; // Redirect to MyProducts page
    } else {
        echo "<script>alert('Error deleting the product.');</script>";
        echo "<script>window.open('MyProducts.php', '_self');</script>"; // Redirect to MyProducts page
    }
} else {
    echo "<script>alert('No product ID specified.');</script>";
    echo "<script>window.open('MyProducts.php', '_self');</script>"; // Redirect to MyProducts page
}
?>
