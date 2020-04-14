// ############################
// ############################
// ###                      ###
// ###    ALFI GLOBAL JS    ###
// ###                      ###
// ############################
// ############################

function app_load_init() {

    // =====
    // MODAL
    // =====

    // Init

    $('.ajax-modal').unbind('click');
    $('.ajax-modal').bind('click', function() {

        let modal = '.modal .modal-dialog .modal-content > ';
        $(modal +'.modal-footer').hide();

        // Set the modal's width if the button's data-modal-width attribute exists
        if ($(this).data('modal-width')) {
            $('div.modal .modal-dialog').css({
                'width': $(this).data('modal-width') +'px'
            });
        }

        // Set the modal's title as the button's data-modal-title or it's text
        $(modal +'.modal-header .modal-title').html( $(this).data('modal-title') || $(this).text() );
    	
        $('div.modal').modal('show');
        
    	if ($(this).attr('href') && $(this).attr('href') != '#') {
            $(modal +'.modal-body').html( "<div class='loader'><i class='fa fa-spin fa-spinner'></i></div>" );
            $.ajax({
                url: $(this).attr('href')
            }).done( function(data) {

                // JSON válasz érkezett a modal-hoz
                if (typeof data === 'object') {
                    $(modal +'.modal-header .modal-title').html(data['modal-title']);
                    $(modal +'.modal-body')               .html(data['modal-body']);
                    if (data['modal-footer']) {
                        $(modal +'.modal-footer')         .html(data['modal-footer']);
                        $(modal +'.modal-footer').css('display', 'block');
                    }
                }
                else {
                    $(modal +'.modal-body').html( data );
                    if ( $(modal +'.modal-body .modal-body').text() || $(modal +'.modal-body .modal-title').text() ) {
                        if ($(modal +'.modal-body .modal-header').text()) {
                            $(modal +'.modal-header .modal-title').html( $(modal +'.modal-body .modal-title').html() );
                            $(modal +'.modal-header').css('display', 'block');
                        }
                        if ($(modal +'.modal-body .modal-footer').text()) {
                            $(modal +'.modal-footer').html( $(modal +'.modal-body .modal-footer').html() );
                            $(modal +'.modal-footer').css('display', 'block');
                        }
                        $(modal +'.modal-body').html( $(modal +'.modal-body .modal-body').html() );
                    };
                }
            }).fail( function() {
                $(modal +'.modal-body').html( "<span class='text-danger'>Hiba! :(</span>" );
            })
        }
        else {
            $(modal +'.modal-body').html( "<span class='text-danger'>No href! :(</span>" );
        }

	    return false;
    });

    // Close modal click outside

    $('body').click( function(event) {
        if ($(event.target).is('.modal.fade')) {
            if(!$(event.target).closest('.modal .modal-dialog').length && !$(event.target).is('.modal .modal-dialog')) {
                $(".modal").modal('hide');
            }     
        }
    });

    // Close modal on keypress ESC

    $(document).keydown( function(e) { 
        if (e.keyCode == 27) { 
            $(".modal").modal('hide');
        } 
    });
    
	// Close button in header

    $('a.close', 'div.modal').unbind();
    $('a.close', 'div.modal').on('click', function () {
		$('div.modal').modal('hide');
	});

    // ========
    // AJAX URL
    // ========

    // Init

    // ========
    // AJAX URL
    // ========

    // Init

    $('a.ajax-url, input.ajax-url, button.ajax-url').unbind();
    $('a.ajax-url, input.ajax-url, button.ajax-url').bind('click', function() {
        var $this = $(this);
        if ($this.attr('href') && $this.attr('href') != '#') {
            $('i.fa', $this).addClass('fa-spin fa-spinner');
            $.ajax({
                url    : $this.attr('href'),
                type   : $this.attr('data-ajax-method')?$this.attr('data-ajax-method'):'GET',
            }).done( function(data, textStatus, jqXHR) {
                if ($this.data('ajax-success-fn')) {
                    if (typeof window[$this.data('ajax-success-fn')] === "function") {
                        var header = {
                            'status': jqXHR.status,
                            'statusText': jqXHR.statusText
                        };
                        if (jqXHR.responseJSON) {
                            response = jqXHR.responseJSON;
                        }
                        else {
                            response = jqXHR.responseText;
                        }
                        window[$this.data('ajax-success-fn')](header, response);
                    }
                }
                $('i.fa', $this).removeClass('fa-spin fa-spinner');
            }).fail( function(jqXHR, textStatus, errorThrown) {
                if ($this.data('ajax-fail-fn')) {
                    if (typeof window[$this.data('ajax-fail-fn')] === "function") {
                        var header = {
                            'status': jqXHR.status,
                            'statusText': jqXHR.statusText
                        };
                        if (jqXHR.responseJSON) {
                            response = jqXHR.responseJSON;
                        }
                        else {
                            response = jqXHR.responseText;
                        }
                        window[$this.data('ajax-fail-fn')](header, response);
                    }
                }
                $('i.fa', $this).removeClass('fa-spin fa-spinner');

                json_data = jqXHR.responseJSON;
                        
                if (json_data) {
                    var return_message = '';

                    if (json_data.message) {
                        return_message = json_data.message;
                    }

                    if (json_data.messages) {
                        $.each(json_data.messages, function(i, e) {
                            return_message = return_message + e + '<br>';                        
                        });                        
                    }

                    if (return_message) {
                        alfi_alert(return_message, '', 'error', { "closeButton": true, "timeOut": 0 } );
                    }

                }
            });
        return false;
        }
    });

    // =========
    // AJAX FORM
    // =========

    // Init

    $('form.ajax-form').unbind();
    $('form.ajax-form').bind('submit', function() {
        $('.form-group', this).removeClass('has-error');

        var $this = $(this);

        if ($this.data('submit-fn')) {
            if (typeof window[$this.data('submit-fn')] === "function") { 
                window[$this.data('submit-fn')]();
            }
        }

        var before_class = $('.btn-save i', $this).attr('class');
        $('.btn-save i', $this).addClass('fa fa-spinner fa-spin');

        $('.btn-save', $this).addClass('btn-primary');
        $('.btn-save', $this).removeClass('btn-danger');

        $.ajax({
            type       : "POST",
            url        : $(this).attr('action'),
            data       : new FormData(this),
            enctype    : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache      : false
        }).done( function(data, textStatus, jqXHR) {
            if ($this.data('ajax-success-fn')) {
                if (typeof window[$this.data('ajax-success-fn')] === "function") {
                    var header = {
                        'status': jqXHR.status,
                        'statusText': jqXHR.statusText
                    };
                    window[$this.data('ajax-success-fn')](header, data);
                }
            }

            $('[type=submit] i', $this).attr('class', before_class);

        }).fail( function(jqXHR, textStatus, errorThrown) {

            if ($this.data('ajax-fail-fn')) {
                if (typeof window[$this.data('ajax-fail-fn')] === "function") {
                    var header = {
                        'status': jqXHR.status,
                        'statusText': jqXHR.statusText
                    };
                    window[$this.data('ajax-fail-fn')](header, jqXHR.responseJSON);
                }
            }

            $('[type=submit]', $this).addClass('btn-danger');
            $('[type=submit]', $this).removeClass('btn-primary');

            $('[type=submit] i', $this).attr('class', before_class);

            json_data = jqXHR.responseJSON;

            if (json_data) {
                if (json_data.validation_messages) {
                    var validation_message = '';
                    $.each(json_data.validation_messages, function(i, e) {
                        $('[name='+i+']', $this).closest('.form-group').addClass('has-error');
                        validation_message = validation_message + e + '<br>';
                    });
                }
                else {
                    var validation_message = json_data.statusText;
                }
                alfi_alert(validation_message, '', 'error', { "closeButton": true, "timeOut": 0 } );
            }
            else {
                alfi_alert(data.statusText, '', 'error', { "closeButton": true, "timeOut": 0 });
            }

        });

        return false;
    });

    // Remove error class on change

    $('form.form .form-group input').on('keyup', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });

    $('form.form .form-group select').on('change', function() {
        $(this).closest('.form-group').removeClass('has-error');
    });   

    // =================
    // AJAX CONFIRMATION
    // =================

    // Init

    $('a.ajax-confirmation-url').unbind();
    $('a.ajax-confirmation-url').confirmation({
        popout      : true,
        rootSelector: 'a.ajax-confirmation-url',
        singleton   : true,

        btnOkClass: 'btn btn-xs btn-primary btn-ok',
        btnOkLabel: 'Igen',
        btnOkIcon : 'fa fa-check',

        btnCancelClass: 'btn btn-xs btn-default btn-cancel',
        btnCancelLabel: 'Nem',
        btnCancelIcon : 'fa fa-times',

        html: true,

        onConfirm: function() {
            var $this = $(this);
            if ($this.attr('ajax-href')) {
                remove_method = 'GET';
                if ($this.attr('data-ajax-method')) {
                    remove_method = $this.attr('data-ajax-method');
                }

                $.ajax({
                    url : $this.attr('ajax-href'),
                    type: remove_method,
                }).done( function(data, textStatus, jqXHR) {
                    if ($this.data('ajax-success-fn')) {
                        if (typeof window[$this.data('ajax-success-fn')] === "function") {
                            var header = {
                                'status': jqXHR.status,
                                'statusText': jqXHR.statusText
                            };
                            if (jqXHR.responseJSON) {
                                response = jqXHR.responseJSON;
                            }
                            else {
                                response = jqXHR.responseText;
                            }
                            window[$this.data('ajax-success-fn')](header, response);
                        }
                    }
                    $('i.fa', $this).removeClass('fa-spin fa-spinner');
                }).fail( function(jqXHR, textStatus, errorThrown) {
                    if ($this.data('ajax-fail-fn')) {
                        if (typeof window[$this.data('ajax-fail-fn')] === "function") {
                            var header = {
                                'status': jqXHR.status,
                                'statusText': jqXHR.statusText
                            };
                            if (jqXHR.responseJSON) {
                                response = jqXHR.responseJSON;
                            }
                            else {
                                response = jqXHR.responseText;
                            }
                            window[$this.data('ajax-fail-fn')](header, response);
                        }
                    }
                    $('i.fa', $this).removeClass('fa-spin fa-spinner');
    
                    json_data = jqXHR.responseJSON;
                            
                    if (json_data) {
                        var return_message = '';
    
                        if (json_data.message) {
                            return_message = json_data.message;
                        }
    
                        if (json_data.messages) {
                            $.each(json_data.messages, function(i, e) {
                                return_message = return_message + e + '<br>';                        
                            });                        
                        }
    
                        if (return_message) {
                            alfi_alert(return_message, '', 'error', { "closeButton": true, "timeOut": 0 } );
                        }
                    }
                });

                return false;
            }
        }
    });

    // Multi fixer

    var last_confirmation_clicked;

    $('a.ajax-confirmation-url').click( function() {
        if (last_confirmation_clicked && last_confirmation_clicked != this) {
            $(last_confirmation_clicked).confirmation('hide');
        }
        $(this).confirmation('show');
        last_confirmation_clicked = this;
        return false;
    });

    // =========
    // DATATABLE
    // =========

    // Filter reset

	$(document).on( 'init.dt', function ( e, settings ) {
		$('input[type=search]', $('.dataTable').closest('.dataTables_wrapper') ).after(
			$('<span>').addClass('dataTables_filter_reset').append(
				$('<i>').addClass('fa fa-times')
			).on('click', function() {
				$(this).closest('.dataTables_wrapper').find('.dataTable').DataTable().search('').draw();
			})
		)
	});

    // Localization

    $.extend( true, $.fn.dataTable.defaults, {
        'language'  : { 'url': 'assets/datatables/Hungarian.json' },
        'dom'       : '<"float-left"B><"float-right"f>rt<"row"<"col-sm-6"l><"col-sm-6"p>>',
        "lengthMenu": [ [30, 100, -1], [30, 100, "Összes"] ],
        'pageLength': 30,
    });

    // ==========
    // DATEPICKER
    // ==========

    // Localization

    if ($.fn.datepicker.dates != undefined) {
        $.fn.datepicker.dates['hu'] = {
            days       : ["Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat"],
            daysShort  : ["Vas", "Hét", "Ked", "Sze", "Csü", "Pén", "Szo"],
            daysMin    : ["Va", "He", "Ke", "Sz", "Cs", "Pé", "Sz"],
            months     : ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"],
            monthsShort: ["jan", "feb", "már", "ápr", "máj", "jún", "júl", "aug", "sze", "okt", "nov", "dec"],
            today      : "Ma",
            clear      : "Töröl",
            format     : "yyyy.mm.dd.",
            titleFormat: "yyyy. MM",
            weekStart  : 1
        };
    }

    // =======
    // TOOLTIP
    // =======

    // Init

    $('[data-toggle="popover"]').popover({
        content: function() {
            if ($(this).attr('data-tooltip-selector')) {
                return $($(this).attr('data-tooltip-selector')).html()
            }
            else {
                return $(this).attr('data-content')
            }
        },
        trigger  : 'hover',
        html     : true,
        container: 'body',
    });

    // =====================
    // BOX ADVANCED COLLAPSE
    // =====================

    $('.box .box-header .box-tools [data-widget=collapse]').one('click', function() {
        if ($(this).closest('.box').hasClass('collapsed-box')) {
            $.cookie($(this).attr('data-cookie-id'), '', { expires : 999999, path: $('base').attr('href') } );           
        }
        else {
            $.cookie($(this).attr('data-cookie-id'), 'collapsed-box', { expires : 999999, path: $('base').attr('href') } );
        }
    })

    $.each($('.box .box-header .box-tools [data-widget=collapse]'), function ( index, value) {
        if ($(value).closest('.box').hasClass('collapsed-box')) {
            $('i.fa', $(value)).removeClass('fa-minus').addClass('fa-plus');
        }
        else {
            $('i.fa', $(value)).removeClass('fa-plus').addClass('fa-minus');
        }
    });

}

// #########################
// #########################
// ###                   ###
// ###    GLOBAL INIT    ###
// ###                   ###
// #########################
// #########################

$(function() {

    $( document ).ajaxComplete( function () {
        app_load_init();
    });

    $( document ).ready( function () {
        app_load_init();
    });

    /* setInterval( function() {
        $.ajax({
            url: 'profile/saml'
        });
    }, 180000); */

});

// ================
// HELPER FUNCTIONS
// ================

// Copy to clipboard

function copyToClipboard(selector) {
    $(selector).select();
    document.execCommand("copy");
    setTimeout( function() {
        if (window.getSelection) { window.getSelection().removeAllRanges(); }
        else if (document.selection) { document.selection.empty(); }
    }, 1000);
}

// Alfi alert based on toaster

function alfi_alert(message, title = 'Figyelem', type = 'info', options = new Array() ) {
    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": 1000
    }
	if (options) {
		toastr.options = Object.assign(toastr.options, options);
	}
	toastr[type](message, title, { 'toastClass': 'callout callout-'+type } );
}
