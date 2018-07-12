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
app.controller('ListOrderBuyerCtrl', function ($rootScope, $scope, $http,$window, $location,$timeout,$stateParams,userService,$state) {
 
    if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
$window.scrollTo(0, 0);
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

if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
   //alert($scope.usersSelectedCurrency+'yy');
}else{
    $scope.usersSelectedCurrency = 'KWD';
   // alert($scope.usersSelectedCurrency+'kk');
}
  
 $scope.myPurchase = function(){
         
             userService.myPurchase($scope.user_id,$scope.usersSelectedCurrency).then(function(response) {
		
		$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log('spandan',response);
                   
                    $scope.isExists=1;
                 
		$scope.allorders=response.allorders;
    
		
		} else {
                    console.log('ppp');
                    
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
    }
    
   
});

