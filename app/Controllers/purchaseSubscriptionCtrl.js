'use strict';
/** 
 * controllers used for the login
 */
app.controller('purchaseSubscriptionCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
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
}

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}



 
$scope.allsubscriptions = function(){

 userService.subscriptions().then(function(response) {
     
    
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.subscriptionLists=response.subscriptionlist;
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
   
    $scope.purchase = function(subscription_id){
        
             userService.purchaseSubscription(subscription_id).then(function(response) {

		if(response.Ack == '1') {
                     alert(response.msg);
                    //console.log(response);
                     $scope.new_subscriber = response.new_subscriber;
                     $scope.subscription_id = response.subscription_id;
                    $scope.exists=1;

		$scope.allsubscriptions();
		} else {
                    console.log('ppp');	
                    $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}



 $scope.payment = function(id){
     //alert(id);
        
           $state.go('frontend.payment',{subscription_id:id});

              
}












 $scope.sendforauction = function(id){
        
           $state.go('frontend.sendForAuction',{product_id:id});

              
}
	
});

