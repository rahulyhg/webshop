'use strict';
/** 
 * controllers used for the login
 */
app.controller('changePasswordCtrl', function ($rootScope, $scope, $http, $location,$timeout,$templateCache,$window,userService) {

  $scope.data = {};
$scope.user = {};
//alert('a');
$scope.getCurrentUserType();   
console.log($scope.current_user_type);  
 $templateCache.removeAll();  
 
   	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
	
	
 		$scope.updatePassword = function(user){
			
	    userService.updatePassword(user,userInfo.user_id).then(function(response) {
	
	if(response.Ack == '1') {
	alert('Data Updated');	
		} else {
			
	alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
         console.log(err); 
    }); 		
			
			};
 
 
});

