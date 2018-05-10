'use strict';
/** 
 * controllers used for the login
 */
app.controller('paymentCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window,userService,$state) {

    
$scope.data = {};
$scope.user = {};

$scope.getCurrentUserType();   
//alert('a');
//$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

var userInfo = JSON.parse($window.localStorage["userInfo"]);
var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//alert($window.localStorage['tname']);


$scope.cardpay = function(user){
    //console.log(user);
    //return false;
     //var plan_id = $localStorage.setItem(user.plan_id);
   //console.log(plan_id); return false;
   var gymiid = $window.localStorage['gymiid'];
   $scope.gymiid =gymiid;
   
   var trainer_id = $window.localStorage['tid'];
   $scope.trainer_id =trainer_id;
   
   var trainer_name = $window.localStorage['tname'];
   $scope.trainer_name =trainer_name;
   
    var clid = $window.localStorage['clid'];
   $scope.clid =clid;
   
    var starttime = $window.localStorage['starttime'];
   $scope.starttime =starttime;
   
    var endtime = $window.localStorage['endtime'];
   $scope.endtime =endtime;
   
   
    var day = $window.localStorage['day'];
   $scope.day =day;
   
   var plan_type = $window.localStorage['plantype'];
   $scope.plan_type =plan_type;
   
   
   var price = $window.localStorage['price'];
   $scope.price =price;
   
   


    $('#loadingmessage').show();
    $(':input[type="submit"]').prop('disabled', true);
    
    Stripe.setPublishableKey('pk_test_avhCsvHAaou7xWu7SxVCzptC');     
    
    
    Stripe.createToken({
    number: user.credit_card,
    cvc: user.cvv,
    exp_month: user.expirymm,
    exp_year: user.expiryyy
    }, $scope.checkoutByCard);
    
    
    
    };
    
    
        $scope.checkoutByCard = function(status, response,user){
        var token = response.id;
        console.log(response);    
        //console.log("zz",user); 
       // return false;
    var userInfo = JSON.parse($window.localStorage["userInfo"]);    
    $scope.user_id=userInfo.user_id;
    

    //alert($scope.plan_id);
        //var checkoutDetails =$window.localStorage["checkoutDetails"];
        userService.cardpay($scope.gymiid,userInfo.user_id,token,$scope.trainer_id, $scope.trainer_name,$scope.clid,$scope.starttime,$scope.endtime,$scope.day,$scope.plan_type,$scope.price).then(function(response) {
        

        
        if(response.Ack == '1') {
             $('#loadingmessage').hide('fast');
      $(':input[type="submit"]').prop('disabled', false);
    
//  $ionicLoading.hide();
    
//  if($scope.user.resturant_type==1){
// ONLY FIRE WHEN ORDER FROM RESTAURENT ====================================            
    // SocketService.emit('new_restaurent_order',response); 
//  }
     //$location.path('payment_success/'+response.orderID); 
     $state.go('frontend_other.success');
    } else {
         $('#loadingmessage').hide('fast');
      $(':input[type="submit"]').prop('disabled', false);
        $state.go('frontend_other.failure');
        
    // $location.path('payment_failure/'+response.Ack);       
    
    }                                                         
                                                                          
     }, function(err) {
//         console.log(err); 
//$location.path('payment_failure/0');  
$state.go('frontend_other.failure');
    }); 
        
        
        
        };  

    
//alert(encodedString);

//alert($window.localStorage['plantype']);


	/*productService.homelistproducts().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.productList=response.productsList;
		console.log($scope.productList);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});*/


	/* productService.listProductsByCategory().then(function(response) {
		
		$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.productList=response.productsList;
		console.log($scope.productList);	
		
		} else {
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); */
	
	
});

