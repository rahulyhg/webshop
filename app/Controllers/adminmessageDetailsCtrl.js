'use strict';
/** 
 * controllers used for the login
 */
app.controller('adminmessageDetailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.user = {};
$scope.message = {};
$scope.fillmessage = '';
$scope.messageerror ='';
$scope.checkboxstr=[];
 $scope.user.brand=[];
 $scope.checkboxstr2=[];
 $scope.user.shop=[];
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
$scope.to_id='';


if ($window.localStorage["userInfo"]) {
var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
        $scope.to_id = $scope.user_id
        
       //alert($scope.user_id)
}
else {
	var userInfo={};
	userInfo.user_id ="";
	$scope.user_id=userInfo.user_id;
}
$scope.from_id='';
if($stateParams.admin_id){
    
        $scope.from_id=$stateParams.admin_id;
        $scope.message.from_id = userInfo.user_id; 
         $scope.message.to_id=$stateParams.admin_id;
  
}
$scope.product_image ='';
userService.getfullAdminMessages($scope.to_id,$scope.from_id).then(function(response) {
        //alert($scope.to_id);
		//console.log('hello',response);
		//$scope.isExists=1;
		if(response.Ack == '1') {
                  if(response.fillmessage){
		$scope.fillmessage=response.fillmessage;
                $scope.product_image=response.product_image;
		console.log('fillmessage',$scope.fillmessage);	
                }else{
                    swal('No message from admin','','error');
                    $state.go('frontend.messagelisting');
                }
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
        
$scope.adminaddmessage = function(message){
    
 if(message.message){
             userService.adminaddmessage(message).then(function(response) {
                 
		console.log('htype',response);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    //alert(1);
                    //$state.go('frontend.messagelisting');
                    $window.location.reload();
                
		
		}else if(response.Ack == '0'){
                    
                   alert(response.msg);
                   
                } else {
                    
                    console.log('ppp');	
                   // $scope.isExists=0;
		}
	
	
             
				   
	}, function(err) {
	console.log(err); 
	});     
        
       }else{
                 
                $scope.messageerror = 'Please write a message ..';
             }
        
}   


});

