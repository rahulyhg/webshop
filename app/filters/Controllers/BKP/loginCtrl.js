'use strict';
/**
 * controllers used for the login
 */
app.controller('loginCtrl', function ($rootScope, $scope, $http, $location, $timeout, $window, userService, $stateParams, $state) {
    
$scope.data = {};
$scope.user = {};    
    
    
    
    $scope.login = function(user) {
        

    //document.getElementById('closeModalButton').click();
    userService.login(user).then(function(response) {
        
        $scope.current_user_login='1';        
                
        

       $window.sessionStorage.isLoggedIn=1;
       
		var userInfo = {
		user_id: response.UserDetails.user_id,
		full_name: response.UserDetails.full_name,
                user_type: response.UserDetails.user_type,
		email: response.UserDetails.email,
		username : response.UserDetails.username, 
		address : response.UserDetails.address,
		phone: response.UserDetails.phone,
		device_type: response.UserDetails.device_type,
		device_token_id: response.UserDetails.device_token_id,
		lat: response.UserDetails.lat,
		lang: response.UserDetails.lang,
		profile_image : response.UserDetails.profile_image
		};
		$window.localStorage["userInfo"] = JSON.stringify(userInfo);

		
		if(response.UserDetails.id!=''){
		 	$window.localStorage["userId"]=response.user_id;
                        $window.localStorage["user_type"]=response.UserDetails.user_type;
		 	//alert($window.localStorage["userId"]);
                        //alert($window.localStorage["Usertp"]);

 	$state.go('frontend.myprofile'); 
                }


    }, function(err) {
		alert('Invalid Login. Please Try Again');
         console.log(err); 
    }); 
}; 

    


});