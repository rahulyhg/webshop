<?php 
include_once("./includes/session.php");
//include_once("includes/config.php");
include_once("./includes/config.php");
$url=basename(__FILE__)."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
?>
<?php
if(isset($_GET['action']) && $_GET['action']=='inactive')

{

   $item_id=$_GET['cid'];

   mysqli_query($con,"update makeoffer_orders set status='0' where id='".$item_id."'");

  $_SESSION['msg']=message('updated successfully',1);

  header('Location:search_order.php');

  exit();

}

if(isset($_GET['action']) && $_GET['action']=='active')

{

  $item_id=$_GET['cid'];

  mysqli_query($con,"update `makeoffer_tblorderdetails` set order_status='1' where orderid='".$item_id."'");
        mysqli_query($con,"update `makeoffer_orders` set status='1' where orderid='".$item_id."'");

  $_SESSION['msg']=message('updated successfully',1);

  header('Location:search_order.php');

  exit();

} 

//csv download
if(isset($_POST['ExportCsv']))
{
   
   
   $sql="SELECT * from `makeoffer_orders`";
   
    
    

$query=mysqli_query($con,$sql);

  $output='';

    $output .='Order ID,User Name,Order Date,Order Amount';

    $output .="\n";

    if(mysqli_num_rows($query)>0)
    {
        while($result = mysqli_fetch_assoc($query))
        {
            $fetch_user=mysqli_fetch_assoc(mysqli_query($con,"select * from `makeoffer_user` where `id`='".$result['order_user_id']."'"));
           $order_ID = $result['new_order_id'];
           $user_fname = $fetch_user['fname'];
           $user_lname = $fetch_user['lname'];
           $user_Name=$user_fname.' '.$user_lname;
           $order_date = $result['orderdate'];
           $order_amount = $result['orderamount'];
           
          
           if($order_ID!=""){
            $output .='"'.$order_ID.'","'.$user_Name.'","'.$order_date.'","'.$order_amount.'"';
            $output .="\n";
            }
        }
    }



    $filename = "myFile".time().".csv";

    header('Content-type: application/csv');

    header('Content-Disposition: attachment; filename='.$filename);



    echo $output;

    //echo'<pre>';

    //print_r($result);

    exit;
  
  
}


//-----------------------------Data Manage----------------------------

$query="SELECT * FROM makeoffer_orders WHERE uploder_user_id = '".$_REQUEST['id']."' ";
if(isset($_REQUEST['transId']) && $_REQUEST['transId']!="")
{
  $transId=$_REQUEST['transId'];
  
  $query .=" where new_order_id=".trim($transId);
}
if(isset($_REQUEST['store']) && $_REQUEST['store']!="")
{
    $query .=" where `storeid`=".$_REQUEST['store'];
}
 $query.= "  order by `id` DESC ";


$res=mysqli_query($con,$query);
$num=mysqli_num_rows($res);


//-----------------------------/Data Manage----------------------------


/*Bulk Category Delete*/
if(isset($_REQUEST['bulk_delete_submit'])){
    
    
  
        $idArr = $_REQUEST['checked_id'];
        foreach($idArr as $id){
            //echo "UPDATE `makeoffer_orders` SET status='0' WHERE id=".$id;
            mysqli_query($con,"DELETE FROM  `makeoffer_orders` WHERE orderid=".$id);
        }
        $_SESSION['success_msg'] = 'Orders have been deleted successfully.';
        
        //die();
        
        header("Location:search_order.php");
    }


?>



<script language="javascript">

   function del(aa,bb)

   {

      var a=confirm("Are you sure, you want to delete this?")

      if (a)

      {

        location.href="search_order.php?cid="+ aa +"&action=delete"

      }  

   } 

   

function inactive(aa)

   { 

       location.href="search_order.php?cid="+ aa +"&action=inactive"



   } 

   function active(aa)

   {

     location.href="search_order.php?cid="+aa+"&action=active";

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
                   <h3 class="page-title">Selling<small>Product history</small></h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Selling list</a>
                        
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
                           <h4><i class="icon-reorder"></i>Products list </h4>
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
          <!--<td align="center"><input type="checkbox" name="select_all" id="select_all" value=""/></td>-->
          <th>
          Selling Id
          </th>
          <th>
          Selling Date
          </th>
          <th>
          Selling By
          </th>
          <th>
          Selling Amount($)
          </th>
          
          <th>
        Admin Charge($)
          </th>
          <th>
          Status
          </th>
          
          <th>
          Details
          </th>
          
          
          
          </tr>
                                     </thead>
                                     <tbody>
                          <?php
          
          if($num>0)
          {
          
          $count=1;
          while($row=mysqli_fetch_object($res))
          {
          $fetch_user=mysqli_fetch_object(mysqli_query($con,"select * from `makeoffer_user` where `id`='".$row->uploder_user_id."'"));
          //  $fetch_store=mysqli_fetch_object(mysqli_query($con,"select * from `makeoffer_store` where `id`='".$row->storeid."'"));
          $fetch_tblorder=mysqli_fetch_object(mysqli_query($con,"select * from `makeoffer_orders` where `id`='".$row->id."'"));
          $fetch_billingdetails=mysqli_fetch_object(mysqli_query($con,"select * from `makeoffer_billing` where `billing_id`='".$fetch_tblorder->billing_id."'"));
          $sql1 = mysqli_query($con,"SELECT * FROM makeoffer_transactions WHERE `transaction_id`='".$row->unique_trans_id."' ");
          $sq=mysqli_num_rows($sql1);
          $sql2=mysqli_fetch_array($sql1);
          
          /*echo "select * from `makeoffer_billing` where `billing_id`='".$fetch_tblorder->billing_id."'";
          exit;*/
          ?>
          
          <tr>
          <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->orderid ; ?>"/></td>-->
          <td>
          <a href="order_details.php?orderid=<?php echo $row->id;?>"><?php echo $row->unique_trans_id;?></a>
          </td>
          <td>
          <?php echo $row->date;?>
          </td>
          <td>
          <?php
                 
          echo  $fetch_user->fname.$fetch_user->lname;
          ?>
          </td>
          
          
          <td>
          $ <?php echo $row->price;?>
          </td>
          
           <td>
          $ <?php
          if($sq >0)
          {
          echo $sql2->admin_fees;
          }
          else
          {
                echo '0.00';
          }
          ?>
          </td>
          <td>
          
          <?php
          if($row->status=='0'){
          ?>
          <span class="label label-warning" > Pending </span>&nbsp;
          
          <?php
          
          }
          elseif($row->status=='1')
          {
              ?>
             <span class="label label-warning" > Delivered </span>&nbsp;
          <?php
              
          }
          elseif($row->status=='2')
          {
              ?>
            <span class="label label-warning" > Completed</span>&nbsp; 
            <?php
          }
          elseif($row->status=='4')
          {
              ?>
            <span class="label label-warning" > Payment Failed</span>&nbsp; 
            <?php
          }
          
          //else{
          
          ?>
         <!-- <a  onClick="javascript:active('<?php echo $row->orderid;?>');"> <span class="label label-warning"> Pending </span></a>&nbsp;-->
          
          <?php
          //}
          ?>
          </td>
          
          <td>
          <button class="btn btn-mini green" type="button"  onClick="location.href='order_details.php?orderid=<?php echo $row->id;?>'">Details</button>&nbsp;
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
   <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
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
