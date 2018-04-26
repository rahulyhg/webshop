'use strict';
/** 
 * controllers used for the login
 */
app.controller('newgymCtrl', function ($rootScope, $scope, $http, $location,$timeout, $window, userService, $stateParams,Upload) {

    
$scope.data = {};
$scope.user = {};
$scope.product = {};

$window.localStorage["product_image"]='';
$window.localStorage["product_image_array"]=[];

$scope.productImages = [];
$scope.product_img = [];

$window.scrollTo(0, 0);
$scope.getCurrentUserType();

var userInfo = JSON.parse($window.localStorage["userInfo"]);    
$scope.user_id=userInfo.user_id;

//alert($scope.user_id);


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





$scope.addGym = function(user) {
    //document.getElementById('closeModalButton').click();
   // console.log($scope.product_img); return false;
    userService.saveGymDetails(user,$scope.product_img).then(function(response) {

        if(response.Ack == '1') {
            alert(response.msg);
        }
        
        
        
        
	}, function(err) {
		alert('Error Occured.');
         console.log(err); 
    });
};


//var userInfo = JSON.parse($window.localStorage["userInfo"]);    
//$scope.user_id=userInfo.user_id;

var userInfo = JSON.parse($window.localStorage["userInfo"]);    
$scope.user_id=userInfo.user_id;

userService.gymDetails(userInfo.user_id).then(function(response) {
        
    
    if(response.Ack == '1') {
         $scope.user.gym_id=response.GymDetails.gym_id;
                $scope.user.name=response.GymDetails.name;
                $scope.user.email=response.GymDetails.email;
                $scope.user.description=response.GymDetails.description;                                
                $scope.user.phone=response.GymDetails.phone;
                $scope.user.price=response.GymDetails.price;
                $scope.user.address=response.GymDetails.address;
               $scope.user.sundaytime=response.GymDetails.sundaytime;
               $scope.user.mondaytime=response.GymDetails.mondaytime;
               $scope.user.tuesdaytime=response.GymDetails.tuesdaytime;
               $scope.user.wednesdaytime=response.GymDetails.wednesdaytime;

               $scope.user.thursdaytime=response.GymDetails.thursdaytime;
               $scope.user.fridaytime=response.GymDetails.fridaytime;
               $scope.user.saturdaytime=response.GymDetails.saturdaytime;
               $scope.user.status=response.GymDetails.status;
               $scope.user.lat=response.GymDetails.lat;
               $scope.user.lang=response.GymDetails.lang;
               
               
               
               angular.forEach(response.GymDetails.image,function(value,key){
                angular.forEach(value,function(v1,k1){//this is nested angular.forEach loop
                    console.log('KKKKKKKK',k1+":"+v1);
                    
                                if(k1=='images'){
                        $scope.productImages.push(v1);	
                                }
                                if(k1=='imagename'){
                                $scope.product_img.push(v1);	
                                }


                 });
                });
               
               
               
               

                
              }else{
                  
               $scope.user.gym_id="";
                $scope.user.name="";
                $scope.user.email="";
                $scope.user.description="";                              
                $scope.user.phone="";
                $scope.user.price="";
                $scope.user.address="";
               $scope.user.sundaytime="";
               $scope.user.mondaytime="";
               $scope.user.tuesdaytime="";
               $scope.user.wednesdaytime="";

               $scope.user.thursdaytime="";
               $scope.user.fridaytime="";
               $scope.user.saturdaytime="";
               $scope.user.status="";
               $scope.user.lat="";
               $scope.user.lang="";
                  
              } 
                                                           
 }, function(err) {
         console.log(err); 
    }); 
    





 $scope.uploadFile = function(files) {
   // alert (files); return false;

           var fd = new FormData();
    //Take the first selected file
    fd.append("product_image", files[0]);
        $http.post($rootScope.serviceurl+"users/upProductImageWeb", fd, {
        headers: {'Content-Type': undefined },
        transformRequest: angular.identity
    }).then(function successCallback(response) {
        console.log(response.data.image);
        
        if(response.data.image !="") {
        
        $scope.product.images=response.data.image; 
        $scope.product.imgpath =response.data.imgpath; 
        //console.log(response.data.image);
        $window.localStorage["product_image"]=','+response.data.image;

            
        $scope.product_img.push($scope.product.images);
        $scope.productImages.push($scope.product.imgpath);

        //console.log('SUMAN',$scope.productImages);
        
        
    }
        
  }, function errorCallback(response) {
    
  });        

       
 };


$scope.removeproductImage = function(id,name,index){
     

    userService.removeproductImage(id,name,index).then(function(response) {
                                                                    
     if(response.Ack == '1') {
        $scope.productImages.splice(index,1);   
        $scope.product_img.splice(index,1);

        //console.log($scope.product_img);

                //alert(response.msg);
                //$scope.mylisting();
                //$state.go('frontend.mylisting');
                
                  } else {
       
                  
              }                                                             
                                                                    
    }, function(err) {
         console.log(err); 
    }); 
     
     
     
     
         
     
     
     }



	
	
	
});

