
app.controller('viewwinauctionCtrl', function ($rootScope, $scope, $http,$window, $location,$timeout,$stateParams,userService) {
$scope.data = {};
$scope.user = {};
//alert('a');
if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
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

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}
if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
   //alert($scope.usersSelectedCurrency+'yy');
}else{
    $scope.usersSelectedCurrency = 'KWD';
   // alert($scope.usersSelectedCurrency+'kk');
}

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
                        
   //alert();
    $scope.auctiondetail = function(userid,productid){
    //alert(productid);
     //var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;
  
  /* bid.bidprice=bid.bidprice;
    bid.productid =$scope.product_id;
    bid.userid = $scope.user_id; */
     //console.log(bid);
      userService.getauctiondetails( userid,productid).then(function(response) {

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
   
});