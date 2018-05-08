<?php
$pagename = end(explode('/', $_SERVER['REQUEST_URI']));
$prevnameall = explode(',', $_SESSION['privilege_name']);
//print_r($pagename);
//print_r($prevnameall);
?>
<!-- BEGIN SIDEBAR -->

<style>
    #sidebar > ul > li > ul.sub > li > a{
        font-size: 10px !important;
        padding: 10px 10px 10px 30px !important;
    }

    .green .widget-title span.tools{
        display: none;
    }
</style>

<div class="sidebar-scroll" style="overflow-y: hidden !important;">
    <div id="sidebar" class="nav-collapse collapse">

        <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
        <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
                <input type="text" class="search-query" placeholder="Search" />
            </form>
        </div>
        <!-- END RESPONSIVE QUICK SEARCH FORM -->
        <!-- BEGIN SIDEBAR MENU -->





        <ul class="sidebar-menu">              

            <li class="sub-menu active">
                <a class="" href="dashboard.php">
                    <i class="icon-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if (in_array('1', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-book"></i>
                        <span>Site Settings</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <li>
                            <a href="site_logo.php">
                                <i class="icon-bulb"></i>
                                Manage Logo</a>
                        </li>

                        <li>

                            <a href="add_social.php">
                                <i class="icon-bulb"></i>
                                Add Social Media</a>
                        </li>

                        <li>

                            <a href="social.php">
                                <i class="icon-bulb"></i>
                                Manage Social Media</a>
                        </li>

                        <li>
                            <a href="add_banner.php">
                                <i class="icon-bulb"></i>
                                Add Banner</a>
                        </li>


                        <li>
                            <a href="list_banner.php">
                                <i class="icon-bulb"></i>
                                List Banner</a>
                        </li>

                        <li>
                            <a href="payment_settings.php">
                                <i class="icon-bulb"></i>
                                Payment Settings</a>
                        </li>

                        <!--  <li>
                             <a href="smtp_settings.php">
                                 <i class="icon-bulb"></i>
                                  SMTP Mail Settings</a>
                         </li> -->

                        <li>
                            <a href="manage_percentage.php">
                                <i class="icon-bulb"></i>
                                Manage Percentage</a>
                        </li> 


                    </ul>
                </li>

                <?php
            }
            ?>

            <?php if (in_array('2', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-tasks"></i>
                        <span>CMS Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <li>
                            <a href="add_page_name.php">
                                Manage CMS</a>
                        </li>



                    </ul>
                </li>





                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-tasks"></i>
                        <span>Email Template</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <li>
                            <a href="email_template.php">
                                Email Template</a>
                        </li>



                    </ul>
                </li>


                <?php
            }
            ?>


            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-tasks"></i>
                    <span>Manage Subscription</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">

                    <li>
                        <a href="add_subscription.php">
                            Add Subscription</a>
                    </li>

                    <li>
                        <a href="list_subscription.php">
                            List Subscription</a>
                    </li>





                </ul>
            </li>


            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-tasks"></i>
                    <span>Offer Subscription</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">

                    <li>
                        <a href="add_user_offer.php">
                            Offer to users</a>
                    </li>

                </ul>
            </li>








            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-tasks"></i>
                    <span>Manage Auction Date</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">

                    <li>
                        <a href="add_auctiondates.php">
                            Add Auction Date</a>
                    </li>

                    <li>
                        <a href="list_auctiondates.php">
                            List Auction Date</a>
                    </li>



                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-tasks"></i>
                    <span>Manage Auction Time</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">

                    <li>
                        <a href="add_auctiontime.php">
                            Add Auction Timing</a>
                    </li>

                    <li>
                        <a href="#">
                            List Auction Timings</a>
                    </li>



                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-tasks"></i>
                    <span>Language</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">

                    <li>
                        <a href="language.php">
                            Language</a>
                    </li>

                    <li>
                        <a href="#">
                            Arabic</a>
                    </li>



                </ul>
            </li>




            <?php if (in_array('3', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-user"></i>
                        <span>Users <br> Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                                                                                                                                       <!--  <li  <?php if ($pagename == 'add_owner.php') { ?>  class="active" <?php } ?>>
                                                                                                                                            <a href="add_owner.php">
                                                                                                                                                <i class="icon-user"></i>
                                                                                                                                                Add Owner</a>
                                                                                                                                        </li> -->

                                                                                                                                       <!--  <li  <?php if ($pagename == 'list_owner.php') { ?>  class="active" <?php } ?>>
                                                                                                                                            <a href="list_owner.php">
                                                                                                                                                <i class="icon-user"></i>
                                                                                                                                               List Owner</a>
                                                                                                                                        </li>  -->
                        <li  <?php if ($pagename == 'list_user.php') { ?>  class="active" <?php } ?>>
                            <a href="list_user.php">
                                <i class="icon-user"></i>
                                Normal User</a>
                        </li> 

                        <li  <?php if ($pagename == 'list_topuser.php') { ?>  class="active" <?php } ?>>
                            <a href="list_topuser.php">
                                <i class="icon-user"></i>
                                Certified User</a>
                        </li>


                    </ul>
                </li>
                <?php
            }
            ?>
            <!-- <?php if (in_array('17', $prevnameall)) { ?>
                                                                                                                                <li class="sub-menu">
                                                                                                                                      <a href="javascript:;" class="">
                                                                                                                                          <i class="icon-briefcase"></i>
                                                                                                                                          <span>Business <br> Management</span>
                                                                                                                                          <span class="arrow"></span>
                                                                                                                                      </a>
                                                                                                                                      <ul class="sub">
                                                                                                                                         <li  <?php if ($pagename == 'add_business.php') { ?>  class="active" <?php } ?>>
                                                                                                                                            <a href="add_business.php">
                                                                                                                                                <i class="icon-briefcase"></i>
                                                                                                                                                Add Business</a>
                                                                                                                                        </li>
                                                                                                                                        
                                                                                                                                        <li  <?php if ($pagename == 'list_business.php') { ?>  class="active" <?php } ?>>
                                                                                                                                            <a href="list_business.php">
                                                                                                                                                <i class="icon-briefcase"></i>
                                                                                                                                               List Business</a>
                                                                                                                                        </li> 
                                                                                                                                      </ul>
                                                                                                                                  </li>
                <?php
            }
            ?> -->

            <?php if (in_array('4', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-user"></i>
                        <span>Vendor <br> Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                      <!--  <li  <?php if ($pagename == 'add_provider.php') { ?>  class="active" <?php } ?>>
                          <a href="add_provider.php">
                               <i class="icon-user"></i>
                              Add Provider</a>
                      </li> 
                      
                      <li  <?php if ($pagename == 'list_provider.php') { ?>  class="active" <?php } ?>>
                          <a href="list_provider.php">
                              <i class="icon-user"></i>
                             List Provider</a>
                      </li> -->
                        <li  <?php if ($pagename == 'list_vendor.php') { ?>  class="active" <?php } ?>>
                            <a href="list_vendor.php">
                                <i class="icon-user"></i>
                                Normal Vendor</a>
                        </li> 

                        <li  <?php if ($pagename == 'list_topvendor.php') { ?>  class="active" <?php } ?>>
                            <a href="list_topvendor.php">
                                <i class="icon-user"></i>
                                Certified Vendor</a>
                        </li>

                    </ul>
                </li>
                <?php
            }
            ?>


            <?php if (in_array('5', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-tag"></i>
                        <span>Category<br>Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'add_category.php') { ?>  class="active" <?php } ?>>
                            <a href="add_category.php">
                                <i class="icon-tag"></i>
                                Add Category</a>
                        </li> 

                        <li  <?php if ($pagename == 'list_category.php') { ?>  class="active" <?php } ?>>
                            <a href="list_category.php">
                                <i class="icon-tag"></i>
                                List Category</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('6', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-tags"></i>
                        <span>SubCategory<br>Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'add_subcategory.php') { ?>  class="active" <?php } ?>>
                            <a href="add_subcategory.php">
                                <i class="icon-tags"></i>
                                Add SubCategory</a>
                        </li> 

                        <li  <?php if ($pagename == 'list_subcategory.php') { ?>  class="active" <?php } ?>>
                            <a href="list_subcategory.php">
                                <i class="icon-tags"></i>
                                List SubCategory</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('21', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-tags"></i>
                        <span>Brands<br>Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'add_brands.php') { ?>  class="active" <?php } ?>>
                            <a href="add_brands.php">
                                <i class="icon-tags"></i>
                                Add Brands</a>
                        </li> 

                        <li  <?php if ($pagename == 'list_brands.php') { ?>  class="active" <?php } ?>>
                            <a href="list_brands.php">
                                <i class="icon-tags"></i>
                                List Brands</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>


            <?php if (in_array('20', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-archive"></i>
                        <span>Products</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'list_products.php') { ?>  class="active" <?php } ?>>
                            <a href="list_products.php">
                                <i class="icon-archive"></i>
                                List Products</a>
                        </li> 

                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('22', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-archive"></i>
                        <span>Newsletter</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'newsletter_list.php') { ?>  class="active" <?php } ?>>
                            <a href="newsletter_list.php">
                                <i class="icon-archive"></i>
                                List Newsletter</a>
                        </li> 

                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('15', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-usd"></i>
                        <span>Auction <br>Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub"> 

                        <li  <?php if ($pagename == 'list_auction.php') { ?>  class="active" <?php } ?>>
                            <a href="list_auction.php">
                                <i class="icon-usd"></i>
                                Request Auction</a>
                        </li> 
                        <li  <?php if ($pagename == 'list_live_auction.php') { ?>  class="active" <?php } ?>>
                            <a href="list_live_auction.php">
                                <i class="icon-usd"></i>
                                List Live Auction</a>
                        </li> 
                        <li  <?php if ($pagename == 'list_expire_auction.php') { ?>  class="active" <?php } ?>>
                            <a href="list_expire_auction.php">
                                <i class="icon-usd"></i>
                                List Expire Auction</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <li class="sub-menu">
                <a href="javascript:;" class="">
                    <i class="icon-usd"></i>
                    <span>Product <br>Management</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub"> 

                    <li class="active">
                        <a href="list_product.php">
                            <i class="icon-usd"></i>
                            Request Product</a>
                    </li> 
                    <li class="active">
                        <a href="list_live_auction.php">
                            <i class="icon-usd"></i>
                            List Live Product</a>
                    </li> 

                </ul>
            </li>


            <?php if (in_array('9', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-star"></i>
                        <span>Reviews <br> Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'list_all_reviews.php') { ?>  class="active" <?php } ?>>
                            <a href="list_all_reviews.php">
                                <i class="icon-star"></i>
                                List Reviews</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('10', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-credit-card"></i>
                        <span>Membership<br>Management</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <li  <?php if ($pagename == 'add_membership.php') { ?>  class="active" <?php } ?>>
                            <a href="add_membership.php">
                                <i class="icon-credit-card"></i>
                                Add Membership</a>
                        </li> 

                        <li  <?php if ($pagename == 'list_membership.php') { ?>  class="active" <?php } ?>>
                            <a href="list_membership.php">
                                <i class="icon-credit-card"></i>
                                Manage Membership</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('13', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-volume-up"></i>
                        <span>Advertisement</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                                                                                                                    <!--   <li  <?php if ($pagename == 'add_advertisement.php') { ?>  class="active" <?php } ?>>
                                                                                                                        <a href="add_advertisement.php">
                                                                                                                          <i class="icon-volume-up"></i>
                                                                                                                           Add Advertisement</a>
                                                                                                                    </li>  -->

                        <li  <?php if ($pagename == 'list_advertisement.php') { ?>  class="active" <?php } ?>>
                            <a href="list_advertisement.php">
                                <i class="icon-volume-up"></i>
                                Manage Advertisement</a>
                        </li> 

                        <li  <?php if ($pagename == 'pending_advertisement.php') { ?>  class="active" <?php } ?>>
                            <a href="pending_advertisement.php">
                                <i class="icon-volume-up"></i>
                                Pending Advertisement</a>
                        </li>

                        <li  <?php if ($pagename == 'paid_advertisement.php') { ?>  class="active" <?php } ?>>
                            <a href="paid_advertisement.php">
                                <i class="icon-volume-up"></i>
                                Paid Advertisement</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('14', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-tag"></i>
                        <span>Broadcast Messages</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">


                        <li  <?php if ($pagename == 'broadcast_customer.php') { ?>  class="active" <?php } ?>>
                            <a href="broadcast_customer.php">
                                <i class="icon-tag"></i>
                                Message All Customer</a>
                        </li> 

                        <li  <?php if ($pagename == 'broadcast_vendor.php') { ?>  class="active" <?php } ?>>
                            <a href="broadcast_vendor.php">
                                <i class="icon-tag"></i>
                                Message All Vendor</a>
                        </li> 

                        <li  <?php if ($pagename == 'selective_customer.php') { ?>  class="active" <?php } ?>>
                            <a href="selective_customer.php">
                                <i class="icon-tag"></i>
                                Selective Customer</a>
                        </li> 

                        <li  <?php if ($pagename == 'selective_vendor.php') { ?>  class="active" <?php } ?>>
                            <a href="selective_vendor.php">
                                <i class="icon-tag"></i>
                                Selective Vendor</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('11', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-bell-alt"></i>
                        <span>Notification Setting</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <li>
                            <a href="notification_list.php">
                                <i class="icon-bell-alt"></i>
                                Notification List</a>
                        </li>


                        <li>
                            <a href="notification_settings.php">
                                <i class="icon-bell-alt"></i>
                                Notification Settings</a>
                        </li>
                    </ul>
                </li>
                <?php
            }
            ?>

            <?php if (in_array('12', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-cogs"></i>
                        <span>Send Messages</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">
                        <li  <?php if ($pagename == 'message_user.php') { ?>  class="active" <?php } ?>>
                            <a href="message_user.php">
                                <i class="icon-home"></i>
                                Message User</a>
                        </li>

                        <li  <?php if ($pagename == 'message_vendor.php') { ?>  class="active" <?php } ?>>
                            <a href="message_vendor.php">
                                <i class="icon-home"></i>
                                Message Vendor</a>
                        </li> 
                    </ul>
                </li>
                <?php
            }
            ?>

            <!--    <?php if (in_array('12', $prevnameall)) { ?>
                                                                                                                                 <li class="sub-menu">
                                                                                                                                       <a href="javascript:;" class="">
                                                                                                                                           <i class="icon-cogs"></i>
                                                                                                                                           <span>Bounces/Red Packet<br>Management</span>
                                                                                                                                           <span class="arrow"></span>
                                                                                                                                       </a>
                                                                                                                                       <ul class="sub">
                                                                                                                                          <li  <?php if ($pagename == 'add_promocodes.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="add_promocodes.php">
                                                                                                                                                 <i class="icon-home"></i>
                                                                                                                                                 Add Red Packet</a>
                                                                                                                                         </li>
                                                                                                                                         
                                                                                                                                         <li  <?php if ($pagename == 'list_promocodes.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="list_promocodes.php">
                                                                                                                                                 <i class="icon-home"></i>
                                                                                                                                                List Red Packet</a>
                                                                                                                                         </li> 
                                                                                                                                       </ul>
                                                                                                                                   </li>
                <?php
            }
            ?>
 
            <?php if (in_array('18', $prevnameall)) { ?>
                                                                                                                                   <li class="sub-menu">
                                                                                                                                       <a href="javascript:;" class="">
                                                                                                                                           <i class="icon-plane"></i>
                                                                                                                                           <span>Manage Locations</span>
                                                                                                                                           <span class="arrow"></span>
                                                                                                                                       </a>
                                                                                                                                       <ul class="sub">
                                                                                                                                          <li  <?php if ($pagename == 'add_location.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="add_location.php">
                                                                                                                                                 <i class="icon-plane"></i>
                                                                                                                                               Add Location </a>
                                                                                                                                         </li>
                                                                                                                     
                                                                                                                                          <li  <?php if ($pagename == 'manage_location.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="manage_location.php">
                                                                                                                                                 <i class="icon-plane"></i>
                                                                                                                                               List Locations </a>
                                                                                                                                         </li>
                                                                                                                                   
                                                                                                                                       </ul>
                                                                                                                                   </li>
                <?php
            }
            ?>
  
            <?php if (in_array('15', $prevnameall)) { ?>
                                                                                                                                 <li class="sub-menu">
                                                                                                                                       <a href="javascript:;" class="">
                                                                                                                                          <i class="icon-usd"></i>
                                                                                                                                           <span>Cost Estimation</span>
                                                                                                                                           <span class="arrow"></span>
                                                                                                                                       </a>
                                                                                                                                       <ul class="sub">
                                                                                                                                         
                                                                                                                                         <li  <?php if ($pagename == 'add_costs.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="add_costs.php">
                                                                                                                                                <i class="icon-usd"></i>
                                                                                                                                                Add Costs</a>
                                                                                                                                         </li> 
                                                                                                                                         
                                                                                                                                         <li  <?php if ($pagename == 'manage_costs.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="manage_costs.php">
                                                                                                                                                <i class="icon-usd"></i>
                                                                                                                                                Manage Costs</a>
                                                                                                                                         </li> 
                                                                                                                                       </ul>
                                                                                                                                   </li>
                <?php
            }
            ?>
            
            <?php if (in_array('16', $prevnameall)) { ?>
                                                                                                                                   <li class="sub-menu">
                                                                                                                                       <a href="javascript:;" class="">
                                                                                                                                           <i class="icon-volume-up"></i>
                                                                                                                                           <span>Manage<br> Advertisement</span>
                                                                                                                                           <span class="arrow"></span>
                                                                                                                                       </a>
                                                                                                                                       <ul class="sub">
                                                                                                                                          <li  <?php if ($pagename == 'add_advertisement.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="add_advertisement.php">
                                                                                                                                                 <i class="icon-volume-up"></i>
                                                                                                                                               Add Advertisement</a>
                                                                                                                                         </li>
                                                                                                                     
                                                                                                                                        <li  <?php if ($pagename == 'list_advertisement.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="list_advertisement.php">
                                                                                                                                                 <i class="icon-volume-up"></i>
                                                                                                                                              List Advertisement</a>
                                                                                                                                         </li>
                                                                                                                                   
                                                                                                                                       </ul>
                                                                                                                                   </li>
                <?php
            }
            ?>
            -->

            <!--  <?php if (in_array('6', $prevnameall)) { ?>
                                                                                                                                 <li class="sub-menu">
                                                                                                                                     <a href="javascript:;" class="">
                                                                                                                                         <i class="icon-comments"></i>
                                                                                                                                         <span>Manage Blogs</span>
                                                                                                                                         <span class="arrow"></span>
                                                                                                                                     </a>
                                                                                                                                     <ul class="sub">
                                                                                                                                        <li  <?php if ($pagename == 'add_blog.php') { ?>  class="active" <?php } ?>>
                                                                                                                                           <a href="add_blog.php">
                                                                                                                                               <i class="icon-comments"></i>
                                                                                                                                             Add Blog </a>
                                                                                                                                       </li>

                                                                                                                                        <li  <?php if ($pagename == 'list_blogs.php') { ?>  class="active" <?php } ?>>
                                                                                                                                           <a href="list_blogs.php">
                                                                                                                                               <i class="icon-comments"></i>
                                                                                                                                             List Blogs </a>
                                                                                                                                       </li>
                                                                                                                                 
                                                                                                                                     </ul>
                                                                                                                                 </li>
                <?php
            }
            ?> -->

            <!-- <?php if (in_array('17', $prevnameall)) { ?>
                                                                                                                               <li class="sub-menu">
                                                                                                                                   <a href="javascript:;" class="">
                                                                                                                                       <i class="icon-cogs"></i>
                                                                                                                                       <span>Newsletter <br> Subscription</span>
                                                                                                                                       <span class="arrow"></span>
                                                                                                                                   </a>
                                                                                                                                   <ul class="sub">
                                                                                                                                      <li  <?php if ($pagename == 'newsletter_user.php') { ?>  class="active" <?php } ?>>
                                                                                                                                         <a href="newsletter_user.php">
                                                                                                                                             <i class="icon-home"></i>
                                                                                                                                           NewsLetter User</a>
                                                                                                                                     </li>

                                                                                                                                    <li  <?php if ($pagename == 'newsletter_supplier.php') { ?>  class="active" <?php } ?>>
                                                                                                                                         <a href="newsletter_supplier.php">
                                                                                                                                             <i class="icon-home"></i>
                                                                                                                                          NewsLetter Supplier</a>
                                                                                                                                     </li>
                                                                                                                               
                                                                                                                                   </ul>
                                                                                                                               </li>
                <?php
            }
            ?>

            <?php if (in_array('18', $prevnameall)) { ?>
                                                                                                                             <li class="sub-menu">
                                                                                                                                   <a href="javascript:;" class="">
                                                                                                                                       <i class="icon-cogs"></i>
                                                                                                                                       <span>Email Template</span>
                                                                                                                                       <span class="arrow"></span>
                                                                                                                                   </a>
                                                                                                                                   <ul class="sub">
                                                                                                                                     
                                                                                                                                     
                                                                                                                                     <li  <?php if ($pagename == 'email_template.php') { ?>  class="active" <?php } ?>>
                                                                                                                                         <a href="email_template.php">
                                                                                                                                             <i class="icon-home"></i>
                                                                                                                                            Email Template</a>
                                                                                                                                     </li> 
                                                                                                                                   </ul>
                                                                                                                               </li>
                <?php
            }
            ?>

            <?php if (in_array('12', $prevnameall)) { ?>
                                                                                                                             <li class="sub-menu">
                                                                                                                                   <a href="javascript:;" class="">
                                                                                                                                       <i class="icon-cogs"></i>
                                                                                                                                       <span>Manage Questions</span>
                                                                                                                                       <span class="arrow"></span>
                                                                                                                                   </a>
                                                                                                                                   <ul class="sub">
                                                                                                                                     
                                                                                                                                      <li  <?php if ($pagename == 'edit_questions.php') { ?>  class="active" <?php } ?>>
                                                                                                                                         <a href="edit_questions.php">
                                                                                                                                             <i class="icon-home"></i>
                                                                                                                                            Add Question</a>
                                                                                                                                     </li> 
                                                                                                                                     
                                                                                                                                     <li  <?php if ($pagename == 'manage_questions.php') { ?>  class="active" <?php } ?>>
                                                                                                                                         <a href="manage_questions.php">
                                                                                                                                             <i class="icon-home"></i>
                                                                                                                                            Manage Questions</a>
                                                                                                                                     </li> 
                                                                                                                                   </ul>
                                                                                                                               </li>
                <?php
            }
            ?>
            -->
            <!--      <?php if (in_array('13', $prevnameall)) { ?>
                                                                                                                                  <li class="sub-menu">
                                                                                                                                        <a href="javascript:;" class="">
                                                                                                                                            <i class="icon-ban-circle"></i>
                                                                                                                                            <span>Report Image</span>
                                                                                                                                            <span class="arrow"></span>
                                                                                                                                        </a>
                                                                                                                                        <ul class="sub">
                                                                                                                                          
                                                                                                                                          
                                                                                                                                          <li  <?php if ($pagename == 'report_image.php') { ?>  class="active" <?php } ?>>
                                                                                                                                              <a href="report_image.php">
                                                                                                                                                  <i class="icon-ban-circle"></i>
                                                                                                                                                 Report Image</a>
                                                                                                                                          </li> 
                                                                                                                                        </ul>
                                                                                                                                    </li>
                <?php
            }
            ?>
  
            <?php if (in_array('14', $prevnameall)) { ?>
                                                                                                                                  <li class="sub-menu">
                                                                                                                                        <a href="javascript:;" class="">
                                                                                                                                            <i class="icon-ban-circle"></i>
                                                                                                                                            <span>Report User</span>
                                                                                                                                            <span class="arrow"></span>
                                                                                                                                        </a>
                                                                                                                                        <ul class="sub">
                                                                                                                                          
                                                                                                                                          
                                                                                                                                          <li  <?php if ($pagename == 'report_user.php') { ?>  class="active" <?php } ?>>
                                                                                                                                              <a href="report_user.php">
                                                                                                                                                 <i class="icon-ban-circle"></i>
                                                                                                                                                 Report User</a>
                                                                                                                                          </li> 
                                                                                                                                        </ul>
                                                                                                                                    </li>
                <?php
            }
            ?>
            -->
            <!--    <?php if (in_array('11', $prevnameall)) { ?>
                                                                                                                                 <li class="sub-menu">
                                                                                                                                       <a href="javascript:;" class="">
                                                                                                                                        <i class="icon-money"></i>
                                                                                                                                           <span>Financial Accounts</span>
                                                                                                                                           <span class="arrow"></span>
                                                                                                                                       </a>
                                                                                                                                       <ul class="sub">
                                                                                                                                         
                                                                                                                                         
                                                                                                                                         <li  <?php if ($pagename == 'financial_accounts.php') { ?>  class="active" <?php } ?>>
                                                                                                                                             <a href="financial_accounts.php">
                                                                                                                                                <i class="icon-money"></i>
                                                                                                                                                List Payments</a>
                                                                                                                                         </li> 
                -->
                                   <!-- <li  <?php if ($pagename == 'pending_payments.php') { ?>  class="active" <?php } ?>>
                                       <a href="pending_payments.php">
                                        <i class="icon-money"></i>
                                          Pending Payments</a>
                                   </li> -->

                <!--                  </ul>
                             </li>
                <?php
            }
            ?>


            <?php if (in_array('19', $prevnameall)) { ?>
                           <li class="sub-menu">
                                 <a href="javascript:;" class="">
                                     <i class="icon-exclamation-sign"></i>
                                     <span>Complaints</span>
                                     <span class="arrow"></span>
                                 </a>
                                 <ul class="sub">
                                   
                                   
                                   <li  <?php if ($pagename == 'complains.php') { ?>  class="active" <?php } ?>>
                                       <a href="complains.php">
                                           <i class="icon-exclamation-sign"></i>
                                          Complaints</a>
                                   </li> 
               
                                 </ul>
                             </li>
                <?php
            }
            ?>


            <?php if (in_array('10', $prevnameall)) { ?>
                           <li class="sub-menu">
                                 <a href="javascript:;" class="">
                                  <i class="icon-truck"></i>
                                     <span>Trips</span>
                                     <span class="arrow"></span>
                                 </a>
                                 <ul class="sub">
                                   
                                   
                                   <li  <?php if ($pagename == 'list_all_bookings.php') { ?>  class="active" <?php } ?>>
                                       <a href="list_all_bookings.php">
                                      <i class="icon-truck"></i>
                                          List Trips</a>
                                   </li>
               
                                   <li  <?php if ($pagename == 'list_pending_bookings.php') { ?>  class="active" <?php } ?>>
                                       <a href="list_pending_bookings.php">
                                      <i class="icon-truck"></i>
                                          Pending Trips</a>
                                   </li> 
               
                                   <li  <?php if ($pagename == 'list_completed_bookings.php') { ?>  class="active" <?php } ?>>
                                       <a href="list_completed_bookings.php">
                                    <i class="icon-truck"></i>
                                          Completed Trips</a>
                                   </li> 
               
                                   <li  <?php if ($pagename == 'list_started_bookings.php') { ?>  class="active" <?php } ?>>
                                       <a href="list_started_bookings.php">
                                      <i class="icon-truck"></i>
                                          Started Trips</a>
                                   </li>  
                                 </ul>
                             </li>
                <?php
            }
            ?>
            -->
            <?php if (in_array('7', $prevnameall)) { ?>
                <li class="sub-menu">
                    <a class="" href="javascript:;">
                        <i class="icon-trophy"></i>
                        <span>Create Admin</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <li>
                            <a href="add_new_admin.php">
                                Add New Admin</a>
                        </li>  


                        <li>
                            <a href="list_admin.php">
                                All Admin List</a>
                        </li>


                    </ul>
                </li>
                <?php
            }
            ?> 
            <?php if (in_array('8', $prevnameall)) { ?>

                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon-glass"></i>
                        <span>Settings</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">

                        <!--  <li>
                             <a href="swipechange.php">
                                 <i class="icon-pencil"></i> Swipe Function </a>
                         </li>
                         
                         <li>
                             <a href="home_app_change.php">
                                 <i class="icon-pencil"></i> Home App Change </a>
                         </li> -->

                        <li>
                            <a href="changeusername.php">
                                <i class="icon-pencil"></i> Change Username </a>
                        </li>

                        <li>
                            <a href="changeemail.php">
                                <i class="icon-pencil"></i> Change Email </a>
                        </li>

                        <li>
                            <a href="changepassword.php">
                                <i class="icon-pencil"></i> Change Password </a>
                        </li>

                        <li>
                            <a href="logout.php">
                                Logout</a>
                        </li>
                    </ul>
                </li>

                <?php
            }
            ?>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->