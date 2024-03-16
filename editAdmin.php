<?php
require 'header.php'; // Assume this file initiates a session and connects to the database

// Redirect non-admin users to the home page or login page
// if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    // echo "<script type='text/javascript'>window.location='editAdmin.php';</script>";
    // header('Location: index.php');
//     exit();
// }

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    
    if (empty($email) || empty($password) || empty($name)) {
        $error = 'All fields are required.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = 'An account with this email already exists.';
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new admin
            $stmt = $conn->prepare('INSERT INTO users (email, password, display_name, is_admin) VALUES (?, ?, ?, 1)');
            $stmt->bind_param('sss', $email, $hashedPassword, $name);
            if ($stmt->execute()) {
                // Redirect to manageAdmins.php or display success message
                header('Location: manageAdmins.php');
                exit();
            } else {
                $error = 'Failed to add new admin.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Admin</title>
    <link rel="stylesheet" href="editAdmin.css">
</head>
<body>
    <h1>Add New Administrator</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="addAdmin.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="name">Display Name:</label>
        <input type="text" id="name" name="name" required><br>
        <input type="submit" value="Add Admin">
    </form>
</body>
</html>