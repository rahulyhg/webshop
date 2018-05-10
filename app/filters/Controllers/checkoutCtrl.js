'use strict';
/** 
 * controllers used for the login
 */
app.controller('checkoutCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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

//alert($window.localStorage["grandtotal"]);
$scope.grandtotal=$window.localStorage["grandtotal"];
$scope.cardpay = function(user){
    
    user.cardshippingname=user.shipping_name;
      user.cardshippingaddress=user.shipping_address;
      $window.localStorage["cardshippingname"]=user.cardshippingname;
       $window.localStorage["cardshippingaddress"]=user.cardshippingaddress;
    
   


    $('#loadingmessage').show();
    $('#checkout').prop('disabled', true);
    

    
    $scope.checkoutByCard(user);
    
    
    
    };
    
    
        $scope.checkoutByCard = function(user){
        
       
    var userInfo = JSON.parse($window.localStorage["userInfo"]);    
    $scope.user_id=userInfo.user_id;
    $scope.cardshippingnamee= $window.localStorage["cardshippingname"];
     $scope.cardshippingaddresss= $window.localStorage["cardshippingaddress"];
    

    //alert($scope.plan_id);
        //var checkoutDetails =$window.localStorage["checkoutDetails"];
        userService.cardpay($scope.user_id,$scope.cardshippingnamee,$scope.cardshippingaddresss,$scope.grandtotal).then(function(response) {
        

        
        if(response.Ack == '1') {
            alert('Payment Successful');
             $('#loadingmessage').hide('fast');
             $('#checkout').prop('disabled', false);
    
     $state.go('frontend.payment_success');
    } else {
         $('#loadingmessage').hide('fast');
     $('#checkout').prop('disabled', false);
        $state.go('frontend.failure');
        
   
    
    }                                                         
                                                                          
     }, function(err) {

$state.go('frontend.failure');
    }); 
        
        
        
        };
/*
$scope.gymlist = function(){    
$state.go('frontend_other.gymlist');
}
*/


//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//alert(encodedString);	





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

