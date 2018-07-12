<?php 
header('Content-Type: text/html; charset=utf-8');

include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_products where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_products.php');
  exit();
}



if (isset($_REQUEST['submit'])) {


   $name = isset($_POST['name']) ? $_POST['name'] : '';
  

    $fields = array(
        'name' => mysqli_real_escape_string($con,$name),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
  
       
       
       echo $addQuery = "INSERT INTO `webshop_products` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
            
             header("location:list_products.php");
           //header("location:list_tools.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `webshop_products` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_products.php");
            $_SESSION['MSG'] = 1;
            exit();
        } else {
           header("location:add_new_admin.php?id=" . $last_id . "&action=edit");
            $_SESSION['MSG'] = 2;
            exit();
        }
        
         
    }
    

/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
             //echo "UPDATE `makeoffer_product` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM `webshop_products` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Tools Type have been deleted successfully.';
        
        //die();
        
        header("Location:list_products.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_products` WHERE `status`='1'"));

}

?>


<?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from hiretools_tools WHERE `status`='1' order by id desc";
   
    
		

   $query=mysqli_query($con,$sql);

  $output='';

    $output .='ToolsId,Name,Description,Price,Tools Type';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            
           //  $det = mysqli_query($con,"SELECT * FROM `hiretools_amenities` where `id` IN($result[amenities])");

           //  while($more=mysqli_fetch_array($det))
           //     {

           // $new_name[]=$more['name'];


           //   }
           // $amenities_name=implode(',',$new_name);
           
           $tools_type_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `hiretools_property_type` WHERE `id`='".mysqli_real_escape_string($con,$result['property_type'])."'"));
      
			 
             $property_id=$result['id'];
             $name=$result['name'];
               $description=$result['description'];
               $price=$result['price'];
               $amenities=$amenities_name;
                  $property_type=$property_type_details['name'];
                  
               
          
           if($property_id!=""){
            $output .='"'.$property_id.'","'.$name.'","'. $description.'","'.$price.'","'.$property_type.'","'.$amenities.'"';
            $output .="\n";
            }
        }
    }



    $filename = "ToolsList".time().".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename='.$filename);



    echo $output;

    //echo'<pre>';

    //print_r($result);

    exit;
	
	
}
?>







<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_products.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_products.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_products.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Products  list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Products  list</a>
                        
                       </li>
                        
                       
                     
                       

                       
                       
                   </ul>
                   <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN SAMPLE FORMPORTLET-->
                    <div class="widget green">
                        <div class="widget-title">
                        <h4><i class="icon-reorder"></i>List Products</h4>
                             <form action="" method="post" >
								<!--<i class="fa fa-edit"></i>Editable Table-->
                                                               <!--  <button type="submit"   name="ExportCsv"> Download Tools List</button> -->
                                                            </form>
                             
                            <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                            </span>
                        </div>
                        <div class="widget-body">
                            <!-- BEGIN Table-->

                             <!--   <div class="control-group">
                                    <label class="control-label">Search by Product Name</label>
                                    <div class="controls">
                                   <input type="text" class="form-control" placeholder="Enter product name"  name="product_name" onkeyup="getProductName(this.value);">
                                    </div>
                                </div> -->
                                	<input type="text" id="search" placeholder="search by name"></input>

                              <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                     <thead>
                	<tr>
                 <th>Slno</th>            
                 <th>Image</th>           
                 <th>Brand</th>
                 <th>Price</th>
                 <th>Category</th>
                 <!--<th>Sub Category</th>-->
                 <th>Uploader Name</th>
                 <th>Quick Links</th> 
              </tr>
            </thead>
        <tbody>
                            <?php

    if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_products set admin_approval='0' where id='".$item_id."'");
         header('Location:list_products.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_products set admin_approval='1' where id='".$item_id."'");
         header('Location:list_products.php');
  exit();
}

// print_r($_SESSION['filtered_ids']);

                                                 
                                                        $fetch_tools_type=mysqli_query($con,"select *,@a:=@a+1 serial_number from webshop_products,(SELECT @a:= 0) AS a where type=1");
                                                        $num=mysqli_num_rows($fetch_tools_type);
                                                        if($num>0)
                                                        {
                                                        while($tools_type=mysqli_fetch_array($fetch_tools_type))
                                                        {
                                                            

                                                            
$category = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_category` WHERE `id`='".$tools_type['cat_id']."'"));

$subcategory = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_subcategory` WHERE `id`='".$tools_type['subcat_id']."'"));

$brands_name = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `webshop_brands` WHERE `id`='" . $tools_type['brands'] . "'"));


$currency = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_currency` WHERE `code`='".$tools_type['currency_code']."'"));

$uploader = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_user` WHERE `id`='".$tools_type['uploader_id']."'"));
                                                           
    if($tools_type['image']!='')
    {
    $image_link='../upload/product_image/'.$tools_type['image'];
    }
    else {
    $image_link='../upload/no.jpg';
    }

                                                        ?>
              
              <tr>
                  
                   <td>
                   <?php echo stripslashes($tools_type['serial_number']);?>
                </td> 
               
                <td>
                 <img src="<?php echo $image_link;?>" height="100" width="100" align="image">
                </td>

               <td>
                   <?php echo stripslashes($brands_name['name']);?>
                </td>

                 <td>
                   <?php echo stripslashes("KWD ".$tools_type['price']);?>
                </td>

                <td>
                   <?php echo stripslashes($category['name']);?>
                </td>
                
<!--                 <td>
                   <?php echo stripslashes($subcategory['name']);?>
                </td>-->

                <td>
                   <?php echo stripslashes($uploader['fname']." ".$uploader['lname'] );?>
                </td>

                 <td>
                  <a  href="edit_product.php?id=<?php echo $tools_type['id'] ?>&action=edit">
                  <i class="icon-edit"></i></a> 
                  <a onClick="javascript:del('<?php echo $tools_type['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td>
                
             <!--    <td>
                 <img src="../upload/product_image/<?php echo $tools_type['image'];?>" height="100" width="100" align="image">
                </td>  -->
              
                
             <!--    <td>

                    <a  href="details_product.php?id=<?php echo $tools_type['id'] ?>&action=details"><i class="icon-eye-open"></i></a>
                  <a  href="add_product.php?id=<?php echo $tools_type['id'] ?>&action=edit">
                  <i class="icon-edit"></i></a>
                  <a onClick="javascript:del('<?php echo $tools_type['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td> -->

              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="7">Sorry, no record found.</td>
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
   <?php if ($num>0){?>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <?php } ?>
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

  var table = $('#editable-sample').DataTable();

      $('#search-date').on('change', function(){
    
    table
    .column(1)
    .search(this.value)
    .draw();

  });

       });
   </script>
   <script type="text/javascript">

    function getProductName(productname){

      var product = productname;
   	   $.ajax({
  type: "POST",
  dataType: "json",
  data: {product_name : product},
   url: "get_productsname.php",
  success: function(data){
		data1 = JSON.parse(data);
		console.log(data1.result);
  }
  });
    }

$("#search").on("keyup", function() {
    var value = $(this).val();

    $("table tr").each(function(index) {
        if (index !== 0) {

            $row = $(this);

            var id = $.map($row.find('td'), function(element) {
                return $(element).text()
            }).join(' ');

            if (id.indexOf(value) < 0) {
                $row.hide();
            } else {
                $row.show();
            }
        }
    });
});
   </script>

</body>
<!-- END BODY -->
</html>
