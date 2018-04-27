<?php $pagename = end(explode('/', $_SERVER['REQUEST_URI'])); ?>
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
 
 
      <div class="sidebar-scroll">
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
                        <a href="social.php">
                            <i class="icon-bulb"></i>
                            Manage Social Media</a>
                    </li>

                    <li>
                        <a href="cms.php">
                            <i class="icon-bulb"></i>
                            Manage CMS</a>
                    </li>

                    <!-- <li>
                        <a href="site_maintanance.php">
                            <i class="icon-bulb"></i>
                            SiteSetting</a>
                    </li> -->
                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-cogs"></i>
                      <span>Banner</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                     <li  <?php if ($pagename == 'add_banner.php') { ?>  class="active" <?php } ?>>
                        <a href="add_banner.php">
                            <i class="icon-home"></i>
                            Add Banner</a>
                    </li>



                    <li>
                        <a href="list_banner.php">
                            <i class="icon-basket"></i>
                            List Banner</a>
                    </li>

                  </ul>
              </li>
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-tasks"></i>
                      <span>Customer Say</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      
                    <li>
                        <a href="add_customer_say.php">
                            Add Customer Say</a>
                    </li>

                    <li>
                        <a href="list_customer_say.php">
                            List Customer Say</a>
                    </li>

                  </ul>
              </li>
             <!--  <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-th"></i>
                      <span>Advertisement</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                     <li>
                        <a href="add_add.php">
                            Add Advertisement</a>
                    </li>

                    <li>
                        <a href="list_add.php">
                            List Advertisement</a>
                    </li>

                  </ul>
              </li> -->
           <!--   <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-fire"></i>
                      <span>FAQ</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      
                    <li>
                        <a href="add_faq.php">
                            Add Faq</a>
                    </li>

                    <li>
                        <a href="list_faq.php">
                            List Faq</a>
                    </li>

                  </ul>
              </li> -->
              <li class="sub-menu">
                  <a class="" href="javascript:;">
                      <i class="icon-trophy"></i>
                      <span>User</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                     
                    <li>
                        <a href="search_user.php">
                            All User List</a>
                    </li>

                    <!--<li>
                        <a href="search_vendor.php">
                            List Sellers</a>
                    </li>-->
                  </ul>
              </li>
              <!-- <li class="sub-menu">
                  <a class="" href="javascript:;">
                      <i class="icon-map-marker"></i>
                      <span>City</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li>
                        <a href="add_city.php">
                            Add City</a>
                    </li>

                    <li>
                        <a href="list_city.php">
                            List City</a>
                    </li>
                  </ul>
              </li> -->
              <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-file-alt"></i>
                      <span>Products</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a href="add_category.php">Add Category</a></li>
                    <li><a href="list_category.php">List Category</a></li>
                    <!--<li><a href="add_subcategory.php">Add Sub Category</a></li>
                    <li><a href="list_subcategory.php">List Sub Category</a></li>-->
                    <!--<li><a href="list_store.php">List Stores</a></li>-->
                    <li><a href="list_product.php">Add Products</a></li>    
                    <li><a href="list_product.php">List Products</a></li>
                  </ul>
              </li>
             <!--<li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-file-alt"></i>
                      <span>Faq</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a href="add_faqcategory.php">Add Category</a></li>
                      <li><a href="list_faq_category.php">List Category</a></li>
                      <li><a href="add_faq.php">Add Faqs</a></li>
                      <li><a href="list_faq.php">List Faqs</a></li>
                  </ul>
              </li>-->
              
              
              
               <!--<li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-glass"></i>
                      <span>Orders</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a href="search_order.php">Orders</a></li>
                     <li><a href="monthly_chart.php"> Monthly order Chart</a></li>
                    <li> <a href="list_order_graph.php"> View Orders in Graph</a></li>

                      <li><a class="" href="500.html">500 Error</a></li> 
                  </ul>
              </li>-->

           <!--     <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-glass"></i>
                      <span>Promote</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                     <li class=" <?php echo ($pagename == 'promote.php') ? 'active' : ''; ?>">
                        <a href="promote.php">Promote</a>
                    </li>
                  </ul>
              </li>
            -->
            
            <!--<li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-rocket"></i>
                      <span>Promote</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
                      <li><a href="promote.php">Promote</a></li>
                     <li><a href="monthly_chart.php"> Monthly order Chart</a></li>
                    <li> <a href="list_order_graph.php"> View Orders in Graph</a></li>

                      <li><a class="" href="500.html">500 Error</a></li> 
                  </ul>
            </li>-->
            
            
             <li class="sub-menu">
                  <a href="javascript:;" class="">
                      <i class="icon-glass"></i>
                      <span>Settings</span>
                      <span class="arrow"></span>
                  </a>
                  <ul class="sub">
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
          </ul>
         <!-- END SIDEBAR MENU -->
      </div>
      </div>
      <!-- END SIDEBAR -->