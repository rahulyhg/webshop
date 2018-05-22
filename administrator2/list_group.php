<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
	$item_id=$_GET['cid'];
	mysqli_query($con,"delete from  webshop_group where id='".$item_id."'");
	//$_SESSION['msg']=message('deleted successfully',1);
	header('Location:list_group.php');
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


       
       
	
       
       
       echo $addQuery = "INSERT INTO `webshop_group` (`" . implode('`,`', array_keys($fields)) . "`)"
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






           header("location:list_group.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_group.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
		$editQuery = "UPDATE `webshop_group` SET " . implode(', ', $fieldsList)
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



            header("location:list_group.php");
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
            mysqli_query($con,"DELETE FROM `webshop_group` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Users have been deleted successfully.';
        
        //die();
        
        header("Location:list_group.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_group` WHERE `id`='".mysqli_real_escape_string($con,$_REQUEST['id'])."'"));

}

?>









<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_group.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_group.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_group.php?cid="+aa+"&action=active";
   } 

   </script>
 <!-- Header Start -->
<?php include ("includes/header.php"); ?>
<!-- Header End -->
 <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->

    <?php include("includes/left_sidebar.php"); ?>

      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                   <!-- BEGIN THEME CUSTOMIZER-->
                   <div id="theme-change" class="hidden-phone">
                       <i class="icon-cogs"></i>
                        <span class="settings">
                            <span class="text">Theme Color:</span>
                            <span class="colors">
                                <span class="color-default" data-style="default"></span>
                                <span class="color-green" data-style="green"></span>
                                <span class="color-gray" data-style="gray"></span>
                                <span class="color-purple" data-style="purple"></span>
                                <span class="color-red" data-style="red"></span>
                            </span>
                        </span>
                   </div>
                   <!-- END THEME CUSTOMIZER-->
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                   <h3 class="page-title">Group list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Group list</a>
                        
                       </li>
                        
                       
                     
                       

                       
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                             
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->
                              <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                     <thead>
                            <tr>
                                                            <!--<td>#</td>-->
                                                            <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
                <th>Image</th>
                <th>Group Name</th>                
                <th>Group Description</th>
                
                <!--<th>Featured for Home</th>
                <th>Featured for Group</th>
                <th>Discover Group for Group </th>-->
                
                               
                <th>Quick Links</th>
                <!--<th>Edit</th>-->
                <th>Delete</th>
              </tr>
            </thead>
        <tbody>
                            <?php
                                                        $fetch_product=mysqli_query($con,"select * from webshop_group");
                                                        $num=mysqli_num_rows($fetch_product);
                                                        if($num>0)
                                                        {
                                                        while($product=mysqli_fetch_array($fetch_product))
                                                        {
                                                            //echo "aA".$product['img'];
    //$fetch_store=mysqli_fetch_array(mysqli_query($con,"select * from `webshop_group` "));
    //$image=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_group`"));
    if($product['img']!='')
    {
    $image_link='../upload/group/'.$product['img'];
    }
    else {
    $image_link='../upload/no.png';
    }

                                                        ?>
              
              <tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $product['id'] ; ?>"/></td>-->
                <td>
                  <img src="<?php echo stripslashes($image_link);?>" height="70" width="70" style="border:1px solid #666666" />
                </td>
                <td>
                  <?php echo stripslashes($product['name']);?>
                </td>
                
                
                
                <td>
                  <?php echo stripslashes($product['description']); ?>
                </td>
                
                
                
                <!--<td>
                    <?php echo stripslashes($product['feature_home']); ?>
                </td>
                
                <td>
                    <?php echo stripslashes($product['feature_group']); ?>
                </td>
                
                <td>
                    <?php echo stripslashes($product['discover_group']); ?>
                </td>-->
                
                
                
                
                
                
                <td>
                  <a  href="add_group.php?id=<?php echo $product['id'] ?>&action=edit">
                  Edit </a>
                </td>
                
                
                
                <!--<td>
                  <a  href="add_product.php?id=<?php echo $product['id'] ?>&action=edit">
                  Edit </a>
                </td>-->
                <td>
                  <a onClick="javascript:del('<?php echo $product['id']; ?>')">
                  Delete </a>
                </td>
              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="4">Sorry, no record found.</td>
                  </tr>
                                                        
                                                        <?php
                                                        }
                                                       ?>

                                     </tbody>
                                 </table>
                                  <?php if ($innerPrivileges->listproductcat_delete == '1') { ?>
                                <!--<input type="submit" class="btn btn-danger" name="bulk_delete_submit" value="Delete"/>-->
                            <?php } ?>
                             </form>

                            <!-- END Table-->
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                   
                </div>
            </div>

            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->

   <!-- Footer Start -->

   <?php include("includes/footer.php"); ?>

   <!-- Footer End -->

    <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="js/jquery-1.8.3.min.js"></script>
   <!--<script src="js/jquery.nicescroll.js" type="text/javascript"></script>-->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="js/jquery.blockui.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="js/excanvas.js"></script>
   <script src="js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="js/editable-table.js"></script>

   <!-- END JAVASCRIPTS -->
   <script>
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
</body>
<!-- END BODY -->
</html>
