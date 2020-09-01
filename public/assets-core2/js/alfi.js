// ############################
// ############################
// ###                      ###
// ###    ALFI GLOBAL JS    ###
// ###                      ###
// ############################
// ############################

// const { on } = require("gulp");

function app_load_init() {

    // =====
    // MODAL
    // =====

    // Init

    $('.ajax-modal').unbind('click');
    $('.ajax-modal').bind('click', function() {

        let modal = '.modal .modal-dialog .modal-content > ';
        $(modal +'.modal-footer').hide();

        // headerless modal
        if ($(this).data('modal-headerless') !== undefined)
            $(modal +'.modal-header').hide();

        $(modal + '.modal-header .modal-title').html('Betöltés...');
        $(modal + '.modal-body').html( "<div class='loader'><i class='fa fa-spin fa-spinner'></i></div>" );


        // Set the modal's width if the button's data-modal-width attribute exists
        $('div.modal .modal-dialog').css({
            'width': ''
        });
        if ($(this).data('modal-width')) {
            $('div.modal .modal-dialog').css({
                'width': $(this).data('modal-width') +'px'
            });
        }
        if ($(this).data('modal-close-fn')) {
            $('.modal').data('modal-close-fn', $(this).data('modal-close-fn'));
        }

        // Set the modal special class
        if ($('div.modal').data('modal-class')) {
            $('div.modal').removeClass($('div.modal').data('modal-class'));
            $('div.modal').data('modal-class', '');
        }
        if ($(this).data('modal-class')) {
            $('div.modal').addClass( $(this).data('modal-class') );
            $('div.modal').data('modal-class', $(this).data('modal-class'));
        }

        if ($('div.modal .modal-dialog').data('modal-dialog-class')) {
            $('div.modal .modal-dialog').removeClass($('div.modal .modal-dialog').data('modal-dialog-class'));
            $('div.modal .modal-dialog').data('modal-dialog-class', '');
        }
        if ($(this).data('modal-dialog-class')) {
            $('div.modal .modal-dialog').addClass( $(this).data('modal-dialog-class') );
            $('div.modal .modal-dialog').data('modal-dialog-class', $(this).data('modal-dialog-class'));
        }

        // Set the modal's title as the button's data-modal-title or it's text
        $(modal + '.modal-header .modal-title').html( $(this).data('modal-title') );

        $('div.modal').modal('show');
        
    	if ($(this).attr('href') && $(this).attr('href') != '#') {
            $(modal +'.modal-body').html( "<div class='loader'><i class='fa fa-spin fa-spinner'></i></div>" );

            let ajaxOptions = {
                url: $(this).attr('href')
            };
            
            // NOTE: Ez lehetőséget ad az ajax model inicializálására.
            // Az eddigi kód nem módosult, csak bűvült, nem befolyásolja az eddigi felhasználási módot
            // Felhasználás: Modal megnyitása bküldött adatokkal, pl egy form tartalmával.
            // Bővítés oka: Sok dolgot nem célszerű GET metódussal küldeni.
            if (typeof window[$(this).data('modal-init')] === "function") {
                ajaxOptions = window[$(this).data('modal-init')]();
            }

            $.ajax(ajaxOptions).done( function(data) {

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

    function closeModal() {
        $(".modal").modal('hide');
        if (typeof window[$(".modal").data('modal-close-fn')] === "function") {
            window[$(".modal").data('modal-close-fn')]();
        }
    }

    // Close modal click outside

    $('body').click( function(event) {
        if ($(event.target).is('.modal.fade')) {
            if(!$(event.target).closest('.modal .modal-dialog').length && !$(event.target).is('.modal .modal-dialog')) {
                closeModal();
            }     
        }
    });

    // Close modal on keypress ESC

    $(document).keydown( function(e) {
        if (e.keyCode == 27) {
            closeModal();
        } 
    });
    
	// Close button in header

    $('a.close', 'div.modal').unbind();
    $('a.close', 'div.modal').on('click', function () {
		closeModal();
	});

    // ========
    // AJAX URL
    // ========

    // Init

    // $('a.ajax-url, input.ajax-url, button.ajax-url').unbind();
    $('.ajax-url').unbind();
    $('.ajax-url').bind('click', function() {
        var $this = $(this);
        if ($this.attr('href') && $this.attr('href') != '#') {
            $('i.fa, i.far, i.fas', $this).addClass('fa-spin fa-spinner');
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
                $('i.fa, i.far, i.fas', $this).removeClass('fa-spin fa-spinner');
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
                $('i.fa, i.far, i.fas', $this).removeClass('fa-spin fa-spinner');

                json_data = jqXHR.responseJSON;
                        
                if (json_data) {
                    var return_message = '';

                    if (json_data.message) {
                        return_message = json_data.message;
                    }
                    else
                    if (json_data.messages) {
                        if (typeof json_data.messages === 'object') {
                            $.each(json_data.messages, function(i, e) {
                                return_message = return_message + e + '<br>';                        
                            });
                        }                    
                        else {
                            return_message = json_data.messages;
                        }
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
        $('.is-invalid', this).removeClass('is-invalid');

        $('.btn-submit').removeClass('btn-danger');
        $('.btn-submit').addClass('btn-primary');

        var $this = $(this);

        if ($this.data('submit-fn')) {
            if (typeof window[$this.data('submit-fn')] === "function") { 
                window[$this.data('submit-fn')]();
            }
        }

        $('.btn-submit i.fa, .btn-submit i.far, .btn-submit i.fas').addClass('fa-spinner fa-spin');

        $.ajax({
            type       : "POST",
            url        : $(this).attr('action'),
            data       : new FormData(this),
            enctype    : 'multipart/form-data',
            processData: false,
            contentType: false,
            cache      : false     
        }).done( function(data, textStatus, jqXHR) {
            $('.btn-submit i.fa, .btn-submit i.far, .btn-submit i.fas').removeClass('fa-spinner fa-spin');

            if ($this.data('ajax-success-fn')) {
                if (typeof window[$this.data('ajax-success-fn')] === "function") {
                    var header = {
                        'status': jqXHR.status,
                        'statusText': jqXHR.statusText
                    };
                    window[$this.data('ajax-success-fn')](header, data);
                }
            }

        }).fail( function(jqXHR, textStatus, errorThrown) {
            $('.btn-submit').addClass('btn-danger');
            $('.btn-submit').removeClass('btn-primary');
            $('.btn-submit i.fa, .btn-submit i.far, .btn-submit i.fas').removeClass('fa-spinner fa-spin');

            if ($this.data('ajax-fail-fn')) {
                if (typeof window[$this.data('ajax-fail-fn')] === "function") {
                    var header = {
                        'status': jqXHR.status,
                        'statusText': jqXHR.statusText
                    };
                    window[$this.data('ajax-fail-fn')](header, jqXHR.responseJSON);
                }
            }

            json_data = jqXHR.responseJSON;

            if (json_data) {
                var message = '';
                if (json_data.message) {
                    message = json_data.message;
                }
                else
                if (json_data.messages) {
                    if (typeof json_data.messages === 'object') {
                        $.each(json_data.messages, function(i, e) {
                            $('[name='+i+']', $this).addClass('is-invalid');
                            message = message + e + '<br>';
                        });
                    }
                    else {
                        message = json_data.messages;
                    }
                }
                else {
                    message = json_data.statusText;
                }
                alfi_alert(message, '', 'error', { "closeButton": true, "timeOut": 0 } );
            }
            else {
                alfi_alert(data.statusText, '', 'error', { "closeButton": true, "timeOut": 0 });
            }
        });

        return false;
    });

    // Remove error class on change

    $('form.form input').on('keyup', function() {
        $(this).removeClass('is-invalid');
    });

    $('form.form select').on('change', function() {
        $(this).removeClass('is-invalid');
    });   

    $.each ( $('.btn-submit[data-submit]'), function(index, item)  {
        $( item ).unbind('click');
        $( item ).on('click', function() {
            $( $(item).data('submit') ).submit();
        })
    });

    // =====================
    // CONFIRMATION URL
    // =====================

    // Init

    $('.confirmation-url').unbind();
    $('.confirmation-url').confirmation({
        popout      : true,
        rootSelector: '.confirmation-url',
        singleton   : true,

        btnOkClass: 'btn btn-xs btn-primary btn-ok',
        btnOkLabel: 'Igen',
        btnOkIcon : 'fa fa-check',

        btnCancelClass: 'btn btn-xs btn-default btn-cancel',
        btnCancelLabel: 'Nem',
        btnCancelIcon : 'fa fa-times',

        html: true,
        
        onConfirm: function(value) {
            if ($(this).data('confirm') && typeof window[ $(this).data('confirm') ] === 'function') {
                window[ $(this).data('confirm') ]( $(this) , value);
            }
            else {
                try {
                    executeFunctionByName($(this).data('confirm'), window, $(this), value)
                }
                catch(e) {}
            }
        },

        onCancel: function() {
            if ($(this).data('cancel') && typeof window[ $(this).data('cancel') ] === 'function') {
                window[ $(this).data('cancel') ]( $(this) );
            }
        }

    });

    // =====================
    // AJAX CONFIRMATION URL
    // =====================

    // Init

    $.each( $('.ajax-confirmation-url'), function(index, item) {
        if ($(item).attr('href') && $(item).attr('href') != '#') {
            $(item).data('href', $(item).attr('href'));
            $(item).attr('href', '#')
        }
    });

    $('.ajax-confirmation-url').unbind();
    $('.ajax-confirmation-url').confirmation({
        popout      : true,
        rootSelector: '.ajax-confirmation-url',
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
            if ($this.data('href')) {
                $('i.fa, i.fas, i.far', $this).addClass('fa-spin fa-spinner');
                this_method = 'GET';
                if ($this.attr('data-ajax-method')) {
                    this_method = $this.attr('data-ajax-method');
                }

                $.ajax({
                    url : $this.data('href'),
                    type: this_method,
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
                    $('i.fa, i.fas, i.far', $this).removeClass('fa-spin fa-spinner');
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
                    $('i.fa, i.fas, i.far', $this).removeClass('fa-spin fa-spinner');
    
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

    var last_confirmation_clicked = '';

    $('.ajax-confirmation-url, .confirmation-url').click( function() {
        if (last_confirmation_clicked && last_confirmation_clicked != this) {
            $(last_confirmation_clicked).confirmation('hide');
        }
        $(this).confirmation('show');
        last_confirmation_clicked = this;
        return false;
    });

    // =================
    // TOOLTIP / POPOVER
    // =================

    // Init

    $('[data-tooltip]').tooltip({
        title: function() {
            return this.getAttribute('data-tooltip');
        }
    });

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

    // ====================
    // MENU COLLAPSE
    // ====================
    $('.sidebar-toggle').on('click', function() {
        setTimeout(function() {
            if ($('body').hasClass('sidebar-collapse'))
                $.cookie('sidebar_collapse', 'sidebar-collapse', { expires : 999999, path: document.location.host } );
            else
                $.cookie('sidebar_collapse', '', { expires : 999999, path: document.location.host } );
        }, 100);
    });

    // ====================
    // BLURBOX AJAX WRAPPER
    // ====================
    $(window).click(e => blurbox.close());
    $(window).keyup(e => {
        if (e.key === "Escape") {
            blurbox.close();
        }
    });
    $('.ajax-blurbox').unbind('click');
    $('.ajax-blurbox').click(event => event.stopPropagation());
    $('.ajax-blurbox').bind('click', event => {

        event.stopPropagation();
        
        let self = event.delegateTarget;
        blurbox.render('Betöltés', "<i class='fa fa-spin fa-spinner'></i>");

        // Setting the class
        if ($(self).data('blurbox-class')) {
            blurbox.setClass($(self).data('blurbox-class'));
        }

        let ajaxOptions = {
            url: $(self).attr('href')
        };
        
        if (typeof window[$(self).data('bb-init')] === "function") {
            ajaxOptions = window[$(self).data('bb-init')]();
        }

        $.ajax(ajaxOptions).done( function(data) {

            let head = 'Nem megfelelő válasz a szervertől';
            let body = '';

            // JSON válasz érkezett a modal-hoz
            if (typeof data === 'object') {

                head = $(self).data('blurbox-title');

                if (data['modal-title'])
                    head = data['modal-title'];

                if (data['head'])
                    head = data['head'];

                body = data['body'] || data['modal-body'];
            }
            else if(typeof data === 'string') {

                head = $(self).data('blurbox-title') || $(self).data('modal-title');
                body = data;
            }
            
            blurbox.render(head, body);

        }).fail( function() {
            blurbox.render("Szerver oldali hiba");
        });

        return false;
        
    });


    // ============================
    // DROPDOWN SHORTCUT jQ WRAPPER
    // ============================
    $('dropdown').each((ddk, dd) => {

        let dropdownGenerator                = new DropdownGenerator();
            dropdownGenerator.data.name      = $(dd).data('name');
            dropdownGenerator.data.inputName = $(dd).data('input');
            dropdownGenerator.data.btnClass  = $(dd).data('btn-class');

        $(dd).find('dropdown-item').each((ddik, ddi) => {
            dropdownGenerator.data.items.push({
                title: $(ddi).data('title'),
                value: $(ddi).data('value'),
                html : $(ddi).html(),
            });
        });

        $(dd).replaceWith( dropdownGenerator.render() );

        let initFn = $(dd).data('init');
        if (window[ initFn ] && typeof window[ initFn ] === 'function') {
            window[ initFn ]();
        }

    });
    // ====================
    // DROPDOWN SELECT
    // ====================
    $('.dropdown-select li').unbind();
    $('.dropdown-select li').click(function(event) {
        let ddValue = $(this).find('[data-dropdown-value]').data('dropdown-value');
        let ddTitle = $(this).find('[data-dropdown-title]').data('dropdown-title');
        $(this).parents('.dropdown').find('input').val( ddValue ).trigger('change');
        $(this).parents('.dropdown').find('.dropdown-selected').html( ddTitle );
    });

}

// #########################
// #########################
// ###                   ###
// ###    GLOBAL INIT    ###
// ###                   ###
// #########################
// #########################

// ==========
// DATEPICKER
// ==========

if ($.fn.datepicker.defaults) {
    $.fn.datepicker.defaults.language  = 'hu';
}

$.extend( true, $.fn.datetimepicker.defaults, {
    icons: {
        time: 'fas fa-clock'
    },
    format: 'YYYY.MM.DD. HH:mm:ss',
    locale: 'hu'
});

// ========
// SELECT 2
// ========

$.fn.select2.defaults.set( "theme",    "bootstrap4" );
$.fn.select2.defaults.set( "language", "hu" );

// =========
// DATATABLE
// =========

// Localization
$.extend( true, $.fn.dataTable.defaults, {
    'language'  : { 'url': 'assets/datatables/Hungarian.json' },
    'dom'       : '<"float-left"B><"float-right"f>rt<"row"<"col-sm-6"l><"col-sm-6"p>>',
    "lengthMenu": [ [25, 50, 100, -1], [25, 50, 100, "Összes"] ],
    'pageLength': 25,
});

$(function() {

    $( document ).ajaxComplete( function () {
        app_load_init();
    });

    $( document ).ready( function () {
        app_load_init();
    });

});

// =======
// BLURBOX
// =======
class BlurBox {

    constructor () {
        this.data        = {};
        this.initEvent   = null;
        this.renderEvent = null;
        this.closeEvent  = null;
        this.lastClass   = '';
    }

    render (head, body) {
        let self = this;

        return new Promise(function(resolve, reject) {

            self.init();

            // Clearing the blurbox
            $('#blurbox .blurbox-head, #blurbox .blurbox-body').html('');

            let BBParts = {head, body};
            for (let BBKey in BBParts) {

                let BBPart = BBParts[ BBKey ];

                (BBPart instanceof Array ? BBPart : [ BBPart ]).forEach((item, index) => {
                    let jQItem = null;
                    try       { jQItem = $(item); }
                    catch (e) {}

                    if (jQItem && jQItem.length === 1) {
                        jQItem.clone().appendTo( $('#blurbox .blurbox-'+ BBKey) );
                    }
                    else {
                        if (BBKey === 'head' && index === 0) {
                            $('#blurbox .blurbox-'+ BBKey).append( '<h4>'+ item +'</h4>' );
                        }
                        else {
                            $('#blurbox .blurbox-'+ BBKey).append( item );
                        }
                    }
                });

            }
            
            setTimeout(() => {
                $('#blurbox').addClass('active');

                if (self.renderEvent)
                self.renderEvent();

                return resolve();
            }, 1);

        });
    }

    close () {
        let self = this;
        return new Promise((resolve, reject) => {

            $('#blurbox').removeClass('active');
            self.setClass('');
            setTimeout(() => {
                $('#blurbox').remove();
                $('html, body').css({'overflow-x': self.data.ox});
            }, 750);

            if (self.closeEvent)
                self.closeEvent();

            resolve();

        });
    }

    setClass (className) {
        $('#blurbox').removeClass(this.lastClass);
        this.lastClass = className;
        $('#blurbox').addClass(className);
    }

    init () {

        this.data.ox = $('html, body').css('overflow-x');
        $('html, body').css('overflow-x', 'hidden');

        if (!$('#blurbox').length) {
            $('body').append(`
                <div id="blurbox">
                    <div class="blurbox-head px-4 pb-2 pt-2"></div>
                    <div class="blurbox-close" onclick="blurbox.close()">
                        <!--i class="far fa-times-circle"></i-->
                        <i class="fa-fw far fa-times"></i>
                    </div>
                    <div class="blurbox-body pr-3 ml-4 mt-3 mb-4 p-1 mr-2"></div>
                </div>
            `);
        }

        if (this.initEvent)
            this.initEvent();

    }

}
let blurbox = new BlurBox();

// ===============
// HTML GENERATORS
// ===============
class DropdownGenerator {

    constructor () {
        this.data = {
            name        : '',
            inputName   : '',
            btnClass    : '',
            items       : [],
            selectedItem: {},
        };
    }

    render () {

        if (Object.keys(this.data.selectedItem).length === 0) {
            this.data.selectedItem = this.data.items[0];
        }

        let output = 
        `<div class="dropdown dropdown-select" style="display:inline;">
            <input type="hidden" name="${this.data.inputName}" value="${this.data.selectedItem.value}">
            <label class="mb-0">
                <button class="btn btn-default dropdown-toggle ${this.data.btnClass}" style="width: 100%; text-align: left;" data-btncolor="primary" type="button" id="${this.data.name}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="dropdown-selected">${this.data.selectedItem.html}</span>
                </button>
                <ul class="dropdown-menu item-action-bar-dropleft-menu p-0 w-100" data-toggle="dropdown" aria-labelledby="${this.data.name}" x-placement="bottom-start">
                `;
        
        this.data.items.forEach(item => {
            output += `
            <li>
                <a class="btn btn-sm btn-default d-block text-left border-0 py-2 px-3" href="javascript: null;" data-dropdown-value="${item.value}">
                    <b data-dropdown-title="${item.title}">${item.html}</b>
                </a>
            </li>`;
        });

        output += `
                </ul>
            </label>
        </div>`;

        return output;

    }

}

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
    if (type == 'danger') type = 'error';
    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": 1000
    }
	if (options) {
		toastr.options = Object.assign(toastr.options, options);
	}
	toastr[type](message, title, { 'toastClass': 'callout callout-'+type } );
}

function executeFunctionByName(functionName, context) {
    let args = Array.prototype.slice.call(arguments, 2);
    let namespaces = functionName.split(".");
    let func = namespaces.pop();
    for(let i = 0; i < namespaces.length; i++) {
        console.log(context)
      context = context[namespaces[i]];
    }
    return context[func].apply(context, args);
}