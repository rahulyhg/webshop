<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  webshop_product where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_product.php');
	exit();
}



if (isset($_REQUEST['submit'])) {



	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$feature = isset($_POST['feature']) ? $_POST['feature'] : '';
	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	$subcat = isset($_POST['subcat']) ? $_POST['subcat'] : '';
	$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
	$regular_price = isset($_POST['regular_price']) ? $_POST['regular_price'] : '';
	$offer_price = isset($_POST['offer_price']) ? $_POST['offer_price'] : '';
	$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
	$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
	$store_id = isset($_POST['store_id']) ? $_POST['store_id'] : '';
	$datetime = date('Y-m-d H:i:s');
	$expiry_date_datetime = date('2024-05-31 6:30:00');
	$size = isset($_POST['size']) ? $_POST['size'] : '';
	$dbsize= implode(',' ,$size);
	$quan = isset($_POST['inventory']) ? $_POST['inventory'] : '';
	$offer_price = isset($_POST['offer_price']) ? $_POST['offer_price'] : '';

	$vendor = isset($_POST['vendor']) ? $_POST['vendor'] : '';
	$division = isset($_POST['division']) ? $_POST['division'] : '';
	$class = isset($_POST['class']) ? $_POST['class'] : '';
	$season = isset($_POST['season']) ? $_POST['season'] : '';
	$type='P';
	$product_keyword = isset($_POST['product_keyword']) ? $_POST['product_keyword'] : '';
	$product_keyword=preg_replace('/[\s]+/', ' ', $product_keyword);
	$queryCat="SELECT id,name from webshop_category where id=".$cat_id."";
	$resCat=mysqli_query($con,$queryCat);
	$dataCat=mysqli_fetch_assoc($resCat);
	// $cat_name=$dataCat['name'];
	$cat_name = str_replace($arr_remove, " ",$dataCat['name']);

	$querySubCat="SELECT id,name from webshop_subcategory where id=".$subcat."";
	$resSubCat=mysqli_query($con,$querySubCat);
	$dataSubCat=mysqli_fetch_assoc($resSubCat);
	// $sub_cat_name=$dataSubCat['name']

	$sub_cat_name = str_replace($arr_remove, " ",$dataSubCat['name']);

	$queryStore="SELECT id,store_title from webshop_store where id=".$store_id."";
	$resStore=mysqli_query($con,$queryStore);
	$dataStore=mysqli_fetch_assoc($resStore);
	$store_name = str_replace($arr_remove, " ",$dataStore['store_title']);
	// $store_name=$dataStore['name']
	$brand_name=str_replace($arr_remove, " ",trim($vendor));
	$product_name=str_replace($arr_remove, " ",trim($name));
	$product_name=preg_replace('/[\s]+/', ',', $product_name);
	$search_tag=trim($product_name).','.trim($cat_name).','.trim($sub_cat_name).','.trim($brand_name);
	$search_tag=strtolower($search_tag);
	
	
	
	    
    $fields = array(
        'name' => mysqli_real_escape_string($con,$name),
        'user_id' => mysqli_real_escape_string($con,$user_id),
        'cat_id' => mysqli_real_escape_string($con,$cat_id),
        'subcat' => mysqli_real_escape_string($con,$subcat),
        'desc' => mysqli_real_escape_string($con,$desc),
        'store_id' => mysqli_real_escape_string($con,$store_id),
        'regular_price' => mysqli_real_escape_string($con,$regular_price),
        'offer_price' => mysqli_real_escape_string($con,$offer_price),
        'start_date' => mysqli_real_escape_string($con,$start_date),
        'end_date' => mysqli_real_escape_string($con,$end_date),
        'datetime' => mysqli_real_escape_string($con,$datetime),
        'size' => mysqli_real_escape_string($con,$dbsize),
        'expiry_date' => $expiry_date_datetime,
        'inventory' => mysqli_real_escape_string($con,$quan),
        'vendor' => mysqli_real_escape_string($con,$vendor),
        'division' => mysqli_real_escape_string($con,$division),
        'class' => mysqli_real_escape_string($con,$class),
        'season' => mysqli_real_escape_string($con,$season),
        'is_feature' => mysqli_real_escape_string($con,$feature),
        'offer_price' => mysqli_real_escape_string($con,$offer_price),
        'product_type' => mysqli_real_escape_string($con,$type),
        'search_tag'=>mysqli_real_escape_string($con,$search_tag),
        'product_keyword'=>mysqli_real_escape_string($con,$product_keyword),
        
        
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
	
       
       
       echo $addQuery = "INSERT INTO `webshop_product` (`" . implode('`,`', array_keys($fields)) . "`)"
			. " VALUES ('" . implode("','", array_values($fields)) . "')";
    		 
    	

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
        
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {


 if ($_FILES['images']['tmp_name'][$i] != '') {
        $target_path = "../upload/product/";
      $userfile_name = $_FILES['images']['name'][$i];
       
        $store_logo_image = $_FILES['images']['name'][$i];
        $userfile_tmp = $_FILES['images']['tmp_name'][$i];
        $store_logo = time().$userfile_name;
        $img = $target_path .$store_logo;
        move_uploaded_file($userfile_tmp, $img);
        
           $video_link = basename($inv_video);
                $date_added = date('y-m-d h:i:s');



               $query_image = "INSERT INTO `webshop_moreimage` 
				  (pro_id,image)  
				  VALUES ('" . $last_id . "','" . $store_logo . "')";

                $res_image = mysqli_query($con,$query_image);
        
        
        
				} 



			}






           header("location:list_product.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_product.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
		$editQuery = "UPDATE `webshop_product` SET " . implode(', ', $fieldsList)
			. " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";





        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
              
       for ($i = 0; $i < count($_FILES['images']['name']); $i++) {


 if ($_FILES['images']['tmp_name'][$i] != '') {
        $target_path = "../upload/product/";
      $userfile_name = $_FILES['images']['name'][$i];
       
        $store_logo_image = $_FILES['images']['name'][$i];
        $userfile_tmp = $_FILES['images']['tmp_name'][$i];
        $store_logo = time().$userfile_name;
        $img = $target_path .$store_logo;
        move_uploaded_file($userfile_tmp, $img);
        
           $video_link = basename($inv_video);
                $date_added = date('y-m-d h:i:s');



               $query_image = "INSERT INTO `webshop_moreimage` 
				  (pro_id,image)  
				  VALUES ('" . $last_id . "','" . $store_logo . "')";

                $res_image = mysqli_query($con,$query_image);
        
        
        
				} 



			}
            }



            header("location:list_product.php");
            $_SESSION['MSG'] = 1;
            exit();
        } else {
           header("location:add_product.php?id=" . $last_id . "&action=edit");
            $_SESSION['MSG'] = 2;
            exit();
        }
        
         
    }
    

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_product` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_product.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_product` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}

?>
