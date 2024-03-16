<?php
// Include the header.php file to use common HTML header elements
require 'header.php';
// Include the datacon.php file to establish a database connection
require 'datacon.php';
// Check if the 'log_out' form button was clicked
if (isset($_POST['log_out'])) {

    // Clear the session array to log the user out
    $_SESSION = array();
    // Redirect the user to the index.php page
    echo "<script>window.location.href = 'index.php';</script>";
    // Destroy the session to ensure the user is logged out
    session_destroy();
} 
// Check if the 'cance_logout' form button was clicked
if (isset($_POST['cance_logout'])) {
    // Redirect the user to the index.php page
    echo "<script>window.location.href = 'index.php';</script>";
} 
?>

<!-- Define the document type and HTML version -->
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Define the character set for the document -->
	<meta charset="UTF-8">
	<!-- Define the viewport settings for responsive design -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="logs.css">
	<!-- Define the title of the document -->
	<title>Document</title>
</head>

<body>
    <!-- Start of the head section, which is typically used for metadata -->
    <head>
        <!-- Container for the logout header -->
        <div class="logot_hed">
            <!-- Heading for the logout section -->
            <h1>Logout</h1>
        </div>
    </head>
	<!-- Main content area -->
	<main>
		<!-- Container for the logout form -->
		<div class="logot_body">			
            <!-- Logout form with action set to logout.php -->
            <form action="logout.php" method="post">
                <!-- Label for the logout confirmation -->
                <label for="logout">DO YOU WANT TO LOGOUT ?</label>
                <!-- Button to cancel the logout action -->
                <button name="cance_logout" type='submit'class='bt_n1' >NO</button>
                <!-- Button to confirm the logout action -->
                <button name="log_out" type='submit' class='bt_n'>YES</button>                
			</form>
		</div>
	</main>	
</body>

</html>
