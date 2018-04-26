'use strict';
/** 
 * controllers used for the login
 */
app.controller('communitydetailsCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, userService, $stateParams) {
    
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
//console.log($scope.current_user_type);

//var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';	
//alert(encodedString);


userService.communityDetailsAll($stateParams.id).then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    
		$scope.commentsListing=response.commentsListing;
		$scope.CommunityDetails=response.CommunityDetails;
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
        
        
        
        
        
$scope.sendcomments = function(user) {
    //console.log('CTRL',auc);    
    //document.getElementById('closeModalButton').click();
    var userInfo = JSON.parse($window.localStorage["userInfo"]);	
    $scope.user_id=userInfo.user_id;
    
    
    userService.sendCommentsCommunity(user,userInfo.user_id,$stateParams.id).then(function(response) {
        
        
        if(response.Ack == '1') {
            alert(response.msg);
            $window.location.reload();
            //$state.go('frontend.auctionlist');
            
        }
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};
    
    
        
        
        
        
	
});

