'use strict';
/** 
 * controllers used for the login
 */
app.controller('cartCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService) {

    
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


 $scope.myCarts = function(){
          // alert(cat_id);
           // return false;
             userService.myCarts($scope.user_id).then(function(response) {
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.all_cart_products=response.all_cart_products;
                $scope.final_quantity=response.final_quantity;
                 $scope.service_percent=response.admin_percent;
                 $scope.sub_total=response.sub_total;
                  $scope.grand_total=response.grand_total;
                  $window.localStorage["grandtotal"]=$scope.grand_total;
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');
                    $scope.sub_total=response.sub_total;
                  $scope.grand_total=response.grand_total;
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});  
        
 }  
         $scope.increaseQuantity = function(product){
	  
	  product.quantity = parseInt(product.quantity)+1;
	  
	   $scope.addTocart(product.id,product.quantity); 
           //console.log('Increasingggg',product);
  }
 
  $scope.decreaseQuantity = function(product){
	  
	  product.quantity = parseInt(product.quantity)-1;
	  //console.log('Decreasingggg',product.quantity);
	  //return false;
          //alert(product.quantity);
	 $scope.addTocart(product.id,product.quantity); 
	  
  }
  
  
  
  $scope.addTocart = function(product_id,quantity){
      //alert(quantity);
      console.log(quantity);
      
      $('#loadingmessage').show();
			
           // alert(product_id);
           // alert(quantity);
                // alert('dfgdf');

	 		//console.log(user); return false;
	 		var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	                $scope.user_id=userInfo.user_id;

			
	   userService.addTocart($scope.user_id,product_id,quantity).then(function(response) {
																	   
	

	//return false;
	
	if(response.Ack == '1') {
            
            $('#loadingmessage').hide('fast');
             $scope.myCarts();
	//alert('Product added to cart');	
		} 
                else if(response.Ack == '2')
                
                {
                    console.log(response);
                  $('#loadingmessage').hide('fast');
                     $scope.myCarts();
                            //alert('Product updated to cart');
                }
                
                else if(response.Ack == '3')
                
                {
                   // console.log(response);
                  $('#loadingmessage').hide('fast');
                     $scope.myCarts();
                       alert(response.msg);
                }
                
                 else if(response.Ack == '4')
                
                {
                   // console.log(response);
                  $('#loadingmessage').hide('fast');
                     $scope.myCarts();
                       alert(response.msg);
                }
                
               else {
			
	alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
        // console.log(err); 
    }); 	
			
			}; 
                        
                        
                         $scope.deletecart = function(id){
                             //alert(id);
          // alert(cat_id);
           // return false;
             userService.deletecart(id).then(function(response) {
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.myCarts();
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
 
        
       
        





	
});

