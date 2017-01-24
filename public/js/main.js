jQuery(document).ready(function(){
	$('#submenu #submenu-a').click(function(e){
		e.preventDefault();
		if($(this).closest('#submenu li.active').hasClass('nav-sidebar-li')){
			$(this).closest('#submenu li.active').removeClass('nav-sidebar-li');	
		}
		else{
			$(this).closest('#submenu li.active').addClass('nav-sidebar-li');
		}		
	});

	
});