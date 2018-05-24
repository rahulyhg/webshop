'use strict';
/** 
 * controllers used for the login
 */
app.controller('headerCtrl', function ($rootScope, $scope, $http, $location,$window) {

   //  if ($window.localStorage["userInfo"]) {
		    
			$scope.current_user_login=1;
               var userInfo = JSON.parse($window.localStorage["userInfo"]);	
				$scope.fname=userInfo.fname;
				$scope.lname=userInfo.lname;
				$scope.profile_image=userInfo.profile_image;
	
			
			$scope.current_user_login=1;
            $scope.current_loggedin_user=$window.localStorage["userId"]=response.user_id;
            $scope.current_loggedin_user_type=userInfo.user_type; 
          
            //$scope.language= $window.localStorage["language"];
            
			
			//console.log($scope.current_loggedin_user_type); 
			
	// }
	 
	 
   
});

