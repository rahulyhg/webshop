'use strict';
/** 
 * controllers used for the login
 */
app.controller('listordergymCtrl', function ($rootScope, $scope, $http, $location,$timeout,$templateCache,$window,userService,$state,$stateParams) {

  $scope.data = {};
$scope.user = {};
//alert('a');

 if (!$window.localStorage["userInfo"]) { 
	$state.go('frontend.home');
	return false;
	} 

$scope.getCurrentUserType();



if($scope.current_user_type ==1) {
	$scope.user.membership_id="3";
}

else {
	$scope.user.membership_id="2";
}

//alert($stateParams.id);

//console.log("aa",$scope.current_user_type);  
 $templateCache.removeAll();  


 
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


//$scope.listorder = function(){

var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;


userService.orderlistgym(userInfo.user_id).then(function(response) {
    
    //console.log('Testing');
   
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.orderList=response.orderList;
		//console.log($scope.all_trainer);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
//    };
    
    


	

 	
    

 
 
});

