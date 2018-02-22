$(document).ready(function() {
	function makePanelActive(this_obj) {
		this_obj.css('font-weight','bold').addClass('current-link');
		this_obj.parents('ul').slideDown('normal');
		this_obj.parents('li:eq(1)').addClass('active');	
	}
	
	$('#menu ul').hide().children('.current').parent().show('slow');
	var path = window.location.pathname.toLowerCase();
	
	/* Open the first panel if we're on the homepage */
	if (path == '/' || path == '') {
		$('#menu ul:first').show('slow');	
		$('#menu li:first').addClass('active');
	}

	/* Open the correct menu item based on the url */
	$('#menu li a').each(function(){
		var menu_href = $(this).attr('href').toLowerCase();
		if (menu_href == path) {
			makePanelActive($(this));
			return false;
		}
		if(path.includes(menu_href)) {
			makePanelActive($(this));
			return false;
		}
	});

	/* Mouse events */
	$('#menu li a').click(function() {
		var panel = $(this).next();
		var header = $(this).parent();
		if (!panel.is('ul')) { return true; }

		if (!panel.is(':visible')) {
			// Remove white, bold from all previously clicked links
			$('#menu li a').each(function() {
				if (!$(this).hasClass('current-link')) {
					$(this).css('color','#fff').css('font-weight','normal');
				}
			});
			// Remove active class from all headers
			$('#menu li').each(function() {
			  $(this).removeClass('active');
			});
			
			// Apply proper styling
			$(this).css('font-weight','bold');
			header.addClass('active');
			panel.slideDown('normal');
			return false;
		}

		if (panel.is(':visible')) {
			$(this).css('font-weight','normal');
			header.removeClass('active');
			panel.slideUp('fast');

			//Close all children panels
			panel.find('ul').slideUp('fast');
			return false;
		}


	});

	/* This opens the hidden menu. */        
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
});