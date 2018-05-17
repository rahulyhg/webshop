app.service('userService', function($q, $http, $window, $rootScope, Upload) {
 
 
 


var ServiceSection = function() {
return $q(function(resolve, reject) {

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/serviceSettings",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};




var ServiceCategory = function() {
return $q(function(resolve, reject) {

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/massageCategoryListing_web",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};
 
 
 
 
 var login = function(user) {
        return $q(function(resolve, reject) {
           // alert(user);
						   
						   
		var email = user.email;
		var password = user.password;
		var uuid='';
		var lat='';
		var lang='';


	
var encodedString ='{"email":"'+ email +'","password":"'+ password +'","device_type":"mobile","device_token_id":"","lat":"","lang":"","phone":""}';


						   
						   
	console.log(encodedString);		
	//return false;
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"userLogin",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
			// console.log('hello');
			 //resolve(response.data); 
                         if(response.data.Ack == "1") {
                             
                               resolve(response.data); 
                            } else {
                                 resolve(response.data); 
                            }
                         
                         
			 
			 },function(response) {
                     console.log(response);  
          reject(response);
            });
        });
 };
 
 
 
 
 
var signup = function(user) {

 return $q(function(resolve, reject) {
var encodedString ='{"fname":"'+ user.fname +'","lname":"'+ user.lname +'","email":"'+ user.email +'","password":"'+ user.password +'","phone":"'+ user.phone +'","device_type":"","type":"'+ user.type +'","device_token_id":"","my_latitude":"","my_longitude":""}';             
 // alert(encodedString);
 // return false;
  
  $http({
  method: 'POST',
  url: $rootScope.serviceurl+"userSignup",
  data: encodedString,
  headers: {'Content-Type': 'application/json'}
  }).then(function (response) {
  console.log(response.data);  
  if(response.data.Ack == "1") {
  console.log('ok');
       // $window.location.href = '#/home';
  resolve(response.data);
  } else {
  console.log('ok2');
  resolve(response.data);
  }
  },function(response) { 
  reject(response);
  });
  }); 
  };
      


 
 var notificationList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"listNotification",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
       resolve(response.data); 
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};


 var messagelist = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"unreadMessage",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
       resolve(response.data); 
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};


 var reviewList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"myReviews",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
      resolve(response.data); 
   } else {
        reject(response);
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};

 var articleDetails = function(article_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"article_id":"'+ article_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"articledetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
      resolve(response.data); 
   } else {
        reject(response);
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};






 var areaCoveredlist = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"areaCoveredList",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};


var addareaCovered = function(user,user_id) {

 return $q(function(resolve, reject) {
var encodedString ='{"user_id":"'+ user_id +'","area":"'+ user.area +'","zip":"'+ user.zip +'"}';             
  
  
  $http({
  method: 'POST',
  url: $rootScope.serviceurl+"areaCovered",
  data: encodedString,
  headers: {'Content-Type': 'application/json'}
  }).then(function (response) {
  console.log(response.data);  
  if(response.data.Ack == "1") {
  console.log('ok');
      //  $window.location.href = '#/home';
  resolve(response.data);
  } else {
  console.log('ok2');
  reject(response);
  }
  },function(response) { 
  reject(response);
  });
  }); 
  };



        
        
var postjob = function(user,user_id) {
    
    
return $q(function(resolve, reject) {
    
    user.user_id = user_id;
    
    Upload.upload({
                url: $rootScope.serviceurl+"postjob",
                data: user,
            }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
               $window.location.href = '#/myjobs';
           } else {
                resolve(response.data);
           }
                  // $window.location.href = '#/waitlisted';

            }, function (response) {
                reject(response.data);
        }); 

//var encodedString ='{"full_name":"'+ user.name +'","email":"'+ user.email +'","password":"'+ user.password +'","phone":"'+ user.phone +'","device_type":"","device_token_id":"","lat":"","lang":"","user_id":"'+ user_id +'"}';					   
	
	//console.log(encodedString);
	//return false;
	
	
	});
	};
    

        

var postjobHome = function(user,user_id) {
    
    
return $q(function(resolve, reject) {
    
    user.user_id = user_id;
    
    Upload.upload({
                url: $rootScope.serviceurl+"sendQuote",
                data: user,
            }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
               $window.location.href = '#/home';
           } else {
                resolve(response.data);
           }
                  // $window.location.href = '#/waitlisted';

            }, function (response) {
                reject(response.data);
        }); 

//var encodedString ='{"full_name":"'+ user.name +'","email":"'+ user.email +'","password":"'+ user.password +'","phone":"'+ user.phone +'","device_type":"","device_token_id":"","lat":"","lang":"","user_id":"'+ user_id +'"}';            
  
  //console.log(encodedString);
  //return false;
  
  
  });
  };
    


    
    
