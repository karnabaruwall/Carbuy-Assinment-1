<?php
// Start the session to use session variables
session_start();
// Include the datacon.php file to establish a database connection
require 'datacon.php';
$cool_list="";

// Function to reverse the order of category names retrieved from the database
function show_Catego_Data($connection)
{
    // Prepare the SQL query to select all records from the 'category' table
    $da_ta_fetc = $connection->prepare('SELECT * FROM category');
    // Execute the prepared statement
    $da_ta_fetc->execute();
    // Fetch all results from the query
    $resul_t = $da_ta_fetc->fetchAll();
    // Reverse the order of the results array
    $resul_t = array_reverse($resul_t);
    // Return the reversed results array
    return $resul_t;
}

// Function to retrieve data from a specified table
function show_for_Data($connection,$tab_name)
{
    // Prepare the SQL query to select all records from the specified table
    $da_ta_fetc = $connection->prepare("SELECT * FROM $tab_name");
    // Execute the prepared statement
    $da_ta_fetc->execute();
    // Fetch all results from the query
    $resul_t = $da_ta_fetc->fetchAll();
    // Return the results array
    return $resul_t;
}

// Function to check if an email exists in the 'user' table
function im_function_check($connection,$em_ail){
    // Prepare the SQL query to select records from the 'user' table where the email matches the provided email
    $da_ta=$connection->prepare('SELECT * FROM user WHERE email=:emai_l');
    // Bind the provided email to the query parameter
    $user_criteri_a=[
        ':emai_l'=>$em_ail
    ];
    // Execute the prepared statement with the bound parameters
    $da_ta->execute($user_criteri_a);
    // Fetch the first result from the query
    $res_ult=$da_ta->fetch();
    // Return the fetched result
    return $res_ult;
}

// Function to check if a specific value exists in a specified column of a specified table
function em_func_tion_chec($connection, $tab_name, $cool_name, $val_ue) {
    // Prepare the SQL query to select records from the specified table where the specified column matches the provided value
    $da_ta = $connection->prepare("SELECT * FROM $tab_name WHERE $cool_name = :val_ue");    
    // Bind the provided value to the query parameter
    $user_criteri_a = [
        ':val_ue' => $val_ue
    ];    
    // Execute the prepared statement with the bound parameters
    $da_ta->execute($user_criteri_a);    
    // Fetch the first result from the query
    $res_ult = $da_ta->fetch();
    // Return the fetched result
    return $res_ult;
}

// Function to transform an email value from a specified column of a specified table
function trf_em($connection, $tab_name, $cool_mns,$cool_name, $val_ue) {
    // Prepare the SQL query to select the specified column from the specified table where the specified column matches the provided value
    $da_ta = $connection->prepare("SELECT $cool_mns FROM $tab_name WHERE $cool_name = :val_ue");    
    // Bind the provided value to the query parameter
    $user_criteri_a = [
        ':val_ue' => $val_ue
    ];    
    // Execute the prepared statement with the bound parameters
    $da_ta->execute($user_criteri_a);    
    // Fetch the first result from the query
    $res_ult = $da_ta->fetch();
    // Return the fetched result
    return $res_ult;
}
function trans_cat($Connection, $au_car){
	$dat_a = $Connection->prepare('SELECT category_id FROM category WHERE category_name=:va_le');
	$usr_criter_ia = [
		':va_le'=> $au_car
	];
	$dat_a->execute($usr_criter_ia);
	$res_t = $dat_a->fetch();
	return $res_t['category_id'];
}
// Function to check if a category exists in the 'category' table
function Cate_ceck($connection, $rand_gen)
{
    // Prepare the SQL query to select records from the 'category' table where the category_id matches the provided id
    $da_ta = $connection->prepare('SELECT * FROM category WHERE category_id=:id_ces');
    // Bind the provided id to the query parameter
    $user_criteri_a = [
        ':id_ces' => $rand_gen
    ];
    // Execute the prepared statement with the bound parameters
    $da_ta->execute($user_criteri_a);
    // Fetch the first result from the query
    $res_ult = $da_ta->fetch();
    // Return -1 if the data exists in the database, 0 otherwise
    if ($res_ult != 0) {
        return -1;
    } else {
        return 0;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="logs.css">
</head>

<body>
	<header>
		<h1 herf="index.php"><span class="C">C</span>
			<span class="a">a</span>
			<span class="r">r</span>
			<span class="b">b</span>
			<span class="u">u</span>
			<span class="y">y</span>
		</h1>

		<form action="index.php" method="post">
			<input type="text" name="search" placeholder="Search for a car" />
			<input type="submit" name="submit" value="Search" />
			<!-- //if session set login register need to be hidden -->
			<?php
			if (isset($_SESSION['admin_log'])) {
				echo $_SESSION['admin_log'];
				
			} elseif (isset($_SESSION['user_log'])) {
				echo $_SESSION['user_log'];
				$u_led=$_SESSION['user_log'];
			} else {
				// echo'<div class="abc">';
				echo '<a href="login.php" type="submit" name="log_ni" class="re_di">Login</a>';
				echo '<a href="register.php" type="submit" name="sign_pu" class="re_di">Register</a>';
				// echo'</div>';

			}
			?>
			<!-- //only session user email need to be displayed  -->
		</form>
	</header>
	<nav>
		<ul>
			<li><a class="categoryLink" href="index.php">Home</a></li>
			<?php
			$categ = [];
			
			foreach (show_Catego_Data($connection) as $in_poos => $value) {
				if ($in_poos < 5) {
					$categ[$in_poos] = $value['category_name'];
				}
			}
			for ($i = 0; $i < 5; $i++) {
				echo '<li>';
				echo '<a class="category" href="#">';
				echo $categ[$i];
				echo '</a>';
				echo '</li>';
			}
			?>
			<div class="dro_p">
				<li><a class="category" href="">Category</a></li>
				<div class="drp_cont">
					<?php
					foreach (show_Catego_Data($connection) as $value) {
						echo '<a href="">' . $value['category_name'] . '</a>';
					}
					?>
				</div>
			</div>

			<div class="dro_p">
				<li><a class="mo_re" href="#">More</a></li>
				<?php

				if (isset($_SESSION['user_log'])) { ?>
					<div class="drp_cont">
					
						<a href="logout.php">Logout</a>
						<a href="addAuction2.php">Add Auction</a>
						<a href="addAuction2.php">link 3</a>
					</div>
					<?php
				} ?>
				<?php
				if (isset($_SESSION['admin_log'])) { ?>
					<div class="drp_cont">
						<a href="logout.php">Logout</a>
						<a href="Categories.php">Add category</a>
						<a href="adminRegister.php">Add Admin</a>
						<a href="categories">Categories</a>
					</div>
					<?php
				} ?>
			</div>
		</ul>
	</nav>

</body>

</html>