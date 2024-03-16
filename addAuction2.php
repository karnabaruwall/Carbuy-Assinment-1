<?php
require 'header.php';
$au_des = $au_dt = $cu_bid = $auc_nm = $au_img = $cat_img = '';
$au_der = $au_dter = $cu_bider = $auc_nmer = $au_img = "";
$upErr = ""; // Initialize $upErr to an empty string
if (isset($_POST['sub_it'])) {
    if (empty($_POST['au_nam'])) {
        $auc_nm = -9;
        $auc_nmer = 'Name REQUIRED';
    } else {
        $auc_nm = $_POST['au_nam'];

    }
    if (isset($_FILES['im_g'])) {
        $diretoupload = "img_Auction/";
        $t_name = $_FILES['im_g']['tmp_name'];
        $per_name = $_FILES['im_g']['name'];
        $file_type = $_FILES['im_g']['type'];
        if ($file_type != "image/png" && $file_type != "image/jpeg" && $file_type != "image/jpg" && $file_type != "image/avif") {
            $upErr = "Only PNG, JPG, and JPEG files are allowed.";
            $cat_img =-9;
        }else{
            if (move_uploaded_file($t_name, $diretoupload . $per_name)) {
                $cat_img = $per_name;
                //echo $cat_img;
            } else {
                echo 'File upload failed';
            }
        }        

    } else {
        $au_img = -9;
    }
    if (isset($_POST['au_cat'])) {
        $au_car = $_POST['au_cat'];
        echo $au_car;
        $cat_id = trans_cat($connection, $au_car);
    }
    if (empty($_POST['crt_bid'])) {
        $cu_bid = -9;
        $cu_bider = 'Bid REQUIRED';
    } else {
        $cu_bid = $_POST['crt_bid'];
    }
    if (empty($_POST['tx_tar'])) {
        $au_des = -9;
        $au_der = ' desc REQUIRED';
    } else {
        $au_des = $_POST['tx_tar'];
    }
    if (empty($_POST['da_te'])) {
        $au_dter = -9;
        $au_dter = 'REQUIRED';
    } else {
        $au_dt = $_POST['da_te'];
    }
    if ($auc_nm != -9 && $cu_bid != -9 && $au_des != -9 && $au_dt != -9 && $cat_img !=-9) {
        // echo'okay';
        $dat_au = $connection->prepare('INSERT INTO auction(name, category_id, image, price, date, description, email) VALUES(:nam, :categ, :igm, :prc, :dte, :decs, :emali)');
        $au_criteria = [
            ':nam' => $auc_nm,
            ':categ' => $cat_id,
            ':prc' => $cu_bid,
            ':decs' => $au_des,
            ':dte' => $au_dt,
            ':igm' => $cat_img,
           ':emali'=>$u_led

        ];

        $dat_au->execute($au_criteria);

    } else {
        echo 'wrong';
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
    <main class="aut_man">
        <div class="act_bdy">
            <div class="act_hd">
                <h1>Auction</h1>
            </div>
            <form action="addAuction2.php" method="POST" enctype="multipart/form-data">
                <label for="name">Name</label>
                <input type="text" name='au_nam'>
                <span class="error">
                    <?php echo $auc_nmer; ?>
                </span>
                <label for="categoryselection">Select Category</label>
                <select name="au_cat">
                    <?php
                    foreach (show_Catego_Data($connection) as $value) {
                        echo '<option value="' . $value['category_name'] . '">' . $value['category_name'] . '</option>';
                    }
                    ?>
                </select>

                <div>
                    <label for="img">Select Image</label>
                    <input type="file" name="im_g">
                    <span>
                        <?php echo $upErr?>
                    </span>

                </div>
                <div>
                    <label for="pri_e">Current Bid</label>
                    <input type="text" name="crt_bid"><br>
                    <span class="error">
                        <?php echo $cu_bider; ?>
                    </span>

                </div>
                <div>
                    <label for="description">Description</label>
                    <span class="error">
                        <?php echo $au_der; ?>
                    </span>
                    <textarea name="tx_tar" cols="5" rows="5"></textarea>

                </div>
                <div>
                    <label for="date">End date of bid</label>
                    <span class="error">
                        <?php echo $au_dter; ?>
                    </span>
                    <input type="date" name="da_te">

                </div>
                <input type="submit" name="sub_it">
            </form>
        </div>
    </main>
</body>

</html>