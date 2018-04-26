<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from  webshop_property where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_property.php');
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


       
       
  
       
       
       echo $addQuery = "INSERT INTO `webshop_property` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
           header("location:list_property.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `webshop_property` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_property.php");
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
            mysqli_query($con,"DELETE FROM `webshop_property` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Property Type have been deleted successfully.';
        
        //die();
        
        header("Location:list_property.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_property` WHERE `status`='1'"));

}

?>


<?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from webshop_property WHERE `status`='1' order by id desc";
   
    
		

   $query=mysqli_query($con,$sql);

  $output='';

    $output .='PropertyId,Name,Description,Price,Property Type,Amenities';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            
            $det = mysqli_query($con,"SELECT * FROM `webshop_amenities` where `id` IN($result[amenities])");

            while($more=mysqli_fetch_array($det))
               {

           $new_name[]=$more['name'];


             }
           $amenities_name=implode(',',$new_name);
           
           $property_type_details = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_property_type` WHERE `id`='".mysqli_real_escape_string($con,$result['property_type'])."'"));
      
			 
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



    $filename = "PropertyList".time().".csv";

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
        location.href="list_property.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_property.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_property.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Property  list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Property  list</a>
                        
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
                                                                <button type="submit"   name="ExportCsv"> Download Property List</button>
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
                                                            
                <!-- <th>Property  Name</th> -->
                <!--<th>User Password</th>-->
                <!-- <th>Landlord Email</th> -->
                
                               
                <th>Property Type</th>
                 <!-- <th>Price</th> -->
                <th>Image</th>
                <th>Details</th>
               <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
        <tbody>
                            <?php
                                                        $fetch_property_type=mysqli_query($con,"select * from webshop_property WHERE `status`='1'");
                                                        $num=mysqli_num_rows($fetch_property_type);
                                                        if($num>0)
                                                        {
                                                        while($property_type=mysqli_fetch_array($fetch_property_type))
                                                        {
                                                            
                                                            
$property_typee = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_property_type` WHERE `id`='".$property_type['property_type']."'"));
                                                           
    if($property_type['image']!='')
    {
    $image_link='../upload/property/'.$product['image'];
    }
    else {
    $image_link='../upload/no.png';
    }

                                                        ?>
              
              <tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $product['id'] ; ?>"/></td>-->
                
                
                
               <!--  <td>
                  <?php echo stripslashes($property_type['name']);?>
                </td> -->
                
                
                
               <td>
                   <?php echo stripslashes($property_typee['name']);?>
                </td>
                
               <!--  <td>
                 $<?php echo stripslashes($property_type['price']);?>
                </td> -->
                
                <td>
                 <img src="../upload/property/<?php echo $property_type['image'];?>" height="100" width="100" align="image">
                </td> 
                
                
                <td>

                    <a  href="details_property.php?id=<?php echo $property_type['id'] ?>&action=details">Details</a>

                </td>
                
                
                
                <td>
                  <a  href="add_property.php?id=<?php echo $property_type['id'] ?>&action=edit">
                  Edit </a>
                </td>
                
                
                
                <!--<td>
                  <a  href="add_new_admin.php?id=<?php echo $product['id'] ?>&action=edit">
                  Edit </a>
                </td>-->
                <td>
                  <a onClick="javascript:del('<?php echo $property_type['id']; ?>')">
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
