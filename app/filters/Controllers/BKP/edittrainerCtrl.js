'use strict';
/** 
 * controllers used for the login
 */
app.controller('edittrainerCtrl', function ($rootScope, $scope, $http, $location,$timeout, $window, userService,$state, $stateParams) {

    
$scope.data = {};
$scope.user = {};

$scope.getCurrentUserType();   

// alert('dd22');




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



$scope.editTrainer = function(user) {
    var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
    //alert('dd');
    //exit;
    //document.getElementById('closeModalButton').click();
      userService.editTrainer(user,$stateParams.id).then(function(response) {
        
        if(response.Ack == '1') {
	alert('Updated Successfully');
        $window.location.href = '#/trainerlist';
	
		} 
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};








	  userService.trainerDetails($stateParams.id).then(function(response) {
																	   

	
	if(response.Ack == '1') {
  		 $scope.trainerDetails=response.trainerDetails;
  		// console.log($scope.jobDetails);
  		 $scope.user.name = response.trainerDetails.name;
  		 $scope.user.email = response.trainerDetails.email;
  		 $scope.user.phone = response.trainerDetails.phone;
  		 $scope.user.txt_pass = response.trainerDetails.txt_pass;
                  $scope.user.trainer_image = response.trainerDetails.trainer_image;
  		 
  		 //$scope.user.date = response.JobDetails.date;
  		// console.log($scope.user.payrate);
		} else {
			
	//alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
         console.log(err); 
    }); 




	
	
	
});

