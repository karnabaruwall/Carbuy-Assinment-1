<?php
require 'header.php';
$edtt = $id_c = $ra_d = $rw_a = $id_ces="";

if (isset($_POST['ed_t'])) {

    // $edtt = $_POST['ed_t'];

    $edt_data = $connection->prepare('UPDATE  category SET category_name = :ne_name where category_id=:id_s');
    $edt_crit = array(
        ':ne_name' => $edtt,
        ':id_s' => $id_c
    );
    $edt_data->execute($edt_crit);
}




//generate unique number
do {
    $ra_d = rand(100, 1000);
    $res_t = Cate_ceck($connection, $ra_d);
} while ($res_t == -1);

if (isset($_POST['ad_sub'])) {
    if (isset($_POST['ad_d'])) {
        $add_data = $connection->prepare('INSERT INTO category(category_id,category_name)VALUES(:id_s,:nam_s)');
        $us_crt = [
            ':id_s' => $ra_d,
            ':nam_s' => $_POST['ad_d']
        ];
        $add_data->execute($us_crt);
        echo "<script type='text/javascript'>window.location='categories.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cate.css">
</head>

<body>
    <main>
        <form action="categories.php" method="POST">
            <table class="t_ble">
                <h1>Categories</h1>
                <tr class="ro_s">
                    <th>Categories</th>
                    <th>Edit</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        //calling function to display all the category
                        // foreach (show_Cat_Data($Connection) as $rw_a) {
                        //     echo "<tr>";
                        //     echo "<td name=" . $rw_a['category_name'] . ">" . $rw_a['category_name'] . "</td>";
                        //     echo "<form method='post'>
                        //     <input type='hidden' name='cat_name' value='" . $rw_a['category_name'] . "'>
                        //     <button type='submit' name='edit_submit' value='" . $rw_a['category_name'] . "'>Edit</button>
                        //     <button type='submit' name='del_t' value='" . $rw_a['category_name'] . "'>Delete</button>
                        
                        //      </td>;
                        //     </form>";
                        // }
                        foreach (show_Cat_Data($connection) as $rw_a) {
                            echo "<tr>";
                            echo "<td>" . $rw_a['category_name'] . "</td>";
                            echo "<td>
                                    <form method='POST'>
                                        <input type='hidden' name='ca_name' value='" . $rw_a['category_name'] . "'>
                                        <button type='submit' name='ed_st' value='" . $rw_a['category_name'] . "'>Edit</button>                                        
                                        <button type='submit' name='del_t' value='" . $rw_a['category_name'] . "'>Delete</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        // if (isset($_POST['delete_submit'])) {
                        //     // if the button is clicked 
                        //     // if(isset($_POST['cat_name'])) {
                        //     //     //deleteCategory.php is called
                        //     //     //delete category code 
                        
                        //     //     //reload the same page
                        //     //     echo "<script type='text/javascript'>window.location='adminCategories.php';</script>";
                        //     //     exit;
                        //     // }
                        //     echo 'D';
                        // }
                        if (isset($_POST['del_t'])) {
                            if(isset($_POST['ca_name'])){
                              require 'deleteCat.php';
                              echo "<script type='text/javascript'>window.location='categories.php';</script>";
                              exit;
                                
                            }  
                        }
                        if (isset($_POST['ed_st'])) {
                            // // if the button is clicked the value will be stored
                            if(isset($_POST['ca_name'])){
                                echo 'E';
                                echo $_POST['ca_name'];   
                                echo "<script type='text/javascript'>window.location='editCategory.php';</script>";
                                exit;
                            }
                        }
                        ?>

                    </td>
                </tr>
            </table>
            <div class="ad_cat">
                <label for="new">ADD NEW CATEGORY</label>
                <input type="text" name="ad_d">
                <input type="submit" name="ad_sub">
            </div>
        </form>
    </main>
</body>

</html>