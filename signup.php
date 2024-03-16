<?php
require 'header.php';
require 'datacon.php';
$c_ty = $c_untry = $n_mber = $p_stalcode = $t_rms = $g_nder = $pa_sword = $con_password = $e_ail = $n_me = "";
$err =$erra=$err_p= "";

if (isset($_POST['submit_button'])) {
    if (empty($_POST['namse'])) {
        $n_me = -8;
        $err = "Required";
    } else {
       $n_me = $_POST['namse'];
    }
    if (isset($_POST['ema_li'])) {
        $e_ail = $_POST["ema_li"];
        // $res_t=em_func_t_check($Connection,$e_ail);
        $res_t = em_func_t_chec($Connection, "user", "email", $e_ail);
        if ($res_t!= '0'){
            $erra='alreday exist';
            $e_ail=-8;
        }
    } else {
        $e_ail = -8;       
    }
    if (isset($_POST['pass_ord'])) {
        $pa_sword = $_POST["pass_ord"];
        $has_passw_d = password_hash($pa_sword, PASSWORD_DEFAULT);
    } else {
        $pa_sword = -8;
        $err = "Required";
    }
    if (isset($_POST['conpass_ord'])) {
        $con_password = $_POST["conpass_ord"];
        if($pa_sword!=$con_password){
            $err_p = "Password doesnot match";
        }else{
           $_SESSION['pas_s']=$has_passw_d;
        }
    } else {
        $con_password = -8;
        $err = "Required";
    }
    if (isset($_POST['gen_der'])) {
        $g_nder = $_POST['gen_der'][0];
    }
    if (isset($_POST['Pnum_er'])) {
        $n_mber = $_POST["Pnum_er"];
    }
    if (isset($_POST['postal_ode'])) {
        $p_stalcode = $_POST["postal_ode"];
    }
    //for city
    if (isset($_POST['ci_y'])) {
        $c_ty = $_POST["ci_y"];
    }
    //for country
    if (isset($_POST['coun_try'])) {
        $c_untry = $_POST["coun_try"];
    }
    if($c_ty!=-8 && $c_untry!=-8 && $n_mber!=-8 && $p_stalcode!=-8 && $t_rms!=-8 && $g_nder!=-8 && $pa_sword!=-8 && $e_ail!=-8 && $n_me!=-8 && $con_password!=-8){
        $valueiinsert=$Connection->prepare('INSERT INTO user(name,email,password,postal_code,phone_number,country,city,gender)VALUES(:names,:emai,:passw,:post,:numbr,:count,:cit,:gend)');

        $user_criteri_a=[
            ':emai'=>$e_ail,
            ':names'=>$n_me,
            ':numbr'=>$n_mber,
            // ':passw'=>$pa_sword,
            ':passw'=>$has_passw_d,
            ':cit'=>$c_ty,
            ':count'=>$c_untry,
            ':post'=>$p_stalcode,
            ':gend'=>$g_nder
        ];
        $valueiinsert->execute($user_criteri_a);
        echo "<script>window.location.href = 'index.php';</script>";
        $_SESSION['usr_logged']=$e_ail;
        
    }  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="register.php" method="POST">
        <div class="sig_bod">
            <div class="sig_hed">
                <h1>Register</h1>
            </div>
            <div class="sig_main">
                <div class="lef">
                    <li>
                        <label for="name">Name</label><br>
                        <input type="text" name="namse"><br>                    
                    <span class="error">
                        <?php echo $err; ?>
                    </span>
                    <li>
                        <label for="email">Email</label><br>
                        <input type="email" name="ema_li">
                        <span class="error">
                        <?php
                            echo $erra;
                            echo $err; 
                        ?>
                    </span><br>
                    </li>
                    <li>
                        <label for="password">Password</label><br>
                        <input type="password" name="pass_ord"><br>
                        <span class="error">
                        <?php echo $err; ?>
                    </span>
                    </li>
                    <li>
                        <label for="conpassword">Conform password</label><br>
                        <input type="password" name="conpass_ord">
                        <span class="error">
                        <?php 
                            echo $err; 
                            echo $err_p;
                        ?>
                    </span><br>
                    </li>
                    <li>
                        <label for="terms">Accept our <span>terms and condition</span></label>
                        <input type="checkbox" name="ter_s"><br>
                    </li>
                    <li>
                        <a href="login.php">Already have a account?</a>
                    </li>
                    <li>
                        <label for="gender">Gender</label><br>
                        <label for="">Male</label>
                        <input type="radio" class="gen_er" value="male" name="gen_der[]">
                        <label for="">Female</label>
                        <input type="radio" class="gen_er" value="female" name="gen_der[]">
                        <label for="">Others</label>
                        <input type="radio" class="gen_er" value="other" name="gen_der[]"> <br>
                    </li>
                </div>
                <div class="rit">
                    <li>
                        <label for="number">Number</label><br>
                        <input type="number" name="Pnum_er"><br>
                    </li>
                    <li>
                        <label for="postalcode">Postal-code</label><br>
                        <input type="number" name="postal_ode"><br>
                    </li>
                    <li>
                        <label for="address">City</label><br>
                        <input type="text" name="ci_y">
                    </li>
                    <li>
                        <label for="country">Country</label><br>
                        <input type="text" name="coun_try"><br>
                    </li>

                </div>
            </div>
            <button type="submit" name='submit_button'>Register</button>
    </form>
</body>

</html>