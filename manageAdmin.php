<?php
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="ad_min">
        <form action="manageAdmin.php" method="POST">
            <table class="t_ble">
                <h1>ADMIN</h1><br>
                <tr class="ro_s">
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>Edit</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        foreach (show_fr_Data($Connection, "Admin") as $rw_a) {
                            echo "<tr>";
                            echo "<td>" . $rw_a['name'] . "</td>";
                            echo "<td>" . $rw_a['email'] . "</td>";
                            echo "<td>
                                        <form method='post'>
                                            <input type='hidden' name='adm_nam' value='" . $rw_a['email'] . "'>
                                            <button type='submit' name='edt_t' value='" . $rw_a['email'] . "'>Edit</button>                                        
                                            <button type='submit' name='del_t' value='" . $rw_a['email'] . "'>Delete</button>
                                        </form>
                                    </td>";
                            echo "</tr>";
                        }
                        if (isset($_POST['del_t'])) {
                            if(isset($_POST['adm_nam'])){
                                $adm_ame=$_POST['adm_nam'];                                  
                                require 'deleteAdmin.php';
                                echo "<script type='text/javascript'>window.location='manageAdmin.php';</script>";
                                exit;                            
                            }  
                        }
                        if (isset($_POST['edt_t'])) {
                            if(isset($_POST['adm_nam'])){
                                $em_li=$_POST['adm_nam'];
                                $_SESSION['adm_edt']=$em_li;    
                                echo "<script type='text/javascript'>window.location='editAdmin.php';</script>";
                                exit;            
                            }  
                              
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </form>
        <div class="aad_new">
            <a href="adminRegister.php">ADD NEW ADMIN</a>
            
        </div>
    </div>
</body>

</html>