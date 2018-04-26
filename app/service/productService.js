app.service('productService', function($q, $http, $window,$rootScope,Upload) {

  var saveProductDetails = function(data) {

    alert(data);

    return $q(function(resolve, reject) { 
    //alert(aaa);        
  console.log(data);           
//  return false;          
        Upload.upload({
                url: $rootScope.serviceurl+"users/addProducts",
                data: data
            }).then(function (response) {
                  resolve(response.data); 
            }, function (response) {
                reject(response.data);
        }); 
    });
       
 };


 var homelistproducts = function() {
        return $q(function(resolve, reject) {

          var userInfo = JSON.parse($window.localStorage["userInfo"]);
var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';  
                
   //var encodedString ='{"user_id":""}';           
                   
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"frontend/listProducts",
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
 
 
 
// For All Gym Listing
 var listproducts = function() {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listJob",
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


 var listrequestreceived = function(job_id) {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'","job_id":"'+ job_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"useracceptedlisting",
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


 var listacceptedproducts = function() {
        return $q(function(resolve, reject) {
                
      var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
               
        $http({
         method: 'POST',
        // url: $rootScope.serviceurl+"finalacceptedjobs",
        url: $rootScope.serviceurl+"myacceptJobList",
        
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

 var listhireprovider = function() {
        return $q(function(resolve, reject) {
                
      var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
               
        $http({
         method: 'POST',
        // url: $rootScope.serviceurl+"finalacceptedjobs",
        url: $rootScope.serviceurl+"myhiredJobList",
        
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

 var listawaitingprovider = function() {
        return $q(function(resolve, reject) {
                
      var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
               
        $http({
         method: 'POST',
        // url: $rootScope.serviceurl+"finalacceptedjobs",
        url: $rootScope.serviceurl+"waitingapprovedJobList",
        
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


var nudgeRequest = function(user_id,owner_id,job_id) {
        return $q(function(resolve, reject) {
                
    //  var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"user_id":"'+ user_id +'","owner_id":"'+ owner_id +'","job_id":"'+ job_id +'"}';
      //alert(encodedString);
               
        $http({
         method: 'POST',
        // url: $rootScope.serviceurl+"finalacceptedjobs",
        url: $rootScope.serviceurl+"NudgeCustomer",
        
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
              // alert('Alert send');
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



 var assignworker = function(job_id,owner_id,assigned_user_id) {
        return $q(function(resolve, reject) {
                
     // var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"job_id":"'+ job_id +'","user_id":"'+ owner_id +'","assigneduser_id":"'+ assigned_user_id +'"}';
         // alert(encodedString);     
console.log(encodedString);

        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"assignedworker",
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

 var serviceComplete = function(job_id,owner_id,user_id) {
        return $q(function(resolve, reject) {
                
     // var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"job_id":"'+ job_id +'","owner_id":"'+ owner_id +'","user_id":"'+ user_id +'"}';
         // alert(encodedString);     
console.log(encodedString);

        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"serviceComplete",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
               
                $window.location.href = '#/awaiting';
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


 var userRejectJob = function(job_id,owner_id,assigned_user_id) {
        return $q(function(resolve, reject) {
                
     // var userInfo = JSON.parse($window.localStorage["userInfo"]);
      var encodedString ='{"job_id":"'+ job_id +'","owner_id":"'+ owner_id +'","user_id":"'+ assigned_user_id +'"}';
          console.log(encodedString);     
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"userRejectJob",
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





// For Product Description Page
var productdetails = function(id) {
        return $q(function(resolve, reject) {
                
var userInfo = JSON.parse($window.localStorage["userInfo"]);
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"product_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/productsDetails",
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









 var myjobs = function() {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"myjobs",
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



var hiremember = function(job_id) {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"job_id":"'+ job_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"hiremember",
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

 
 var ProviderCompleteList = function(job_id) {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"job_id":"'+ job_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"ProviderCompleteList",
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
 var listfinalacceptedprovider = function(user_id) {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ user_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"FinalCompleteListProvider",
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
 
 var listfinalaccepteduser = function(user_id) {
        return $q(function(resolve, reject) {
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ user_id +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"FinalCompleteListUser",
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


 
 var GiveReview = function(user,job_id,owner_id,user_id) {
        return $q(function(resolve, reject) {
            
            var rating=user.rating;
            var comment=user.comment;
                
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"job_id":"'+ job_id +'","owner_id":"'+ owner_id +'","user_id":"'+ user_id +'","rating":"'+ rating +'","comment":"'+ comment +'"}';
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"GiveReview",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
               
                $window.location.href = '#/pastuser';
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


  var listarticalecatname = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"articlecategorieslist",
         //data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           } else {
          //console.log('ok2');
              resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };
 
  var showArticle = function(cat_id) {
        return $q(function(resolve, reject) {
                

var encodedString ='{"cat_id":"'+ cat_id +'"}';
            console.log(encodedString);
            console.log($rootScope.serviceurl+"categoryarticledetails");
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"categoryarticledetails",
         data: encodedString,

         //console.log(url);
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
          
           if(response.data.Ack == "1") {

              resolve(response.data); 
           } else {

              resolve(response.data); 
           }

        },function(response) {
        
          reject(response);
            });
        });
 };
 
 
 /* var listAllProducts = function(user_id) {
        return $q(function(resolve, reject) {
						  	
   var encodedString ='{"user_id":"'+ user_id +'"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/listProducts",
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
 
 
 
 var listMenuCategory = function() {
        return $q(function(resolve, reject) {
						  	
   var encodedString ='{"user_id":"","type":"1"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/listMenuCategory",
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
 
 var homeResturants = function() {
        return $q(function(resolve, reject) {
						  	
   var encodedString ='{"user_id":"","type":"1"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/homeResturants",
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
 
 
 
 
 var listAllOthers = function(user_id) {
        return $q(function(resolve, reject) {
						  	
   var encodedString ='{"user_id":"'+ user_id +'","type":"2"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/listrResturant",
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
 
 
  var myMenus = function(user_id) {
        return $q(function(resolve, reject) {
						  	
   var encodedString ='{"user_id":"'+ user_id +'"}';				   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/myMenus",
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
 
 
 var resturantDetailsMenu = function(user_id,restaurent_id) {
        return $q(function(resolve, reject) {
						  	
 var encodedString ='{"user_id":"'+ user_id +'","resturant_id":"'+ restaurent_id +'"}';			   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/resturantDetailsMenu",
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
 
 
 var getBusinessDetails = function(user_id) {
        return $q(function(resolve, reject) {
						  	
 var encodedString ='{"user_id":"'+ user_id +'","resturant_id":""}';			   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/resturantDetails",
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
 
 
	var removeMenuItems = function(menu_id) {
	return $q(function(resolve, reject) {
	
	var encodedString ='{"menu_id":"'+ menu_id +'"}';			   
		console.log(encodedString);	
//return false;
	
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/removeMenuItems",
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
	};  */ 
 
  
/* var saveBusinessDetails = function(user,user_id) {
        return $q(function(resolve, reject) {
						  	
 var encodedString ='{"user_id":"'+ user_id +'","name":"'+ user.name +'","address":"'+ user.address +'","lat":"'+ user.lat +'","lang":"'+ user.lang +'","opening_hours":"'+ user.opening_hours +'","description":"'+ user.description +'","phone":"'+ user.phone +'","email":"'+ user.email +'","type":"'+ user.type +'"}';			   
						   
	console.log(encodedString);	
	//return false;
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/addResturants",
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
 }; */  
 
 
 
 
/*   var addMenu = function(data) {
    return $q(function(resolve, reject) { 
					   
	console.log(data);				   
//	return false;				   
        Upload.upload({
                url: $rootScope.serviceurl+"users/addMenus",
                data: data
            }).then(function (response) {
                  resolve(response.data); 
            }, function (response) {
                reject(response.data);
        }); 
    });
       
 }; */
 
 
 
 
/* var addMenu = function(user,user_id) {
        return $q(function(resolve, reject) {
						  	
 var encodedString ='{"vendor_id":"'+ user_id +'","resturant_id":"'+ user.resturant_id +'","category_id":"'+ user.category_id +'","menu_name":"'+ user.menu_name +'","price":"'+ user.price +'","menu_description":"'+ user.menu_description +'","type":"'+ user.type +'"}';			   
						   
	console.log(encodedString);	
	//return false;
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/addMenus",
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
 };  */ 
 
 
 
 
 
 return {
  saveProductDetails: saveProductDetails,
  homelistproducts: homelistproducts,
  listacceptedproducts: listacceptedproducts,
  listhireprovider: listhireprovider,
   listproducts: listproducts,
  assignworker: assignworker,
  listrequestreceived: listrequestreceived,
  productdetails: productdetails,
  hiremember:hiremember,
  serviceComplete:serviceComplete,
  listfinalacceptedprovider:listfinalacceptedprovider,
   listfinalaccepteduser:listfinalaccepteduser,
  ProviderCompleteList:ProviderCompleteList,
    nudgeRequest:nudgeRequest,
   myjobs:myjobs,
   listawaitingprovider:listawaitingprovider,
    GiveReview:GiveReview,
  userRejectJob:userRejectJob,
  listarticalecatname:listarticalecatname,
  showArticle:showArticle,
	/*  listMenuCategory: listMenuCategory,
    listAllRestaurents: listAllRestaurents,
	listAllOthers: listAllOthers,
	resturantDetailsMenu: resturantDetailsMenu,
	getBusinessDetails: getBusinessDetails,
	
	myMenus: myMenus,
	homeResturants: homeResturants,
	addMenu : addMenu,
	removeMenuItems : removeMenuItems, */
};
    
});