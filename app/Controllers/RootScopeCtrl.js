app.controller("RootScopeCtrl", function ($scope,$rootScope, $location, $rootScope, $http, $state, $window, $q, $templateCache, $interval, userService,Upload,$timeout) {

$scope.search={};
$scope.searchsubmitvariable='';
$scope.myVarhide=false;
$scope.is_fav='';
    //$scope.mobileverify = '';
    if($window.localStorage["language"] == 2){
    $window.localStorage["language"] = 2;
    $scope.lang= 2 ;
    $scope.selectedlanguage = 'Arabic'
 
    }else{
    $window.localStorage["language"]=1;
    $scope.lang= 1;
    $scope.selectedlanguage = 'English'
   
    }
     $scope.myVar ='';
    
    if($window.localStorage["currency"] == '' || $window.localStorage["currency"] == undefined){
       $scope.selectedCurr = 'KWD';
       $window.localStorage["currency"] = 'KWD';
      // alert();
    }else{
       // $window.localStorage["currency"] = 'KWD'
        $scope.selectedCurr = $window.localStorage["currency"];
       // alert($window.localStorage["currency"]);
    }
    
    if($window.localStorage["keyword"]){
	$scope.search.brandName=$window.localStorage["keyword"];
        $window.localStorage["keyword"] ='';
}else{
	$scope.search.brandName='';
        $window.localStorage["keyword"]='';
}
    //alert($scope.lang);
    $scope.menuVisible = false;
    $scope.swipeValue = true;
    $scope.loader = true;
     $scope.language= '';
     userService.listbrand().then(function(response) {
       // alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('brandsList',response);
		$scope.brandsList=response.brandlist;
		
                
		}
		else{
 		
		}
	
	
																  
	}, function(err) {
         console.log(err); 
    });
    
    userService.listshops().then(function(response) {
       // alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('vendorlist',response);
		$scope.vendorlist=response.shopOwners;
		
                
		}
		else{
 		
		}
	
	
																  
	}, function(err) {
         console.log(err); 
    });
    
    userService.getproductpictures().then(function(response) {
        
       // $scope.specia_auction_image=response.shopOwners;
         $scope.imageSpecialauction =response.imageSpecialauction;
        $scope.imagetopmodel = response.imagetopmodel;
        $scope.imageWomenwatch = response.imageWomenwatch;
        $scope.imageCertifiedwatch = response.imageCertifiedwatch;
       // alert('imageSpecialauction=>'+$scope.imageSpecialauction+'imagetopmodel=>'+$scope.imagetopmodel+'imageWomenwatch=>'+$scope.imageWomenwatch);
        
            
	}, function(err) {
		//swal('Error found!!','','error');
         console.log(err); 
    });
    
   /* userService.getmaxprice2().then(function(response) {
    // alert();

		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.maxprice=response.maxprice;
                $scope.minprice=response.minprice;
                //$scope.amount_min = response.maxprice;
                
                $scope.search.amount_min=$scope.minprice;
                 $scope.minprice=response.minprice;
                $scope.search.amount_max=$scope.maxprice;
                $scope.amount_min = $scope.search.amount_min;
                $scope.amount_max = $scope.search.amount_max;
                $rootScope.amount_max = $scope.search.amount_max;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});*/
    
    
    $scope.showMenu = function () {
        $scope.menuVisible = !$scope.menuVisible;
    };
	  if($window.localStorage["language"]){
            $scope.lang=$window.localStorage["language"];
            //alert($scope.lang);
        }else{
            $window.localStorage["language"] = '';
        }


$templateCache.removeAll();

