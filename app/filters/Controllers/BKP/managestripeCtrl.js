'use strict';
/** 
 * controllers used for the login
 */
app.controller('managestripeCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,userService) {

    
$scope.data = {};
$scope.user = {};

$scope.getCurrentUserType();   
//alert('a');
$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

var userInfo = JSON.parse($window.localStorage["userInfo"]);
var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';


        
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
    
    
    
var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

	
  userService.showStripeDetails(userInfo.user_id).then(function(response) {
																	   

	
	if(response.Ack == '1') {
  		 $scope.user.secret_key=response.UserDetails.secret_key;
  		// console.log($scope.jobDetails);
  		 $scope.user.publish_key = response.UserDetails.publish_key;
  		
  		
  		 
  		 //$scope.user.date = response.JobDetails.date;
  		// console.log($scope.user.payrate);
		} else {
			
	//alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
         console.log(err); 
    }); 
    
    
    $scope.updatedetails = function(user) {
       // console.log(user);
      //  return false;
    var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
    //alert('dd');
    //exit;
    //document.getElementById('closeModalButton').click();
      userService.updatedetails(user,userInfo.user_id).then(function(response) {
        
        if(response.Ack == '1') {
                alert('Updated Successfully');		
		} 
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};




//alert(encodedString);


	/*productService.homelistproducts().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.productList=response.productsList;
		console.log($scope.productList);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});*/


	/* productService.listProductsByCategory().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.productList=response.productsList;
		console.log($scope.productList);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); */
	
	
});

