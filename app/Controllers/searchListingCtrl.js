'use strict';
/** 
 * controllers used for the login
 */
app.controller('searchListingCtrl', function ($rootScope, $scope, $http, $location,$timeout,$window, $state, userService,$stateParams) {

  $window.scrollTo(0, 0);  
$scope.data = {};
$scope.user = {};
$scope.checkboxstr=[];
 $scope.user.brand=[];
 $scope.checkboxstr2=[];
 $scope.user.shop=[];
  $scope.count =0;
   $scope.count1 =0;
 $scope.user.category=[];
   $scope.checkboxstrcat=[];
   $scope.checkboxstrmove =[];
   $scope.user.movements=[];
   $scope.categorylisting='';
    //$scope.maxprice =0;
 //$scope.minprice=0;
  $scope.size_amount_min=0;
   $scope.size_amount_max=0;
   if($scope.is_special_auction){
       $scope.is_special_auction=$scope.is_special_auction;
   }else{
     $scope.is_special_auction='';  
   }
   
    $scope.user.status=[];
   $scope.status=[];
//alert('a');
 $scope.search = { price_min : '', price_max : '', amount_min : 0, amount_max : 10000 };
$scope.drpmodel='0';

userService.listbracelet().then(function(response) {
          
		$scope.isExists=1;
		if(response.Ack == '1') {
                   
                    $scope.isExists=1;
                 
		$scope.braceletlist=response.braceletlist;
               
		} else {
                   
                    $scope.isExists=0;
		}
				   
	}, function(err) {
	console.log(err); 
	});
 $scope.cobchange=function(){

 	$window.localStorage["selected_value"]=$scope.drpmodel;
 	$scope.searchListing();
     //alert("puja "+$window.localStorage["selected_value"]);

  }

var limitStep = 5;
$scope.limit = limitStep;
$scope.incrementLimit = function() {
      $scope.limit = $scope.limit+5;
};
var limitStep1 = 5;
$scope.limit1 = limitStep;
$scope.incrementLimit1 = function() {
   $scope.limit1 = $scope.limit1+5;
};
$scope.brand='';
if($stateParams.brand){
$scope.brand=$stateParams.brand;
}

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

userService.getmaxprice(2,$scope.user_id).then(function(response) {
     //alert('getmaxprice');

		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.maxprice=response.maxprice;
                $scope.minprice=response.minprice;
                //$scope.amount_min = response.maxprice;
                // $scope.search = { price_min : '', price_max : '', amount_min : $scope.minprice, amount_max : $scope.maxprice };
                //$scope.search.amount_min=$scope.minprice;
                 //$scope.minprice=response.minprice;
               // $scope.amount_max=$scope.maxprice;
               // $scope.amount_min = $scope.search.amount_min;
               // $scope.amount_min = $scope.minprice;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		//spandan
                if($scope.maxprice){
                        //alert($scope.maxprice);
                     $scope.amount_max=$scope.maxprice;
                    }else{
                        $scope.amount_max=100000;
                    }
                    if($scope.minprice){
                       $scope.amount_min = $scope.minprice;
                    }else{

                     $scope.amount_min=0;
                    }
                    
                     $scope.visSlider = {
                        options: {
                          floor: $scope.amount_min,
                          ceil: $scope.amount_max,
                          step: 10
                        }
                      };
                
                
                
                
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
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


if($window.localStorage["categorylisting"]){
	$scope.categorylisting=$window.localStorage["categorylisting"];
        //alert();
}else{
	$scope.categorylisting='';
}

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


if($window.localStorage["currency"] != ''){
   $scope.usersSelectedCurrency = $window.localStorage["currency"] ;
}else{
    $scope.usersSelectedCurrency = 'KWD';
}


//spandan
if($scope.gender){
    $scope.gender;
}else{
    $scope.gender="";
}

if($scope.breslettype){
    $scope.breslettype;
}else{
    $scope.breslettype="";
}

if($scope.year){
    $scope.year;
}else{
    $scope.year="";
}

    
if($scope.amount_min){
    $scope.amount_min;
    $('#min_price').html($scope.amount_min);
}else{
    $scope.amount_min= 0;
    $('#min_price').html($scope.amount_min);
}	
if($scope.amount_max){
    $scope.amount_max;
    $('#max_price').html($scope.amount_max);
}else{
    $scope.amount_max= 10000;
    $('#max_price').html(10000);
}

if($scope.preferred_date){
    $scope.preferred_date;
}else{
    $scope.preferred_date="";
}

if($scope.country_id){
	$scope.country_id=$scope.country_id;
}else{
	$scope.country_id='';
}


if($scope.state_id){
	$scope.state_id=$scope.state_id;
}else{
	$scope.state_id='';
}

if($scope.city_id){
    $scope.city_id;
}else{
    $scope.city_id="";
}


if($window.localStorage["movementListing"]){
	$scope.movementListing=$window.localStorage["movementListing"];
        
}else{
	$scope.movementListing='';
}


if($scope.size_amount_max){
//    $scope.size_amount_max = $scope.size_amount_max;
//    $('#max_size_price').html($scope.size_amount_max);
$scope.size_amount_max= 100;
    $('#max_size_price').html(100);
}else{
    //alert('max');
    $scope.size_amount_max= 100;
    $('#max_size_price').html(100);
}

if($scope.size_amount_min){
    $scope.size_amount_min = 0;
    $('#min_size_price').html($scope.size_amount_min);
    
    
}else{
    $scope.size_amount_min= 0;
   // alert();
    $('#min_size_price').html($scope.amount_min);
}

if($window.localStorage["statuslist"]){
	$scope.statuslisting=$window.localStorage["statuslist"];
}else{
	$scope.statuslisting='';
}

 userService.searchListing($scope.user_id,$scope.brand,$scope.brandListing,$scope.sellerListing,$scope.selected_value,$scope.amount_min,$scope.amount_max,$scope.gender,$scope.breslettype,$scope.year,$scope.preferred_date,$scope.country_id,$scope.state_id,$scope.city_id,$scope.categorylisting,$scope.movementListing,$scope.size_amount_max,$scope.size_amount_min,$scope.is_special_auction,$scope.statuslisting,$scope.usersSelectedCurrency).then(function(response) {
     
//alert($scope.categorylisting);
		
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

$scope.getcategory = function(){

	userService.listcategoryproduct().then(function(response) {
		// console.log("ppa "+response.brandlist);

		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.categorylist=response.categorylist;
                $scope.count1 = response.count1;
                //alert();
		//$scope.listbrands=response.brandList;
		 console.log("categorylist "+response.categorylist);

  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});

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
                $scope.count = response.count;
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

$scope.getmovements = function(){
   // alert();
userService.getmovement().then(function(response) {
          
		$scope.isExists=1;
		if(response.Ack == '1') {
                   
                    $scope.isExists=1;
                 
		$scope.movementlist=response.movementlist;
                console.log('movementssss',$scope.movementlist);
               
		} else {
                   
                    $scope.isExists=0;
		}
				   
	}, function(err) {
	console.log(err); 
	});
        };
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

$scope.updatecheckboxcat = function(select,cat_id){


	      if (select)
        {
           // alert(select);
            $scope.user.category.push(select);
        } else {
            $scope.deleteitem = $scope.user.category.indexOf(cat_id);
            $scope.user.category.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstrcat = $scope.user.category.toString();
        $window.localStorage["categorylisting"]=$scope.checkboxstrcat;
        console.log("Checkbox List",$scope.checkboxstrcat);
        $scope.searchListing();



}
userService.listcategoryproduct().then(function(response) {
		// console.log("ppa "+response.brandlist);

		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.categorylist=response.categorylist;
               // alert();
		//$scope.listbrands=response.brandList;
		 //console.log("categorylist "+response.categorylist);

  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});
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

$scope.updatecheckboxmovement= function(select,movement_id){


	      if (select)
        {
            $scope.user.movements.push(select);
        } else {
            $scope.deleteitem = $scope.user.movements.indexOf(movement_id);
            $scope.user.movements.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstrmove = $scope.user.movements.toString();
        $window.localStorage["movementListing"]=$scope.checkboxstrmove;
       // console.log("Checkbox List2",$scope.checkboxstr2);
        $scope.searchListing();



}

//spandan

 userService.listAuctionDtates().then(function(response) {
         // alert('hii');
		//console.log('hello',response);
		//$scope.isExists=1;
		if(response.Ack == '1') {
                  //alert('hii');
		$scope.listAuctionDtates=response.listAuctionDtates;
               // $scope.user_idd=$scope.user_id;
		//console.log('hhhhh',$scope.listAuctionDtates);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});


userService.listcountry().then(function(response) {
           
		$scope.isExists=1;
		if(response.Ack == '1') {
                  
                    $scope.isExists=1;
                  
		$scope.countrylist=response.countrylist;
              
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
				   
	}, function(err) {
	console.log(err); 
	});



    $scope.state = function (c_id) {
        
        userService.liststate(c_id).then(function (response) {
           
            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);
               
                $scope.isExists = 1;
               
                $scope.statelist = response.statelist;
              

            } else {
                console.log('ppp');
                $scope.isExists = 0;
            }

        }, function (err) {
            console.log(err);
        });
        
        $scope.country_id=c_id;
       
        $scope.searchListing();
       
    }

    $scope.city = function (s_id) {

        userService.listcity(s_id).then(function (response) {

            $scope.isExists = 1;
            if (response.Ack == '1') {
                console.log(response);

                $scope.isExists = 1;

                $scope.citylist = response.citylist;


            } else {
                console.log('ppp');
                $scope.isExists = 0;
            }

        }, function (err) {
            console.log(err);
        });
        
        $scope.state_id=s_id;
       
        $scope.searchListing();

    }


  $scope.getstatuswatch = function(){

	userService.liststatus().then(function(response) {
		if(response.Ack == '1') {
		$scope.statuslist=response.statuslist;
console.log('checkboxstrstatus',response);
  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});

}

$scope.updatecheckbox3 = function(select,status){

//alert(status);
	      if (select)
        {
            $scope.user.status.push(select);
            //alert(select);
        } else {
            $scope.deleteitem = $scope.user.status.indexOf(status);
           // alert($scope.deleteitem);
            $scope.user.status.splice($scope.deleteitem, 1);

        }

         $scope.status = $scope.user.status.toString();
        $window.localStorage["statuslist"]=$scope.status;
       // console.log("checkboxstrstatus",$scope.checkboxstrstatus);
        $scope.searchListing();



}

});