$scope.user={};
$scope.user.user_type_select='';







	
$scope.getCurrentUserType = function(){

//alert('a');
var current_user_login='';	
 if ($window.localStorage["userInfo"]) {
     $scope.current_user_login='1';
     var userInfo = JSON.parse($window.localStorage["userInfo"]);
     
     
if(userInfo.user_type=='1'){
        $window.localStorage["userType"]='1';
        $scope.current_user_type='1';
        }
        else if(userInfo.user_type=='2'){
        $window.localStorage["userType"]='2';
        $scope.current_user_type='2';
        }
        else{
        $window.localStorage["userType"]='3';
        $scope.current_user_type='3';
        }
console.log($scope.current_user_type);     
     
     
      
     
     
userService.getAccountDetails(userInfo.user_id).then(function(response) {

//console.log('Avik');

if(response.Ack == '1') {        
        
        $scope.sidebar_fname=response.UserDetails.fname;
        $scope.sidebar_address=response.UserDetails.address;
        $scope.sidebar_lname=response.UserDetails.lname;
        $scope.sidebar_image=response.UserDetails.profile_image;
        $scope.current_loggedin_user_type=response.UserDetails.user_type;
        $scope.noti_count=response.UserDetails.noti_count;
        
        console.log($scope.sidebar_lname);

      }else{

                        $scope.sidebar_fname='';
                        $scope.sidebar_lname='';
                        $scope.sidebar_address='';
                        $scope.sidebar_email='';
                        $scope.sidebar_image='';

                  }

console.log(current_user_login); 



}, function(err) {
 console.log(err); 
}); 


//$scope.getCounters();
}     
     
     
     
     
     
     
     
     
     

                        
/*userService.notiCount(userInfo.user_id).then(function(response) {

		
		$scope.isExists=response.Ack;


		if(response.Ack == '1') {
		$rootScope.headernotificmsg=response.msg;
		 
		} else {
		}	
	
	
				   
	}, function(err) {
	console.log(err); 
	});   */                     
                        

   
   
     
     
 }
 

	

$scope.getCounters = function(){
	
	var userInfo = JSON.parse($window.localStorage["userInfo"]);
  userService.getCounters(userInfo.user_id).then(function(response) {
	
	if(response.Ack == '1') {
	
	$scope.cart_count=response.cart_count;
	$scope.notification_count=response.notification_count;
	$scope.pending_order_count=response.pending_order_count;
	$scope.accepted_order_count=response.accepted_order_count;
	

	
	} else {	
	}
	
														   
 }, function(err) {
         console.log(err); 
    }); 	
	
}

	$scope.cartBagCount = function(){
               var userInfo = JSON.parse($window.localStorage["userInfo"]);
     
userService.cartBagCount(userInfo.user_id).then(function(response) {
		
                
		$scope.isExists=response.Ack;

		if(response.Ack == '1') {
		$rootScope.headerCartCount=response.count;		 
		} else {
		}
				   
	}, function(err) {
	console.log(err); 
	});     
     
}  


$scope.notiCount = function(){
         var userInfo = JSON.parse($window.localStorage["userInfo"]);                 
userService.notiCount(userInfo.user_id).then(function(response) {
    //alert('OK');
		
		$scope.isExists=response.Ack;
		//alert(response.blockstatus);

		if(response.Ack == '1') {
		$rootScope.headernotificmsg=response.count;
		 
		} else {
		}	
	
	
				   
	}, function(err) {
	console.log(err); 
	});                        
                        
}
   
	
	
	
	$scope.login = function(user) {

    //document.getElementById('closeModalButton').click();
    userService.login(user).then(function(response) {
      console.log(response); 
 if(response.Ack == '1') {
       $window.sessionStorage.isLoggedIn=1;
       
       $scope.current_user_login='1';

		userInfo = {
		user_id: response.UserDetails.user_id,
		fname: response.UserDetails.fname,
		lname: response.UserDetails.lname,
		user_type: response.UserDetails.user_type,
		email: response.UserDetails.email,
		//username : response.UserDetails.username,
                is_stripe : response.UserDetails.stripe_type,
		address : response.UserDetails.address,
		phone: response.UserDetails.phone,
		device_type: response.UserDetails.device_type,
		device_token_id: response.UserDetails.device_token_id,
		lat: response.UserDetails.my_latitude,
		lang: response.UserDetails.my_longitude,
		profile_image : response.UserDetails.profile_image,
                user_payment : response.UserDetails.user_payment,
                
                country : response.UserDetails.country,
                state : response.UserDetails.state,
                city : response.UserDetails.city,
		};
		$window.localStorage["userInfo"] = JSON.stringify(userInfo);

		 if(response.UserDetails.user_id!=''){
		 	$window.localStorage["userId"]=response.user_id;
		 	//alert($window.localStorage["userId"]);
                       // $window.location.reload();
                       
                       if(response.UserDetails.user_type==1)
                       {
                      // $state.go('frontend.my_account'); 
                   }
                   else
                   {
                      //  $state.go('frontend.vendordashboard'); 
                   }
 
 	
        
     $timeout( function(){
         
          $window.location.reload();
        }, 1000 );
       
}
 }else if(response.Ack == '4'){
     $scope.mobileverify = response.mobileverify;
     $scope.mobilenoforlogin= response.mobilenoforlogin;
     $('#login').modal('hide'); 
     $state.go('frontend.mobileverify');
 }
 else
 {
      swal(response.msg,'','error');    
 }


    }, function(err) {
		//alert('Invalid Login. Please Try Again');
                swal("Invalid Login. Please Try Again!", "", "error");
         console.log(err); 
    }); 
};




