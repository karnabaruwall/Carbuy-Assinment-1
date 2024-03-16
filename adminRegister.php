<?php
require 'header.php';
require 'datacon.php';
$n_mber = $pa_sword = $con_password = $e_ail = $n_me = "";
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
        $dat_a=$connection->prepare('SELECT * FROM admin WHERE email=:ema_li');
        $usr_criter_ia=[
            ':ema_li'=>$e_ail
        ];
        $dat_a->execute($usr_criter_ia);
        $res_t=$dat_a->fetch();
        if ($res_t!=0){
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
    if (isset($_POST['Pnum_er'])) {
        $n_mber = $_POST["Pnum_er"];
    }
    
    if($n_mber!=-8 && $pa_sword!=-8 && $e_ail!=-8 && $n_me!=-8 && $con_password!=-8){
        $valueiinsert=$Connection->prepare('INSERT INTO admin(email,name,phone_number,password)VALUES(:emai,:names,:numbr,:passw)');
        $user_criteri_a=[
            ':emai'=>$e_ail,
            ':names'=>$n_me,
            ':numbr'=>$n_mber,
            // ':passw'=>$pa_sword,
            ':passw'=>$has_passw_d,
            
        ];
        $valueiinsert->execute($user_criteri_a);
        // header('loaction: login.php');
        echo "<script>window.location.href = 'login.php';</script>";
        
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
    <form action="adminRegister.php" method="POST">
        <div class="sig_bod">
            <div class="sig_hed">
                <h1>Admin Register</h1>
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
                </div>
                <div class="rit">
                    <li>
                        <label for="number">Number</label><br>
                        <input type="number" name="Pnum_er"><br>
                    </li>
                    

                </div>
            </div>
            <button type="submit" name='submit_button'>Register</button>
    </form>
</body>

</html>