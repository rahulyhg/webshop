'use strict';
/**
 * controllers used for the login
 */
app.controller('changePasswordCtrl', function ($rootScope, $scope, $http, $location, $timeout, $window, userService, $stateParams, $state) {
    
$scope.data = {};
$scope.user = {};    
     $scope.getCurrentUserType();

	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;


$scope.updatePassword = function(user){

var password= user.password;
var conf_password= user.conf_password;

	  user.user_id =userInfo.user_id;
	  
	  if(angular.equals(password, conf_password)){
			
	   userService.ChangePassword(user).then(function(response) {
	
            if(response.Ack == '1') {
                alert(response.msg);
                $window.location.reload();
            } else {
                alert('Error !!!!');			
                   }
	
																	   
                }, function(err) {
                  console.log(err); 
             }); 	

	   }
		else {
                    $scope.showErrorMsg=1;
		}
			
}; 
		

});