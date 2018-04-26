<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
//$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
if(isset($_GET['action']) && $_GET['action']=='delete')
{
  $item_id=$_GET['cid'];
  mysqli_query($con,"delete from webshop_zipcodes where id='".$item_id."'");
  //$_SESSION['msg']=message('deleted successfully',1);
  header('Location:manage_zipcode.php');
  exit();
}



if (isset($_REQUEST['submit'])) {


   $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
     $address = isset($_POST['address']) ? $_POST['address'] : '';
     $email = isset($_POST['email']) ? $_POST['email'] : '';
     $city = isset($_POST['city']) ? $_POST['city'] : '';
   $pass = isset($_POST['password']) ? $_POST['password'] : '';
   $password = md5($pass);
  

    $fields = array(
     'fname' => mysqli_real_escape_string($con,$fname),
    'lname' => mysqli_real_escape_string($con,$lname),
    'address' => mysqli_real_escape_string($con,$address),
    'email' => mysqli_real_escape_string($con,$email),
    'city' => mysqli_real_escape_string($con,$city),
    'password' => mysqli_real_escape_string($con,$password),
    );

    $fieldsList = array();
    foreach ($fields as $field => $value) {
        $fieldsList[] = '`' . $field . '`' . '=' . "'" . $value . "'";
    }

    
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    
    if ($action == 'add' || $action == '') {


       
       
  
       
       
       echo $addQuery = "INSERT INTO `hiretools_general_user` (`" . implode('`,`', array_keys($fields)) . "`)"
      . " VALUES ('" . implode("','", array_values($fields)) . "')";
         
      

        $res = mysqli_query($con,$addQuery);
        echo $last_id = mysqli_insert_id($con);
        
        
      

        if ($last_id != "" || $last_id != 0) {
        
           header("location:list_user.php");
            $_SESSION['MSG'] = 3;
            exit();
        } else {
           // header("location:list_admin.php");
            $_SESSION['MSG'] = 4;
            exit();
        }
    } else if ($action == 'edit') {

        $last_id = $_REQUEST['id'];
    $editQuery = "UPDATE `hiretools_general_user` SET " . implode(', ', $fieldsList)
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
            mysqli_query($con,"DELETE FROM `hiretools_general_user` WHERE id=".$id);
        }
        $_SESSION['success_msg'] = 'General User have been deleted successfully.';
        
        //die();
        
        header("Location:list_user.php");
    }





if($_REQUEST['action']=='edit')
{
$categoryRowset = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `webshop_zipcodes`"));

}

?>
<!-- <?php
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="select * from webshop_user WHERE `type`='1' order by id desc";
   
    
    

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



    $filename = "GeneralUserList".time().".csv";

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
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="manage_zipcode.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_user.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_user.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Manage Zipcode</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Manage Zipcode</a>
                        
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
                        <h4><i class="icon-reorder"></i>List Zipcode</h4>
                             <form action="" method="post">
                <!--<i class="fa fa-edit"></i>Editable Table-->
                                 <!-- <button type="submit"   name="ExportCsv"> Download General User List</button> -->
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
                              
                <th>ZipCode</th>
                <th>Address</th>
                <th>Quick Links</th>
              </tr>
            </thead>
        <tbody>
                            <?php

    if(isset($_GET['action']) && $_GET['action']=='inactive')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_user set status='0' where id='".$item_id."'");
         header('Location:list_user.php');
  exit();
}
if(isset($_GET['action']) && $_GET['action']=='active')
{
   $item_id=$_GET['cid'];
  mysqli_query($con,"update webshop_user set status='1' where id='".$item_id."'");
         header('Location:list_user.php');
  exit();
}
                                                        $fetch_landlord=mysqli_query($con,"select * from webshop_zipcodes");
                                                        $num=mysqli_num_rows($fetch_landlord);
                                                        if($num>0)
                                                        {
                                                        while($landlord=mysqli_fetch_array($fetch_landlord))
                                                        {
                                                           
    if($landlord['image']!='')
    {
    $image_link='../upload/user_image/'.$landlord['image'];
    }
    else {
    $image_link='../upload/user_image/nouser.jpg';
    }

                                                        ?>
              
              <tr>
                
                
                <td>
                  <?php echo stripslashes($landlord['zipcode']);?>
                </td> 

                 <td>
                  <?php echo stripslashes($landlord['address']);?>
                </td> 
                
              
                <td>
                  <a  href="add_zipcode.php?id=<?php echo $landlord['id'] ?>&action=edit">
                  Edit </a> |  
                  <a onClick="javascript:del('<?php echo $landlord['id']; ?>')">
                  Delete </a>
                </td>

              <!--    <td>
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
