<?php
$adm_ame=$_POST['adm_nam'];                                
$dlt_data = $Connection->prepare('DELETE FROM Admin WHERE email=:cat_nam');
$dlt_crit = [
    ':cat_nam' =>  $adm_ame
];
$dlt_data->execute($dlt_crit);

?>