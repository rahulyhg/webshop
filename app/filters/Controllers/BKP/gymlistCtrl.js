'use strict';
/** 
 * controllers used for the login
 */
app.controller('gymlistCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,userService) {
    

    
$scope.data = {};
$scope.user = {};
//alert('a');

//console.log($scope.current_user_type);

//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//$scope.user_id=userInfo.user_id;
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);

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


//$scope.getlisting=function(){

userService.gymList().then(function(response) {
    //console.log('Testing');
   //alert('OK');
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.all_gyms=response.all_gyms;
		console.log($scope.all_gyms);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
	
        
//}
        

//$scope.getlisting();

});


