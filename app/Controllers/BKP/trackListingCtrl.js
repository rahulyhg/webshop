'use strict';
/** 
 * controllers used for the login
 */
app.controller('trackListingCtrl', function ($rootScope, $scope, $http, $location,$timeout, orderService, $window, driverService) {

$scope.data = {};
$scope.user = {};
//alert('a');
$scope.getCurrentUserType();   
console.log($scope.current_user_type);  



	
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

    driverService.myRides(userInfo.user_id).then(function(response) {
	
	
	
		if(response.Ack=='1'){		
		
		console.log(response.allorders);
		$scope.allorders=response.allorders;
		$scope.isExists=response.Ack;
		}
		else{
		$scope.isExists=response.Ack;		
		}
	
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 

   
   
   
   
   
	  
  
   
});

