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
$scope.allreviews = {};
$scope.date = new Date('hh:mm:ss a');
$scope.review.rating =0;
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
$scope.error ='';
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

 
$scope.product_id=atob($stateParams.id);  

$scope._Index = 0;

    // if a current image is the same as requested image
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
 
 $scope.Showdetails = function(){
   //  alert('hi');
 

        userService.productDetails($scope.product_id,userInfo.user_id).then(function(response) {

	console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    //alert(response.productList);
	
		$scope.productLists=response.productList;
                $scope.is_hide=0;
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       userService.reviews($scope.product_id).then(function(response) {

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
    
    }; 

    

 $scope.emailtothevendor = function(seller_id,message){
   //  alert('hi');
 $scope.loader = false;
 var product_id = $stateParams.id;
 //alert(message);
 if(userInfo.user_id){

        userService.interestedEmail(userInfo.user_id,seller_id,product_id,'',message).then(function(response) {

	//console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	$scope.loader = true;
		// $scope.productLists=response.productList;
		swal("Message Sent Successfully",'','success');
		$scope.is_hide=0;
                $scope.is_click=0;
		

  } else {
      $scope.loader = true;
swal("Mail can not be sent",'','error');
		}
	
				   
	}, function(err) {
            $scope.loader = true;
	console.log(err); 
	});
 }else{
     $scope.loader = true;
     $('#login').modal('show');
 }
       
    
    }; 
        
$scope.checklogin = function(){	
       $('#login').modal('show'); 
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
			
	swal('Error !!!!','','error');			
			}
	
	
	
	
																	   
       }, function(err) {
        // console.log(err); 
    }); 	
			
			}; 

    
    $scope.addbid = function(bid){
    //alert('bid');
     //var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;
        //$scope.checkauctionvaliditybeforeaddbid();
        bid.bidincrement=5;
    bid.bidprice=bid.bidprice;
    bid.productid =$scope.product_id;
    bid.userid = $scope.user_id;
   // bid.uploaderid = bid.uploaderid;
    bid.uploaderid = $scope.productLists.uploader_id;
    if($scope.productLists.bidincrement && $scope.productLists.bidincrement!= 0 ){
    bid.bidincrement = $scope.productLists.bidincrement;
    }
    $scope.checkauctionvalidity();
    //alert(bid.bidprice);
     //console.log('bidding',bid);
      userService.addbid( bid.userid,bid.productid,bid.bidprice,bid.uploaderid,bid.bidincrement).then(function(response) {

	//console.log("vv",response);
		
		if(response.Ack == '1') {
		 $scope.Showdetails();
                // $('#myModal').modal('hide');
                 //alert('Secessfully submitted your bid');
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };
    
 $scope.emailtothevendorinterest = function(seller_id,type){
   //  alert('hi');
 $scope.loader1 = false;
       var product_id = $stateParams.id;
 if(userInfo.user_id){

        userService.interestedEmail(userInfo.user_id,seller_id,product_id,type).then(function(response) {

	//console.log("vv",response);
		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                   // alert('gg');
	$scope.loader1 = true;
		// $scope.productLists=response.productList;
		//swal("Mail Sent Successfully",'','success');
		$scope.Showdetails();
		

  } else {
      $scope.loader = true;
swal("Mail can not be sent",'','error');
		}
	
				   
	}, function(err) {
            $scope.loader = true;
	console.log(err); 
	});
 }else{
    $scope.loader1 = true;
     $('#login').modal('show');
 }    
       
    
    };   
    
    
    $scope.addreview = function(review){

       
    review.review=review.review;
    review.rating=review.rating;    
    review.productid =$scope.product_id;
    review.userid = $scope.user_id;
    review.recomend =review.recomend;
   
   // alert(review.review);
     //console.log('review',review);
      userService.addreview( review.userid,review.productid,review.review,review.rating,review.recomend).then(function(response) {

	console.log("vv",response);
		
		if(response.Ack == '1') {
		 $scope.Showdetails();
                 $('#myModal1').modal('hide');
                 swal('Secessfully submitted your Reviwe','','success');
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };
    
    
    $scope.is_clicked = function(review){

       
    $scope.user_id=userInfo.user_id;
   
  if($scope.user_id){
     $scope.is_click=1;
     $scope.is_hide=1;
     //$scope.Showdetails();
     
  }else{
      $('#login').modal('show');
      $scope.is_click =0;
  }
        
       
    
    };
    
    
    
    $scope.checkauctionvalidity = function(){
         
        
        userService.checkauctionvalidity($scope.product_id,userInfo.user_id).then(function(response) {
             if(response.Ack == '1') { 
                 $('#password').modal('show');
                 
            } else if(response.Ack == '2'){
         $scope.winnermsg ='Congratulation, You Are Winner';
         $('#myModal').modal('hide');
          $('#password').modal('hide');
           $('#winner').modal('show'); 
           
    }else if(response.Ack == '3'){
       
                     $scope.winnermsg ='Better Luck Next Time,Please Try Our Other Auctions';
                     $scope.winnerlink = '1';
                     $('#myModal').modal('hide');
                      $('#password').modal('hide');
                     $('#winner').modal('show');
                   // $scope.isExists=0;
		}
            
        }, function(err) {
	console.log(err); 
	});
    };
    
    $scope.checkpassword = function(pass){
        
       
         
        pass.password=pass.password;
        pass.user_id=userInfo.user_id; 
        //alert(pass.user_id);
        userService.checkpassword(pass,pass.user_id).then(function(response) {
		console.log('checkpass',response)
		$scope.isExists=1;
		if(response.Ack == '1') {
                   $scope.error ='';
                    $('#myModal').modal('show');
                    $('#password').modal('hide');
		
		}else if(response.Ack == '2'){
                   //$('#winner').modal('show');
                   $scope.error ='Plsease enter connect password';
                   
                   
                } else {
                   
                     $scope.error ='Plsease enter connect password';
                    
                   // $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
    
        
       
    
    };
    
        
 $scope.addmessage = function(message){
    //$scope.checkpassword();
 message.message=message.message;
  message.to_id=message.seller_id;
   message.from_id=userInfo.user_id; 
   message.product_id =$scope.product_id;
  // message.user_id=;
             userService.addmessage(message).then(function(response) {
		//console.log('htype',response);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    
                    $scope.is_hide=0;
                $scope.is_click=0;
                  $scope.Showdetails();  
                
		
		}else if(response.Ack == '0'){
                    
                   swal(response.msg,'','error');
                   
                } else {
                    
                   // console.log('ppp');	
                   // $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}       
 
 var formdata = new FormData();
            $scope.getTheFiles = function ($files) {              
                angular.forEach($files, function (value, key) {
                    formdata.append(key, value);
                });
            };
            // NOW UPLOAD THE FILES.
            $scope.uploadFiles = function () {
                var request = {
                       method: 'POST',
                       url: 'uploadFile.php',
                       data: formdata,
                       headers: {
                           'Content-Type': undefined
                       }
                };
                   $http(request).success(function(data) {
                     $scope.msg=data.message;                 
                      console.log('success!');
                    })
                    .error(function(data) {
                      $scope.msg=data.message;
                    });
            }
            
            $scope.checkauctionvaliditybeforeaddbid = function(bid){
                bid.bidincrement=5;
    bid.bidprice=bid.bidprice;
    bid.productid =$scope.product_id;
    bid.userid = $scope.user_id;
   // bid.uploaderid = bid.uploaderid;
    bid.uploaderid = $scope.productLists.uploader_id;
    if($scope.productLists.bidincrement && $scope.productLists.bidincrement!= 0 ){
    bid.bidincrement = $scope.productLists.bidincrement;
    }
        userService.checkauctionvaliditybeforeaddbid($scope.product_id,userInfo.user_id).then(function(response) {
             if(response.Ack == '1') { 
                 $scope.addbid2(bid)
                 
            } else if(response.Ack == '2'){
         $scope.winnermsg ='Congratulation , You Win This Auction. PLease Pay Now';
         $scope.winnerlink = '2';
         $('#password').modal('hide');
          $('#myModal').modal('hide');
           $('#winner').modal('show'); 
           
    }else if(response.Ack == '3'){
         $scope.winnermsg ='Better Luck Next Time.';
         $scope.winnerlink = '1';
         $('#password').modal('hide');
          $('#myModal').modal('hide');
           $('#winner').modal('show'); 
           
    }
            
        }, function(err) {
	console.log(err); 
	});
    };
    
      $scope.gotolink = function(bid){
          //alert();
          $('#winner').modal('hide');
          $state.go('frontend.searchListing');
      }
      $scope.gotolink2 = function(product_id){
          //alert();
          $('#winner').modal('hide');
          $state.go('frontend.auctionpayment',{product_id:btoa(product_id)});
      }
    
    $scope.addbid2 = function(bid){
    //alert('bid');
     //var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	//$scope.user_id=userInfo.user_id;
        //$scope.checkauctionvaliditybeforeaddbid();
        bid.bidincrement=5;
    bid.bidprice=bid.bidprice;
    bid.productid =$scope.product_id;
    bid.userid = $scope.user_id;
   // bid.uploaderid = bid.uploaderid;
    bid.uploaderid = $scope.productLists.uploader_id;
    if($scope.productLists.bidincrement && $scope.productLists.bidincrement!= 0 ){
    bid.bidincrement = $scope.productLists.bidincrement;
    }
   // $scope.checkauctionvalidity();
    //alert(bid.bidprice);
     //console.log('bidding',bid);
      userService.addbid( bid.userid,bid.productid,bid.bidprice,bid.uploaderid,bid.bidincrement).then(function(response) {

	//console.log("vv",response);
		
		if(response.Ack == '1') {
		 $scope.Showdetails();
                // $('#myModal').modal('hide');
                 //alert('Secessfully submitted your bid');
		
		

  } else {

		}
	
				   
	}, function(err) {
	console.log(err); 
	});
        
       
    
    };
    
    $scope.addwishlist2 = function(product_id,owner_id){
	 
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
	 

    userService.addFavWishlist(userInfo.user_id,product_id,owner_id).then(function(response) {
		
                
	 if(response.Ack == '1') {
				//alert (response.msg);
                //alert ('Added to your Watchlist');
				//$state.go('frontend.wishlist');
                $window.location.reload();                
                                
                              
                                
                }
                
        
        else {
//alert ('Already Added in your wishlist'); 
              //alert('Error !!!!');
              $window.location.reload();  
              }
																	
	}, function(err) {
           // alert ('Already Added in your wishlist');
            $window.location.reload();
         console.log(err); 
    });
	 
} 

$scope.addlike2 = function(product_id,owner_id){
	 
  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
	 

    userService.addlike(userInfo.user_id,product_id,owner_id).then(function(response) {
		
                
	 if(response.Ack == '1') {
				//alert (response.msg);
                //alert ('You liked The Product');
				//$state.go('frontend.wishlist');
                $window.location.reload();                
                                
                              
                                
                }
                
        
        else {
//alert ('Already Added in your like'); 
              //alert('Error !!!!');
              $window.location.reload();  
              }
																	
	}, function(err) {
           // alert ('Already Added in your wishlist');
            $window.location.reload();
         console.log(err); 
    });
	 
}
});

