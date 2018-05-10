'use strict';
/** 
 * controllers used for the login
 */
app.controller('signupCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, userService,$state, $stateParams) {
    
$scope.data = {};
$scope.user = {};
//$scope.user.test = "testing";

//$scope.getCurrentUserType();   
//alert("zz");
//return false;

$scope.signup = function(user) {
    //alert('aa');
    //return false;
    //document.getElementById('closeModalButton').click();
    userService.signup(user).then(function(response) {
        
        if(response.Ack == '1') {
           
            

	alert('Signup Successful');	
	
		} 
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    }); 
};

	
});

