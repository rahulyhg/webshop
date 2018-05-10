'use strict';
/** 
 * controllers used for the login
 */
app.controller('order_detailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService, $stateParams,NgMap) {

    
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




$scope.order_id=$stateParams.id;
   
        userService.orderHistoryDetails($scope.order_id).then(function(response) {

	console.log("vv",response);
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
	
		$scope.allordersListing=response.allorders;
                $scope.allordersDet=response.orders;

        } else {

                }
	

	}, function(err) {
	console.log(err); 
});







/*
$scope.gymlist = function(){    
$state.go('frontend_other.gymlist');
}
*/


//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//alert(encodedString);	





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
	
	NgMap.getMap().then(function(map) {

	console.log(map);
    console.log(map.getCenter());
    console.log('markers', map.markers);
    console.log('shapes', map.shapes);
  });
});

