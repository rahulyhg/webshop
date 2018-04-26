'use strict';
/** 
 * controllers used for the login
 */
app.controller('typeCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,$state) {

$scope.data = {};
$scope.user = {};
//alert('a');
$scope.getCurrentUserType();   
console.log($scope.current_user_type);  


$scope.goToRestaurents = function(){	
	$state.go('frontend.restaurents');
}
   
   
$scope.goToOthers = function(){	
	$state.go('frontend.others');
}   
   
});

