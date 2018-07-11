'use strict';
/** 
 * controllers used for the login
 */
app.controller('wishlistCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
$scope.data = {};
$scope.user = {};
 $window.scrollTo(0, 0);
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

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}



 
$scope.wishlist = function(){
   // alert('hii');

 userService.wishlist().then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.favouriteProductList=response.favouriteProductList;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
        



	
});

