app.controller("RootScopeCtrl", function ($scope, $location, $rootScope, $http, $state, $window, $q, $templateCache, $interval, userService) {
//    $scope.loggedindetails = myAuth.getAdminAuthorisation();
//
//    if ($scope.loggedindetails) {
//        if ($scope.loggedindetails.roleName.toLowerCase() == 'admin') {
//            $location.path("/admin/home");
//        }
//        else if ($scope.loggedindetails.roleName.toLowerCase() == 'staff') {
//            $location.path("/staff/home");
//        }
//    }
//    else {
//        $location.path("/home");
//    }
    
    
    $scope.menuVisible = false;
    $scope.swipeValue = true;

    $scope.showMenu = function () {
        $scope.menuVisible = !$scope.menuVisible;
    };
	


$templateCache.removeAll();

$scope.user={};
$scope.user.user_type_select='';







	
$scope.getCurrentUserType = function(){

//alert('a');
var current_user_login='';	
 if ($window.localStorage["userInfo"]) {
     $scope.current_user_login='1';
     var userInfo = JSON.parse($window.localStorage["userInfo"]);
     
     
if(userInfo.user_type.trim()=='1'){
        $window.localStorage["userType"]='1';
        $scope.current_user_type='1';
        }
        else if(userInfo.user_type.trim()=='2'){
        $window.localStorage["userType"]='2';
        $scope.current_user_type='2';
        }
        else{
        $window.localStorage["userType"]='3';
        $scope.current_user_type='3';
        }
//console.log($scope.current_user_type);     
     
     
     
     
     
userService.getAccountDetails(userInfo.user_id).then(function(response) {

//console.log('Avik');

if(response.Ack == '1') {        
        
        $scope.sidebar_name=response.UserDetails.full_name;
        $scope.sidebar_email=response.UserDetails.email;
        $scope.sidebar_username=response.UserDetails.username;                                
        $scope.sidebar_address=response.UserDetails.address;
        $scope.sidebar_user_id=response.UserDetails.user_id;
        $scope.sidebar_phone=response.UserDetails.phone;
        $scope.sidebar_is_stripe=response.UserDetails.stripe_type;
        $scope.sidebar_image=response.UserDetails.profile_image;
        

        console.log($scope.sidebar_lname);

      }else{

                        $scope.sidebar_fname='';
                        $scope.sidebar_lname='';
                        $scope.sidebar_email='';
                        $scope.sidebar_image='';

                  }

console.log(current_user_login); 



}, function(err) {
 console.log(err); 
}); 


//$scope.getCounters();
}     
     
     
     
     
     
     
     
     
     
//$scope.notiCount = function(){
                        
userService.notiCount(userInfo.user_id).then(function(response) {
    //alert('OK');
		
		$scope.isExists=response.Ack;
		//alert(response.blockstatus);

		if(response.Ack == '1') {
		$rootScope.headernotificmsg=response.msg;
		 
		} else {
		}	
	
	
				   
	}, function(err) {
	console.log(err); 
	});                        
                        
   //}
   
   
     
     
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


	
	
	
	
	$scope.login = function(user) {

    //document.getElementById('closeModalButton').click();
    userService.checkLogin(user).then(function(response) {
       // console.log(response); 

       $window.sessionStorage.isLoggedIn=1;
       
       $scope.current_user_login='1';

		userInfo = {
		user_id: response.UserDetails.id,
		fname: response.UserDetails.fname,
		lname: response.UserDetails.lname,
		//user_type: response.UserDetails.user_type,
		email: response.UserDetails.email,
		//username : response.UserDetails.username,
                is_stripe : response.UserDetails.stripe_type,
		address : response.UserDetails.address,
		phone: response.UserDetails.phone,
		device_type: response.UserDetails.device_type,
		device_token_id: response.UserDetails.device_token_id,
		lat: response.UserDetails.my_latitude,
		lang: response.UserDetails.my_longitude,
		profile_image : response.UserDetails.profile_image
		};
		$window.localStorage["userInfo"] = JSON.stringify(userInfo);

		//console.log(response.UserDetails.user_type.trim());
		
		//$scope.modal.hide();
		/* if(response.UserDetails.user_type=='S'){
		
		$window.localStorage["userType"]='S';
		//$state.go('frontend.my_account');	
		$location.path('my_account');	
		}
		else if(response.UserDetails.user_type.trim()=='D'){
		$window.localStorage["userType"]='D';
		$state.go('frontend.my_account');
		}
		else{
		$window.localStorage["userType"]='U';	
		$state.go('frontend.my_account'); 
		} */
		 if(response.UserDetails.user_id!=''){
		 	$window.localStorage["userId"]=response.user_id;
		 	//alert($window.localStorage["userId"]);

 	$state.go('frontend.myprofile'); 
}


    }, function(err) {
		alert('Invalid Login. Please Try Again');
         console.log(err); 
    }); 
};


	$scope.signup = function(user) {
    //document.getElementById('closeModalButton').click();
    userService.signup(user).then(function(response) {
										   
										   
										   
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    }); 
};


//$scope.reload = function() {
//    $state.go('frontend.home', {}, {reload: 'frontend.home'},200);                
//} 



  $scope.logout = function(){
	
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

    userService.logout(userInfo.user_id).then(function(response) {
                                
		$window.localStorage["userInfo"]='';
                $scope.current_user_login='';
		$window.localStorage.clear();
                //$window.location.reload();                
                $state.go('frontend.home',{},{reload:true, inherit: false});
                
                //$window.location.href = '#/home';
														   
														   
 }, function(err) {
         console.log(err); 
    }); 
   
	  
  }
  
  
  
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
        $rootScope.appTitle = "7seven";
    }
	
	
	
	
	
    


});
