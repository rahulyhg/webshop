'use strict';
/** 
 * controllers used for the login
 */
app.controller('paymentCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
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



//alert($scope.subscription_id);

 //var subscription_id = $stateParams.subscription_id;

 $scope.addPayment1 = function(value){
    
    //console.log(user2);
    //return false;
    
    
     //var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;
  
    var subscription_id = $stateParams.subscription_id;
    
  
    $window.localStorage["selected_value"]=$scope.drpmodel;
    $window.localStorage["cat_id"]=user2.cat_id;
     $window.localStorage["subcat_id"]=user2.subcat_id;
     $window.localStorage["name"]=user2.name;
     $window.localStorage["description"]=user2.description;
     $window.localStorage["brand"]=user2.brand;
     $window.localStorage["price"]=user2.price;
     $window.localStorage["currency"]=user2.currency;
     $window.localStorage["quantity"]=user2.quantity;
     $window.localStorage["preferred_date"]=user2.preferred_date;
     $window.localStorage["user_id"]=$scope.user_id;
     $window.localStorage["model_year"]=user2.model_year;
     $window.localStorage["breslet_type"]=user2.breslet_type;
     $window.localStorage["time_slot_id"]=user2.time_slot_id;
    // $window.localStorage["baseauctionprice"]=$scope.baseauctionprice;
   //  $window.localStorage["thresholdprice"]=$scope.thresholdprice;
   
   

  //console.log("Selected Value "+ $window.localStorage["selected_value"]);
//return false;
      

 //user2.image= user2.image;
         //  alert( user.job_image);
         //alert(user1.product_image);
   // alert(user.question);
 //             userService.addproduct(user2).then(function(response) {
	// 	console.log(response.Ack);
	// 	$scope.isExists=1;
	// 	if(response.Ack == '1') {
 //                    alert('Added Successfully.');
 //                    $window.location.reload()
 //                    $scope.isExists=1;
		
	// 	} else {
 //                    console.log('ppp');	
 //                    $scope.isExists=0;
	// 	}
	
	
	
				   
	// }, function(err) {
	// console.log(err); 
	// });     
        
       
        
}  
 
 
 $scope.addPayment = function(value){
     
     //alert('ok');
     
           var subscription_id=$stateParams.subscription_id;
            
            value.subscription_id = subscription_id;
            value.name = value.name;
            value.email = value.email;
            value.phone = value.phone;
            //console.log('sp',value);
             userService.purchaseSubscription(value).then(function(response) {

		if(response.Ack == '1') {
                    // alert(response.msg);
                    //console.log(response);
                     //$scope.new_subscriber = response.new_subscriber;
                     //$scope.subscription_id = response.subscription_id;
                     $window.location.href = response.url;
                    $scope.exists=1;

		//$scope.allsubscriptions();
		} else {
                    console.log('ppp');	
                    $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
 
 
 
 
 
 

	
});

