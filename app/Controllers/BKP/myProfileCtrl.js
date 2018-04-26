'use strict';
/** 
 * controllers used for the login
 */
//app.controller('myProfileCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,) {

app.controller('myProfileCtrl', function ($rootScope, $scope, $http, $location,$timeout, $q, userService,$window,Upload) {
   
$scope.data = {};
$scope.user = {};
//alert('a');
//$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
	//$scope.fname=userInfo.fname;
	//console.log($scope.user_id);
	//console.log($scope.fname);
	
	userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	//console.log('Avik');
	
	if(response.Ack == '1') {
				$scope.user.fname=response.UserDetails.fname;
				$scope.user.lname=response.UserDetails.lname;
				$scope.user.email=response.UserDetails.email;
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
				$scope.user.about_me=response.UserDetails.about_me;
				//$scope.user.location=response.UserDetails.location;
				//$scope.user.address=response.UserDetails.address;
			//	$scope.user.license_no=response.UserDetails.license_no;
				//$scope.user.license_expired_on=response.UserDetails.license_expired_on;
				
              }else{
				  
				$scope.user.fname='';
				$scope.user.lname='';
				$scope.user.email='';
				$scope.user.address='';
				$scope.user.id='';
				$scope.user.phone='';
				//$scope.user.location='';
				$scope.user.address='';
				$scope.user.about_me='';
				//$scope.user.license_no='';
				//$scope.user.license_expired_on='';	  
				  
			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
	
	
	
	 	$scope.updateProfile = function(user){
			
	   userService.updateProfile(user).then(function(response) {
																	   
	
	
	if(response.Ack == '1') {
	alert('Data Updated');	
		} else {
			
	alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
         console.log(err); 
    }); 	
			
			}; 	
	
	

	
	

});


