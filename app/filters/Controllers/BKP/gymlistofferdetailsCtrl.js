'use strict';
/** 
 * controllers used for the login
 */
app.controller('gymlistofferdetailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, userService, $stateParams) {
    
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


userService.aucDetailsfront($stateParams.id).then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    
		$scope.auctionDetails=response.auctionDetails;
		//$scope.allordersdetails=response.productsDetails;
		//$scope.user.product_id=$stateParams.id;	
                
                //$scope.user_id=userInfo.user_id;
                
		//console.log($scope.productsDetails);
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
        
        
        
        
        
$scope.sendmessage = function(user) {
    //console.log('CTRL',auc);    
    //document.getElementById('closeModalButton').click();
    var userInfo = JSON.parse($window.localStorage["userInfo"]);	
    $scope.user_id=userInfo.user_id;    
    
    
    userService.sendmessageauction(user,userInfo.user_id,$stateParams.id).then(function(response) {
        
        
        if(response.Ack == '1') {
            alert(response.msg);
            $window.location.reload();
            //$state.go('frontend.auctionlist');
            
        }
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};
    
    
        
        
        
        
	
});

