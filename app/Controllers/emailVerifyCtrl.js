app.controller('emailVerifyCtrl', function($rootScope, $scope, $http, $location,$timeout, $stateParams, userService,$q,$window,Upload) {
  

	var userid = $stateParams.id;

   $scope.toemailverifying =function(){
   //alert($stateParams.id);


   userService.toemailverify(userid).then(function(response) {
	
	console.log("zzz",response);  
	if(response.Ack == '1') {
				$scope.msg=response.msg;
			
				
              }else if(response.Ack == '0'){
				  
			$scope.msg='There is problem in verifying your email.';
				
				
				  
			  }else{

			  	$scope.msg='';

			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 

   };




  });