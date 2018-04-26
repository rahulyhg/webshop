'use strict';
/** 
 * controllers used for the login
 */
app.controller('profileCtrl', function ($rootScope, $scope, $http, $location,$timeout, $q, $window, userService, Upload, $state) {

    
$scope.data = {};
$scope.user = {};

//$scope.login();
//alert('a');
$window.scrollTo(0, 0);
$scope.getCurrentUserType();  
//alert($scope.current_user_type);
console.log("aa",$scope.current_user_type);

//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);
if (!$window.localStorage["userInfo"]) { 
	//alert("zz");
	$state.go('frontend.home');
	//alert("Login Required");
	return false;
	}



var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;

userService.getAccountDetails(userInfo.user_id).then(function(response) {
		
	
	if(response.Ack == '1') {
				$scope.user.full_name=response.UserDetails.full_name;
				$scope.user.email=response.UserDetails.email;
                                $scope.user.username=response.UserDetails.username;                                
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
                                $scope.user.profile_image=response.UserDetails.profile_image;                                
				//$scope.user.location=response.UserDetails.location;
				//$scope.user.address=response.UserDetails.address;
				//$scope.user.license_no=response.UserDetails.license_no;
				//$scope.user.license_expired_on=response.UserDetails.license_expired_on;
				
              }else{
				  
				$scope.user.full_name='';
				$scope.user.email='';
                                $scope.user.username='';
				$scope.user.address='';
				$scope.user.user_id='';
				$scope.user.phone='';
                                $scope.user.profile_image='';
				//$scope.user.location='';
				//$scope.user.address='';
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
        $window.location.reload();
		} else {
			
	alert('Error !!!!');			
			}
																	   
       }, function(err) {
         console.log(err); 
    }); 	
			
};









	
	
	
});

