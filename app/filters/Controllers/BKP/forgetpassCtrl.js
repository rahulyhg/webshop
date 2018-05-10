'use strict';
/**
 * controllers used for the login
 */
app.controller('forgetpassCtrl', function ($rootScope, $scope, $http, $location, $window, userService) {
        
$scope.data = {};
$scope.user = {};

//$scope.getCurrentUserType();    

/*
$scope.forgetpass = function(user) {    
    //document.getElementById('closeModalButton').click();
    userService.forgetPassword(user).then(function(response) {
            //alert('OK');    
            alert('Mail Send Successfully');
	}, function(err) {
		alert('Email not found in our database');
         console.log(err); 
    });
    
};
*/






$scope.forgetpass = function(user) {    
    //document.getElementById('closeModalButton').click();
    userService.forgetPassword(user).then(function(response) {
        
        
            if(response.Ack == '1') {
                alert('Mail Send Successfully');
            } else {
                alert('Email not found in our database');
            }
        
            
	}, function(err) {
		alert('Error found!!');
         console.log(err); 
    });
    
};





   
    


});