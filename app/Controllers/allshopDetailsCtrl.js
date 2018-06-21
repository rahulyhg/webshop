'use strict';
/** 
 * controllers used for the login
 */
app.controller('allshopDetailsCtrl', function ($rootScope, $scope,$interval, $http, $location,$timeout,$window, $state,$stateParams, userService) {

    
$scope.data = {};
$scope.user = {};
$scope.checkboxstr=[];
$scope.checkboxstrcat=[];
 $scope.user.brand=[];
  $scope.user.category=[];
 $scope.checkboxstr2=[];
$scope.checkboxstrmove =[];
   $scope.user.movements=[];
 $scope.user.shop=[];
  $scope.user.movement=[];
 $scope.maxprice =0;
 $scope.minprice=0;
 $scope.search = { price_min : '', price_max : '', amount_min : '', amount_max : '' };
$scope.shop_id=$stateParams.id; 
  
	
       
//alert('a');
 
  
  //alert('h'+$scope.maxprice);
 //console.log('search_obj',$scope.search);
$scope.drpmodel='0';
 $scope.cobchange=function(){

 	$window.localStorage["selected_value"]=$scope.drpmodel;
 	$scope.searchListing(); 
     //alert("puja "+$window.localStorage["selected_value"]);

  }
//if($scope.keyword){
//   alert($scope.keyword); 
//}else{
//   alert(); 
//}
var limitStep = 5;
$scope.limit = limitStep;
$scope.incrementLimit = function() {
    $scope.limit = '';
};
var limitStep1 = 5;
$scope.limit1 = limitStep;
$scope.incrementLimit1 = function() {
    $scope.limit1 = '';
};
$scope.brand='';
if($stateParams.id){
    //alert($scope.brand);
$scope.brand=$stateParams.id;
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


//$scope.brand=$stateParams.brand;

userService.getmaxprice(2).then(function(response) {
    // alert();

		
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.maxprice=response.maxprice;
                $scope.minprice=response.minprice;
                //$scope.amount_min = response.maxprice;
                
                //$scope.search.amount_min=$scope.minprice;
                 $scope.minprice=response.minprice;
                $scope.search.amount_max=$scope.maxprice;
               // $scope.amount_min = $scope.search.amount_min;
                $scope.amount_max = $scope.search.amount_max;
		//console.log($scope.alljobs);
                //$window.localStorage["userzip"]='';
		
		} else {
                    
                     $scope.exists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});


// alert($scope.amount_max);
$scope.searchListing = function(){
    
    

if($scope.keyword){
    
	$scope.keyword=$scope.keyword;
        $window.localStorage["keyword"] ='';
        //alert($scope.keyword);
        // $window.location.reload();
}else{
	$scope.keyword='';
        $window.localStorage["keyword"] ='';
       // alert($scope.keyword);
         //$window.location.reload();
}

if($window.localStorage["brandListing"]){
	$scope.brandListing=$window.localStorage["brandListing"];
}else{
	$scope.brandListing='';
}
if($window.localStorage["categorylisting"]){
	$scope.categorylisting=$window.localStorage["categorylisting"];
        //alert();
}else{
	$scope.categorylisting='';
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


if($window.localStorage["movementListing"]){
	$scope.movementListing=$window.localStorage["movementListing"];
}else{
	$scope.movementListing='';
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
    $scope.amount_min = $scope.amount_min;
    $('#min_price').html($scope.amount_min);
    
    
}else{
    $scope.amount_min= 0;
   // alert();
    $('#min_price').html($scope.amount_min);
}	
if($scope.amount_max){
    $scope.amount_max = $scope.amount_max;
    $('#max_price').html($scope.amount_max);
}else{
    //alert('max');
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
//alert($scope.country_id);

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


 //spandan end     

//console.log('amount',$scope.amount_max);
 userService.allShopListing($scope.user_id,$scope.brand,$scope.brandListing,$scope.sellerListing,$scope.selected_value,$scope.amount_min,$scope.amount_max,$scope.gender,$scope.breslettype,$scope.year,$scope.country_id,$scope.state_id,$scope.city_id,$scope.keyword,$scope.categorylisting,$scope.movementListing,$scope.shop_id).then(function(response) {
    // alert();

		//alert($scope.movementListing);
		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
                    $scope.exists=1;
		$scope.allshoplist=response.allshoplist;
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
		//console.log('YearsList',$scope.YearsList);


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

$scope.getcategory = function(){

	userService.listcategoryproduct().then(function(response) {
		// console.log("ppa "+response.brandlist);

		//$scope.isExists=response.Ack;
		if(response.Ack == '1') {
		$scope.categorylist=response.categorylist;
                //alert();
		//$scope.listbrands=response.brandList;
		 console.log("categorylist "+response.categorylist);

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
            alert('yes');
            $scope.user.category.push(select);
        } else {
            alert('select');
            $scope.deleteitem = $scope.user.category.indexOf(cat_id);
            $scope.user.category.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstrcat = $scope.user.category.toString();
        $window.localStorage["categorylisting"]=$scope.checkboxstrcat;
        console.log("Checkbox List",$scope.checkboxstrcat);
        $scope.searchListing();



}

$scope.updatecheckbox2 = function(select,shop_id){


	      if (select)
        {
            $scope.user.shop.push(select);
            alert(select);
        } else {
            $scope.deleteitem = $scope.user.shop.indexOf(shop_id);
            $scope.user.shop.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstr2 = $scope.user.shop.toString();
        $window.localStorage["sellerListing"]=$scope.checkboxstr2;
        console.log("Checkbox List2",$scope.checkboxstr2);
        $scope.searchListing();



}

$scope.updatecheckbox23 = function(select,movement2){

 alert(select);
	      if (select)
        {
           // alert('yes');
            $scope.user.movement.push(select);
        } else {
           // alert($scope.user.movement);
            $scope.deleteitem = $scope.user.movement.indexOf(movement2);
            $scope.user.movement.splice($scope.deleteitem, 1);

        }

         $scope.checkboxstr23 = $scope.user.movement.toString();
        $window.localStorage["movementListing"]=$scope.checkboxstr23;
        console.log("Checkbox List2",$scope.checkboxstr23);
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



});

