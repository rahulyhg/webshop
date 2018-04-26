$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var modal = $(this)
})

$(function() {
    //$('#toggle-one').bootstrapToggle();
  })
  
  
//for profile Page
  $(".profile_menu li a").click(function(){
    	$(".profile_menu li a").removeClass("active");
    	$(this).addClass("active");
  	var addClass=($(this).attr('id'));
  	$(".profile_menu_result").addClass("DN");
  	$("."+addClass).removeClass("DN");
  	
});
  
  
