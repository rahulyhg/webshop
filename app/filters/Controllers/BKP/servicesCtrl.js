'use strict';
/** 
 * controllers used for the login
 */
app.controller('servicesCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, userService) {

    
$scope.data = {};
$scope.user = {};

if ($window.localStorage["userInfo"]) {
var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
        $scope.getCurrentUserType();
}
else {
	var userInfo={};
	userInfo.user_id ="";
	//$scope.user_id=userInfo.user_id;
}


//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);




userService.ServiceSection().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.serviceSettings=response.serviceSettings;
                
		} else {
		}
				   
	}, function(err) {
	console.log(err); 
	});
        

userService.ServiceCategory().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.massageCategoryList=response.massageCategoryList;
                
		} else {
		}
				   
	}, function(err) {
	console.log(err); 
	}); 
        
	
	
});

