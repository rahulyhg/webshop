'use strict';
/** 
 * controllers used for the login
 */
app.controller('myProductCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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



 
$scope.myproduct = function(){
   // alert('hii');

 userService.myproduct().then(function(response) {
     
    
		
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
		$scope.myproduct();
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

$scope.editProduct = function(id){
          // alert(cat_id);
           // return false;
             userService.editProduct(id).then(function(response) {
		//console.log(response.Ack);
	
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.exists=1;
                  //  $scope.user='';
		$scope.myproduct();
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

 $scope.sendforauction = function(id){
        
           $state.go('frontend.sendForAuction',{product_id:id});

              
}

$scope.pay = function(lid){
        
           
           $state.go('frontend.userpayment',{pid:lid}); 

              
}





$scope.marksold = function(id){
          // alert(cat_id);
           // return false;
             userService.markProduct(id).then(function(response) {
		//console.log(response.Ack);
	
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.exists=1;
                  //  $scope.user='';
		$scope.myproduct();
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








	
});

