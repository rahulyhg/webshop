app.service('cmsService', function($q, $http, $window,$rootScope,$filter) { 
 
				   

 
 var getCms = function(id) {
        return $q(function(resolve, reject) {
						  	
var data ='{"id":"'+ id +'"}';
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"getCms",
         data: data,
         headers: {'Content-Type': 'application/json'}
         }).then(function (response) {
           console.log(response);  
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
 
 
 
 
 
/*  var getFaq = function() {
        return $q(function(resolve, reject) {
						  	
//var data ='{"id":"'+ id +'"}';					   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"faqs/faqlist_service/",
         //data: data,
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
 
 

 


 
 
 
 return {
    getCms: getCms,
    //getFaq: getFaq,
	

};
    
});