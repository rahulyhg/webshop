'use strict';
/** 
 * controllers used for the login
 */
app.controller('messageDetailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.user = {};
$scope.message = {};
$scope.fillmessage = '';
$scope.checkboxstr=[];
 $scope.user.brand=[];
 $scope.checkboxstr2=[];
 $scope.user.shop=[];
 var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;
$scope.to_id='';
if($stateParams.to_id){
$scope.message.to_id=$stateParams.to_id;
//alert($scope.id);
}
$scope.product_id='';
if($stateParams.product_id){
$scope.message.product_id=$stateParams.product_id;
$scope.product_id = $stateParams.product_id
//alert($scope.product_id);
}
if ($window.localStorage["userInfo"]) {
var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
       //alert($scope.user_id)
}
else {
	var userInfo={};
	userInfo.user_id ="";
	$scope.user_id=userInfo.user_id;
}
$scope.from_id='';
if($stateParams.from_id){
$scope.from_id=$stateParams.from_id;
$scope.message.from_id = $scope.from_id;
//alert($scope.product_id);
}

userService.getfullMessages($scope.user_id,$scope.product_id,$scope.from_id).then(function(response) {
         // alert('hii');
		//console.log('hello',response);
		//$scope.isExists=1;
		if(response.Ack == '1') {
                  //alert('hii');
		$scope.fillmessage=response.fillmessage;
               // $scope.user_idd=$scope.user_id;
		console.log('fillmessage',$scope.fillmessage);	
		
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
                    
                    $state.go('frontend.messagelisting');
                    
                
		
		}else if(response.Ack == '0'){
                    
                   alert(response.msg);
                   
                } else {
                    
                    console.log('ppp');	
                   // $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}   


});

