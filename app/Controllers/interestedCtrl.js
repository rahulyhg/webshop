'use strict';
/** 
 * controllers used for the login
 */
app.controller('interestedCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
  $window.scrollTo(0, 0);   
$scope.data = {};
$scope.user = {};

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

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}

if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
   //alert($scope.usersSelectedCurrency+'yy');
}else{
    $scope.usersSelectedCurrency = 'KWD';
   // alert($scope.usersSelectedCurrency+'kk');
}

 
$scope.interestedproduct = function(){
   // alert('hii');

 userService.interestedproduct($scope.usersSelectedCurrency).then(function(response) {
     
    
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
                    $scope.productLists=response.productList;
		
		
		} else {
                    
                    $scope.productLists='';
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
        

 $scope.deleteInterest = function(id){
          
             userService.deleteInterest(id).then(function(response) {
		
	
		if(response.Ack == '1') {
                   
                   
                    $scope.exists=1;
                 
		$scope.interestinproduct();
              
		
		} else {
                   
                    $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
      
}





	
});

