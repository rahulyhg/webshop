'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('addProductCtrl', function ($rootScope,$stateParams, $state, $scope, $http, $location,$timeout, $q, userService,$window,Upload) {

$scope.data = {};
$scope.user = {};
$scope.user2 = {};

$scope.getCurrentUserType();   
//console.log($scope.current_user_type);
$scope.timeslot = '';
$scope.drpmodel='1';
 $scope.cobchange=function(){

     //alert("puja "+$scope.drpmodel);

  }
//$scope.id=$stateParams.id;
if($stateParams.id){
   	userService.getproductdetailsforedit($stateParams.id).then(function(response) {
		
		if(response.Ack == '1') {
		$window.localStorage["price"]=response.allproduct.price;
                $window.localStorage["cat_id"]=response.allproduct.cat_id;
                $window.localStorage["name"]=response.allproduct.name;
                $window.localStorage["brand"]=response.allproduct.brand;
                $window.localStorage["currency"]=response.allproduct.currency;
                $window.localStorage["quantity"]=response.allproduct.quantity;
                $window.localStorage["brand"]=response.allproduct.brands;
                $window.localStorage["currency"]=response.allproduct.currency_code;
                
                $window.localStorage["movement"]=response.allproduct.movement;
                $window.localStorage["gender"]=response.allproduct.gender;
                $window.localStorage["reference_number"]=response.allproduct.reference_number;
                $window.localStorage["date_purchase"]=response.allproduct.date_purchase;
                $window.localStorage["status_watch"]=response.allproduct.status_watch;
                $window.localStorage["owner_number"]=response.allproduct.owner_number;
                $window.localStorage["country"]=response.allproduct.country;
                $window.localStorage["size"]=response.allproduct.size;
                $window.localStorage["location"]=response.allproduct.location;
                $window.localStorage["work_hours"]=response.allproduct.work_hours;
                $window.localStorage["image"]=response.allproduct.image;
                
                
		console.log('bbbb',$window.localStorage["movement"]);


  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});
}

//
//if( $window.localStorage["brand"])
//{
//    $scope.user2.brand = $window.localStorage["brand"];
//    //alert($scope.user2.brand);
//}
//if( $window.localStorage["brand"])
//{
//    $scope.user2.brand = $window.localStorage["brand"];
//    //alert($scope.user2.brand);
//}
//if( $window.localStorage["brand"])
//{
//    $scope.user2.brand = $window.localStorage["brand"];
//    //alert($scope.user2.brand);
//}
//if( $window.localStorage["brand"])
//{
//    $scope.user2.brand = $window.localStorage["brand"];
//    //alert($scope.user2.brand);
//}
//if( $window.localStorage["brand"])
//{
//    $scope.user2.brand = $window.localStorage["brand"];
//    //alert($scope.user2.brand);
//}
//if( $window.localStorage["brand"])
//{
//    $scope.user2.brand = $window.localStorage["brand"];
//    //alert($scope.user2.brand);
//}




 
if( $window.localStorage["brand"])
{
    $scope.user2.brand = $window.localStorage["brand"];
    //alert($scope.user2.brand);
}
if( $window.localStorage["currency"])
{
    $scope.user2.currency = $window.localStorage["currency"];
    //alert($scope.user2.brand);
}
if( $window.localStorage["price"])
{
    $scope.user2.price = $window.localStorage["price"];
}


if( $window.localStorage["price"])
{
    $scope.user2.price = $window.localStorage["price"];
}
if( $window.localStorage["cat_id"])
{
    $scope.user2.cat_id = $window.localStorage["cat_id"];
}
//if( $window.localStorage["subcat_id"])
//{
//    $scope.user2.subcat_id = $window.localStorage["subcat_id"];
//}
if( $window.localStorage["name"])
{
    $scope.user2.name = $window.localStorage["name"];
}
if( $window.localStorage["description"])
{
    $scope.user2.description = $window.localStorage["description"];
}
if( $window.localStorage["price"])
{
    $scope.user2.price = $window.localStorage["price"];
}
if( $window.localStorage["brand"])
{
    $scope.user2.brand = $window.localStorage["brand"];
}
if( $window.localStorage["currency"])
{
    $scope.user2.currency = $window.localStorage["currency"];
}

if( $window.localStorage["quantity"])
{
    $scope.user2.quantity = $window.localStorage["quantity"];
}
if( $window.localStorage["preferred_date"])
{
    $scope.user2.preferred_date = $window.localStorage["preferred_date"];
}
if( $window.localStorage["user_id"])
{
    $scope.user2.user_id = $window.localStorage["user_id"];
}
if( $window.localStorage["selected_value"])
{
    $scope.user2.drpmodel = $window.localStorage["selected_value"];
}
if( $window.localStorage["model_year"])
{
    $scope.user2.model_year = $window.localStorage["model_year"];
}
if( $window.localStorage["breslet_type"])
{
    $scope.user2.breslet_type = $window.localStorage["breslet_type"];
}


  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

	

	userService.listYears().then(function(response) {
		
		if(response.Ack == '1') {
		$scope.YearsList=response.Years;
		//console.log('YERRRRR',$scope.YearsList);


  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});



	
   userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	console.log("zzz",response);  
	if(response.Ack == '1') {
            
            //console.log("abcd",response.UserDetails.state);
				$scope.user.fname=response.UserDetails.fname;
				$scope.user.lname=response.UserDetails.lname;
				$scope.user.gender=response.UserDetails.gender;
				$scope.user.email=response.UserDetails.email;
				$scope.user.address=response.UserDetails.address;
				$scope.user.user_id=response.UserDetails.user_id;
				$scope.user.phone=response.UserDetails.phone;
				$scope.user.location=response.UserDetails.location;
                                $scope.user.business_type=response.UserDetails.business_type;
				$scope.user.city=response.UserDetails.city;
				$scope.user.state=response.UserDetails.state;
				$scope.user.country=response.UserDetails.country;
				$scope.user.zip=response.UserDetails.zip;
				$scope.user.address=response.UserDetails.address;
				
              }else{
				  
				$scope.user.fname='';
				$scope.user.lname='';
				$scope.user.gender='';
				$scope.user.email='';
				$scope.user.address='';
				$scope.user.user_id='';
				$scope.user.phone='';
				$scope.user.location='';
				$scope.user.city="";
				$scope.user.state="";
				$scope.user.country="";
				$scope.user.zip="";
				$scope.user.address='';
				
				  
			  }
	
	
	
														   
 }, function(err) {
         console.log(err); 
    }); 
	
	
	
		
	
	
