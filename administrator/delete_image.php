
<?php 
$product_id = isset($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';

 //$product_id = $_REQUEST['cid'];
    echo $product_id;
    exit;
     mysqli_query($con, " DELETE FROM webshop_product_image WHERE id ='" . $product_id . "'");
    header('Location:add_auction.php');
?>


