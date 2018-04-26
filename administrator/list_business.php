<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from webshop_companies where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:list_business.php');
  exit();
}



if (isset($_REQUEST['submit'])) {


    $cname = isset($_POST['name']) ? $_POST['name'] : '';
   //  $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
   //   $address = isset($_POST['address']) ? $_POST['address'] : '';
   //   $email = isset($_POST['email']) ? $_POST['email'] : '';
   //   $city = isset($_POST['city']) ? $_POST['city'] : '';
   // $pass = isset($_POST['password']) ? $_POST['password'] : '';
   // $password = md5($pass);
   $add_date = date('Y-m-d');

    $fields = array(
    'name' => mysqli_real_escape_string($con,$cname),
    'add_date' => mysqli_real_escape_string($con,$add_date)
    // 'lname' => mysqli_real_escape_string($con,$lname),
    // 'address' => mysqli_real_escape_string($con,$address),
    // 'email' => mysqli_real_escape_string($con,$email),
    // 'city' => mysqli_real_escape_string($con,$city),
    // 'password' => mysqli_real_escape_string($con,$password),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
  
       
       
       echo $addQuery = "INSERT INTO `hiretools_rent_user` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
           header("location:list_provider.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `hiretools_rent_user` SET " . implode(', ', $fieldsList)
      . " WHERE `id` = '" . mysqli_real_escape_string($con,$last_id) . "'";


        $res = mysqli_query($con,$editQuery);
        if ($res) {

                   
          
            }



            header("location:list_admin.php");
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
            mysqli_query($con,"DELETE FROM `hiretools_rent_user` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'Rent User have been deleted successfully.';
        
        //die();
        
        header("Location:list_provider.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_companies`"));

}

?>
<!-- <?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from gym_users WHERE `user_type`='3' order by id desc";
   
    
    

   $query=mysqli_query($con,$sql);

  $output='';

    $output .='UserId,First Name,Last Name,City,Address,Email,Contact Number,Status';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            
            if($result['status']==1)
            {
                $status='Active';
            }
            else
            {
                 $status='Deactive';
            }
      
       
             $user_id=$result['id'];
             $first_name=$result['fname'];
               $last_name=$result['lname'];
               $city=$result['city'];
               $address=$result['address'];
                  $email=$result['email'];
                     $contact_number=$result['phone'];
               
          
           if($user_id!=""){
            $output .='"'.$user_id.'","'.$first_name.'","'. $last_name.'","'.$city.'","'.$address.'","'.$email.'","'.$contact_number.'","'.$status.'"';
            $output .="\n";
            }
        }
    }



    $filename = "RentUserList".time().".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename='.$filename);



    echo $output;

    //echo'<pre>';

    //print_r($result);

    exit;
  
  
}
?> -->









<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_business.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_business.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_business.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Business list</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Business list</a>
                        
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
                        <h4><i class="icon-reorder"></i>List Business </h4>
                              <form action="" method="post">
                <!--<i class="fa fa-edit"></i>Editable Table-->
                                <!--  <button type="submit"   name="ExportCsv"> Download Rent User List</button> -->
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
                                  <th>Image</th>
                                                            
                <th>Name</th>
                <th> Workers List </th>
               <!--  <th>Provider Details</th> -->
          <!--        <th>View Bookings</th>       -->

                <th>Quick Links</th>
            <!--     <th>Status</th> -->
              </tr>
            </thead>
        <tbody>
                            <?php

        if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_companies set status='0' where id='".$item_id."'");
         header('Location:list_business.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_companies set status='1' where id='".$item_id."'");
         header('Location:list_business.php');
  exit();
}
                                                        $fetch_landlord=mysqli_query($con,"select * from webshop_companies order by id desc");
                                                        $num=mysqli_num_rows($fetch_landlord);
                                                        if($num>0)
                                                        {
                                                        while($landlord=mysqli_fetch_array($fetch_landlord))
                                                        {
                                                           
    if($landlord['image']!='')
    {
    $image_link='../upload/companies_image/'.$landlord['image'];
    }
    else {
    $image_link='../upload/companies_image/nouser.jpg';
    }

                                                        ?>
              
              <tr>
                                                          
                  <td>
                 <img src="<?php echo $image_link;?>" height="100" width="100" align="image">
                </td>
                
                
                
            <td>
                  <?php echo stripslashes($landlord['name']);?>
                </td> 

                   <td>
                  <a  href="listWorkers.php?id=<?php echo $landlord['id'] ?>&action=details">
                  <i class="icon-list-ol"></i></a>
                </td> 
                
         <!--      <td>
                  <a  href="view_providerdetails.php?id=<?php echo $landlord['id'] ?>&action=details">
                  Details</a>|
                   <a  href="view_reviews.php?id=<?php echo $landlord['id'] ?>&action=details">
                  Reviews</a>
                  </td> -->

              <!--    <td>
                  <a  href="view_Provider.php?id=<?php echo $landlord['id'] ?>&action=details">
                  View  Details</a><br><br>
                  <a  href="view_reviews.php?id=<?php echo $landlord['id'] ?>&action=details">
                  View  Reviews</a>
                </td>
  

                <td>
                  <a  href="listOwnerBookings.php?id=<?php echo $landlord['id'] ?>&action=details">
                  View  Bookings</a>
                </td> -->

                <td>
                  <a  href="add_business.php?id=<?php echo $landlord['id'] ?>&action=edit">
                  <i class="icon-edit"></i></a>
                  <a onClick="javascript:del('<?php echo $landlord['id']; ?>')">
                  <i class="icon-trash"></i></a>
                </td>

                <!--  <td>
                  <?php if($landlord['status']=='0'){?>
                    <a  onClick="javascript:active('<?php echo $landlord['id'];?>');">Click to Activate</a>
                    <?php } else {?>
                    <a  onClick="javascript:inactive('<?php echo $landlord['id'];?>');">Click to deactivate</a>
                  <?php }?>
                </td> -->
              </tr>
                                                       <?php
                                                        }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                        <tr>
                    <td colspan="6">Sorry, no record found.</td>
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