//
//	userService.listcategoryproduct().then(function(response) {
//		console.log(response.Ack);
//		$scope.isExists=1;
//		if(response.Ack == '1') {
//                   // alert('Added Successfully.');
//                   // $window.location.reload()
//                    $scope.isExists=1;
//                  //  $scope.user='';
//		$scope.categorylist=response.categorylist;
//               // $scope.user_idd=$scope.user_id;
//		//console.log($scope.alljobs);	
//		
//		} else {
//                    console.log('ppp');	
//                    $scope.isExists=0;
//		}
//	
//	
//	
//				   
//	}, function(err) {
//	console.log(err); 
//	}); 
        
        userService.listcurrency().then(function(response) {
           // alert('hii');
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.currencylist=response.currencylist;
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
        
        
        
         userService.listbrand().then(function(response) {
           // alert('hii');
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.brandlist=response.brandlist;
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
        
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
        
        
             
        $scope.sub = function(cat_id){
          // alert(cat_id);
           // return false;
             userService.listsubcategory(cat_id).then(function(response) {
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    console.log(response);
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.categorylist=response.subcategorylist;
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

$scope.addProduct = function(user2){
    
    //console.log(user2);
    //return false;
    
    
     var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
        
        //alert(userInfo.user_type);exit;
  
 
    
    // user2.cat_id=user2.cat_id;
    // user2.subcat_id=user2.subcat_id;
    // user2.name=user2.name;
    // user2.description=user2.description;
    // user2.brand=user2.brand;
    // user2.price= user2.price;
    //  user2.quantity= user2.quantity;
    // user2.user_id= $scope.user_id;

    $window.localStorage["selected_value"]=$scope.drpmodel;
    $window.localStorage["cat_id"]=user2.cat_id;
     $window.localStorage["subcat_id"]=user2.subcat_id;
     $window.localStorage["name"]=user2.name;
     $window.localStorage["description"]=user2.description;
     $window.localStorage["brand"]=user2.brand;
     $window.localStorage["price"]=user2.price;
     $window.localStorage["currency"]=user2.currency;
     $window.localStorage["quantity"]=user2.quantity;
     $window.localStorage["preferred_date"]=user2.preferred_date;
     $window.localStorage["user_id"]=$scope.user_id;
     $window.localStorage["model_year"]=user2.model_year;
     $window.localStorage["breslet_type"]=user2.breslet_type;
     $window.localStorage["time_slot_id"]=user2.time_slot_id;
    // $window.localStorage["baseauctionprice"]=$scope.baseauctionprice;
   //  $window.localStorage["thresholdprice"]=$scope.thresholdprice;
   
   

  //console.log("Selected Value "+ $window.localStorage["selected_value"]);
//return false;
      $state.go('frontend.addProduct2');

 //user2.image= user2.image;
         //  alert( user.job_image);
         //alert(user1.product_image);
   // alert(user.question);
 //             userService.addproduct(user2).then(function(response) {
	// 	console.log(response.Ack);
	// 	$scope.isExists=1;
	// 	if(response.Ack == '1') {
 //                    alert('Added Successfully.');
 //                    $window.location.reload()
 //                    $scope.isExists=1;
		
	// 	} else {
 //                    console.log('ppp');	
 //                    $scope.isExists=0;
	// 	}
	
	
	
				   
	// }, function(err) {
	// console.log(err); 
	// });     
        
       
        
}

$scope.getAuctionTime = function(date){
    if(date){
       //alert(date);
   userService.getTimeslot(date).then(function(response) {
           // alert('hii');
		//console.log('kkkkk',response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                  
                    $scope.timeslot=response.time;
                   	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
    }
}


userService.getuserpayment().then(function(response) {
		
		if(response.Ack == '1') {
		$window.localStorage["userpayment"]=response.payment;
                
                

  } else {
		}
	
				   
	}, function(err) {
	console.log(err); 
	});


$scope.checkuserpayment = function(){
    //alert('ok');
    
    var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
       if(userInfo.user_type == 1){
           
           
           userService.getuserpayment().then(function(response) {
		
		if(response.Ack == '1') {
                    //alert(response.payment);exit;
                    if(response.payment== 0){
                    
                   $state.go('frontend.userpayment'); 
                    
                }else{
                    
                    $scope.addProduct();
                }
              
  }
	
				   
	}, function(err) {
	console.log(err); 
	});
     

     
 }
   
}





});

