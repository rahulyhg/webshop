'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('NotificationSettingCtrl', function ($rootScope, $scope, $http, $location,$timeout, $q, userService,$window,Upload,$state) {
    
    if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
    
 $window.scrollTo(0, 0);
$scope.data = {};
$scope.user2 = {};

$scope.getCurrentUserType();   
//console.log($scope.current_user_type);




      var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	  $scope.user_id=userInfo.user_id;
	
       

  userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	console.log("zzz ",response);  
	if(response.Ack == '1') {

				$scope.user2.fname=response.UserDetails.fname;
				$scope.user2.lname=response.UserDetails.lname;
				$scope.user2.gender=response.UserDetails.gender;
				$scope.user2.email=response.UserDetails.email;
				$scope.user2.address=response.UserDetails.address;
				$scope.user2.user_id=response.UserDetails.user_id;
				$scope.user2.phone=response.UserDetails.phone;
				$scope.user2.location=response.UserDetails.location;
                                $scope.user.business_type=response.UserDetails.business_type;
				$scope.user2.city=response.UserDetails.city;
				$scope.user2.state=response.UserDetails.state;
				$scope.user2.country=response.UserDetails.country;
				$scope.user2.zip=response.UserDetails.zip;
				$scope.user2.address=response.UserDetails.address;
				$scope.user2.type=response.UserDetails.user_type;
				$scope.user2.sale_notify=response.UserDetails.sale_notify;
				$scope.user2.new_message_notify=response.UserDetails.new_message_notify;
				$scope.user2.review_notify=response.UserDetails.review_notify;
                                $scope.user2.auction_notify=response.UserDetails.auction_notify;
                                $scope.user2.add_product_notify=response.UserDetails.add_product_notify;
				$scope.user2.subscription_notify=response.UserDetails.subscription_notify;
                                
                                
              }else{
				  
				$scope.user2.fname='';
				$scope.user2.lname='';
				$scope.user2.gender='';
				$scope.user2.email='';
				$scope.user2.address='';
				$scope.user2.user_id='';
				$scope.user2.phone='';
				$scope.user2.location='';
				$scope.user2.city="";
				$scope.user2.state="";
				$scope.user2.country="";
				$scope.user2.zip="";
				$scope.user2.address='';
				$scope.user2.sale_notify='0';
				$scope.user2.new_message_notify='0';
				$scope.user2.reviewnotify='0';
				$scope.user2.subscription_notify='0';
			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
        
   
$scope.notificationsetting = function(user2){
    
    console.log(user2);
    //return false;

  
             userService.notifysetting(userInfo.user_id,user2).then(function(response) {
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    swal('Updated Successfully.','','success');
                    //$window.location.reload()
                    $scope.isExists=1;
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}


});

