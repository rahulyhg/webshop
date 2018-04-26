<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_category where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_category.php');
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


       
       
  
       
       
       echo $addQuery = "INSERT INTO `webshop_category` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
           header("location:list_category.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `webshop_category` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_category.php");
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
            mysqli_query($con,"DELETE FROM `webshop_category` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Category have been deleted successfully.';
        
        //die();
        
        header("Location:list_category.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_category` WHERE `status`='1'"));

}

?>


<!-- <?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from insulationez_category WHERE `status`='1' order by id desc";
   
    
		

   $query=mysqli_query($con,$sql);

  $output='';

    $output .='ToolsId,Name,Description,Price,Tools Type';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            
           //  $det = mysqli_query($con,"SELECT * FROM `insulationez_amenities` where `id` IN($result[amenities])");

           //  while($more=mysqli_fetch_array($det))
           //     {

           // $new_name[]=$more['name'];


           //   }
           // $amenities_name=implode(',',$new_name);
           
           $tools_type_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `insulationez_category` WHERE `id`='".mysqli_real_escape_string($con,$result['property_type'])."'"));
      
			 
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
 -->






<script language="javascript">

	function trend(aa)
   {
      
        location.href="list_category.php?cid="+ aa +"&action=trend"
   } 

   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_category.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_category.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_category.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Category  list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Category list</a>
                        
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
                          
                             <form action="" method="post">
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
                              <form name="bulk_action_form" action="" method="post" onsubmit="return deleteConfirm();"/>
                          <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                     <thead>
                            <tr>
             <!--     <th> Trending </th>                  -->                          
                <th> Name </th>
                <th>Image</th>          
               <th>Quick Links</th>
               <!--  <th>View Products</th> -->
                 <th>Status</th> 
            </thead>
        <tbody>
                            <?php

if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_category set status='0' where id='".$item_id."'");
         header('Location:list_category.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_category set status='1' where id='".$item_id."'");
         header('Location:list_category.php');
  exit();
}
                                                        $fetch_tools_type=mysqli_query($con,"select * from webshop_category where status = 1");
                                                        $num=mysqli_num_rows($fetch_tools_type);
                                                        if($num>0)
                                                        {
                                                        while($tools_type=mysqli_fetch_array($fetch_tools_type))
                                                        {
                                                            
                                                           
    if($tools_type['image']!='')
    {
    $image_link='../upload/category_image/'.$tools_type['image'];
    }
    else {
    $image_link='../upload/no.png';
    }
                                                        ?>
              
              <tr>
                                                     
                <!--  <td>
                  <?php if($tools_type['is_trending']=='1'){?>
                    <input type="checkbox" checked onClick="javascript:inactive('<?php echo $tools_type['id'] ?>');"><br><br>
    <input type="number" id="ordernumber" value="<?php echo $tools_type['order_numbering']?>"onblur="saveorder(this.value,'<?php echo $tools_type['id']?>')">
                    <?php } else {?>
                    <input type="checkbox" onClick="javascript:active('<?php echo $tools_type['id'] ?>');">
                  <?php }?>
                </td> -->
                
               <td>
              
                   <?php echo stripslashes($tools_type['name']);?>
                </td>
                
                <td>
                 <img src="../upload/category_image/<?php echo $tools_type['image'];?>" height="100" width="100" align="image">
                </td> 
                
                <td>
                  <a  href="add_category.php?id=<?php echo $tools_type['id'] ?>&action=edit">
                  <i class="icon-edit"></i></a>
                  <a onClick="javascript:del('<?php echo $tools_type['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td> 

           <td>
                  <?php if($tools_type['status']=='1'){?>
                    <a  onClick="javascript:inactive('<?php echo $tools_type['id'] ?>');">Deactivate</a>
                    <?php } else {?>
                    <a  onClick="javascript:active('<?php echo $tools_type['id'] ?>');">Activate</a>
                  <?php }?>
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
   <?php if ($num >0) {?>
   <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
   <?php } ?>
   <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
   <script src="js/jquery.scrollTo.min.js"></script>


   <!--common script for all pages-->
   <script src="js/common-scripts.js"></script>

   <!--script for this page only-->
   <script src="js/editable-table.js"></script>

   <!-- END JAVASCRIPTS -->
   <?php
    if($num>0)
    {
   ?>
   <script>
       jQuery(document).ready(function() {
           EditableTable.init();
       });
   </script>
   <?php
    }
   ?>
 <script>
 function saveorder(val1,val2){
  //alert("ppp"+val1);
  //alert("xxx"+val2);
  $.ajax({
  type: "POST",
  url: "save_ordering.php",
  data: 'order_numbering='+val1+'&category_id='+val2,
  // success: function(data){
  // 	if(data.datavalue == 0){
  // 		alert("Please enter another order number");
  // 	}
  //  }
  });

}

 </script>
</body>
<!-- END BODY -->
</html>
