'use strict';
/**
 * controllers used for the login
 */
app.controller('mobileverifyCtrl', function($rootScope, $scope, $http, $location,$timeout, $stateParams, userService,$q,$window,Upload) {
    
$scope.data = {};
$scope.user = {}; 
$scope.user.mobileno = $stateParams.mobileno;
$scope.user.code = $stateParams.code;
var userid='';
if($scope.mobileverify){
   // alert($scope.mobileverify);
     userid = $scope.mobileverify;
     userService.resend(userid,$scope.user.mobileno).then(function(response) {
        if(response.Ack == '1'){
            	 swal("OTP Sent To Your Mobile.", "", "success")
                .then((value) => {
                    if(value == true){

                           // $window.location.reload();
                    }

                });
        }else{
            swal("There is problem in verifying your Mobile No.Please try again", "", "error")
                .then((value) => {
                    if(value == true){

                            $window.location.reload();
                    }
                  //swal(`The returned value is: ${value}`);
                });
        }
   														   
 }, function(err) {
         console.log(err); 
    });
}
else{
    userid = $stateParams.id; 
}
//$rootScope.preventNavigation = false;
    // $scope.getCurrentUserType();

	//var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;

	

$scope.tomobileverifying = function(user){

var otp= user.otp;


   userService.tomobileverifying(userid,otp).then(function(response) {
	
	//console.log("zzzdfdzsxfdz",response);  
	 if(response.Ack == '1'){
				  
			//$scope.msg='There is problem in verifying your email.';
				
			 swal("Successfully Verified Your Mobile No.", "", "success")
                .then((value) => {
                    if(value == true){

                            $window.location.href = '#/home';
                    }

                });	

                 }else{

                 swal("Please Check Your Mobile Number Along With Your Country .", "", "error")
                .then((value) => {
                    if(value == true){

                            $window.location.reload();
                    }
                  //swal(`The returned value is: ${value}`);
                });

                 }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
			
}; 


$scope.tomobileverifying1 = function(user){

var otp= user.otp;
var mobileno = user.mobileno; 

   userService.tomobileverifying1(userid,otp,mobileno).then(function(response) {
	
	//console.log("zzzdfdzsxfdz",response);  
	 if(response.Ack == '1'){
				  
			//$scope.msg='There is problem in verifying your email.';
				
			 swal("Successfully Verified Your Mobile No.", "", "success")
                .then((value) => {
                    if(value == true){

                            $window.location.href = '#/home';
                    }

                });	

                 }else if(response.Ack == '0'){

                 swal("There is problem in verifying your Mobile No.Please try again", "", "error")
                .then((value) => {
                    if(value == true){

                            $window.location.reload();
                    }
                  //swal(`The returned value is: ${value}`);
                });

                 }else{

                 swal("There is problem in verifying your Mobile No.Please try again", "", "error")
                .then((value) => {
                    if(value == true){

                            $window.location.reload();
                    }
                  //swal(`The returned value is: ${value}`);
                });

                 }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
			
}; 

		
$scope.resend = function(user){
   
   userService.resend(userid).then(function(response) {
        if(response.Ack == '1'){
            	 swal("Successfully Verified Your Mobile No.", "", "success")
                .then((value) => {
                    if(value == true){

                            $window.location.reload();
                    }

                });
        }else{
            swal("There is problem in verifying your Mobile No.Please try again", "", "error")
                .then((value) => {
                    if(value == true){

                            $window.location.reload();
                    }
                  //swal(`The returned value is: ${value}`);
                });
        }
   														   
 }, function(err) {
         console.log(err); 
    });
   
}
});