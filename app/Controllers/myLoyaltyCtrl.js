'use strict';
/** 
 * controllers used for the login
 */
app.controller('myLoyaltyCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

   $window.scrollTo(0, 0);  
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

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}



 
$scope.myloyalty = function(){
   // alert('hii');

 userService.myloyalty().then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   
                    $scope.exists=1;
                    $scope.totalloyalty=response.total_loyalty;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                    $scope.totalloyalty= 0;
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
        

 
 /*$scope.loyaltydetails = function(){
   // alert('hii');

 userService.myloyalty().then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   
                    $scope.exists=1;
                    $scope.loyaltyList=response.loyaltyList;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                    $scope.loyaltyList='';
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }*/
 
 $scope.loyaltydetails = function(){
        
           $state.go('frontend.loyaltydetails');

              
}
 
 



 $scope.sendforauction = function(id){
        
           $state.go('frontend.sendForAuction',{product_id:id});

              
}







	
});