$scope.signup = function(user) {
$scope.loader = false;
    userService.signup(user).then(function(response) {
         console.log('responsesss',response)
        if(response.Ack == '1') {
           
            $scope.loader = true;
            
	//alert('Successfully Registered.The account activation email has been sent.');	
        
        if(response.smsstatus == 1){
            
            swal("Successfully Registered.The account activation email has been sent.", "", "success")
.then((value) => {
    if(value == true){
        $('#exampleModal').modal('hide');
            $window.location.href = response.smslink;
    }
  //swal(`The returned value is: ${value}`);
});
           // swal("Successfully Registered.The account activation email has been sent.", "", "success");
//            $('#exampleModal').modal('hide');
//            $window.location.href = response.smslink;
        }
        else{
            
            swal("Please Signup Again.", "", "error").then((value) => {
            if(value == true){
                //$('#exampleModal').modal('hide');
                    $state.go('frontend.signup');
                    // $window.location.reload();
                   // $window.location.href = response.smslink;
            }
            
            // swal("Please Signup Again.", "", "error");
            
        });
            
	 //$window.location.reload();
		} 
            }
                else
                {
                  swal(response.msg,'','success');   
                  $scope.loader = true;
                }
        
        
        
        
	}, function(err) {
		swal('Error Occured.','','error');
                $scope.loader = true;
         console.log(err); 
    }); 
};


        
        
$scope.forget = function(user) {
        
    userService.forgotpass(user).then(function(response) {
        
        
            if(response.Ack == '1') {
               
                
                  swal('Mail Send Successfully','','success')
                .then((value) => {
                    if(value == true){

                           $window.location.reload();
                    }

                });
                
                // $window.location.reload();
            } else {
                
                 swal('Email not found in our database','','error')
                .then((value) => {
                    if(value == true){

                           $window.location.reload();
                    }

                });
                //swal('Email not found in our database','','error');
            }
        
            
	}, function(err) {
		swal('Error found!!','','error');
         console.log(err); 
    });
    
};


/*	$scope.signup = function(user) {
		console.log(user); return false;
    //document.getElementById('closeModalButton').click();
    userService.signup(user).then(function(response) {
										   
										   
										   
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    }); 
}; */


