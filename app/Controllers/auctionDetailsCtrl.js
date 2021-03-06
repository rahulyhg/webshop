'use strict';
/** 
 * controllers used for the login
 */
app.controller('auctionDetailsCtrl', function ($rootScope, $scope,$http, $location,$timeout,$window, $state,$stateParams, userService) {

    if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}

  $window.scrollTo(0, 0);    
$scope.data = {};
$scope.user = {};
$scope.countview="";
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
 if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
}else{
    $scope.usersSelectedCurrency = 'KWD';
}
$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}




 $scope.isActive = function (index) {
        return $scope._Index === index;
    };

    // show prev image
    $scope.showPrev = function () {
        $scope._Index = ($scope._Index > 0) ? --$scope._Index : $scope.photos.length - 1;
    };

    // show next image
    $scope.showNext = function () {
        $scope._Index = ($scope._Index < $scope.photos.length - 1) ? ++$scope._Index : 0;
    };

    // show a certain image
    $scope.showPhoto = function (index) {
        $scope._Index = index;
    };

 
$scope.product_id=$stateParams.id;
$scope.product_id1=atob($stateParams.id);
 
 $scope.Showdetails = function(){
   //  alert('hi');
 

        userService.productDetails($scope.product_id,userInfo.user_id,$scope.usersSelectedCurrency).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	
		$scope.productLists=response.productList;


		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    }; 
        
$scope.checklogin = function(){	
        alert('Please Login');	 
return false;	 
}  


	$scope.addTocart = function(product_id,quantity){
           // alert(quantity);
           
	 		//var userInfo = JSON.parse($window.localStorage["userInfo"]);	
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

			
	   userService.addTocart($scope.user_id,product_id,quantity).then(function(response) {
																	   
	//console.log(response);

	//return false;
	
	if(response.Ack == '1') {
	alert('Product added to cart');	
		} 
                else if(response.Ack == '2')
                {
                    alert('Product updated to cart');
                }
                 else if(response.Ack == '3')
                
                {
                   // console.log(response);
                  //$('#loadingmessage').hide('fast');
                    // $scope.myCarts();
                       alert(response.msg);
                }
                
                 else if(response.Ack == '4')
                
                {
                   // console.log(response);
                 // $('#loadingmessage').hide('fast');
                    // $scope.myCarts();
                       alert(response.msg);
                }
                
               else {
			
	alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
        // console.log(err); 
    }); 	
			
			}; 
                        
    
    $scope.auctiondetail = function(userid,productid){
    //alert(productid);
     //var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;
  
  /* bid.bidprice=bid.bidprice;
    bid.productid =$scope.product_id;
    bid.userid = $scope.user_id; */
     //console.log(bid);
      userService.getauctiondetails( userid,productid,$scope.usersSelectedCurrency).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    console.log(response.UserDetails);
	
		$scope.UserDetails=response.UserDetails;

		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };                     

    
    userService.reviews($scope.product_id1).then(function(response) {

	//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    
                    console.log('reviewss',response.reviews);
	$scope.allreviews=response.reviews;
        
		//$scope.productLists=response.productList;
                
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
        
         userService.countview($scope.product_id1).then(function(response) {

	//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.countview=response.countview;
                     $scope.Showdetails();
		//$scope.productLists=response.productList;
                
		
		

  } else {
        $scope.Showdetails();
		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
        
        
        
        
});
