<?php
//include_once("controller/categoryController.php");
include_once("./includes/session.php");
include_once("./includes/config.php");
if($_REQUEST["action"]=='populate_subcat')
{
    //echo "select * from `webshop_state` WHERE id='".$_REQUEST['id']."'";
    $result="<option value=''>Choose State</option>";
    $sql=mysqli_query($con,"select * from `webshop_state` WHERE country_id='".$_REQUEST['id']."'");
    while($row=mysqli_fetch_assoc($sql))
    {
        $result.="<option value=".$row['id'].">".$row["name"]."</option>";
    }
    echo $result;
    
        
    
}




if($_REQUEST["action"]=='populate_subcity')
{    
    $result="<option value=''>Choose City</option>";
    $sql=mysqli_query($con,"select * from `webshop_city` WHERE state_id='".$_REQUEST['id']."'");
    while($row=mysqli_fetch_assoc($sql))
    {
        $result.="<option value=".$row['id'].">".$row["name"]."</option>";
    }
    echo $result;
    
        
    
}





?>
