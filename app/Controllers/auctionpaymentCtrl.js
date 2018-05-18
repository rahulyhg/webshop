'use strict';
/** 
 * controllers used for the login
 */
app.controller('auctionpaymentCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
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


 
 
 $scope.addPayment = function(value){
     
     //alert('ok');
     
           var product_id=$stateParams.product_id;
            
            value.product_id = product_id;
            value.name = value.name;
            value.email = value.email;
            value.phone = value.phone;
            //console.log('sp',value);
             userService.purchaseAuctionproduct(value).then(function(response) {

		if(response.Ack == '1') {
                    
                     $window.location.href = response.url;
                    $scope.exists=1;

		
		}else if(response.Ack == '2'){
                    
                    alert('Sorry ! Your payment date is expired.')
                    $scope.home();
                    
                 }else {
                    console.log('ppp');	
                    $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
 
 
 $scope.home = function(){
        
           
           $state.go('frontend.home'); 

              
}
 
 
 

	
});

