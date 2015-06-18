jQuery(document).ready(function(){
  jQuery(".acordeon > a").click(function(e){
		jQuery(".acordeon > ul").slideUp();
		if(!jQuery(this).parent().find('ul').is(":visible"))
		{
			jQuery(this).parent().find('ul').slideDown();
		}
		e.preventDefault();
	});
	jQuery(".acordeon").each(function(i, e){
		if(!jQuery(e).hasClass('current-menu-parent') && !jQuery(e).hasClass('current-post-ancestor'))
			jQuery(e).find('ul').hide();
	});
	
	if(jQuery(window).width() < 768){
		jQuery('#sidebar').prepend('<div id="menu-icon">Menu</div>');
		jQuery("#sidebar nav").hide();
		jQuery("#sidebar .widget").hide();
		jQuery("#menu-icon").on("click", function(){
			jQuery("#sidebar nav").slideToggle();
			jQuery("#sidebar .widget").slideToggle();
			//jQuery(this).toggleClass("hidden");
		});
	}
	
});