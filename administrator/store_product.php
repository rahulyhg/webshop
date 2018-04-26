<?php
include_once("controller/productController.php");
?>


<script language="javascript">
   function del(aa,bb)
   {
      var a=confirm("Are you sure, you want to delete this?")
      if (a)
      {
        location.href="list_product.php?cid="+ aa +"&action=delete"
      }  
   } 
   
function inactive(aa)
   { 
       location.href="list_product.php?cid="+ aa +"&action=inactive"

   } 
   function active(aa)
   {
     location.href="list_product.php?cid="+aa+"&action=active";
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
                   <h3 class="page-title">Products of yours</h3>
                   <ul class="breadcrumb">
                       <li>
                           <a href="#">Home</a>
                           <span class="divider">/</span>
                       </li>
                       <li>
                           <a href="#">Products list</a>
                        
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
                             Products list
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
                <th>Product Name</th>
                <th>Currency</th>
                <th>Price</th>
                <th>Quick Links</th>                
                <!--<th>Edit</th>-->
                <th>Delete</th>
              </tr>
            </thead>
        <tbody>
    <?php
    $fetch_product=mysqli_query($con,"select * from makeoffer_product  where `product_type`='P' and `user_id`='".$_REQUEST['id']."'");
    $num=mysqli_num_rows($fetch_product);
    if($num>0)
    {
    while($product=mysqli_fetch_array($fetch_product))
    {
    $fetch_store=mysqli_fetch_array(mysqli_query($con,"select * from `makeoffer_store` where `id`='".$product['store_id']."'"));
    $image=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `makeoffer_moreimage` WHERE `pro_id`='".$product['id']."'"));
    if($image['image']!='')
    {
    $image_link='../upload/product/'.$image['image'];
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
                
                
                <?php
                
                //$prom=mysqli_query($con,"SELECT makeoffer_product.currency_name, makeoffer_currencies.symbol FROM makeoffer_product INNER JOIN makeoffer_currencies ON makeoffer_product.currency = makeoffer_currencies.id WHERE makeoffer_product.currency = makeoffer_currencies.id;");
                //$prod=mysqli_fetch_assoc($prom);
                

                
                ?>
                
                
                
                
                <td>
                  <?php echo stripslashes($product['currency_name']); ?>
                </td>
                
                
                
                
                
                
                
                
                
                
                <td>
                   <?php echo stripslashes($product['regular_price']);?>
                </td>
                
                
                <td>
                    <a  href="details_product.php?id=<?php echo $product['id'] ?>&action=details">Details</a>

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
