'use strict';
/** 
 * controllers used for the login
 */


app.controller('newauctionCtrl', function ($rootScope, $state, $scope, $http, $location,$timeout, $window, userService, $stateParams,Upload) {

    
$scope.data = {};
$scope.user = {};

$window.scrollTo(0, 0);
$scope.getCurrentUserType();


var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;


$scope.addAuction = function(auc) {
    //console.log('CTRL',auc);    
    //document.getElementById('closeModalButton').click();
    var userInfo = JSON.parse($window.localStorage["userInfo"]);	
    $scope.user_id=userInfo.user_id;    
    
    
    userService.saveAuctionDetails(auc,userInfo.user_id).then(function(response) {
        
        
        if(response.Ack == '1') {
            alert(response.msg);
            //$state.go('frontend.auctionlist');
            $window.location.href = '#/auctionlist';
        }
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};




userService.getAccountDetails(userInfo.user_id).then(function(response) {
		
	
	if(response.Ack == '1') {
				$scope.user.full_name=response.UserDetails.full_name;
				$scope.user.email=response.UserDetails.email;
                                $scope.user.username=response.UserDetails.username;                                
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
                                //$scope.user.auction_image=response.UserDetails.auction_image;
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
                                //$scope.user.auction_image='';
				//$scope.user.location='';
				//$scope.user.address='';
				//$scope.user.license_no='';
				//$scope.user.license_expired_on='';	  
				  
			  }	
														   
 }, function(err) {
         console.log(err); 
    });








	
	
	
});