//$scope.reload = function() {
//    $state.go('frontend.home', {}, {reload: 'frontend.home'},200);                
//} 



  /* $scope.logout = function(){

  	alert("aa");
	
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

    userService.logout(userInfo.user_id).then(function(response) {
                                
		$window.localStorage["userInfo"]='';
                $scope.current_user_login='';
		$window.localStorage.clear();
                //$window.location.reload();                
                $state.go('frontend.login',{},{reload:true, inherit: false});
                
                //$window.location.href = '#/home';
														   
														   
 }, function(err) {
         console.log(err); 
    }); 
   
	  
  }  */

      $scope.getbrandname = function(){



      	var   brand=angular.element(document.getElementById("brandname")).val();
      	//$scope.brandName =brand.val();
      	//alert(brand);
	  //console.log($scope.brandName);
if(brand){
    //$scope.keyword =brand;
    //alert(location.path());
    $scope.keyword=brand;
    $state.go('frontend.productlisting');
     // $window.location.href = siteurl.'/searchListing';
    
      
}else{
    $window.localStorage["keyword"]='';
    $state.go('frontend.productlisting');
     
}
	 /*  userService.getProductsByBrand(brand).then(function(response) {
		
                console.log("pp "+response.data);
	 if(response.Ack == '1') {
	 			//alert(response.brand[0]);
				//alert (response.msg);
                swal ('Added to your Watchlist','','success');
				//$state.go('frontend.wishlist');
                //$window.location.reload();                
                                
                              
                                
                }
  });*/
}


    $scope.logout = function(){

  //	alert("aa");
	
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

   // userService.logout(userInfo.user_id).then(function(response) {
                                
		$window.localStorage["userInfo"]='';
                $scope.current_user_login='';
		$window.localStorage.clear();
                            
                //$state.go('frontend.login',{},{reload:true, inherit: false});
                
                $window.location.href = '#/home';
                $window.location.reload();    
														   
														   
// }, function(err) {
  //       console.log(err); 
  //  }); 
   
	  
  } 
  
  
 /* 
userService.homeSettingsSection().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.homeSettings=response.homeSettings;
                //console.log('SUMAN',$scope.homeSettings);
		} else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});  
  
  */
  
  
  $scope.addwishlist = function(product_id,owner_id){
	 
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
	 

    userService.addFavWishlist(userInfo.user_id,product_id,owner_id).then(function(response) {
		
                
	 if(response.Ack == '1') {
				lert ('response.msg');
                //alert ('Added to your Watchlist');
				//$state.go('frontend.wishlist');
               // $window.location.reload();                
                $scope.is_fav1= response.is_fav;             
                              
                                
                }
                
        
        else {
//alert ('Already Added in your wishlist'); 
              //alert('Error !!!!');
             // $window.location.reload();  
             $scope.is_fav1= response.is_fav;
              }
																	
	}, function(err) {
           // alert ('Already Added in your wishlist');
            //$window.location.reload();
         console.log(err); 
    });
	 
} 

$scope.addlike = function(product_id,owner_id){
	 
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
	 

    userService.addlike(userInfo.user_id,product_id,owner_id).then(function(response) {
		
                
	 if(response.Ack == '1') {
				//alert (response.msg);
                //alert ('You liked The Product');
				//$state.go('frontend.wishlist');
                $window.location.reload();                
                                
                              
                                
                }
                
        
        else {
//alert ('Already Added in your like'); 
              //alert('Error !!!!');
              $window.location.reload();  
              }
																	
	}, function(err) {
           // alert ('Already Added in your wishlist');
            $window.location.reload();
         console.log(err); 
    });
	 
}
  
  if ($window.localStorage["userInfo"]!="") {

$interval(function () {
	  $scope.cartBagCount();
	}, 4000);
        
        
        
$interval(function () {
	  $scope.notiCount();
	}, 4000);        
        
        
}  
  

	
	$scope.goToCart = function(){
	$state.go('frontend.cart');
	}
	
	$scope.goToCheckout = function(){
	$state.go('frontend.checkout');
	}
	
	
	$scope.goToPaymentNow = function(){
	$state.go('frontend.pay_now');
	}
	
	$scope.viewDetails = function(id){
	$location.path('order_details/'+id);
	}
        

    
    if ($window.localStorage["appTitle"] != undefined && $window.localStorage["appTitle"] != null) {
        $rootScope.appTitle = $window.localStorage["appTitle"];

    }
    else {
        $rootScope.appTitle = "GMT24";
    }
	
	





 $scope.open_uploader = function(){

 	//alert("zzz");
	// console.log('aaaaaaaaa');
      document.querySelector('.sidbar_upload').click();       
  }
  
  
