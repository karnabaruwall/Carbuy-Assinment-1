<?php
// $res_t = trf_em($Connection, "category", "category_id", "category_name", "cat_name");
// // $res_t = em_func_t_chec($Connection, "category", "category_name", "cat_name");
$category_name=$_POST['ca_name'];                                  
$dlt_data = $connection->prepare('DELETE FROM category WHERE category_name=:cat_nam');
$dlt_crit = [
    ':cat_nam' =>  $category_name
];
$dlt_data->execute($dlt_crit);
?>