'use strict';
/** 
 * controllers used for the login
 */
app.controller('userpaymentCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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
}




 
 
 $scope.addPayment = function(value){
     
     //alert('ok');
     
           
            
            
            value.name = value.name;
            value.email = value.email;
            value.phone = value.phone;
            //console.log('sp',value);
             userService.userpaymentforupload(value).then(function(response) {

		if(response.Ack == '1') {
                   
                     $window.location.href = response.url;
                    $scope.exists=1;

		//$scope.allsubscriptions();
		} else {
                    console.log('ppp');	
                    $scope.exists=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
 
 
 
 
 
 

	
});

