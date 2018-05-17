'use strict';
/** 
 * controllers used for the login
 */
app.controller('successAuctionuploadpaymentCtrl', function ($stateParams,$rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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
	
}

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}



 
/*$scope.addauctionpayment = function(){
    
    //alert('hii');
var id = $stateParams.id;
//alert(id);
 userService.addwinnerpayment(id).then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }*/
        

$scope.addauctionpayment = function(){
   
        var auction_id = $stateParams.id;
        var notification_type=1;
        userService.auctionFees(notification_type,auction_id).then(function(response) {

	
		if(response.Ack == '1') {
                   $scope.exists=1;
		
		
		

  } else {
             $scope.exists=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };

	
});