$scope.uploadFile = function(files) {


	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

 	
 	//$('#loadingmessage').show();
 	//$('#addsub').prop('disabled', true);
 
           var fd = new FormData();

    fd.append("profile_image", files[0]);
    fd.append("user_id",$scope.user_id);


        $http.post($rootScope.serviceurl+"updateProfilePhoto", fd, {
        headers: {'Content-Type': undefined },
        transformRequest: angular.identity
    }).then(function successCallback(response) {
    	//alert(response.data.image);
    	//$('#loadingmessage').hide('fast');

    	//$('#addsub').prop('disabled', false);
    	//console.log(response);

    	console.log("bb",response);

    	if(response.data.image !="") {
    	//	$scope.product.images=response.data.image; 
   		//$scope.product.imgpath =response.data.imgpath; 
   		//console.log(response.data.image);
		$window.localStorage["profile_image"]=response.data.image;

$window.location.reload();
		   // $scope.imglenght = $scope.product_img.length;


    	}
    	else {
    		swal("Image not supported","","error");

    	}

  }, function errorCallback(response) {
  	
  });        
             
     
   //  }  
        
        
        
    
       
 };


if($window.localStorage["language"] == 1){

userService.changeLaguage(1).then(function(response) {
	 if(response.Ack == '1') {
				
               $window.localStorage["language"] = 1;
                $scope.language = response.languages;
                                   
                }
                
        
        else {

              }
																	
	}, function(err) {
            
            $window.location.reload();
         console.log(err); 
    });

}else{
    userService.changeLaguage(2).then(function(response) {
	 if(response.Ack == '1') {
				
               $window.localStorage["language"] = 2;
                $scope.language = response.languages;
                                   
                }
                
        
        else {

              }
																	
	}, function(err) {
            
            $window.location.reload();
         console.log(err); 
    });
}

if($window.localStorage["language"] == ""){

userService.changeLaguage(1).then(function(response) {
	 if(response.Ack == '1') {
				
               $window.localStorage["language"] = 1;
                $scope.language = response.languages;
                                   
                }
                
        
        else {

              }
																	
	}, function(err) {
            
            $window.location.reload();
         console.log(err); 
    });

}else{
    //alert('else');
}





  $scope.selectedlaguage = function(laguage){
      //alert(laguage);
       
userService.changeLaguage(laguage).then(function(response) {
		
                
             
	 if(response.Ack == '1') {
		
                //alert ('Language changed to english');
                if(laguage == '1'){
                    $scope.selectedlanguage = 'English';
                   
                }else{
                  $scope.selectedlanguage = 'Arabic'  
                  
                }
                $window.localStorage["language"]= laguage;
                 //$scope.langu= laguage;
                $scope.language = response.languages;
                console.log('language',$scope.language ); 
                 $window.location.reload();            
                                
                              
                                
                }
                
        
        else {
//alert ('Language can not be changed'); 
              
              }
		
    
	}, function(err) {
            //alert ('Language can not be changed');
            //$window.location.reload();
         console.log(err); 
    });
         
    };


$scope.selectedCurrency = function(currency){
     
	
                if(currency == 'KWD'){
                     $window.localStorage["currency"] = 'KWD';
                     $scope.selectedCurr = $window.localStorage["currency"];
                   
                }else if(currency == 'AED'){
                 $window.localStorage["currency"] = 'AED';
                 $scope.selectedCurr = $window.localStorage["currency"];
                  
                }else if(currency == 'USD'){
                 $window.localStorage["currency"] = 'USD';
                 $scope.selectedCurr = $window.localStorage["currency"];
                  
                }else if(currency == 'OMR'){
                  $window.localStorage["currency"] = 'OMR'; 
                  $scope.selectedCurr = $window.localStorage["currency"];
                  
                }else if(currency == 'QAR'){
                  $window.localStorage["currency"] = 'QAR'; 
                  $scope.selectedCurr = $window.localStorage["currency"];
                  
                }else if(currency == 'SAR'){
                 $window.localStorage["currency"] = 'SAR';
                 $scope.selectedCurr = $window.localStorage["currency"];
                  
                }else if(currency == 'EUR'){
                 $window.localStorage["currency"] = 'EUR'; 
                 $scope.selectedCurr = $window.localStorage["currency"];
                  
                }
                else if(currency == 'GBP'){
                 $window.localStorage["currency"] = 'GBP'; 
                 $scope.selectedCurr = $window.localStorage["currency"];
                  
                }else{
                     $window.localStorage["currency"] = 'KWD'; 
                     $scope.selectedCurr = $window.localStorage["currency"];
                }
              
                 $window.location.reload();            
          
         
    };

