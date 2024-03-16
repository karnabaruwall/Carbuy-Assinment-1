<?php
// Include the header and database connection files
require 'header.php';
require 'datacon.php';
function verify_password($plain_password, $hashed_password) {
    return password_verify($plain_password, $hashed_password);
}

// Check if the login form has been submitted
if (isset($_POST['loged_in'])) {
    // Initialize variables for email, password, category, and password border
    $em_ail = $pass_word = $cate_ogo = $passw_bord = "";

    // Check if the email field is set and assign its value to $em_ail, otherwise set it to -9
    if (isset($_POST['ema_li'])) {
        $em_ail = $_POST["ema_li"];
    } else {
        $em_ail = -9;
    }

    // Check if the password field is set and assign its value to $pass_word, otherwise set it to -9
    if (isset($_POST['passwor_d'])) {
        $pass_word = $_POST["passwor_d"];
    } else {
        $pass_word = -9;
    }

    // Check if the category field is set and assign its value to $cate_ogo, otherwise set it to -9
    if (isset($_POST['catlog_in'])) {
        $cate_ogo = $_POST['catlog_in'];
    } else {
        $cate_ogo = -9;
    }

    // If the category is "admi_n", check if the email exists in the admin table
    if ($cate_ogo == "admi_n") {
        // Prepare a SQL statement to select the email from the admin table where the email matches the input email
        $d_ata = $connection->prepare('SELECT email FROM admin WHERE email=:em_ali');
        // Bind the input email to the SQL statement
        $user_criteria = [
            ':em_ali' => $em_ail
        ];
        // Execute the SQL statement
        $d_ata->execute($user_criteria);
        // Fetch the result
        $r_esult = $d_ata->fetch();

        // If the email exists, prepare another SQL statement to select the email from the admin table (this seems redundant)
        if ($r_esult != 0) {
            $d_ata = $connection->prepare('SELECT email FROM admin WHERE email=:em_ali');
            $user_criteria = [
                ':em_ali' => $em_ail
            ];
            $d_ata->execute($user_criteria);
            $r_esult = $d_ata->fetch();

            // If the email exists again, prepare a SQL statement to select the password from the admin table
            if ($r_esult != 0) {
                $p_as_a = $connection->prepare('SELECT password FROM admin where email=:em_ali');
                $pass_im_criter = [
                    ':em_ali' => $em_ail
                ];
                $p_as_a->execute($pass_im_criter);
                $re_sultpas_s = $p_as_a->fetchAll();
                // Loop through the results to get the password
                foreach ($re_sultpas_s as $user_data) {
                    $data_base_pass_word = $user_data['password'];
                }
                // Verify the input password against the database password
                if (verify_password($pass_word, $data_base_pass_word)) {
                    // If the password matches, set a session variable and redirect to index.php
                    $_SESSION['admin_log'] = $em_ail;
                    echo "<script>window.location.href = 'index.php';</script>";
                } else {
                    // If the password does not match, display an error message
                    echo 'wrong password';
                }
            } else {
                // If the email does not exist, display an error message
                echo 'email doesnot exist';
            }
        }
    } else {
        // If the category is not "admi_n", check if the email exists in the user table
        $d_ata = $connection->prepare('SELECT email FROM user WHERE email=:em_ali');
        $user_criteria = [
            ':em_ali' => $em_ail
        ];
        $d_ata->execute($user_criteria);
        $r_esult = $d_ata->fetch();

        // If the email exists, prepare a SQL statement to select the password from the user table
        if ($r_esult != 0) {
            $p_as_a = $connection->prepare('SELECT password FROM user where email=:em_ali');
            $pass_im_criter = [
                ':em_ali' => $em_ail
            ];
            $p_as_a->execute($pass_im_criter);
            $re_sultpas_s = $p_as_a->fetchAll();
            // Loop through the results to get the password
            foreach ($re_sultpas_s as $user_data) {
                $data_base_pass_word = $user_data['password'];
            }
            // Verify the input password against the database password
            if (verify_password($pass_word, $data_base_pass_word)) {
                // If the password matches, set a session variable and redirect to index.php
                $_SESSION['user_log'] = $em_ail;
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                // If the password does not match, display an error message
                echo 'Your password is wrong';
            }
        } else {
            // If the email does not exist, display an error message
            echo 'email doesnot exist';
        }
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
	<link rel="stylesheet" href="ok.css">
</head>

<body>
	<main>
		<div class="login_body">
			<div class="login_head">
				<h1>LOGIN</h1>
			</div>
			<div class="login_form">
				<form action="login.php" method="post">
					<label for="email">Email:</label><br>
					<input type="email" name="ema_li"><br>
					<label for="password">Password:</label><br>
					<input type="password" name="passwor_d"><br>
					<label for="adminselec_t">Login Category</label>
					<select name="catagory_login" class="catagory_login">
						<option value="admi_n" class="catagory_login" name="Ad_men">Admin</option>
						<option value="m_embre" class="catagory_login" name="Ad_men">Member</option>
					</select>
					<div class="login_pass">
						<a href="">Forgot password?</a>
						<a href="register.php">Create new account</a><br>
						<br>
					</div>
					<button name="loged_in" type='submit' class='bttu_n'>LOGIN</button>
				</form>
			</div>
		</div>
		<!-- <?php


		?>
		<h1>Latest Car Listings / Search Results / Category listing</h1>
		<ul class="carList">
			<li>
				<img src="car.png" alt="car name">
				<article>
					<h2>Car model and make</h2>
					<h3>Car category</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales ornare purus, non laoreet
						dolor sagittis id. Vestibulum lobortis laoreet nibh, eu luctus purus volutpat sit amet. Proin
						nec iaculis nulla. Vivamus nec tempus quam, sed dapibus massa. Etiam metus nunc, cursus vitae ex
						nec, scelerisque dapibus eros. Donec ac diam a ipsum accumsan aliquet non quis orci. Etiam in
						sapien non erat dapibus rhoncus porta at lorem. Suspendisse est urna, egestas ut purus quis,
						facilisis porta tellus. Pellentesque luctus dolor ut quam luctus, nec porttitor risus dictum.
						Aliquam sed arcu vehicula, tempor velit consectetur, feugiat mauris. Sed non pellentesque quam.
						Integer in tempus enim.</p>

					<p class="price">Current bid: £1234.00</p>
					<a href="#" class="more auctionLink">More &gt;&gt;</a>
				</article>
			</li>
			<li>
				<img src="car.png" alt="car name">
				<article>
					<h2>Car model and make</h2>
					<h3>Car category</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales ornare purus, non laoreet
						dolor sagittis id. Vestibulum lobortis laoreet nibh, eu luctus purus volutpat sit amet. Proin
						nec iaculis nulla. Vivamus nec tempus quam, sed dapibus massa. Etiam metus nunc, cursus vitae ex
						nec, scelerisque dapibus eros. Donec ac diam a ipsum accumsan aliquet non quis orci. Etiam in
						sapien non erat dapibus rhoncus porta at lorem. Suspendisse est urna, egestas ut purus quis,
						facilisis porta tellus. Pellentesque luctus dolor ut quam luctus, nec porttitor risus dictum.
						Aliquam sed arcu vehicula, tempor velit consectetur, feugiat mauris. Sed non pellentesque quam.
						Integer in tempus enim.</p>

					<p class="price">Current bid: £2000</p>
					<a href="#" class="more auctionLink">More &gt;&gt;</a>
				</article>
			</li>
			<li>
				<img src="car.png" alt="car name">
				<article>
					<h2>Car model and make</h2>
					<h3>Car category</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales ornare purus, non laoreet
						dolor sagittis id. Vestibulum lobortis laoreet nibh, eu luctus purus volutpat sit amet. Proin
						nec iaculis nulla. Vivamus nec tempus quam, sed dapibus massa. Etiam metus nunc, cursus vitae ex
						nec, scelerisque dapibus eros. Donec ac diam a ipsum accumsan aliquet non quis orci. Etiam in
						sapien non erat dapibus rhoncus porta at lorem. Suspendisse est urna, egestas ut purus quis,
						facilisis porta tellus. Pellentesque luctus dolor ut quam luctus, nec porttitor risus dictum.
						Aliquam sed arcu vehicula, tempor velit consectetur, feugiat mauris. Sed non pellentesque quam.
						Integer in tempus enim.</p>

					<p class="price">Current bid: £3000</p>
					<a href="#" class="more auctionLink">More &gt;&gt;</a>
				</article>
			</li>
		</ul>

		<hr />

		<h1>Car Page</h1>
		<article class="car">

			<img src="car.png" alt="car name">
			<section class="details">
				<h2>Car model and make</h2>
				<h3>Car category</h3>
				<p>Auction created by <a href="#">User.Name</a></p>
				<p class="price">Current bid: £4000</p>
				<time>Time left: 8 hours 3 minutes</time>
				<form action="#" class="bid">
					<input type="text" name="bid" placeholder="Enter bid amount" />
					<input type="submit" value="Place bid" />
				</form>
			</section>
			<section class="description">
				<p>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales ornare purus, non laoreet dolor
					sagittis id. Vestibulum lobortis laoreet nibh, eu luctus purus volutpat sit amet. Proin nec iaculis
					nulla. Vivamus nec tempus quam, sed dapibus massa. Etiam metus nunc, cursus vitae ex nec,
					scelerisque dapibus eros. Donec ac diam a ipsum accumsan aliquet non quis orci. Etiam in sapien non
					erat dapibus rhoncus porta at lorem. Suspendisse est urna, egestas ut purus quis, facilisis porta
					tellus. Pellentesque luctus dolor ut quam luctus, nec porttitor risus dictum. Aliquam sed arcu
					vehicula, tempor velit consectetur, feugiat mauris. Sed non pellentesque quam. Integer in tempus
					enim.</p>


			</section>

			<section class="reviews">
				<h2>Reviews of User.Name </h2>
				<ul>
					<li><strong>John said </strong> great car seller! Car was as advertised and delivery was quick
						<em>29/01/2024</em>
					</li>
					<li><strong>Dave said </strong> disappointing, Car was slightly damaged and arrived
						slowly.<em>22/12/2023</em></li>
					<li><strong>Susan said </strong> great value but the delivery was slow <em>22/07/2023</em></li>

				</ul>

				<form>
					<label>Add your review</label> <textarea name="reviewtext"></textarea>

					<input type="submit" name="submit" value="Add Review" />
				</form>
			</section>
		</article>

		<hr />
		<h1>Sample Form</h1>

		<form action="#">
			<label>Text box</label> <input type="text" />
			<label>Another Text box</label> <input type="text" />
			<input type="checkbox" /> <label>Checkbox</label>
			<input type="radio" /> <label>Radio</label>
			<input type="submit" value="Submit" />

		</form>-->

	</main> 
	<footer>
		&copy; Carbuy 2024
	</footer>
</body>

</html>