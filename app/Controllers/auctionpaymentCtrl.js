'use strict';
/** 
 * controllers used for the login
 */
app.controller('auctionpaymentCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.user = {};
$scope.value ={};
//alert('a');
$scope.value.loyalty_redeem=0;
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
            value.loyalty_redeem = value.loyalty_redeem;
            //console.log('sp',value);
             userService.purchaseAuctionproduct(value).then(function(response) {

		if(response.Ack == '1') {
                    
                     $window.location.href = response.url;
                    $scope.exists=1;

		
		}else if(response.Ack == '2'){
                    
                    swal('Sorry ! Your payment date is expired.','','error')
                    $scope.home();
                    
                 }else if(response.Ack == '3'){
                    
                    swal('Sorry ! You have not enough loyalty point.','','error')
                    //$scope.home();
                    
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
 
 userService.myloyalty().then(function(response) {
     
		if(response.Ack == '1') {
                   
                    $scope.exists=1;
                    $scope.totalloyalty=response.total_loyalty;
		
		
		} else {
                    
                    $scope.totalloyalty= 0;
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
 
 userService.myauctionpayamount($stateParams.product_id).then(function(response) {
     
		if(response.Ack == '1') {
                   
                    $scope.exists=1;
                    $scope.totalamount=response.amountdetails;
		
		
		} else {
                    
                    $scope.totalamount= 0;
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 






	
});

