'use strict';
/** 
 * controllers used for the login
 */
app.controller('communityCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, userService) {

    
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


//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);




userService.AllCommunitySection().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.ArticlesPosts=response.ArticlesPosts;
                $scope.CommunityPosts=response.CommunityPosts;
                $scope.FeaturedPosts=response.FeaturedPosts;
                
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
        

userService.GetRecentComments().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.GetRecentComments=response.GetRecentComments;
                
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});    
        
        
        
        
        
	
	
});

