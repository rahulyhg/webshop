app.filter('dateToISO', function() {
  return function(input) {
    return new Date(input);
  };
});


app.filter('htmlToPlaintext', function() {
   return function(text) {
      return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});

