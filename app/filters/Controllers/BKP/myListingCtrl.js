'use strict';
/** 
 * controllers used for the login
 */
app.controller('myListingCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, restaurentService) {

    
$scope.data = {};
$scope.user = {};
//alert('a');
//$scope.getCurrentUserType();   
//console.log($scope.current_user_type);  		

	
	/* restaurentService.homeResturants().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.resturantsList=response.resturantsList;	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); */
	
});

