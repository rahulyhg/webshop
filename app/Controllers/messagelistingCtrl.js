'use strict';
/** 
 * controllers used for the login
 */
app.controller('messagelistingCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

  $window.scrollTo(0, 0);   
$scope.data = {};
$scope.user = {};
$scope.checkboxstr=[];
 $scope.user.brand=[];
 $scope.checkboxstr2=[];
 $scope.user.shop=[];
  $scope.admin_id =0;
  
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

