$(function() {

	// DATATABLES FILTER PLUGIN

	$(document).on( 'init.dt', function ( e, settings ) {
		$('input[type=search]', $('.dataTable').closest('.dataTables_wrapper') ).after(
			$('<span>').addClass('dataTables_filter_reset').append(
				$('<i>').addClass('fa fa-times')
			).on('click', function() {
				$(this).closest('.dataTables_wrapper').find('.dataTable').DataTable().search('').draw();
			})
		)
	});

	// SIDEBAR

    $('.sidebar-toggle').on('click', function() {
    	setTimeout( function() {
    		if ($('body').hasClass('sidebar-collapse')) {
				$.cookie('sidebar_collapse', 'sidebar-collapse', { path: $('base').attr('href') } );
    		}
    		else {
				$.cookie('sidebar_collapse', '', { path: $('base').attr('href') } );
    		}
    	}, 500);
    })

	// MODAL

    $('a.close', 'div.modal').on('click', function () {
		$('div.modal').modal('hide');
		$('div.modal').removeClass('modal-fullscreen');
	});

	$('a.fullscreen', 'div.modal').on('click', function () {
		$('div.modal').toggleClass('modal-fullscreen');
	});

	// AdminLTE Skins

	(function ($, AdminLTE) {

	  "use strict";

  	  var my_skins = [];

	  $.each($('#control-sidebar-theme-options-tab ul li'), function( index, value ) {
  		my_skins.push( $('a', $(value)).attr('data-skin') ); 
	  });

	setup();

    function change_layout(cls) {
	    $("body").toggleClass(cls);
	    AdminLTE.layout.fixSidebar();
	    //Fix the problem with right sidebar and layout boxed
	    if (cls == "layout-boxed")
	      AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
	    if ($('body').hasClass('fixed') && cls == 'fixed') {
	      AdminLTE.pushMenu.expandOnHover();
	      AdminLTE.layout.activate();
	    }
	    AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
	    AdminLTE.controlSidebar._fix($(".control-sidebar"));
	  }

	  function change_skin(cls) {
	    $.each(my_skins, function (i) {
	      $("body").removeClass(my_skins[i]);
	    });

	    $("body").addClass(cls);
	    store('skin', cls);
	    return false;
	  }

	  function store(name, val) {
	    $.cookie(name, val, { path: $('base').attr('href') } );
	    console.log( $('base').attr('href') );
	  }

	  function setup() {

	    //Add the change skin listener
	    $("[data-skin]").on('click', function (e) {
	      if($(this).hasClass('knob'))
	        return;
	      e.preventDefault();
	      change_skin($(this).data('skin'));
	    });

	    //Add the layout manager
	    $("[data-layout]").on('click', function () {
	      change_layout($(this).data('layout'));
	    });

	    $("[data-controlsidebar]").on('click', function () {
	      change_layout($(this).data('controlsidebar'));
	      var slide = !AdminLTE.options.controlSidebarOptions.slide;
	      AdminLTE.options.controlSidebarOptions.slide = slide;
	      if (!slide)
	        $('.control-sidebar').removeClass('control-sidebar-open');
	    });

	    $("[data-sidebarskin='toggle']").on('click', function () {
	      var sidebar = $(".control-sidebar");
	      if (sidebar.hasClass("control-sidebar-dark")) {
	        sidebar.removeClass("control-sidebar-dark")
	        sidebar.addClass("control-sidebar-light")
	      } else {
	        sidebar.removeClass("control-sidebar-light")
	        sidebar.addClass("control-sidebar-dark")
	      }
	    });

	    $("[data-enable='expandOnHover']").on('click', function () {
	      $(this).attr('disabled', true);
	      AdminLTE.pushMenu.expandOnHover();
	      if (!$('body').hasClass('sidebar-collapse'))
	        $("[data-layout='sidebar-collapse']").click();
	    });

	    // Reset options
	    if ($('body').hasClass('fixed')) {
	      $("[data-layout='fixed']").attr('checked', 'checked');
	    }
	    if ($('body').hasClass('layout-boxed')) {
	      $("[data-layout='layout-boxed']").attr('checked', 'checked');
	    }
	    if ($('body').hasClass('sidebar-collapse')) {
	      $("[data-layout='sidebar-collapse']").attr('checked', 'checked');
	    }

	  }
	})(jQuery, $.AdminLTE);

});

// Init Pace

$(document).ajaxStart(function() { 
    Pace.restart();
});

// ALFI ALERT

function alfi_alert(message, title = 'Figyelem', type = 'info', options = new Array() ) {

    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": 1000
    }

	if (options) {
		toastr.options = Object.assign(toastr.options, options);
	}

	console.log(toastr.options);

	toastr[type](message, title, { 'toastClass': 'callout callout-'+type } );

}
