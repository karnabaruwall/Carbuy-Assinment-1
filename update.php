<?php
require 'header.php'; // Assume this file initiates a session, connects to the database, and includes necessary functions

// Check if the user is logged in and is an admin
// if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
//     header('Location: login.php');
//     exit();
// }

// $error = '';
// $success = '';
// $id = $_GET['id'] ?? null; // The ID of the admin to edit, passed via the query string

// // if (!$id) {
// //     header('Location: manageAdmins.php');
// //     exit();
// // }

// // Load the admin's current information
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//     $stmt = $connection->prepare("SELECT email, display_name FROM users WHERE id = ? AND is_admin = 1");
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $admin = $result->fetch_assoc();

//     if (!$admin) {
//         header('Location: manageAdmins.php');
//         exit();
//     }
// }

// // Handle form submission
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'] ?? '';
//     $password = $_POST['password'] ?? '';
//     $name = $_POST['name'] ?? '';
   
//     if (empty($email) || empty($name)) {
//         $error = 'Email and display name are required.';
//     } else {
//         if (!empty($password)) {
//             // Hash the new password if provided
//             $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//             $query = "UPDATE users SET email = ?, password = ?, display_name = ? WHERE id = ?";
//             $stmt = $conn->prepare($query);
//             $stmt->bind_param("sssi", $email, $hashedPassword, $name, $id);
//         } else {
//             // Don't update the password if not provided
//             $query = "UPDATE users SET email = ?, display_name = ? WHERE id = ?";
//             $stmt = $conn->prepare($query);
//             $stmt->bind_param("ssi", $email, $name, $id);
//         }

//         if ($stmt->execute()) {
//             $success = 'Admin updated successfully.';
//         } else {
//             $error = 'Failed to update the admin.';
//         }
//     }
// }
$error = 'Failed to update the admin';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Admin</title>
    <link rel="stylesheet" href="editAdmin.css">
</head>
<body>
    <h1>Edit Administrator</h1>
   
    <form action="editAdmin.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>" required><br>
       
        <label for="password">New Password (leave blank to keep current):</label>
        <input type="password" id="password" name="password"><br>
       
        <label for="name">Display Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($admin['display_name'] ?? ''); ?>" required><br>
       
        <input type="submit" value="Update Admin">
    </form>
</body>
</html>
