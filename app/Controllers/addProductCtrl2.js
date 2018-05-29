'use strict';
/** 
 * controllers used for the My Account
 */
app.controller('addProductCtrl2', function ($rootScope, $state, $scope, $http, $location,$timeout, $q, userService,$window,Upload) {

$scope.data = {};
$scope.user = {};
$scope.user2 = {};

$scope.getCurrentUserType();   
//console.log($scope.current_user_type);

if( $window.localStorage["selected_value"])
{
   
    $scope.ptype = $window.localStorage["selected_value"];
}
if( $window.localStorage["preferred_date"])
{
   
    $scope.preferred_date = $window.localStorage["preferred_date"];
}

//---------------------------------------------------------------
if( $window.localStorage["movement"])
{
     //alert();
    $scope.user2.movement = $window.localStorage["movement"];
}
if( $window.localStorage["gender"])
{
    $scope.user2.gender = $window.localStorage["gender"];
}
if( $window.localStorage["reference_number"])
{
    $scope.user2.reference = $window.localStorage["reference_number"];
}if( $window.localStorage["date_purchase"])
{
    $scope.user2.date_of_purchase = $window.localStorage["date_purchase"];
}
if( $window.localStorage["status_watch"])
{
    $scope.user2.status = $window.localStorage["status_watch"];
}
if( $window.localStorage["owner_number"])
{
    $scope.user2.owner_number = $window.localStorage["owner_number"];
}
if( $window.localStorage["country"])
{
    $scope.user2.country = $window.localStorage["country"];
}
if( $window.localStorage["size"])
{
    $scope.user2.size = $window.localStorage["size"];
}
if( $window.localStorage["location"])
{
    $scope.user2.location = $window.localStorage["location"];
}
if( $window.localStorage["work_hours"])
{
    $scope.user2.work_hours = $window.localStorage["work_hours"];
}
if( $window.localStorage["image"])
{
    $scope.user2.image = $window.localStorage["image"];
}


//-----------------------------------------



  	var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;

	

$scope.countrylist =''	;
   userService.getAccountDetails(userInfo.user_id).then(function(response) {
	
	//console.log("zzz",response);  
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
				$scope.user2.city=response.UserDetails.city;
				$scope.user2.state=response.UserDetails.state;
				$scope.user2.country=response.UserDetails.country;
                                
                                $scope.state($scope.user2.country);
                                $scope.city($scope.user2.state);
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
	
	userService.listcuntry().then(function(response) {
           // alert('hii');
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.countrylist=response.countrylist;
               // $scope.user_idd=$scope.user_id;
		console.log('country',response.countrylist);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
	
        userService.liststatus().then(function(response) {
           // alert('hii');
		//console.log(response.Ack);
		$scope.isExists=1;
		if(response.Ack == '1') {
                   // alert('Added Successfully.');
                   // $window.location.reload()
                    $scope.isExists=1;
                  //  $scope.user='';
		$scope.statuslist=response.statuslist;
               // $scope.user_idd=$scope.user_id;
		//console.log('status',response.statuslist);	
		
		} else {
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});
		
	
	

	userService.listcategoryproduct().then(function(response) {
		//console.log(response.Ack);
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
		//console.log(response.Ack);
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
		//console.log(response.Ack);
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
                    //console.log(response);
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

$scope.addProduct = function(user2){
    
    //console.log('he',user2);
    //return false;
    
    
     var userInfo = JSON.parse($window.localStorage["userInfo"]);	
	$scope.user_id=userInfo.user_id;
  
 	user2.type=$window.localStorage["selected_value"];
    user2.cat_id=$window.localStorage["cat_id"];
    //user2.subcat_id=$window.localStorage["subcat_id"];
    user2.name=$window.localStorage["name"];
    user2.description=$window.localStorage["description"];
    user2.brand=$window.localStorage["brand"];
    user2.price= $window.localStorage["price"];
      user2.currency= $window.localStorage["currency"];
     user2.quantity= $window.localStorage["quantity"];
     user2.preferred_date= $window.localStorage["preferred_date"];
    user2.user_id= $window.localStorage["user_id"];
     user2.model_year= $window.localStorage["model_year"];
    user2.breslet_type= $window.localStorage["breslet_type"];
    user2.time_slot_id= $window.localStorage["time_slot_id"];
   // user2.baseauctionprice= $window.localStorage["baseauctionprice"];
   // user2.thresholdprice= $window.localStorage["thresholdprice"];
    //console.log("Selected Value "+ user2.type);
    //return false;
    
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
             user2.baseauctionprice= user2.baseauctionprice;
             user2.thresholdprice= user2.thresholdprice;
             user2.state=user2.state;
             user2.city=user2.city;
//console.log(user2);
             userService.addproduct(user2).then(function(response) {
		//console.log('htype',response);
		$scope.isExists=1;
		if(response.Ack == '1') {
                    $window.localStorage["brand"]='';
                    swal(response.msg,'','success');
                    if(response.type == '1'){
                        
                       
                        if(response.utype == '1'){
                            
                            if(response.certified_user == 1){
                                
                            var lid = response.lastid; 
                            $state.go('frontend.userpayment',{pid:lid}); 
                            
                         }else{
                       
                       $state.go('frontend.myProduct');
                   }
                       
                        }else{
                    $state.go('frontend.myProduct');
                }
                    $scope.isExists=1;
                }  
                if(response.type == '2'){
                   
                   
                  $state.go('frontend.myAuction');
                  
                    $scope.isExists=1;
                }
		
		}else if(response.Ack == '0'){
                   swal(response.msg,'','error');
                   
                   
                } else {
                    
                    console.log('ppp');	
                    $scope.isExists=0;
		}
	
	
	
				   
	}, function(err) {
	console.log(err); 
	});     
     
}



  /*$scope.showAdvanced = function(ev) {
    $mdDialog.show({
      controller: DialogController,
      templateUrl: 'dialog1.tmpl.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose:true,
      fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
    })
    .then(function(answer) {
      $scope.status = 'You said the information was "' + answer + '".';
    }, function() {
      $scope.status = 'You cancelled the dialog.';
    });
  };*/


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

    }

	

});

