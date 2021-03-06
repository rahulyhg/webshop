'use strict';
/** 
 * controllers used for the login
 */
app.controller('SubscribedListCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

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

if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
   //alert($scope.usersSelectedCurrency+'yy');
}else{
    $scope.usersSelectedCurrency = 'KWD';
   // alert($scope.usersSelectedCurrency+'kk');
}

 
$scope.allsubscriptions = function(){

 userService.subscribedlist($scope.usersSelectedCurrency).then(function(response) {
     
    
		if(response.Ack == '1') {
                    $scope.exists=1;
                    $scope.subscribedLists=response.subscribedLists;
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
   
    $scope.renew1 = function(subscription_id){
        
             userService.purchaseSubscription(subscription_id).then(function(response) {

		if(response.Ack == '1') {
                     swal(response.msg,'','success');
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


$scope.renew = function(id,status){
     //alert(id);
        if(status==0){
            swal("Sorry! This package is not available now.",'','error');
        }else{
           $state.go('frontend.payment',{subscription_id:id});

    }     
}







 $scope.sendforauction = function(id){
        
           $state.go('frontend.sendForAuction',{product_id:id});

              
}
	
});

