'use strict';
/** 
 * controllers used for the login
 */
app.controller('homeCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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
	//$scope.user_id=userInfo.user_id;
}

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}



 
  userService.gethome().then(function(response) {
       // alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log(response);
		$scope.brandList=response.brandList;
		//$scope.allorderproducts=response.all_products;
		}
		else{
 		
		}
	
	
																  
	}, function(err) {
         console.log(err); 
    });
    

$scope.registernewsletter = function(email){
           //alert(email);
           // return false;
             userService.registernewsletter(email).then(function(response) {
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                   // $scope.isExists=1;
                  //  $scope.user='';
		//$scope.subcategorylist=response.subcategorylist;
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

