'use strict';
/** 
 * controllers used for the login
 */
app.controller('detailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,$state, userService) {

    
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
//alert('a');
//$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';


//var a= $window.localStorage['gymiid'];
//alert("zz");
//alert($window.localStorage['day']);
 //alert($window.localStorage['clid']);




userService.allPlanDetails().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.PlanListing=response.PlanListing;
                
		} else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});







$scope.getpaydetails = function(plantype,price){
            
            //alert();
            $window.localStorage['plantype']=plantype;
            $window.localStorage['price']=price;
            
            $state.go('frontend_other.payment'); 
	
        //alert(gymid);
	 

	 
}
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

