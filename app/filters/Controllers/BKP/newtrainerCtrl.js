'use strict';
/** 
 * controllers used for the login
 */
app.controller('newtrainerCtrl', function ($rootScope, $scope, $http, $location,$timeout, $window, userService,$state, $stateParams) {

    
$scope.data = {};
$scope.user = {};

$window.scrollTo(0, 0);
$scope.getCurrentUserType();





var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;

userService.getAccountDetails(userInfo.user_id).then(function(response) {
		
	
	if(response.Ack == '1') {
				$scope.user.full_name=response.UserDetails.full_name;
				//$scope.user.email=response.UserDetails.email;
                               //$scope.user.username=response.UserDetails.username;                                
				$scope.user.address=response.UserDetails.address;
				//$scope.user.user_id=response.UserDetails.user_id;
				//$scope.user.phone=response.UserDetails.phone;
                                //$scope.user.profile_image=response.UserDetails.profile_image;                                
				//$scope.user.location=response.UserDetails.location;
				//$scope.user.address=response.UserDetails.address;
				//$scope.user.license_no=response.UserDetails.license_no;
				//$scope.user.license_expired_on=response.UserDetails.license_expired_on;
				
              }else{
				  
				$scope.user.full_name='';
				//$scope.user.email='';
                                //$scope.user.username='';
				$scope.user.address='';
				//$scope.user.user_id='';
				//$scope.user.phone='';
                               // $scope.user.profile_image='';
				//$scope.user.location='';
				//$scope.user.address='';
				//$scope.user.license_no='';
				//$scope.user.license_expired_on='';
				  
			  }	
														   
 }, function(err) {
         console.log(err); 
    });




// alert('dd22');
var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

$scope.addTrainer = function(user) {
    //alert('dd');
    //exit;
    //document.getElementById('closeModalButton').click();
    userService.addTrainer(user,userInfo.user_id).then(function(response) {
        
        if(response.Ack == '1') {
	alert('Added Successfully');
        $window.location.href = '#/trainerlist';
	
		} 
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};












	
	
	
});

