<!-- <?php
// addCategory.php

// Include header
include_once("includes/header.php");

// Your PHP logic for adding categories goes here
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to the login page or display an error message
    header("Location: login.php");
    exit;
}

// Include database connection code
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];

    // Add your validation and sanitization code here

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO category (name) VALUES (?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(1, $name);

        // Execute the statement
        if ($stmt->execute()) {
            // Category added successfully, redirect to a confirmation page or the category management page
            header("Location: adminCategories.php");
            exit;
        } else {
            // Error occurred, handle it appropriately
            echo "Error: Unable to add category";
        }
    } catch (PDOException $e) {
        // Handle PDO exceptions
        echo "Error: " . $e->getMessage();
    }

    // Close statement
    $stmt = null;
}

// Close connection
$conn = null;

// Include footer
include_once("includes/footer.php");
?> -->

<!-- chat -->
<?php
session_start();

// Check if the user is logged in as admin
// Replace this with your actual authentication logic
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate form data
    $name = $_POST["name"];

    // Insert the new category into the database
    // Replace this with your actual database insertion logic
    // Example:
    // insertCategory($name);

    // Redirect to admin categories page after adding the category
    header("Location: adminCategories.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - Carbuy Auctions</title>
    <link rel="stylesheet" href="sac.css">
    <link rel="stylesheet" href="vje.css">
    <link rel="stylesheet" href="customstyle.css">
</head>
<body>
    <header>
        <h1><span class="C">C</span><span class="a">a</span><span class="r">r</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
    </header>

    <nav>
        <ul>
            <li><a href="adminCategories.php" class="categoryLink">Manage Categories</a></li>
            <li><a href="logout.php" class="categoryLink">Logout</a></li>
        </ul>
    </nav>

    <main>
        <h1>Add Category</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required>
            <input type="submit" value="Add Category">
        </form>
    </main>

    <footer>
        &copy; Carbuy 2024
    </footer>
</body>
</html>
