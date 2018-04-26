app.service('groupService', function($q, $http, $window,$rootScope,Upload) { 

 var listgroup = function() {
        return $q(function(resolve, reject) {
                
   var encodedString ='{"user_id":""}';           
                   
               
        $http({
         method: 'POST',
         url: $rootScope.serviceurl+"users/listGroup",
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
  listgroup: listgroup,


};
    
});