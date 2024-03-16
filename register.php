<?php
// Include the header file, which likely contains common elements like the doctype, HTML head, and opening body tag.
require 'header.php';
// Include the data connection file, which is presumably used to establish a connection to a database.
require 'datacon.php';
// Initialize variables for member number, password, confirm password, email, and name. Set them to empty strings.
$numbe_r = $pass_word = $compass_word = $em_ail = $na_me = "";
// Initialize variables for error messages related to name, email, and password. Set them to empty strings.
$erro_r =$err_or=$e_rror_p= "";

// Check if the form has been submitted by looking for the 'submitbutto_n' in the POST data.
if (isset($_POST['submitbutto_n'])) {
    // Check if the 'nam_e' field is empty. If it is, set the name variable to -8 and set an error message.
    if (empty($_POST['nam_e'])) {
        $na_me = -8;
        $erro_r = "Required";
    } else {
       // If the 'nam_e' field is not empty, assign its value to the name variable.
       $na_me = $_POST['nam_e'];
    }
    // Check if the 'emai_l' field is set. If it is, assign its value to the email variable.
    if (isset($_POST['emai_l'])) {
        $em_ail = $_POST["emai_l"];
        // Prepare a SQL statement to select users with the same email.
        $dat_a=$connection->prepare('SELECT * FROM user WHERE email=:emai_l');
        // Define an array with the email parameter.
        $user_criteri_a=[
            ':emai_l'=>$em_ail
        ];
        // Execute the prepared statement with the email parameter.
        $dat_a->execute($user_criteri_a);
        // Fetch the result of the query.
        $res_ult=$dat_a->fetch();
        // If the result is not '0', meaning an email already exists, set an error message and set the email variable to -8.
        if ($res_ult!= '0'){
            $err_or='Email alreday exist';
            $em_ail=-8;
        }
    } else {
        // If the 'emai_l' field is not set, set the email variable to -8.
        $em_ail = -8;       
    }
    // Check if the 'passwor_d' field is set. If it is, assign its value to the password variable and hash it.
    if (isset($_POST['passwor_d'])) {
        $pass_word = $_POST["passwor_d"];
        $hashed_passwor_d = password_hash($pass_word, PASSWORD_DEFAULT);
    } else {
        // If the 'passwor_d' field is not set, set the password variable to -8 and set an error message.
        $pass_word = -8;
        $erro_r = "Required";
    }
    // Check if the 'conpasswor_d' field is set. If it is, assign its value to the confirm password variable.
    if (isset($_POST['conpasswor_d'])) {
        $compass_word = $_POST["conpasswor_d"];
        // If the password and confirm password do not match, set an error message.
        if($pass_word!=$compass_word){
            $e_rror_p = "Your password doesnot match";
        }else{
           // If they match, store the hashed password in the session.
           $_SESSION['p_ass']=$hashed_passwor_d;
        }
    } else {
        // If the 'conpasswor_d' field is not set, set the confirm password variable to -8 and set an error message.
        $compass_word = -8;
        $erro_r = "Required";
    }
    
    // Check if the 'Phon_er' field is set. If it is, assign its value to the member number variable.
    if (isset($_POST['Phon_er'])) {
        $numbe_r = $_POST["Phon_er"];
    }
    // Check if all required fields are set and valid. If they are, prepare an SQL statement to insert the new user into the database.
    if( $numbe_r!=-8   && $pass_word!=-8 && $em_ail!=-8 && $na_me!=-8 && $compass_word!=-8){
        $valuesinsert=$connection->prepare('INSERT INTO user(name,email,password,phone_number)VALUES(:nyme,:e_mai,:passwor,:numb)');

        $user_criteri_a=[
            ':e_mai'=>$em_ail,
            ':nyme'=>$na_me,
            ':numb'=>$numbe_r,
            ':passwor'=>$hashed_passwor_d,
        ];
        // Execute the prepared statement with the user data.
        $valuesinsert->execute($user_criteri_a);
        // Redirect the user to the login page.
        echo "<script>window.location.href = 'login.php';</script>";
        
    }  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Define the character encoding for the document. -->
    <meta charset="UTF-8">
    <!-- Set the viewport to ensure the page is responsive on different devices. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Set the title of the document. -->
    <title>Document</title>
    <!-- Link to the CSS file for styling the page. -->
    <link rel="stylesheet" href="logs.css">
</head>
<body>
    <!-- Start of the form for user registration. The form data will be sent to "register.php" using the POST method. -->
    <form action="register.php" method="POST">
        <!-- Container for the registration form. -->
        <div class="user-registration">
            <!-- Header section of the form. -->
            <div class="form-header">
                <h1>Register</h1>
            </div>
            <!-- Main content area of the form. -->
            <div class="form-content">
                <!-- Container for the form fields. -->
                <div class="nocss">
                    <!-- Name field. -->
                    <li>
                        <label for="name">Name</label><br>
                        <input type="text" name="nam_e"><br>                    
                        <!-- Error message for the name field. -->
                        <span class="error">
                            <?php echo $erro_r; ?>
                        </span>
                    </li>
                    <!-- Email field. -->
                    <li>
                        <label for="email">Email</label><br>
                        <input type="email" name="emai_l">
                        <!-- Error messages for the email field. -->
                        <span class="error">
                        <?php
                            echo $err_or;
                            echo $erro_r; 
                        ?>
                    </span><br>
                    </li>
                    <!-- Password field. -->
                    <li>
                        <label for="password">Password</label><br>
                        <input type="password" name="passwor_d"><br>
                        <!-- Error message for the password field. -->
                        <span class="error">
                        <?php echo $erro_r; ?>
                    </span>
                    </li>
                    <!-- Confirm password field. -->
                    <li>
                        <label for="conpassword">Conform password</label><br>
                        <input type="password" name="conpasswor_d">
                        <!-- Error messages for the confirm password field. -->
                        <span class="error">
                        <?php 
                            echo $erro_r; 
                            echo $e_rror_p;
                        ?>
                    </span><br>
                    </li>
                    <!-- Number field. -->
                    <li>
                        <label for="number">Number</label><br>
                        <input type="number" name="Phon_er"><br>
                    </li>
                    <!-- Terms and conditions checkbox. -->
                    <li>
                        <label for="terms">Accept our <span>terms and condition</span></label>
                        <input type="checkbox" name="ter_s"><br>
                    </li>
                    
                    <!-- Link for users who already have an account. -->
                    <li>
                        <a href="login.php">Already have a account?</a>
                    </li>
                    
                </div>
                
            </div>
            <!-- Submit button for the form. -->
            <button type="submit" name='submitbutto_n'>Register</button>
    </form>
</body>

</html>
