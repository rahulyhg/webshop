'use strict';
/** 
 * controllers used for the login
 */
app.controller('cmsCtrl', function ($rootScope, $scope, $http,$window, $location,$timeout,$stateParams,cmsService) {

$scope.data = {};
$scope.user = {};
//alert('a');
//$scope.getCurrentUserType();   
//console.log($scope.current_user_type);




/*if ($window.localStorage["userInfo"]) {
var userInfo = JSON.parse($window.localStorage["userInfo"]);
$scope.user_id=userInfo.user_id;
}else {
var userInfo={};
userInfo.user_id ="";
}*/


$scope.cms_page_id = $stateParams.id;


  	//var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;

    cmsService.getCms($stateParams.id).then(function(response) {
        //alert('OK');
        //exit;
	
	
	if(response.Ack=='1'){
		
		console.log(response);
		$scope.cmsdetails=response.cmsdetails;
		//$scope.allorderproducts=response.all_products;
		}
		else{
 		
		}
	
	
																  
	}, function(err) {
         console.log(err); 
    });
    
    
    
   
});

