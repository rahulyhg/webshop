'use strict';
/** 
 * controllers used for the login
 */
app.controller('gymdetailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,$state, $stateParams, userService) {

    
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
//alert('a');
//$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);

$scope.gymid =$stateParams.id;


userService.gymDetailsfront($stateParams.id).then(function(response) {   
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    
		$scope.GymDetails=response.GymDetails;
		//$scope.allordersdetails=response.productsDetails;
		//$scope.user.product_id=$stateParams.id;	
                
                //$scope.user_id=userInfo.user_id;
                
		//console.log($scope.productsDetails);
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
        $scope.checklogin = function(){
	
        alert('Please Login');
	 
return false;
	 
}



	$scope.getgymdetails = function(tid,tname,clid,starttime,endtime,day){
            
          
            $window.localStorage['gymiid']=$stateParams.id;
            $window.localStorage['tid']=tid;
            $window.localStorage['tname']=tname;
             $window.localStorage['clid']=clid;
            $window.localStorage['starttime']=starttime;
            $window.localStorage['endtime'] =endtime;
            $window.localStorage['day'] =day;
            $state.go('frontend_other.details'); 
	
        //alert(gymid);
	 

	 
}
	
});

