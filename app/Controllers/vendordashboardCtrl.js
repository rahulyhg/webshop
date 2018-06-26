'use strict';
/** 
 * controllers used for the login
 */
app.controller('vendordashboardCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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



 
$scope.wishlist = function(){
   // alert('hii');

 userService.wishlist().then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.favouriteProductList=response.favouriteProductList;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
        


 userService.get_total_subcriptions($scope.user_id).then(function(response) {
       // alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('normaluserlist',response);
		$scope.subcriptions=response.subcriptions;
		alert($scope.subcriptions);
                
		}
		
	
																  
	}, function(err) {
         console.log(err); 
    });
    
   
   
    userService.get_total_auctioned_product($scope.user_id).then(function(response) {
       // alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('auctionlist',response);
		$scope.auctionlist=response.auctionlist;
		
                
		}
		
	
																  
	}, function(err) {
         console.log(err); 
    });
    
        userService.get_total_product($scope.user_id).then(function(response) {
        //alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('productlist',response);
		$scope.productlist=response.productlist;
		
                
		}
		
	
																  
	}, function(err) {
         console.log(err); 
    });
    
         userService.get_total_reviews($scope.user_id).then(function(response) {
       // alert('OK1');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('reviewlist',response);
		$scope.reviewlist=response.reviewlist;
		
                
		}
		
	
																  
	}, function(err) {
         console.log(err); 
    });
    
      userService.get_total_messages($scope.user_id).then(function(response) {
       // alert('OK1');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log('reviewlist',response);
		$scope.messagelist=response.messagelist;
		
                
		}
		
	
																  
	}, function(err) {
         console.log(err); 
    });
	
});

