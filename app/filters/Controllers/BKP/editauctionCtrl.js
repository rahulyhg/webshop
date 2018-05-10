'use strict';
/** 
 * controllers used for the login
 */
app.controller('editauctionCtrl', function ($rootScope, $scope, $http, $location,$timeout, $window, userService,$state, $stateParams) {

    
$scope.data = {};
$scope.auc = {};

$scope.getCurrentUserType();   

// alert('dd22');



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





userService.auctionDetails($stateParams.id).then(function(response) {								   

	
	if(response.Ack == '1') {
  		 $scope.auctionDetails=response.auctionDetails;
  		 //console.log('HHHH',$scope.auctionDetails);
  		 $scope.auc.title = response.auctionDetails.name;
  		 $scope.auc.description = response.auctionDetails.description;
  		 $scope.auc.price = response.auctionDetails.price;
  		 $scope.auc.offer_price = response.auctionDetails.offer_price;                 
                 $scope.auc.start_date = response.auctionDetails.start_date;
                 $scope.auc.end_date = response.auctionDetails.end_date;
                 $scope.auc.auction_image = response.auctionDetails.auction_image;
  		 
  		 //$scope.user.date = response.JobDetails.date;
  		// console.log($scope.user.payrate);
		} else {
			
	//alert('Error !!!!');			
			}
	
																	   
       }, function(err) {
         console.log(err); 
    });
    




$scope.editAuction = function(auc) {
    var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
    //alert('dd');
    //exit;
    //document.getElementById('closeModalButton').click();
      userService.editAuction(auc,$stateParams.id).then(function(response) {
        
        if(response.Ack == '1') {

	alert('Updated Successfully');
        $window.location.href = '#/auctionlist';
	
		} 
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};

	
	
	
});

