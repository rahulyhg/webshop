'use strict';
/** 
 * controllers used for the login
 */
app.controller('loyaltydetailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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

   

 
 $scope.loyaltydetails = function(){
   // alert('hii');

 userService.myloyalty().then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   
                    $scope.exists=1;
                    $scope.loyaltyLists=response.loyaltyList;
		//console.log('spandan',$scope.loyaltyList);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
 
 
 

	
});

