app.service('driverService', function($q, $http, $window,$rootScope) { 
 

 
  var myRides = function(user_id) {
        return $q(function(resolve, reject) {
						   
						
	
var encodedString ='{"user_id":"'+ user_id +'"}';		   
						   
						   
						   
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/myRides",
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
 
 
 

 
 
 
 return {
    myRides: myRides,
	
};
    
});