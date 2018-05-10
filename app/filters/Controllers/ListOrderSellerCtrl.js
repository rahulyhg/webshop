'use strict';
/** 
 * controllers used for the login
 */
app.filter('browserSupportedDateFormat', function($filter) {

  // In the return function, we must pass in a single parameter which will be the data we will work on.
  // We have the ability to support multiple other parameters that can be passed into the filter optionally
  return function(input, optional1, optional2) {
//alert(input);
   //input = "2017-07-08 07:10:29";
if(input)
{
input = input.replace(/(.+) (.+)/, "$1T$2Z");
input = new Date(input).getTime();
input=$filter('date')(input, optional1);
return input;
}

  }

});
app.controller('ListOrderSellerCtrl', function ($rootScope, $scope, $http,$window, $location,$timeout,$stateParams,userService) {

$scope.data = {};
$scope.user = {};
//alert('a');
$scope.getCurrentUserType();   
//console.log($scope.current_user_type);




if ($window.localStorage["userInfo"]) {
var userInfo = JSON.parse($window.localStorage["userInfo"]);
$scope.user_id=userInfo.user_id;
}else {
var userInfo={};
userInfo.user_id ="";
}


  
 $scope.mySold = function(){
     //alert('hi');
          // alert(cat_id);
           // return false;
             userService.mySold($scope.user_id).then(function(response) {
		//console.log(response.Ack);
		//$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.allorders=response.allorders;
                
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');
                    
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
    }
    
   
});

