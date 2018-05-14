'use strict';
/** 
 * controllers used for the login
 */
app.controller('productDetailsCtrl', function ($rootScope, $scope,$interval, $http, $location,$timeout,$window, $state,$stateParams, userService) {


//			$scope.ratings = [{
//				title : 'Rating',
//				//description : 'I\'m not editable but update myself with a timer...',
//				rating : 0,
//				basedOn : 5,
//				starsCount : 5,
//				iconClass : 'fa fa-star',
//				editableRating : true,
//				showGrade : true
//			}];
$scope.rating = {};
$scope.review = {};
$scope.review.rating =1;
$scope.rating.editableRating = true;
 $scope.rating.iconClass ='fa fa-star';
$scope.rating.starsCount =5;
$scope.rating.basedOn =5;
$scope.rating.showGrade = true;
$scope.rating.rating =1;
$scope.rating.title ='Rating';
        
			

		
 
$scope.data = {};
$scope.user = {};
$scope.productLists ='';
//alert('a');
$scope.loader = true;
$scope.loader1 = true;
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

 
$scope.product_id=$stateParams.id;  
 
 $scope.Showdetails = function(){
   //  alert('hi');
 

        userService.productDetails($scope.product_id,userInfo.user_id).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    //alert(response.productList);
	
		$scope.productLists=response.productList;
                
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    }; 

    

 $scope.emailtothevendor = function(seller_id){
   //  alert('hi');
 $scope.loader = false;
       var product_id = $stateParams.id;

        userService.interestedEmail(userInfo.user_id,seller_id,product_id).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	$scope.loader = true;
		// $scope.productLists=response.productList;
		alert("Mail Sent Successfully");
		
		

  } else {
      $scope.loader = true;
alert("Mail can not be sent ");
		}
	
				   
	}, function(err) {
            $scope.loader = true;
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

    
    $scope.addbid = function(bid){
    //alert(bid);
     //var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;
        bid.bidincrement=5;
    bid.bidprice=bid.bidprice;
    bid.productid =$scope.product_id;
    bid.userid = $scope.user_id;
   // bid.uploaderid = bid.uploaderid;
    bid.uploaderid = $scope.productLists.uploader_id;
    if($scope.productLists.bidincrement && $scope.productLists.bidincrement!= 0 ){
    bid.bidincrement = $scope.productLists.bidincrement;
    }
     //console.log('bidding',bid);
      userService.addbid( bid.userid,bid.productid,bid.bidprice,bid.uploaderid,bid.bidincrement).then(function(response) {

	console.log("vv",response);
		
		if(response.Ack == '1') {
		 $scope.Showdetails();
                 $('#myModal').modal('hide');
                 alert('Secessfully submitted your bid');
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };
    
 $scope.emailtothevendorinterest = function(seller_id){
   //  alert('hi');
 $scope.loader1 = false;
       var product_id = $stateParams.id;

        userService.interestedEmail(userInfo.user_id,seller_id,product_id).then(function(response) {

	//console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	$scope.loader1 = true;
		// $scope.productLists=response.productList;
		alert("Mail Sent Successfully");
		
		

  } else {
      $scope.loader = true;
alert("Mail can not be sent ");
		}
	
				   
	}, function(err) {
            $scope.loader = true;
	console.log(err); 
	});
        
       
    
    };   
    
    
    $scope.addreview = function(review){

       
    review.review=review.review;
    review.rating=review.rating;    
    review.productid =$scope.product_id;
    review.userid = $scope.user_id;
   
   // alert(review.review);
     //console.log('review',review);
      userService.addreview( review.userid,review.productid,review.review,review.rating).then(function(response) {

	console.log("vv",response);
		
		if(response.Ack == '1') {
		 $scope.Showdetails();
                 $('#myModal1').modal('hide');
                 alert('Secessfully submitted your Reviwe');
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };
    
    
    userService.reviews($scope.product_id).then(function(response) {

	//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    //alert(response.productList);
	
		//$scope.productLists=response.productList;
                
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
        
         
    
});

