'use strict';
/** 
 * controllers used for the login
 */
app.controller('myAuctionCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

$window.scrollTo(0, 0);  
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
	//$scope.user_id=userInfo.user_id;
}

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}


$scope.myauction = function(){
   // alert('hii');

 userService.myauction().then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.productLists=response.productList;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    $scope.productLists='';
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
        

 $scope.deleteProduct = function(id){
          // alert(cat_id);
           // return false;
             userService.deleteProduct(id).then(function(response) {
		//console.log(response.Ack);
	
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.exists=1;
                  //  $scope.user='';
		$scope.myauction();
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');	
                    $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}



/*$scope.auctionFeesPayment = function(notification_type,auction_id){
   //  alert('hi');

        userService.auctionFees(notification_type,auction_id).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	
		// $scope.productLists=response.productList;
		alert("Payment has been done successfully.Wait for the admin to make your product GO LIVE.");
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };*/
    
    
    
    
    $scope.auctionFeesPayment = function(id){
     //alert(id);
        
           $state.go('frontend.auctionuploadpayment',{product_id:id});

              
        }



	
});

