'use strict';
/** 
 * controllers used for the login
 */
app.controller('searchmapCtrl', function ($rootScope, $scope, $http, $location,$timeout, $window, userService, $stateParams,NgMap) {

    
$scope.data = {};
$scope.user = {};

$window.scrollTo(0, 0);
//$scope.getCurrentUserType();


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






  NgMap.getMap().then(function(map) {
      
       var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
       map.showInfoWindow('bar', 'marker1');
       $scope.googleMapsUrl="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1fy6E1ehPO5HNHhRIvjnEykLQ-DFMzbg";
    console.log(map.getCenter());
    console.log('markers', map.markers);
    console.log('shapes', map.shapes);
    
         
   

  });




//var userInfo = JSON.parse($window.localStorage["userInfo"]);	
//$scope.user_id=userInfo.user_id;

userService.getAccountDetails(userInfo.user_id).then(function(response) {
		
	
	if(response.Ack == '1') {
				$scope.user.full_name=response.UserDetails.full_name;
				$scope.user.email=response.UserDetails.email;
                                $scope.user.username=response.UserDetails.username;                                
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
                                $scope.user.profile_image=response.UserDetails.profile_image;                                
				//$scope.user.location=response.UserDetails.location;
				//$scope.user.address=response.UserDetails.address;
				//$scope.user.license_no=response.UserDetails.license_no;
				//$scope.user.license_expired_on=response.UserDetails.license_expired_on;
				
              }else{
				  
				$scope.user.full_name='';
				$scope.user.email='';
                                $scope.user.username='';
				$scope.user.address='';
				$scope.user.user_id='';
				$scope.user.phone='';
                                $scope.user.profile_image='';
				//$scope.user.location='';
				//$scope.user.address='';
				//$scope.user.license_no='';
				//$scope.user.license_expired_on='';
				  
			  }	
														   
 }, function(err) {
         console.log(err); 
    });


$scope.searchGym = function(user) {
 
 //alert('test');
 

//var userInfo = JSON.parse($window.localStorage["userInfo"]);	
//$scope.user_id=userInfo.user_id;




userService.searchGym(user,userInfo.user_id).then(function(response) {
		
		$scope.isExists=response.Ack;
              //  alert("aa");
              //  alert(response.Ack);
		if(response.Ack == '1') {
		$scope.all_gym=response.all_gym;		
		
		} else {
                    $scope.all_gym="";
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});


}

userService.searchGymall().then(function(response) {
		//alert("bb");
               // alert(response.Ack);
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.all_gym=response.all_gym;		
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});



});

