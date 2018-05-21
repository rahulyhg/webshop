'use strict';
/** 
 * controllers used for the login
 */
app.controller('conatctuserCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.message = {};

//alert('a');
 $scope.search = { price_min : '', price_max : '', amount_min : 0, amount_max : 10000 };
$scope.drpmodel='0';
 $scope.cobchange=function(){

 	$window.localStorage["selected_value"]=$scope.drpmodel;
 	$scope.searchListing();
     //alert("puja "+$window.localStorage["selected_value"]);

  }

var limitStep = 5;
$scope.limit = limitStep;
$scope.incrementLimit = function() {
    $scope.limit = '';
};

$scope.id='';
if($stateParams.id){
$scope.id=$stateParams.id;
//alert($scope.id);
}
$scope.product_id='';
if($stateParams.product_id){
$scope.product_id=$stateParams.product_id;
//alert($scope.product_id);
}

$scope.from_id='';
if($stateParams.from_id){
$scope.from_id=$stateParams.from_id;
$scope.message.from_id = $scope.from_id;
//alert($scope.product_id);
}
userService.getusercontact($scope.id).then(function(response) {
           // alert('hii');
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.userdetails=response.userdetails;
              $scope.message.to_id=$scope.userdetails.id;
		console.log('userdetails',$scope.userdetails);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 

userService.getProductcontact($scope.product_id).then(function(response) {
           // alert('hii');
		//console.log(response.Ack);
		//$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    //$scope.isExists=1;
                  //  $scope.user='';
		$scope.productdetails=response.productdetails;
                $scope.message.product_id=$scope.productdetails.id;
		//console.log('productdetails',$scope.productdetails);	
		//alert($scope.productdetails);
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 


$scope.addmessage = function(message){
    
 
             userService.addmessage(message).then(function(response) {
		console.log('htype',response);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    
                    $state.go('frontend.myProduct');
                    
                
		
		}else if(response.Ack == '0'){
                    
                   swal(response.msg,'','error');
                   
                } else {
                    
                    console.log('ppp');	
                   // $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
});

