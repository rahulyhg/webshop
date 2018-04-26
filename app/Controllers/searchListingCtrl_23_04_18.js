'use strict';
/** 
 * controllers used for the login
 */
app.controller('searchListingCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

    
$scope.data = {};
$scope.user = {};
$scope.checkboxstr=[];
 $scope.user.brand=[];
 $scope.checkboxstr2=[];
 $scope.user.shop=[];
//alert('a');
 $scope.search = { price_min : '', price_max : '', amount_min : 0, amount_max : 10000 };
$scope.drpmodel='0';
 $scope.cobchange=function(){

 	$window.localStorage["selected_value"]=$scope.drpmodel;
 	$scope.searchListing();
     //alert("puja "+$window.localStorage["selected_value"]);

  }

var limitStep = 5;
$scope.limit = limitStep;
$scope.incrementLimit = function() {
    $scope.limit = '';
};


if ($window.localStorage["userInfo"]) {
var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
        $scope.getCurrentUserType();
}
else {
	var userInfo={};
	userInfo.user_id ="";
	$scope.user_id=userInfo.user_id;
}

$scope.isform1 =0;
	$scope.form1 = function(user) {

	$scope.isform1 =1;

}
$scope.brand=$stateParams.brand;

$scope.amount_min = $scope.search.amount_min;
$scope.amount_max = $scope.search.amount_max;


 //alert($scope.brand);
$scope.searchListing = function(){
   // alert($scope.amount_max);
// if ($window.localStorage["brandListing"]) {

// 	$scope.brandListing=$window.localStorage["brandListing"];
      
// }
// else if($scope.brand !=''){
// 	$scope.brandListing = $scope.brand;
// }else{
// 	$scope.brandListing = '';
// }

if($window.localStorage["brandListing"]){
	$scope.brandListing=$window.localStorage["brandListing"];
}else{
	$scope.brandListing='';
}

if($window.localStorage["sellerListing"]){
	$scope.sellerListing=$window.localStorage["sellerListing"];
}else{
	$scope.sellerListing='';
}

if($window.localStorage["selected_value"]){
	$scope.selected_value=$window.localStorage["selected_value"];
}else{
	$scope.selected_value='';
}
//console.log('amount',$scope.amount_max);
 userService.searchListing($scope.user_id,$scope.brand,$scope.brandListing,$scope.sellerListing,$scope.selected_value,$scope.amount_min,$scope.amount_max).then(function(response) {
     

		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.productList=response.productList;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
	
        }
        
$scope.getPrice  = function(amount_min,amount_max){
//alert(amount_min +''+amount_max);
	$scope.amount_min = amount_min;
        $scope.amount_max = amount_max;
         $scope.searchListing();
}


$scope.getYears = function(){

	userService.listYears().then(function(response) {
		
		if(response.Ack == '1') {
		$scope.YearsList=response.Years;
		console.log($scope.YearsList);


  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});

}


// $scope.getval = function(){
//     alert('hello');
//     userService.listYears().then(function(response) {
		
// 		if(response.Ack == '1') {
// 		$scope.YearsList=response.Years;
// 		console.log($scope.YearsList);


//   } else {
// 		}
	
				   
// 	}, function(err) {
// 	console.log(err); 
// 	});
// }
$scope.getYears();


$scope.getBrands = function(){

	userService.listbrand().then(function(response) {
		// console.log("ppa "+response.brandlist);

		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.brandlist=response.brandlist;
		//$scope.listbrands=response.brandList;
		// console.log("ppag "+response.brandList);

  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});

}


$scope.changeYearValue = function(selectedYear){

	$window.localStorage["selectedYear"]=$scope.selectedYear;
	alert("pp"+$scope.selectedYear);

	 $scope.searchListing();

}


$scope.getShops = function(){

	userService.listshops($scope.user_id).then(function(response) {
		if(response.Ack == '1') {
		$scope.shopOwners=response.shopOwners;

  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});

}

$scope.updatecheckbox = function(select,brand_id){


	      if (select)
        {
            $scope.user.brand.push(select);
        } else {
            $scope.deleteitem = $scope.user.brand.indexOf(brand_id);
            $scope.user.brand.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstr = $scope.user.brand.toString();
        $window.localStorage["brandListing"]=$scope.checkboxstr;
        console.log("Checkbox List",$scope.checkboxstr);
        $scope.searchListing();



}

$scope.updatecheckbox2 = function(select,shop_id){


	      if (select)
        {
            $scope.user.shop.push(select);
        } else {
            $scope.deleteitem = $scope.user.shop.indexOf(shop_id);
            $scope.user.shop.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstr2 = $scope.user.shop.toString();
        $window.localStorage["sellerListing"]=$scope.checkboxstr2;
        console.log("Checkbox List2",$scope.checkboxstr2);
        $scope.searchListing();



}




//spandan 23_04_2018

/*$scope.updateProfile = function(user){

	 		//console.log(user); return false;
	 		var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

			//alert($scope.user_id)
	   userService.updateProfile(user,$scope.user_id).then(function(response) {
																	   
	console.log(response);
	
	if(response.Ack == '1') {
	alert('Profile Updated');
        //user.fname='';
		} else {
			
	alert('Error !!!!');			
			}
	
	
	
	
																	   
       }, function(err) {
        // console.log(err); 
    }); 	
			
			};*/






});