userService.sociallinks().then(function(response) {
	 if(response.Ack == '1') {
		//alert(response.sociallinks);		
               //$window.localStorage["sociallinks"] = 1;
               $scope.sociallinks = response.sociallinks;
               
                
                                   
                }
                
        
        else {

              }
																	
	}, function(err) {
            
            //$window.location.reload();
         console.log(err); 
    });
	
	
userService.contactinfo().then(function(response) {
	 if(response.Ack == '1') {
		
               $scope.contactinfo = response.contactinfo;
               
                                   
                }
               
        else {

              }
																	
	}, function(err) {
            
         console.log(err); 
    });	
    

userService.listcountry().then(function(response) {
           
		$scope.isExists=1;
		if(response.Ack == '1') {
                  
                    $scope.isExists=1;
                  
		$scope.countrylist=response.countrylist;
              
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});
       
    
    
    
     $scope.state = function (c_id) {
        
        userService.liststate(c_id).then(function (response) {
           
            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);
               
                $scope.isExists = 1;
               
                $scope.statelist = response.statelist;
                $scope.phonecode = response.phonecode;
              

            } else {
                console.log('ppp');
                $scope.isExists = 0;
            }

        }, function (err) {
            console.log(err);
        });

    }
    
        
     $scope.sendtoproduct = function(link){
         if(link == 'sp_auction'){
          $scope.is_special_auction='1'; 
         // $window.localStorage["keyword"] ='';
          $state.go('frontend.searchListing');
          $window.scrollTo(0, 0);
         }
         
         if(link == 'top_product'){
          $scope.top_prodct='1';
            //$windos.location.href='#/productlisting/';
          $state.go('frontend.productlisting');
          $window.scrollTo(0, 0);
         }
         
         if(link == 'top_seller'){
          //$scope.top_user_vendor='1'; 
          $window.localStorage["top_user_vendor"] ='1';
          $state.go('frontend.allshopDetails');
          $window.scrollTo(0, 0);
         }
         
         if(link == 'Female'){
          $scope.gender='Female'; 
          $state.go('frontend.productlisting');
           $window.scrollTo(0, 0);
         }
         
    }; 
    
    
       $scope.autofield = function(word){
        
       // alert(word);
    userService.autofield(word).then(function(response) {
           
		$scope.isExists=1;
		if(response.Ack == 1) {
                  
                    $scope.isExistsfield=1;
                    $scope.myVarhide=true;
                    $scope.autofieldlist=response.autofieldlist;
              
		} else {
                    
                    $scope.isExistsfield=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
     }
    
    $scope.selectvalue = function(status){
       // alert(status);
    $scope.search.brandName = status;
    //$scope.myVar = status;
   $scope.myVarhide=false;
   //alert($scope.myVarhide);
 }
    
     $scope.searchsubmit = function(search){
        var search_submit = search.brandName;
    //$scope.search.brandName = status;
    //$scope.myVar = status;
    if($state.current.name != 'frontend.productlisting'){
        
        $scope.searchsubmitvariable = search_submit;
        $state.go('frontend.productlisting'); 
        //alert('on product listing1')
    }else{
       $scope.searchsubmitvariable = search_submit;
       $scope.searchListing();
    }
   
 } 
    
   
       
      /*  $scope.stateName = null;
        
        $scope.autoCompleteOptions = {
            minimumChars: 1,
            data: function (searchText) {
                
                
                 userService.autofield(searchText).then(function(response) {
           
                    console.log('sp',response);
		
                        searchText = searchText.toUpperCase();

                        // ideally filtering should be done on the server
                        var states = _.filter(response.autofieldlist, function (state) {
                            console.log('sp11',state);
                            return state.field.startsWith(searchText);
                        });
                        
                        return _.map(states, 'field');
				   
                    });

                        }
                    }*/

    
    
    
    
    
    
   
    
    
});
