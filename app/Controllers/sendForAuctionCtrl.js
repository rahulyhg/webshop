'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('sendForAuctionCtrl', function ($rootScope, $state, $scope, $http, $location,$timeout, $q, userService, $stateParams, $window,Upload) {

if(!localStorage.getItem("userInfo"))
{
   $state.go('frontend.home', {reload:true})
}
$window.scrollTo(0, 0);

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


$scope.processforauction = function(user2){
    
    var product_id = $stateParams.product_id;
    // alert("pp "$stateParams.product_id);
    console.log(user2);
    //return false;
    
    
     var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
 	
   //user2.bid=user2.bid;
    user2.preferred_date=user2.preferred_date;
    user2.comments=user2.comments;
    
    user2.time_slot_id=user2.time_slot_id;
    user2.breslet_type=user2.breslet_type;
user2.model_year=user2.model_year;




             userService.auctionapproval(product_id, user2).then(function(response) {
		console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    
                     swal("Added Successfully.", "", "success")
                .then((value) => {
                    if(value == true){

                         $state.go('frontend.myAuction');
                    }

                });
                    
//                    
//                    swal('Added Successfully.','','success');
//                   window.location.reload()
//                    $scope.isExists=1;
//		
//		} else {
//                    console.log('ppp');	
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
        
       
        
}
	

	userService.listYears().then(function(response) {
		
		if(response.Ack == '1') {
		$scope.YearsList=response.Years;
		//console.log('YERRRRR',$scope.YearsList);


  } else {
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

});

