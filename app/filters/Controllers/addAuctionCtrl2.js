'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('addAuctionCtrl2', function ($rootScope, $state, $scope, $http, $location,$timeout, $q, userService,$window,Upload) {

$scope.data = {};
$scope.user = {};

$scope.getCurrentUserType();   
//console.log($scope.current_user_type);




  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

	

	
   userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	console.log("zzz",response);  
	if(response.Ack == '1') {
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
	
	
	
		
	
	

	userService.listcategoryproduct().then(function(response) {
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.categorylist=response.categorylist;
               // $scope.user_idd=$scope.user_id;
		//console.log($scope.alljobs);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	}); 
        
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
		$scope.subcategorylist=response.subcategorylist;
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

$scope.addAuction = function(user2){
    
    console.log(user2);
    //return false;
    
    
     var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
  
 
    user2.cat_id=$window.localStorage["cat_id"];
    user2.subcat_id=$window.localStorage["subcat_id"];
    user2.name=$window.localStorage["name"];
    user2.description=$window.localStorage["description"];
    user2.brand=$window.localStorage["brand"];
    user2.price= $window.localStorage["price"];
      user2.currency= $window.localStorage["currency"];
     user2.quantity= $window.localStorage["quantity"];
     user2.preferred_date= $window.localStorage["preferred_date"];
     // user2.auction_start_date= $window.localStorage["auction_start_date"];
     // user2.auction_end_date= $window.localStorage["auction_end_date"];
     user2.special_price= $window.localStorage["special_price"];
    user2.user_id= $window.localStorage["user_id"];
    user2.model_year= $window.localStorage["model_year"];
    user2.breslet_type= $window.localStorage["breslet_type"];
   

   user2.movement=user2.movement;
    user2.gender=user2.gender;
     user2.reference=user2.reference;
      user2.date_of_purchase=user2.date_of_purchase;
       user2.status=user2.status;
        user2.owner_number=user2.owner_number;
         user2.country=user2.country;
          user2.size=user2.size;
           user2.location=user2.location;
            user2.work_hours=user2.work_hours;
             user2.image= user2.image;

             userService.addauction(user2).then(function(response) {
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    alert('Added Successfully.');
                    $state.go('frontend.myAuction');		
                    $scope.isExists=1;
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
	

});

