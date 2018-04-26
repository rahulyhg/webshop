'use strict';
/** 
 * controllers used for the login
 */
app.controller('gymlistofferCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, userService) {
    

    
$scope.data = {};
$scope.user = {};
//alert('a');
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
//console.log($scope.current_user_type);

//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);

userService.gymAuction().then(function(response) {
   
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.all_auction=response.all_auction;
		//console.log($scope.all_gyms);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});        
        
	
});

