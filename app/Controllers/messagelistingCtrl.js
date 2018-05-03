'use strict';
/** 
 * controllers used for the login
 */
app.controller('messagelistingCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.user = {};
$scope.checkboxstr=[];
 $scope.user.brand=[];
 $scope.checkboxstr2=[];
 $scope.user.shop=[];
 var userInfo = JSON.parse($window.localStorage["userInfo"]);	
$scope.user_id=userInfo.user_id;

userService.listproductMessages($scope.user_id).then(function(response) {
         // alert('hii');
		//console.log('hello',response);
		//$scope.isExists=1;
		if(response.Ack == '1') {
                  //alert('hii');
		$scope.message=response.message;
               // $scope.user_idd=$scope.user_id;
		//console.log('message',$scope.message);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
        
   


});

