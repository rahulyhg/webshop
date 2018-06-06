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
		
		console.log('homesite',response);
		$scope.brandList=response.brandList;
		$scope.topmodellist=response.topmodellist;
                $scope.launchedproductList=response.launchedproductList;
                
		}
		else{
 		
		}
	
	
																  
	}, function(err) {
         console.log(err); 
    });
    

$scope.registernewsletter = function(email){
        if(email){
             userService.registernewsletter(email).then(function(response) {
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log(response);
                  swal('Email added successfully.','','success');
                 
		
		} else if(response.Ack == '2') {
                   alert(response.message );
                    
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
    }else{
        swal('Please enter a emailid.','','error');
    }
       
        
}

	
});

