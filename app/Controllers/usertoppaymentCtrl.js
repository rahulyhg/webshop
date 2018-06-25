'use strict';
/** 
 * controllers used for the login
 */
app.controller('usertoppaymentCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.user = {};
$scope.value ={};
//alert('a');
$scope.value.loyalty_redeem=0;
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
     
            var pid=$stateParams.pid;
            value.pid=pid;
            value.sid = value.sid;
            value.name = value.name;
            value.email = value.email;
            value.phone = value.phone;
            value.loyalty_redeem = value.loyalty_redeem;
            //console.log('sp',value);
             userService.userpaymentfortop(value).then(function(response) {

		if(response.Ack == '1') {
                   
                     $window.location.href = response.url;
                    $scope.exists=1;

		
		}else if(response.Ack == '2'){
                    
                    swal('Sorry ! You have not enough loyalty point.','','error')
                    
                    
                 } else {
                    console.log('ppp');	
                    $scope.exists=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
 
 
$scope.allsubscriptions = function(){

 userService.topsubscriptions().then(function(response) {
     
    
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.subscriptionLists=response.subscriptionlist;
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
 
 
userService.myloyalty().then(function(response) {
     
		if(response.Ack == '1') {
                   
                    $scope.exists=1;
                    $scope.totalloyalty=response.total_loyalty;
		
		
		} else {
                    
                    $scope.totalloyalty= 0;
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	


 $scope.packagedetails = function (pid) {
        
        userService.packagedetails(pid).then(function (response) {
           
            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);
               
                $scope.isExists = 1;
               
                $scope.package = response.packagedetails;
              

            } else {
                console.log('ppp');
                $scope.isExists = 0;
            }

        }, function (err) {
            console.log(err);
        });

    }




	
});

