<?php
session_start();
include_once("controller/grpcategoryController.php");
include("includes/config");


?>

<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="grouplist_category.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="grouplist_category.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="grouplist_category.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">
            List Group Category
                   </h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Group List Category</a>
                           <span class="divider">/</span>
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
                            <h4><i class="fa fa-edit"></i>Group List Category</h4>
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
                <th>
                  Name
                </th>
                                                                <th>
                   Edit
                </th>
                
                                                                <th>
                   Delete
                </th>
                                                                <!--<th>
                   Product List
                </th>-->
                                                                <th>
                  Status
                </th>
                
              </tr>
                                     </thead>
                                     <tbody>
                                <?php
                                                  //  $sql="select * from makeoffer_category  where 1";
                                                        

 

//$record=mysqli_query($con,$sql);

if(mysqli_num_rows($record)==0)

{?>

                  <tr>

                    <td colspan="3">Sorry, no record found.</td>

                  </tr>

                  <?php 

}

else

{

$count=1;

  while($row=mysqli_fetch_object($record))

  {
            $cat=mysqli_query($con,"select * from `webshop_product` where `cat_id`='".$row->id."'");
            $num=mysqli_num_rows($cat);
            if($num>0)
            {
                $a=$num;
                
            }
            else
            {
                $a=0;
                
            }

  

?>

              
              <tr>
                                                             <!--<td align="center"><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php echo $row->id ; ?>"/></td>-->        
                <td>
                  <?php echo stripslashes($row->name);?>
                </td>
                
                
                <!--<td>
                  <?php echo $row->email;?>
                </td>-->
                <td>
                  <a onClick="window.location.href='add_grpcategory.php?id=<?php echo $row->id ?>&action=edit'">Edit</a>
                </td>
                                                                <td>
                  <a onClick="javascript:del('<?php echo $row->id; ?>')">Delete</a>
                </td>
                                                                <!--<td>
                                                                    <a href="grpcategory_product_list.php?id=<?php echo $row->id ?>">Product List(<?php echo $a ?>)</a>
                                                                </td>-->
                                                                <td>
                  <?php if($row->status=='0'){?>
<a  onClick="javascript:active('<?php echo $row->id;?>');">Activate</a>
<?php } else {?>
<a onClick="javascript:inactive('<?php echo $row->id;?>');">Deactivate</a>
      <?php }?>
                </td>
              </tr>
                                                       <?php
                                                        }
}
                                                       ?>
                                     </tbody>
                                 </table>
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
