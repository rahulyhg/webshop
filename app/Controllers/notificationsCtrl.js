'use strict';
/**
 * controllers used for the login
 */
app.filter('browserSupportedDateFormat', function($filter) {

  // In the return function, we must pass in a single parameter which will be the data we will work on.
  // We have the ability to support multiple other parameters that can be passed into the filter optionally
  return function(input, optional1, optional2) {
//alert(input);
   //input = "2017-07-08 07:10:29";
if(input)
{
input = input.replace(/(.+) (.+)/, "$1T$2Z");
input = new Date(input).getTime();
input=$filter('date')(input, optional1);
return input;
}

  }

});
app.controller('notificationsCtrl', function ($rootScope, $scope, $http, $location, $timeout, $window, userService, $stateParams, $state) {
    
        if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
$scope.data = {};
$scope.user = {}; 
 $window.scrollTo(0, 0);
     $scope.getCurrentUserType();

	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

    userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	console.log('Avik');
	
	if(response.Ack == '1') {
				$scope.user.first_name=response.UserDetails.fname;
			 $scope.user.last_name=response.UserDetails.lname;
			 $scope.user.email=response.UserDetails.email;
			 $scope.user.phone=response.UserDetails.phone;
			
            
				
              }else{
				  
				$scope.user.first_name='';
			 $scope.user.last_name='';
			 $scope.user.email='';
			 $scope.user.phone='';
			
              
				  
			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
    
    
userService.notificationList(userInfo.user_id).then(function(response) {
//angular.element('#loadingmessage').show();

	//alert(response.Ack);

	console.log(response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.isExists=1;
			//angular.element('#loadingmessage').hide('fast');
		$scope.all_notifications=response.all_notifications;
		 userService.getAccountDetails(userInfo.user_id);
		

  } else {
      $scope.isExists=0;
  	//angular.element('#loadingmessage').hide('fast');
		}
	
				   
	}, function(err) {
	console.log(err); 
	});


 /*$scope.auctionFeesPayment = function(notification_type,auction_id){
   //  alert('hi');

        userService.auctionFees(notification_type,auction_id).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	
		// $scope.productLists=response.productList;
		alert("Payment has been done successfully.Wait for the admin to make your product GO LIVE.");
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    }; */
    
    
    $scope.auctionFeesPayment = function(id){
     //alert(id);
        
           $state.go('frontend.auctionuploadpayment',{product_id:id});

              
        }
    
    
    
    

});

