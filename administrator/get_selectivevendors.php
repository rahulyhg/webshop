<?php
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url = basename(__FILE__) . "?" . (isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : 'cc=cc');
?>
<?php

if (!empty($_POST['language'])) {
     if($_POST['language'] != 'all'){
       $query = mysqli_query($con, "SELECT * FROM webshop_user WHERE  language_preference IN('All','" . $_POST['language'] . "') and type = 2");  
     
     }
     else if($_POST['language'] == 'all'){
        $query = mysqli_query($con, "SELECT * FROM webshop_user  WHERE email_verified=1 and type = 2 and language_preference !=''");   
     }
    
    
    ?>
    <!-- <option value="">Select SubCategory</option> -->
    <?php
    while ($selected_vendors = mysqli_fetch_array($query)) {
        ?>
        <option value="<?php echo $selected_vendors['email']; ?>"><?php echo $selected_vendors['email']; ?></option>
        <?php
        //print_r($subcat);
    }
}
?>