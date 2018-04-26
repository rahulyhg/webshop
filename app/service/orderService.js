app.service('orderService', function($q, $http, $window,$rootScope,$filter) { 
 
 var listBuyerOrders = function(user_id,user_type) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"user_id":"'+ user_id +'"}';						   
var call_url='';						   
	if(user_type=='S')					   {
	call_url=$rootScope.serviceurl+"users/getOrderListSeller";	
	}
	
	else{
	call_url=$rootScope.serviceurl+"users/getOrderList";	
		
	}
						   
        $http({
         method: 'POST',
         url: call_url,
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };
 
 
 var gerOrderDetails = function(order_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"order_id":"'+ order_id +'"}';					   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/getOederDetails",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 }; 
 
 
 var getPendingOrderListSeller = function(user_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"user_id":"'+ user_id +'","type":"1"}';					   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/getPendingOrderListSeller",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 }; 
 
 var getAcceptedOrderListBuyer = function(user_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"user_id":"'+ user_id +'","type":"1"}';					   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/getAcceptedOrderListBuyer",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };  
 
 
 var getCart = function(user_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"user_id":"'+ user_id +'"}';					   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/getCart",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
               resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };  
 
 
	var addToCart = function(user_id,productID) {
	return $q(function(resolve, reject) {
	
var encodedString ='{"userid":"'+ user_id +'","productid":"'+ productID +'","quantity":"1"}';				   
	
	
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/addtocart",
	data: encodedString,
	headers: {'Content-Type': 'application/json'}
	}).then(function (response) {
	console.log(response.data);  
	if(response.data.Ack == "1") {
	console.log('ok');
	resolve(response.data); 
	} else {
	console.log('ok2');
	resolve(response.data); 
	}
	//console.log(response); 
	},function(response) {
	//console.log(response);  
	reject(response);
	});
	});
	};  
 
 
 
 
  var removeProductFromCart = function(user_id,product_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"userid":"'+ user_id +'","productid":"'+ product_id +'"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/removeProductFromCart",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };  
 
 
 
 
 var getStoreType = function(user_id,resturant_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"user_id":"'+ user_id +'","resturant_id":"'+ resturant_id +'"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/getStoreType",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };  
 
 
 var checkoutByCard = function(checkoutDetailsData,user_id,token) {
        return $q(function(resolve, reject) {
	
	
	
	var checkoutDetails = JSON.parse(checkoutDetailsData);
	console.log(checkoutDetails);
	var userInfo = JSON.parse($window.localStorage["userInfo"]);		
	var systemDate=$filter('date')(new Date(), "yyyy-MM-dd HH:mm:ss");

	var encodedString ='{"resturant_id":"'+ checkoutDetails.resturant_id +'","total_amount":"'+ checkoutDetails.total_amount +'","billing_name":"'+ checkoutDetails.billing_name +'","billing_email":"'+ checkoutDetails.billing_email +'","billing_phone":"'+ checkoutDetails.billing_phone +'","billing_address":"'+checkoutDetails.billing_address +'","shipping_address":"'+ checkoutDetails.shipping_address +'","shipping_city":"'+ checkoutDetails.shipping_city +'","shipping_state":"'+ checkoutDetails.shipping_state +'","shipping_zip":"'+ checkoutDetails.shipping_zip +'","user_id":"'+ userInfo.user_id +'","redeedm_wallet":"'+checkoutDetails.redeedm_wallet+'","wallet_balance":"'+checkoutDetails.wallet_balance+'","tokenID":"'+ token +'","system_datetime":"'+ systemDate +'"}';
	
/*	console.log(encodedString);
	return false;*/	
						   
						   
			$http({
			method: 'POST',
			url: $rootScope.serviceurl+"users/checkout",
			data: encodedString,
			headers: {'Content-Type': 'application/json'}
			}).then(function (response) {
		//	console.log(response.data);  
			if(response.data.Ack == "1") {
		//	console.log('ok');
			resolve(response.data); 
			} else {
			//console.log('ok2');
			reject(response);
			}
			//console.log(response); 
			},function(response) {
			//console.log(response);  
			reject(response);
			});
        });
 }; 
 
 
  var checkoutRestaurent = function(checkoutDetailsData,user_id,token) {
        return $q(function(resolve, reject) {
	
	
	
	var checkoutDetails = JSON.parse(checkoutDetailsData);
	console.log(checkoutDetails);
	var userInfo = JSON.parse($window.localStorage["userInfo"]);		
	var systemDate=$filter('date')(new Date(), "yyyy-MM-dd HH:mm:ss");
//	console.log($scope.user.resturant_type);
	//return false;
	var encodedString ='{"resturant_id":"'+ checkoutDetails.resturant_id +'","total_amount":"'+ checkoutDetails.total_amount +'","billing_name":"'+ checkoutDetails.billing_name +'","billing_email":"'+ checkoutDetails.billing_email +'","billing_phone":"'+ checkoutDetails.billing_phone +'","billing_address":"'+checkoutDetails.billing_address +'","shipping_address":"'+ checkoutDetails.shipping_address +'","shipping_city":"'+ checkoutDetails.shipping_city +'","shipping_state":"'+ checkoutDetails.shipping_state +'","shipping_zip":"'+ checkoutDetails.shipping_zip +'","user_id":"'+ userInfo.user_id +'","redeedm_wallet":"'+checkoutDetails.redeedm_wallet+'","wallet_balance":"'+checkoutDetails.wallet_balance+'","tokenID":"'+ token +'","system_datetime":"'+ systemDate +'"}';
	
	
						   
						   
			$http({
			method: 'POST',
			url: $rootScope.serviceurl+"users/checkoutRestaurent",
			data: encodedString,
			headers: {'Content-Type': 'application/json'}
			}).then(function (response) {
			console.log(response.data);  
			if(response.data.Ack == "1") {
			console.log('ok');
			resolve(response.data); 
			} else {
			console.log('ok2');
			reject(response);
			}
			//console.log(response); 
			},function(response) {
			//console.log(response);  
			reject(response);
			});
        });
 }; 
 
 
 
  var acceptOrder = function(order_id,user_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"order_status":"A","order_id":"'+ order_id +'","user_id":"'+user_id +'"}';			   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/acceptRestaurentOrders",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };  
 
  var cancelOrder = function(order_id,user_id) {
        return $q(function(resolve, reject) {
						  	
var encodedString ='{"order_status":"C","order_id":"'+ order_id +'","user_id":"'+user_id +'"}';			   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/cancelRestaurentOrders",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 }; 
 
 
  var ConfirmPayment = function(user_id,order_id,token,total_amount) {
        return $q(function(resolve, reject) {
	var systemDate=$filter('date')(new Date(), "yyyy-MM-dd HH:mm:ss");					  	
var encodedString ='{"user_id":"'+ user_id +'","order_id":"'+ order_id +'","tokenID":"'+ token +'","system_datetime":"'+ systemDate +'","total_amount":"'+ total_amount +'"}';		   
		console.log(encodedString);				   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/ConfirmPayment",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			   console.log('ok');
              resolve(response.data); 
           } else {
			    console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };  
 
 
 
 
 return {
    listBuyerOrders: listBuyerOrders,
	getPendingOrderListSeller: getPendingOrderListSeller,
	getAcceptedOrderListBuyer: getAcceptedOrderListBuyer,
	getCart: getCart,
	addToCart: addToCart,
	getStoreType: getStoreType,
	removeProductFromCart: removeProductFromCart,
	gerOrderDetails: gerOrderDetails,
	checkoutByCard: checkoutByCard,
	checkoutRestaurent: checkoutRestaurent,
	acceptOrder: acceptOrder,
	cancelOrder: cancelOrder,
	ConfirmPayment: ConfirmPayment,
	
};
    
});