var forgotpass = function(user) {
        
        return $q(function(resolve, reject) {
	
	    var encodedString ='{"email":"'+ user.email +'"}';

        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"forgetpassword",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
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
    
    
    
    
    var invoiceList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"getInvoices",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == '1') {
                   console.log('ok666');
      resolve(response.data); 
   } else {
                    console.log('ok2');
       // reject(response);
         resolve(response.data);
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};

  

    var updateSetting = function(is_notify,is_email_notify,is_inapp_notify,user_id) {
    
 //alert(is_notify);
return $q(function(resolve, reject) {

var encodedString ='{"is_notify":"'+ is_notify +'","is_email_notify":"'+ is_email_notify +'","is_inapp_notify":"'+ is_inapp_notify +'","user_id":"'+ user_id +'"}';

//console.log(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"updateSetting",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == '1') {
                   console.log('ok666');
      resolve(response.data); 
   } else {
                    console.log('ok2');
       // reject(response);
         resolve(response.data);
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};

    
 
 
 
 
 
 
 
 
  var ChangePassword = function(user) {
  	
        return $q(function(resolve, reject) {
	
	    var encodedString ='{"user_id":"'+ user.user_id +'","password":"'+ user.password +'"}';
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"changepassword",
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
 
 var updateCard = function(user_id,user) {
  	
        return $q(function(resolve, reject) {
	
	    var encodedString ='{"user_id":"'+ user_id +'","cardno":"'+ user.cardno +'","cardholdername":"'+ user.cardholdername +'","exp_year":"'+ user.exp_year +'","exp_month":"'+ user.exp_month +'"}';
            //alert(encodedString)
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"updateCardDetails",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
            // alert("mmm");
           console.log("lllll",response.data);  
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
 
 
	 var getCounters = function(user_id) {
		return $q(function(resolve, reject) {
		
		var encodedString ='{"user_id":"'+ user_id +'"}';						   
		
		
		
		$http({
		method: 'POST',
		url: $rootScope.serviceurl+"users/getCounters",
		data: encodedString,
		headers: {'Content-Type': 'application/json'}
		}).then(function (response) {
		
		if(response.data.Ack == "1") {
		//console.log('ok');
		resolve(response.data); 
		} else {
		//console.log('ok2');
		reject(response);
		}	
		
		
		},function(response) {
		//console.log(response);  
		reject(response);
		});
		});
		};  
  
  
  
   var removearea = function(id) {
    return $q(function(resolve, reject) {
    
    var encodedString ='{"id":"'+ id +'"}';              
    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"removeArea",
    data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.ACK == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
    reject(response);
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };  
  

    var searchListing = function(user_id,brand,brandList,sellerList,selected_value,amount_min,amount_max,gender,breslettype,year,preferred_date) {
    return $q(function(resolve, reject) {
        
        //var encodedString ='{"user_id":"'+ user_id +'","brand":"'+ brand +'","brandList":"'+ brandList +'","sellerList":"'+ sellerList +'","selected_value":"'+ selected_value +'"}';
        var encodedString ='{"user_id":"'+ user_id +'","brand":"'+ brand +'","brandList":"'+ brandList +'","sellerList":"'+ sellerList +'","selected_value":"'+ selected_value +'","amount_min":"'+amount_min+'","amount_max":"'+amount_max+'","gender":"'+gender+'","breslettype":"'+breslettype+'","year":"'+year+'","preferred_date":"'+preferred_date+'"}';
         console.log(encodedString);
         //return false;
//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';

    
        // alert(encodedString);    
    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"auctionListSearch",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    
    
    
        var wishlist = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';

//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';

    
         //alert(encodedString);    
    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"myFavoriteProduct",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    
    
    
         var myproduct = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';

//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';

    
         //alert(encodedString);    
    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listmyProducts",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };


             var subscriptions = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listSubscriptions",
    data: encodedString,
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
    
    
    
    //spandan
    
    var subscribedlist = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listSubscribed",
    data: encodedString,
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
    
    
    
    
    
    
    


          var addsubscription = function(id) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","subscription_id":"'+ id +'"}';

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"addUserSubscription",
    data: encodedString,
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




    var purchaseSubscription = function(value) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","subscription_id":"'+ value.subscription_id +'","name":"'+ value.name +'","email":"'+ value.email +'","phone":"'+ value.phone +'"}';

    $http({
    method: 'POST',
   // url: $rootScope.serviceurl+"addUserSubscription",
    url: $rootScope.serviceurl+"UserSubscriptionpayment",
    data: encodedString,
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


    








           var myauction = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';

//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';

    
         //alert(encodedString);    
    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listmyAuctions",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    


    
    var listcategoryproduct = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listCategory",
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
    
        var listcurrency = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listCurrency",
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
  
var getAccountDetails = function(user_id) {
   // alert(user_id)
return $q(function(resolve, reject) {



var encodedString ='{"user_id":"'+ user_id +'"}';              



$http({
method: 'POST',
url: $rootScope.serviceurl+"userprofile",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};
   
        
var trainerList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/trainerListing",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};


var classListing = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"trainer_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/classListing",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};



var auctionList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';


$http({
method: 'POST',
url: $rootScope.serviceurl+"users/listAuction",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};




var removeAuction = function(auction_id) {
	return $q(function(resolve, reject) {
	
	var encodedString ='{"auction_id":"'+ auction_id +'"}';			   
		console.log(encodedString);	
//return false;
	
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/deleteAuction",
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



/*

var updateProfile = function(data) {
    return $q(function(resolve, reject) {
        					   
	console.log(data);
	//return false;				   
        Upload.upload({
                url: $rootScope.serviceurl+"users/updateProfile",
                data: data
            }).then(function (response) {
                  resolve(response.data); 
            }, function (response) {
                reject(response.data);
        }); 
    });
       
 }; */


     var updateProfile = function(data) {
    
return $q(function(resolve, reject) {

//var encodedString ='{"user_id":"'+data.user_id+'","fname":"'+data.fname+'","lname":"'+data.lname+'","email":"'+data.email+'","phone":"'+data.phone+'","gender":"'+data.gender+'","address":"'+data.address+'","business_type":"'+data.business_type+'"}';
 
//console.log(encodedString);


 Upload.upload({
method: 'POST',
url: $rootScope.serviceurl+"updateProfile",
data: data,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }  


        },function(response) {
//console.log(response);  
reject(response);
});
});
};
   
      
        
        
 
 
 
 
var logout = function(user_id) {
        return $q(function(resolve, reject) {
						   
	
var encodedString ='{"user_id":"'+ user_id +'"}';						   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"logout",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
			  // console.log('ok');              
              resolve(response.data);
           } else {
			   // console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };
 
 
 
 
 
 



 
var saveGymDetails = function(user,images) {

return $q(function(resolve, reject) {    
    
    
var userInfo = JSON.parse($window.localStorage["userInfo"]);

//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';
	user.user_id = userInfo.user_id;
        user.images = images;
	console.log(user);
	//return false;
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/addGym",
	data: user,
	headers: {'Content-Type': 'application/json'}
	}).then(function (response) {
	console.log(response.data);  
	if(response.data.Ack == "1") {     
        //$window.location.reload();
	resolve(response.data);
	} else {
	reject(response);
	}
	//console.log(response); 
	},function(response) {
	//console.log(response);  
	reject(response);
	});
	});
	};
 
 
 var gymDetails = function(user_id) {
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';						   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/gymDetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

 var gymList = function() {
return $q(function(resolve, reject) {

//var encodedString ='{"user_id":"'+ user_id +'"}';						   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/gymListing",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};



 var trainerDetails = function(id) {
return $q(function(resolve, reject) {

var encodedString ='{"trainer_id":"'+ id +'"}';						   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/trainerDetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};



var auctionDetails = function(id) {
return $q(function(resolve, reject) {

var encodedString ='{"auction_id":"'+ id +'"}';						   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/auctionDetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};


      

/*

var saveAuctionDetails = function(auc,user_id) {

return $q(function(resolve, reject) {
        
var encodedString ='{"user_id":"'+ user_id +'","title":"'+ auc.title +'","description":"'+ auc.description +'","price":"'+ auc.price +'","offer_price":"'+ auc.offer_price +'","start_date":"'+ auc.start_date +'","end_date":"'+ auc.end_date +'"}';

console.log('AUCTION',encodedString);
        
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/addAuction",
	data: encodedString,
	headers: {'Content-Type': 'application/json'}
	}).then(function (response) {
	console.log(response.data);  
	if(response.data.Ack == "1") {     
        //$window.location.reload();
	resolve(response.data);
	} else {
	reject(response);
	}
	//console.log(response); 
	},function(response) {
	//console.log(response);  
	reject(response);
	});
	});
	};
        */
        
        
        
var saveAuctionDetails = function(auc,user_id) {
 	//var updateProfile = function(user) {
    return $q(function(resolve, reject) {
        
auc.user_id = user_id;
        
//var encodedString ='{"user_id":"'+ user_id +'","title":"'+ auc.title +'","description":"'+ auc.description +'","price":"'+ auc.price +'","offer_price":"'+ auc.offer_price +'","start_date":"'+ auc.start_date +'","end_date":"'+ auc.end_date +'"}';

//console.log('AUCTION',auc);

		   
        Upload.upload({
                url: $rootScope.serviceurl+"users/addAuction",
                data: auc,
            }).then(function (response) {
                  resolve(response.data);

            }, function (response) {
                reject(response.data);
        }); 
    });
       
 };        
        
        



var uploadProductImage = function($files) {
 	//var updateProfile = function(user) {
    return $q(function(resolve, reject) { 
		
	//console.log($files);	
	//return false;			   
       
        
        
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/upProductImageWeb",
         data: {image:$files},
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
             resolve(response.data); 
           //console.log(response.data);  
           
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        
        
        
        
    });
       
 };
    
 
 var removeproductImage = function(id,name) {
    
         return $q(function(resolve, reject) {
               
  //alert(data);
var encodedString ='{"id":"'+ id +'","proimg":"'+ name +'"}';              
               
          //console.log(encodedString);  
         //return false;    
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/deleteProductImage",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
           // alert(response.data.msg);
        // console.log('ok');
              resolve(response.data); 
           } else {
              //alert(response.data.msg);
         // console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        }); 
 };
 
  var removeTrainer = function(user_id) {
	return $q(function(resolve, reject) {
	
	var encodedString ='{"trainer_id":"'+ user_id +'"}';			   
		console.log(encodedString);	
//return false;
	
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/deleteTrainer",
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
 
 
 

 
 var editTrainer = function(user,id) {
     
  // alert(user);
//return false;
    
return $q(function(resolve, reject) {
    
    user.id = id;
    
    Upload.upload({
                url: $rootScope.serviceurl+"users/updateTrainer",
                data: user,
            }).then(function (response) {
                  resolve(response.data);

            }, function (response) {
                reject(response.data);
        }); 

//var encodedString ='{"full_name":"'+ user.name +'","email":"'+ user.email +'","password":"'+ user.password +'","phone":"'+ user.phone +'","device_type":"","device_token_id":"","lat":"","lang":"","user_id":"'+ user_id +'"}';					   
	
	//console.log(encodedString);
	//return false;
	
	
	});
	};
    
 
 
 
 var editAuction = function(auc, id) {
        return $q(function(resolve, reject) {
               
   auc.id = id;
  //{ position: "Select position", payrate: "122", comments: "test"}
  //var encodedString ='{"user_id":"'+ id +'","full_name":"'+ auc.name +'","email":"'+ auc.email +'","phone":"'+ auc.phone +'","password":"'+ auc.txt_pass +'"}';
  //var data = user;
 
  // console.log('CHANGING',encodedString);
   //return false;            
               
               
        Upload.upload({
                url: $rootScope.serviceurl+"users/editAuction",
                data: auc,
            }).then(function (response) {
                  resolve(response.data);

            }, function (response) {
                reject(response.data);
            });
        
        
        });
 };
 
 
 var addClass = function(user,user_id) {
    
    
return $q(function(resolve, reject) {

var encodedString ='{"trainer_id":"'+ user_id +'","gym_id":"'+ user.gymname +'","class_day":"'+ user.class_day+'","class_start_time":"'+ user.start_time +'","class_end_time":"'+ user.end_time +'"}';					   
	
	console.log(encodedString);
	//return false;
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/addClass",
	data: encodedString,
	headers: {'Content-Type': 'application/json'}
	}).then(function (response) {
	console.log(response.data);  
	if(response.data.Ack == "1") {
	console.log('ok');
        $window.location.href = '#/newclass';
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
    
 var showGymnameClass = function(user_id) {
return $q(function(resolve, reject) {

var encodedString ='{"trainer_id":"'+ user_id +'"}';						   
//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/showGymnameClass",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};
 
 
 var removeClass = function(class_id) {
	return $q(function(resolve, reject) {
	
	var encodedString ='{"class_id":"'+ class_id +'"}';			   
		console.log(encodedString);	
//return false;
	
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"users/deleteClass",
	data: encodedString,
	headers: {'Content-Type': 'application/json'}
	}).then(function (response) {
	console.log(response.data);  
	if(response.data.Ack == "1") {
            //$window.location.href = '#/classlist';
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
 
  var editClass = function(user, id) {
        return $q(function(resolve, reject) {
               
   //var user = user.id;
  //{ position: "Select position", payrate: "122", comments: "test"}
  var encodedString ='{"class_id":"'+ id +'","class_start_time":"'+ user.class_start_time +'","class_end_time":"'+ user.class_end_time +'","class_day":"'+ user.class_day +'"}';
  //var data = user;
 
   console.log('CHANGING',encodedString);
   //return false;            
               
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/updateClass",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           } else {
         // console.log('ok2');
                reject(response);
           }
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        });
 };
 
 
  var ediclassDetails = function(id) {
return $q(function(resolve, reject) {

var encodedString ='{"class_id":"'+ id +'"}';						   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/classEdit",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};



var gymAuction = function() {
return $q(function(resolve, reject) {

//var encodedString ='{"user_id":"'+ user_id +'"}';						   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/AllAuction",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};




var gymDetailsfront = function(id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"gym_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/gymFullDetails",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
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
 
 
 



var messageList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/ListMessage",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var mymessagesend = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/mysendMessage",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};



var aucDetailsfront = function(id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"auction_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/auctionDetails",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
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





var sendmessageauction = function(user,user_id,id) {
        return $q(function(resolve, reject) {
            
            
user.user_id = user_id;
user.auction_id = id;
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"auction_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/sendMessage",
         data: user,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
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
 



 
 
 
 
var notiCount = function(user_id) {
		return $q(function(resolve, reject) {
		
		var encodedString ='{"user_id":"'+ user_id +'"}';						   
		
		
		
		$http({
		method: 'POST',
		url: $rootScope.serviceurl+"notiount",
		data: encodedString,
		headers: {'Content-Type': 'application/json'}
		}).then(function (response) {
		
		if(response.data.Ack == "1") {
		//console.log('ok');
		resolve(response.data); 
		} else {
		//console.log('ok2');
		reject(response);
		}	
		
		
		},function(response) {
		//console.log(response);  
		reject(response);
		});
		});
		}; 
                
                
                
                
                
var orderlist = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/listOrderByUser",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var orderlisttrainer = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/listOrderByTrainer",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var orderlistgym = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/listOrderByGym",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var showStripeDetails = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/getStripedetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var updatedetails = function(user,user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'","secret_key":"'+ user.secret_key +'","publish_key":"'+ user.publish_key +'"}';

//alert(encodedString);
//return false;



$http({
method: 'POST',
url: $rootScope.serviceurl+"users/manageStripe",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};




var orderdetails = function(id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"order_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/orderDetails",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
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
 
 
  var searchGym = function(user,user_id) {
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'","name":"'+ user.name +'","address":"'+ user.addresss +'"}';					   

console.log(encodedString); 
//return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/searchGym",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {
    
    console.log("aa");
console.log(response);
   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } 
     if(response.data.Ack == "0") {
                   console.log('ok');
      resolve(response.data); 
   }
else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

 var searchGymall = function() {
    // alert('hi');
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"","name":"","address":""}';					   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/searchGym",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   }
    if(response.data.Ack == "0") {
                   console.log('ok');
      resolve(response.data); 
   }
   else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};




var searchAuction = function(user,user_id) {
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'","name":"'+ user.name +'"}';					   

console.log(encodedString); 
//return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/searchAuction",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {
    
    console.log("aa");
console.log(response);
   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } 
     if(response.data.Ack == "0") {
                   console.log('ok');
      resolve(response.data); 
   }
else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};


var cartBagCount = function(user_id) {
    return $q(function(resolve, reject) {
        
        

    var encodedString ='{"user_id":"'+ user_id +'"}';

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"cartCount",
    data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {

    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
    reject(response);
    }	


    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
};

   var myCarts = function(userid) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"user_id":"'+ userid +'"}';

          console.log(encodedString);  
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getCart",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           }
           
           else {
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


 var deletecart = function(id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"cart_id":"'+ id +'"}';

            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"removeProductFromCart",
         data: encodedString,
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
var searchAuctionall = function() {
    // alert('hi');
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"","name":""}';					   

//console.log(encodedString); return false;

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/searchAuction",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   }
    if(response.data.Ack == "0") {
                   console.log('ok');
      resolve(response.data); 
   }
   else {
                    console.log('ok2');
        reject(response);
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

















var communityDetailsAll = function(id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/commentsListing",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
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


var listcategory = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listCategory",
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
 
 var listbrand = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listbrand",
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

  var listYears = function() {
        return $q(function(resolve, reject) {
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getYears",
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           if(response.data.Ack == "1") {
            console.log(response.data);
              resolve(response.data); 
           } else {
              resolve(response.data); 
           }
        },function(response) {
          reject(response);
            });
        });
 };



  var listshops = function(user_id) {
        return $q(function(resolve, reject) {
              
            var encodedString ='{"user_id":"'+ user_id +'"}';

        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listshops",
         data: encodedString,
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
 
 
 var listgallerycategory = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"gallerycategorieslist",
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
 
  var listgallerycategorynew = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"community_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"gallerycategorieslist",
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
  var showGallery = function(cat_id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"cat_id":"'+ cat_id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"categorygallerydetails",
         data: encodedString,
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
var listsubcategory = function(cat_id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"cat_id":"'+ cat_id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listSubcategory",
         data: encodedString,
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
 
 
 var addproduct = function(user) {
    
    
return $q(function(resolve, reject) {
    //console.log(user);
   // alert(user.product_image);
    
    Upload.upload({
                url: $rootScope.serviceurl+"addProductNew",
                data: user,
            }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
              // $window.location.href = '#/myjobs';
           } else {
                resolve(response.data);
           }
                  // $window.location.href = '#/waitlisted';

            }, function (response) {
                reject(response.data);
        }); 

//var encodedString ='{"full_name":"'+ user.name +'","email":"'+ user.email +'","password":"'+ user.password +'","phone":"'+ user.phone +'","device_type":"","device_token_id":"","lat":"","lang":"","user_id":"'+ user_id +'"}';					   
	
	//console.log(encodedString);
	//return false;
	
	
	});
	};

   var addauction = function(user) {
    
    
return $q(function(resolve, reject) {
    
    
    Upload.upload({
                url: $rootScope.serviceurl+"addAuction",
                data: user,
            }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
           } else {
                resolve(response.data);
           }

            }, function (response) {
                reject(response.data);
        }); 
  
  });
  };
        
        
         var addTocart = function(userid,product_id,quantity) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"userid":"'+ userid +'","productid":"'+ product_id +'","quantity":"'+ quantity +'"}';

          console.log(encodedString);  
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"addToCart",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           }
           else if(response.data.Ack == "2")
           {
               resolve(response.data); 
           }
            else if(response.data.Ack == "3")
           {
               resolve(response.data); 
           }
           else {
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
 
 var orderHistoryDetails = function(order_id) {
        return $q(function(resolve, reject) {

var encodedString ='{"orderid":"'+ order_id +'"}';

            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"OrderDetails",
         data: encodedString,
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

var question = function(cat_id,subcat_id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
var encodedString ='{"cat_id":"'+ cat_id +'","subcat_id":"'+ subcat_id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listquestions",
         data: encodedString,
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



var sendCommentsCommunity = function(user,user_id,id) {
        return $q(function(resolve, reject) {
            
            
user.user_id = user_id;
user.community_id = id;
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"auction_id":"'+ id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/addCommunityComments",
         data: user,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
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




var allPlanDetails = function() {
return $q(function(resolve, reject) {

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/getPricePlanDetails",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};



var GetRecentComments = function() {
return $q(function(resolve, reject) {

$http({
method: 'POST',
url: $rootScope.serviceurl+"users/getLatestComments",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};


var recentArticle = function() {
return $q(function(resolve, reject) {

$http({
method: 'POST',
url: $rootScope.serviceurl+"recentArticle",
//data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};




var updateProfilePhoto = function(fd) {

  console.log("kalyan",fd);
   /* return $q(function(resolve, reject) { 
   
        
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/upProductImageWeb",
         data: {image:$files},
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
             resolve(response.data); 
           //console.log(response.data);  
           
           //console.log(response); 
        },function(response) {
                     //console.log(response);  
          reject(response);
            });
        
        
        
        
    }); */
       
 };
    






var fbsignupLoginFront = function(fb_id,fb_name) {
return $q(function(resolve, reject) {


var encodedString ='{"email":"","name":"'+ fb_name +'","fb_user_id":"'+ fb_id +'"}';
	
	$http({
	method: 'POST',
	url: $rootScope.serviceurl+"fbsignupLogin",
	data: encodedString,
	headers: {'Content-Type': 'application/json'}
	}).then(function (response) {
        
	if(response.data.Ack == "0") {
	//console.log('ok');
	resolve(response.data); 
	} 

/*else if(response.data.Ack == "2") {
	$state.go('frontend.facebook_confirm');
	} */
	else {
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





var ChatDetails = function(user1,user2) {
return $q(function(resolve, reject) {

var encodedString ='{"sender_id":"'+ user1 +'","receiver_id":"'+ user2 +'"}';


console.log(encodedString); 
$http({
method: 'POST',
url: $rootScope.serviceurl+"chatDetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                  
      resolve(response.data); 
   } else {
          
        resolve(response.data); 
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};
var sendmessage = function(user1,user2,message) {
return $q(function(resolve, reject) {

var encodedString ='{"sender_id":"'+ user2 +'","receiver_id":"'+ user1 +'","message":"'+ message +'"}';


console.log(encodedString); 
$http({
method: 'POST',
url: $rootScope.serviceurl+"sendChat",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                  
      resolve(response.data); 
   } else {
          
        resolve(response.data); 
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};


var acceptjobfinal = function(user_id,job_id) {

 return $q(function(resolve, reject) {
var encodedString ='{"user_id":"'+ user_id +'","job_id":"'+ job_id +'"}';             
  
  
  $http({
  method: 'POST',
  url: $rootScope.serviceurl+"acceptjob",
  data: encodedString,
  headers: {'Content-Type': 'application/json'}
  }).then(function (response) {
  console.log(response.data);  
  if(response.data.Ack == "1") {
  //console.log('ok');

   if(response.data.serial_no<=3) {
     $window.location.href = '#/accepted';
   }
   else {
     $window.location.href = '#/waitlisted';
   }
       
  resolve(response.data);
  } else {
  console.log('ok2');
  reject(response);
  }
  },function(response) { 
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
         url: $rootScope.serviceurl+"acceptJobList",
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
  var deleteProduct = function(id) {
        return $q(function(resolve, reject) {
                
var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"product_id":"'+ id +'","user_id":"'+ userInfo.user_id +'"}';

            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"deleteProduct",
         data: encodedString,
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
 
  var productDetails = function(product_id,user_id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"product_id":"'+ product_id +'","user_id":"'+ user_id +'"}';

           // alert(encodedString);
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"ProductsDetails",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response.data);  
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
 
  var getCms = function(id) {
        return $q(function(resolve, reject) {
						  	
var data ='{"id":"'+ id +'"}';
						   
	//alert(id);					   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getCms",
         data: data,
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
    
 
 var addFavWishlist = function(user_id,product_id,owner_id) {
    
return $q(function(resolve, reject) {
    
var encodedString ='{"user_id":"'+ user_id +'","product_id":"'+ product_id +'","seller_id":"'+ owner_id +'"}';
//alert(encodedString);
$http({
method: 'POST',
url: $rootScope.serviceurl+"addFavoriteProduct",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
          resolve(response.data); 
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};


 var myPurchase = function(userid) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"userid":"'+ userid +'"}';

          console.log(encodedString);  
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"ListOrderBuyer",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           }
           
           else {
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
 
 
  var mySold = function(userid) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"sellerid":"'+ userid +'"}';

          console.log(encodedString);  
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"ListOrderSeller",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           }
           
           else {
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
 
   var gethome = function(userid) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"sellerid":"'+ userid +'"}';

         
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"homeSettings",
        // data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('ok');
              resolve(response.data); 
           }
           
           else {
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
 
 
 
 
 
  var notificationList = function(user_id) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'"}';

$http({
method: 'POST',
url: $rootScope.serviceurl+"ListNotification",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
       resolve(response.data); 
   }	


        },function(response) {
console.log(response);  
reject(response);
});
});
};

  var notifysetting = function(user_id,user2) {
    
return $q(function(resolve, reject) {

var encodedString ='{"user_id":"'+ user_id +'","sale_notify":"'+ user2.sale_notify +'","new_message_notify":"'+ user2.new_message_notify +'","review_notify":"'+ user2.review_notify +'","subscription_notify":"'+ user2.subscription_notify +'"}';

console.log(encodedString);


$http({
method: 'POST',
url: $rootScope.serviceurl+"notifysettings",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
       resolve(response.data); 
   }  


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var getProductsByBrand = function(brand) {
    return $q(function(resolve, reject) {
        
        var encodedString ='{"brand":"'+ brand +'"}';

//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';

    
        //console.log(encodedString);    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"getBrandIdNew",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    // console.log(response.data.brand);
    // return false;

    if(response.data.Ack == "1") {
    //console.log('ok');

    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };


  var toemailverify = function(userid) {
return $q(function(resolve, reject) {

  var encodedString ='{"user_id":"'+ userid +'"}';

$http({
method: 'POST',
  url: $rootScope.serviceurl+"emailverified",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};

  var interestedEmail = function(userid,sellerid,productid,type) {
return $q(function(resolve, reject) {

  var encodedString ='{"user_id":"'+ userid +'","seller_id":"'+sellerid+'","product_id":"'+productid+'","type":"'+type+'"}';

$http({
method: 'POST',
  url: $rootScope.serviceurl+"interestedEmailToVendor",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};


  var auctionFees = function(notificationType,auctionId) {
return $q(function(resolve, reject) {

  var encodedString ='{"notificationType":"'+ notificationType +'","auctionId":"'+auctionId+'"}';

  //  console.log(encodedString);
  // return false;
$http({
method: 'POST',
  url: $rootScope.serviceurl+"auctionFeesAdvancePayment",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};



  var auctionapproval = function(product_id, user) {
return $q(function(resolve, reject) {

  var encodedString ='{"product_id":"'+ product_id +'","time_slot_id":"'+ user.time_slot_id +'","preferred_date":"'+ user.preferred_date +'","comments":"'+ user.comments +'","breslet_type":"'+user.breslet_type+'","model_year":"'+user.model_year+'"}';

// console.log(encodedString);
// return false;

$http({
method: 'POST',
  url: $rootScope.serviceurl+"auctionapproval",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};

 var cardpay = function(user_id,shipping_name,shipping_address,grand_total) {
  return $q(function(resolve, reject) {
   // user.user_id =user_id;
    // user.membership_id =membership_id;
   //console.log(token);
  // return false;
  

  var encodedString ='{"user_id":"'+ user_id +'","shipping_name":"'+ shipping_name +'","shipping_address":"'+shipping_address+'","total_amount":"'+ grand_total +'"}';
              
  //console.log(encodedString); 
  //console.log(encodedString1); 

  $http({
  method: 'POST',
  url: $rootScope.serviceurl+"checkout",
  data: encodedString,
  headers: {'Content-Type': 'application/json'}
  }).then(function (response) {
    console.log(response);
   // console.log("aaa",encodedString); 
     if(response.data.Ack == "1") {
         
          

 resolve(response.data); 

     } 


           else {
             resolve(response.data); 
        
           }  
    
    
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
 
 var addbid = function(userid,productid,bidprice,uploaderid,bidincrement) {
return $q(function(resolve, reject) {
    
  var nextbidprice = parseInt(bidprice)+parseInt(bidincrement);
  //alert(bidprice);
  var encodedString ='{"uploaderid":"'+ uploaderid +'","userid":"'+ userid +'","productid":"'+ productid +'","bidprice":"'+ bidprice +'","nextbidprice":"'+ nextbidprice +'"}';

$http({
method: 'POST',
  url: $rootScope.serviceurl+"bidsubmit",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
       
                   console.log(response);
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};
 
 
 var getauctiondetails = function(userid, productid) {
return $q(function(resolve, reject) {

  var encodedString ='{"userid":"'+ userid +'","productid":"'+ productid +'"}';

$http({
method: 'POST',
  url: $rootScope.serviceurl+"getauctiondetails",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
       
                   console.log(response);
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};

var listAuctionDtates = function() {

    return $q(function(resolve, reject) {
        //alert();
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listAuctionDtates",
         //data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
         // console.log(response.data);
          //console.log('hello',response.data.Ack);
           if(response.data.Ack == "1") {
        // alert('ok');
              resolve(response.data); 
           } else {
          //alert('nok');
              resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
              // alert(response);      //console.log(response);  
          reject(response);
            });
        });
    
};



var getTimeslot = function(date) {
    //alert(date);
   if(date){
      
   
    return $q(function(resolve, reject) {
       var encodedString ='{"getdate":"'+ date +'"}';
       //alert($rootScope.serviceurl+"getTimeslot");
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getTimeslot",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
          console.log(response);
          //console.log('hello',response.data.Ack);
           if(response.data.Ack == "1") {
         //alert(response.data);
              resolve(response.data); 
           } else {
         // alert('nok');
              resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
              // alert(response);      //console.log(response);  
          reject(response);
            });
        });
    }

};

var listcuntry = function() {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
//var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
//var encodedString ='{"cat_id":"'+ cat_id +'"}';
            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"listcuntry",
        // data: encodedString,
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
var liststatus = function() {

    return $q(function(resolve, reject) {
        //alert();
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"liststatus",
         //data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
         // console.log(response.data);
          //console.log('hello',response.data.Ack);
           if(response.data.Ack == "1") {
        // alert('ok');
              resolve(response.data); 
           } else {
          //alert('nok');
              resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
              // alert(response);      //console.log(response);  
          reject(response);
            });
        });
    
};

var getproductdetailsforedit = function(id) {
   var encodedString ='{"id":"'+ id +'"}';
    return $q(function(resolve, reject) {
        //alert();
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getproductdetailsforedit",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
         // console.log(response.data);
          //console.log('hello',response.data.Ack);
           if(response.data.Ack == "1") {
        // alert('ok');
              resolve(response.data); 
           } else {
          //alert('nok');
              resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
              // alert(response);      //console.log(response);  
          reject(response);
            });
        });
    
};
var registernewsletter = function(email) {

    return $q(function(resolve, reject) {
       
         var encodedString ='{"email":"'+ email +'"}';
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"newsleterRegister",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
         // console.log(response.data);
          //console.log('hello',response.data.Ack);
           if(response.data.Ack == "1") {
        // alert('ok');
              resolve(response.data); 
           } else {
          //alert('nok');
              resolve(response.data); 
           }
           //console.log(response); 
        },function(response) {
              // alert(response);      //console.log(response);  
          reject(response);
            });
        });
    
};

var searchproductListing = function(user_id,brand,brandList,sellerList,selected_value,amount_min,amount_max,gender,breslettype,year) {
    return $q(function(resolve, reject) {
        
        //var encodedString ='{"user_id":"'+ user_id +'","brand":"'+ brand +'","brandList":"'+ brandList +'","sellerList":"'+ sellerList +'","selected_value":"'+ selected_value +'"}';
        var encodedString ='{"user_id":"'+ user_id +'","brand":"'+ brand +'","brandList":"'+ brandList +'","sellerList":"'+ sellerList +'","selected_value":"'+ selected_value +'","amount_min":"'+amount_min+'","amount_max":"'+amount_max+'","gender":"'+gender+'","breslettype":"'+breslettype+'","year":"'+year+'"}';
         console.log('productlist',encodedString);
         //return false;
//var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ user.name +'","description":"'+ user.description +'","email":"'+ user.email +'","phone":"'+ user.phone +'","price":"'+ user.price +'","address":"'+ user.address +'","sundaytime":"'+ user.sundaytime +'","mondaytime":"'+ user.mondaytime +'","tuesdaytime":"'+ user.tuesdaytime +'","wednesdaytime":"'+ user.wednesdaytime +'","thursdaytime":"'+ user.thursdaytime +'","fridaytime":"'+ user.fridaytime +'","saturdaytime":"'+ user.saturdaytime +'"}';

    
        // alert(encodedString);    
    
    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"ProductListSearch",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    
    var listproductMessages = function(user_id) {
    return $q(function(resolve, reject) {
       // alert(user_id);
         var encodedString ='{"user_id":"'+ user_id +'"}';
        
        // alert(encodedString);    
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listproductMessages",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    
    var getusercontact = function(to_id) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        //alert(product_id);
        var encodedString ='{"to_id":"'+ to_id +'"}';
//var encodedString ='{"to_id":"'+ to_id +'","product_id":"'+ product_id +'"}';
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"getusercontact",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    var getProductcontact = function(product_id) {
    return $q(function(resolve, reject) {
        //var userInfo = JSON.parse($window.localStorage["userInfo"]);
       // alert(product_id);
        var encodedString ='{"product_id":"'+ product_id +'"}';
//var encodedString ='{"to_id":"'+ to_id +'","product_id":"'+ product_id +'"}';
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"getProductcontact",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
    
    var addmessage = function(message) {
    
    
return $q(function(resolve, reject) {
    //console.log('newmessage',message);
   // alert(user.product_image);
    var encodedString ='{"to_id":"'+ message.to_id +'","from_id":"'+ message.from_id +'","message":"'+ message.message +'","product_id":"'+ message.product_id +'"}';					   

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"addmessage",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
              // $window.location.href = '#/myjobs';
           } else {
                resolve(response.data);
           }
                  // $window.location.href = '#/waitlisted';

            }, function (response) {
                reject(response.data);
        }); 

//var encodedString ='{"full_name":"'+ user.name +'","email":"'+ user.email +'","password":"'+ user.password +'","phone":"'+ user.phone +'","device_type":"","device_token_id":"","lat":"","lang":"","user_id":"'+ user_id +'"}';					   
	
	//console.log(encodedString);
	//return false;
	
	
	});
	};
        
        var getfullMessages = function(to_id,product_id,from_id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"to_id":"'+ to_id +'","product_id":"'+ product_id +'","from_id":"'+ from_id +'"}';

            //alert(encodedString);
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getfullMessages",
         data: encodedString,
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
 var changeLaguage = function(language_id) {
        return $q(function(resolve, reject) {
                
//var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
var encodedString ='{"language_id":"'+ language_id +'"}';

            //alert(encodedString);
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"changeLaguage",
         data: encodedString,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           //console.log(response.data);  
           if(response.data.Ack == "1") {
         //console.log('language',response.data.languages);
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
 
 
 var markProduct = function(id) {
    
    
return $q(function(resolve, reject) {
    
    var encodedString ='{"id":"'+ id +'"}';					   

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"markProduct",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
             
           } else {
                resolve(response.data);
           }
                 

            }, function (response) {
                reject(response.data);
        }); 


	
	
	});
	};
 var expiredproduct = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listexpiredProducts",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };
 
 var markextension = function(id) {
    
    
return $q(function(resolve, reject) {
    
    var userInfo = JSON.parse($window.localStorage["userInfo"]);
    var encodedString ='{"id":"'+ id +'","user_id":"'+ userInfo.user_id +'"}';					   
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"markextension",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
             
           } else {
                resolve(response.data);
           }
                 

            }, function (response) {
                reject(response.data);
        }); 

	});
	};
 
 
 
    var getuserpayment = function() {
    
    return $q(function(resolve, reject) {
    
    var userInfo = JSON.parse($window.localStorage["userInfo"]);
    var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';					   
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"userpayment",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
              if(response.data.Ack == "1") {
              resolve(response.data); 
             
           } else {
                resolve(response.data);
           }
                 

            }, function (response) {
                reject(response.data);
        }); 

	});
	};
 
 
 var userpaymentforupload = function(value) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","name":"'+ value.name +'","email":"'+ value.email +'","phone":"'+ value.phone +'","sid":"'+ value.sid +'","pid":"'+ value.pid +'"}';

    $http({
    method: 'POST',
   // url: $rootScope.serviceurl+"addUserSubscription",
    url: $rootScope.serviceurl+"userpaymentforupload",
    data: encodedString,
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
 
  var adduserpayment = function(id) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","return_id":"'+ id +'"}';

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"adduserpayment",
    data: encodedString,
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
   
    var usersubscriptions = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"listuserSubscriptions",
    data: encodedString,
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
    
    
 var addreview = function(userid,productid,review,rating,recomend) {
return $q(function(resolve, reject) {
    
  //var nextbidprice = parseInt(bidprice)+parseInt(bidincrement);
  //alert(bidincrement);
  var encodedString ='{"userid":"'+ userid +'","productid":"'+ productid +'","review":"'+ review +'","rating":"'+rating+'","recomend":"'+recomend+'"}';
alert(encodedString);
$http({
method: 'POST',
  url: $rootScope.serviceurl+"addreview",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
       
                   console.log(response);
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
});
});
};    
    
var reviews = function(product_id) {
return $q(function(resolve, reject) {
    
  //var nextbidprice = parseInt(bidprice)+parseInt(bidincrement);
  //alert(userid);
  var encodedString ='{"productid":"'+ product_id +'"}';
  //alert(encodedString);
 $http({
method: 'POST',
  url: $rootScope.serviceurl+"reviews",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
       
                   console.log(response);
      resolve(response.data); 
   } else {
                    console.log('ok2');
        reject(response);
   }


        },function(response) {
console.log(response);  
reject(response);
}); 
});
};     
  


var purchaseAuctionproduct = function(value) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","product_id":"'+ value.product_id +'","name":"'+ value.name +'","email":"'+ value.email +'","phone":"'+ value.phone +'"}';

    $http({
    method: 'POST',
   // url: $rootScope.serviceurl+"addUserSubscription",
    url: $rootScope.serviceurl+"UserAuctionpayment",
    data: encodedString,
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


 var addwinnerpayment = function(id) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","product_id":"'+ id +'"}';

    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"addwinnerpayment",
    data: encodedString,
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



    var todaysearchListing = function(user_id,brand,brandList,sellerList,selected_value,amount_min,amount_max,gender,breslettype,year,preferred_date) {
    return $q(function(resolve, reject) {
        
        
        var encodedString ='{"user_id":"'+ user_id +'","brand":"'+ brand +'","brandList":"'+ brandList +'","sellerList":"'+ sellerList +'","selected_value":"'+ selected_value +'","amount_min":"'+amount_min+'","amount_max":"'+amount_max+'","gender":"'+gender+'","breslettype":"'+breslettype+'","year":"'+year+'","preferred_date":"'+preferred_date+'"}';
         
    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"todayauctionListSearch",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };


    var interestinproduct = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';

    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"interestinproduct",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };

var deleteInterest = function (id) {
        return $q(function (resolve, reject) {

            var userInfo = JSON.parse($window.localStorage["userInfo"]); //16.5.2017
            var encodedString = '{"interest_id":"' + id + '","user_id":"' + userInfo.user_id + '"}';


            $http({
                method: 'POST',
                url: $rootScope.serviceurl + "deleteInterest",
                data: encodedString,
                headers: {'Content-Type': 'application/json'}
            }).then(function (response) {

                if (response.data.Ack == "1") {

                    resolve(response.data);
                } else {

                    resolve(response.data);
                }

            }, function (response) {

                reject(response);
            });
        });
    };
  
  
  var addlike = function(user_id,product_id,owner_id) {
    
return $q(function(resolve, reject) {
    
var encodedString ='{"user_id":"'+ user_id +'","product_id":"'+ product_id +'","seller_id":"'+ owner_id +'"}';
//alert(encodedString);
$http({
method: 'POST',
url: $rootScope.serviceurl+"addlike",
data: encodedString,
headers: {'Content-Type': 'application/json'}
}).then(function (response) {

   if(response.data.Ack == "1") {
                   console.log('ok');
      resolve(response.data); 
   } else {
                    console.log('ok2');
          resolve(response.data); 
   }    


        },function(response) {
console.log(response);  
reject(response);
});
});
};






    var interestedproduct = function() {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
        var encodedString ='{"user_id":"'+ userInfo.user_id +'"}';

    
    $http({
    method: 'POST',
    url: $rootScope.serviceurl+"interestedproduct",
   data: encodedString,
    headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
    
    if(response.data.Ack == "1") {
    //console.log('ok');
    resolve(response.data); 
    } else {
    //console.log('ok2');
  resolve(response.data); 
    } 
    
    
    },function(response) {
    //console.log(response);  
    reject(response);
    });
    });
    };



var sociallinks = function() {
        return $q(function(resolve, reject) {
                

//var encodedString ='{"user_id":"0"}';

            
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"sociallinks",
         //data: encodedString,
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

var uploadAuctionproduct = function(value) {
    return $q(function(resolve, reject) {
        var userInfo = JSON.parse($window.localStorage["userInfo"]);
    
     var encodedString ='{"user_id":"'+ userInfo.user_id +'","product_id":"'+ value.product_id +'","name":"'+ value.name +'","email":"'+ value.email +'","phone":"'+ value.phone +'"}';

    $http({
    method: 'POST',
   // url: $rootScope.serviceurl+"addUserSubscription",
    url: $rootScope.serviceurl+"auctionuploapayment",
    data: encodedString,
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


 
 return {
     
       // homeSettingsSection:homeSettingsSection,
        ServiceSection: ServiceSection,
        ServiceCategory: ServiceCategory,
        acceptjobfinal: acceptjobfinal,
        question: question,
        postjob: postjob,
        listsubcategory: listsubcategory,
        listcategory: listcategory,
        login: login,
        getCms: getCms,
        getproductdetailsforedit: getproductdetailsforedit,
        liststatus: liststatus,
        listcuntry: listcuntry,
        getCounters: getCounters,
        getAccountDetails: getAccountDetails,
        updateCard: updateCard,
        updateProfile: updateProfile,
        updateSetting: updateSetting,
        reviewList: reviewList,
        areaCoveredlist: areaCoveredlist,
        addareaCovered: addareaCovered,
        removearea: removearea,
        ChangePassword: ChangePassword,
        logout: logout,
        signup: signup,
        forgotpass: forgotpass,
        ediclassDetails: ediclassDetails,
        classListing: classListing,
        trainerList: trainerList,
        addClass: addClass,
        saveAuctionDetails: saveAuctionDetails,
        trainerDetails: trainerDetails,
        editTrainer: editTrainer,
        editClass: editClass,
        removeTrainer: removeTrainer,
        removeClass: removeClass,
        saveGymDetails: saveGymDetails,
        showGymnameClass: showGymnameClass,
        uploadProductImage: uploadProductImage,
        removeproductImage: removeproductImage,
        gymDetails: gymDetails,
        auctionList: auctionList,
        gymList: gymList,
        removeAuction: removeAuction,
        auctionDetails: auctionDetails,
        editAuction: editAuction,
        gymAuction: gymAuction,
        gymDetailsfront: gymDetailsfront,
        getTimeslot: getTimeslot,
        cardpay: cardpay,
        aucDetailsfront: aucDetailsfront,
        sendmessage: sendmessage,
        messageList: messageList,
        orderlist: orderlist,
        orderlisttrainer: orderlisttrainer,
        updatedetails: updatedetails,
        showStripeDetails: showStripeDetails,
        orderlistgym: orderlistgym,
        notiCount: notiCount,
        mymessagesend: mymessagesend,
        searchGym: searchGym,
        searchGymall: searchGymall,
        orderdetails: orderdetails,
        communityDetailsAll: communityDetailsAll,
        sendCommentsCommunity: sendCommentsCommunity,
        searchAuction: searchAuction,
        searchAuctionall: searchAuctionall,
        allPlanDetails: allPlanDetails,
        GetRecentComments: GetRecentComments,
        updateProfilePhoto: updateProfilePhoto,
        invoiceList: invoiceList,
        messagelist: messagelist,
        showGallery: showGallery,
        fbsignupLoginFront: fbsignupLoginFront,
        ChatDetails: ChatDetails,
        listgallerycategory: listgallerycategory,
        listgallerycategorynew: listgallerycategorynew,
        listacceptedproducts: listacceptedproducts,
        recentArticle: recentArticle,
        articleDetails: articleDetails,
        searchListing: searchListing,
        wishlist: wishlist,
        productDetails: productDetails,
        myproduct: myproduct,
        deleteProduct: deleteProduct,
        listcurrency: listcurrency,
        addFavWishlist: addFavWishlist,
        addproduct: addproduct,
        addTocart: addTocart,
        deletecart: deletecart,
        myPurchase: myPurchase,
        mySold: mySold,
        gethome: gethome,
        listbrand: listbrand,
        notificationList: notificationList,
        orderHistoryDetails: orderHistoryDetails,
        listcategoryproduct: listcategoryproduct,
        listarticalecatname: listarticalecatname,
        myCarts: myCarts,
        cartBagCount: cartBagCount,
        postjobHome: postjobHome,
        notifysetting: notifysetting,
        addauction: addauction,
        myauction: myauction,
        getProductsByBrand: getProductsByBrand,
        toemailverify: toemailverify,
        auctionapproval: auctionapproval,
        interestedEmail: interestedEmail,
        auctionFees: auctionFees,
        subscriptions: subscriptions,
        subscribedlist: subscribedlist,
        purchaseSubscription: purchaseSubscription,
        listshops: listshops,
        addbid: addbid,
        getauctiondetails: getauctiondetails,
        listAuctionDtates: listAuctionDtates,
        listYears: listYears,
        registernewsletter: registernewsletter,
        searchproductListing: searchproductListing,
        listproductMessages: listproductMessages,
        getusercontact: getusercontact,
        getProductcontact: getProductcontact,
        addmessage: addmessage,
        getfullMessages: getfullMessages,
        addsubscription: addsubscription,
        changeLaguage: changeLaguage,
        markProduct: markProduct,
        expiredproduct: expiredproduct,
        markextension: markextension,
        getuserpayment: getuserpayment,
        userpaymentforupload: userpaymentforupload,
        adduserpayment: adduserpayment,
        usersubscriptions: usersubscriptions,
        addreview: addreview,
        reviews: reviews,
        purchaseAuctionproduct: purchaseAuctionproduct,
        addwinnerpayment: addwinnerpayment,
        todaysearchListing: todaysearchListing,
        interestinproduct: interestinproduct,
        deleteInterest: deleteInterest,
        interestedproduct:interestedproduct,
        addlike:addlike,
        sociallinks:sociallinks,
        uploadAuctionproduct:uploadAuctionproduct

	
};
});
