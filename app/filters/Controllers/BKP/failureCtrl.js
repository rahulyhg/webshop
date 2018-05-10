'use strict';
/** 
 * controllers used for the login
 */
app.controller('failureCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window) {

    
$scope.data = {};
$scope.user = {};

$scope.getCurrentUserType();   
//alert('a');
$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

var userInfo = JSON.parse($window.localStorage["userInfo"]);
var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
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

