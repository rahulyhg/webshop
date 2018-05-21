'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('myAccountCtrl', function ($rootScope, $scope, $http, $location,$timeout, $q, userService,$window,Upload) {

$scope.data = {};
$scope.user = {};

$scope.getCurrentUserType();   
//console.log($scope.current_user_type);




  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

	

	
   userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	console.log("zzz",response);  
	if(response.Ack == '1') {
				$scope.user.fname=response.UserDetails.fname;
				$scope.user.lname=response.UserDetails.lname;
				$scope.user.gender=response.UserDetails.gender;
				$scope.user.email=response.UserDetails.email;
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
				$scope.user.location=response.UserDetails.location;
                                $scope.user.business_type=response.UserDetails.business_type;
				$scope.user.city=response.UserDetails.city;
				$scope.user.state=response.UserDetails.state;
				$scope.user.country=response.UserDetails.country;
				$scope.user.zip=response.UserDetails.zip;
                                $scope.user.secret_key=response.UserDetails.secret_key;
                                $scope.user.publish_key=response.UserDetails.publish_key;
				$scope.user.address=response.UserDetails.address;
                                $scope.user.ibanno=response.UserDetails.ibanno;
                                $scope.user.bankname=response.UserDetails.bankname;
                                $scope.user.language_preference=response.UserDetails.language_preference;
				
              }else{
				  
				$scope.user.fname='';
				$scope.user.lname='';
				$scope.user.gender='';
				$scope.user.email='';
				$scope.user.address='';
				$scope.user.user_id='';
				$scope.user.phone='';
				$scope.user.location='';
				$scope.user.city="";
				$scope.user.state="";
				$scope.user.country="";
				$scope.user.zip="";
				$scope.user.address='';
                                $scope.user.secret_key="";
				$scope.user.publish_key='';
                                $scope.user.ibanno='';
                                $scope.user.bankname='';
                                $scope.user.language_preference='';
				
				
				  
			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
	
	
	
	 	$scope.updateProfile = function(user){

	 		//console.log('hellouser',user); return false;
	 		var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

			//alert($scope.user_id)
	   userService.updateProfile(user,$scope.user_id).then(function(response) {
																	   
	console.log(response);
	
	if(response.Ack == '1') {
            //swal('Hello, World!');
	alert('Profile Updated');
        //user.fname='';
		} else {
			
	alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
        // console.log(err); 
    }); 	
			
			}; 	
	
	

	
	

});

