/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
(function ($) {
    'use strict'

        // The original demo code
        var $sidebar = $('.control-sidebar')
        var $container = $('<div />', {
            class: 'p-3 control-sidebar-content'
        })

        $sidebar.append($container)

        var navbar_dark_skins = [
            'navbar-primary',
            'navbar-secondary',
            'navbar-info',
            'navbar-success',
            'navbar-danger',
            'navbar-indigo',
            'navbar-purple',
            'navbar-pink',
            'navbar-navy',
            'navbar-lightblue',
            'navbar-teal',
            'navbar-cyan',
            'navbar-dark',
            'navbar-gray-dark',
            'navbar-gray',
        ]

        var navbar_light_skins = [
            // 'navbar-light',
            'navbar-warning',
            // 'navbar-white',
            'navbar-orange',
        ]

        $container.append(
            '<h5>Oldal testreszabása</h5><hr class="mb-2"/>'
        )

        var $text_sm_body_checkbox = $('<input />', {
            type: 'checkbox',
            value: 1,
            name: 'app_theme_body_small_text',
            checked: $('body').hasClass('text-sm'),
            'class': 'mr-1'
        }).on('click', function () {
            app_theme.set($(this).attr('name'), $(this).is(':checked'));
            $('body').toggleClass('text-sm', $(this).is(':checked'));
        })
        var $text_sm_body_container = $('<label />', {
            'class': 'mb-1',
            'style': 'font-weight: 400; color: inherit;',
        }).append($text_sm_body_checkbox).append('<span>Kis alap betűméret</span>')
        $container.append($text_sm_body_container)

        var $text_sm_sidebar_checkbox = $('<input />', {
            type: 'checkbox',
            value: 1,
            name: 'app_theme_sidebar_nav_small_text',
            checked: $('.nav-sidebar').hasClass('text-sm'),
            'class': 'mr-1'
        }).on('click', function () {
            app_theme.set($(this).attr('name'), $(this).is(':checked'));
            $('.nav-sidebar').toggleClass('text-sm', $(this).is(':checked'));
        })
        var $text_sm_sidebar_container = $('<label />', {
            'class': 'mb-1',
            'style': 'font-weight: 400; color: inherit;',
        }).append($text_sm_sidebar_checkbox).append('<span>Oldalmenü kis betűméret</span>')
        $container.append($text_sm_sidebar_container)

        var $flat_sidebar_checkbox = $('<input />', {
            type: 'checkbox',
            value: 1,
            name: 'app_theme_sidebar_nav_flat_style',
            checked: $('.nav-sidebar').hasClass('nav-flat'),
            'class': 'mr-1'
        }).on('click', function () {
            app_theme.set($(this).attr('name'), $(this).is(':checked'));
            $('.nav-sidebar').toggleClass('nav-flat', $(this).is(':checked'));
        })
        var $flat_sidebar_container = $('<label />', {
            'class': 'mb-1',
            'style': 'font-weight: 400; color: inherit;',
        }).append($flat_sidebar_checkbox).append('<span>Oldalmenü flat stílus</span>')
        $container.append($flat_sidebar_container)

        var $legacy_sidebar_checkbox = $('<input />', {
            type: 'checkbox',
            value: 1,
            name: 'app_theme_sidebar_nav_legacy_style',
            checked: $('.nav-sidebar').hasClass('nav-legacy'),
            'class': 'mr-1'
        }).on('click', function () {
            app_theme.set($(this).attr('name'), $(this).is(':checked'));
            $('.nav-sidebar').toggleClass('nav-legacy', $(this).is(':checked'));
        })
        var $legacy_sidebar_container = $('<label />', {
            'class': 'mb-1',
            'style': 'font-weight: 400; color: inherit;',
        }).append($legacy_sidebar_checkbox).append('<span>Oldalmenü klasszikus stílus</span>')
        $container.append($legacy_sidebar_container)

        var $compact_sidebar_checkbox = $('<input />', {
            type: 'checkbox',
            value: 1,
            name: 'app_theme_sidebar_nav_compact',
            checked: $('.nav-sidebar').hasClass('nav-compact'),
            'class': 'mr-1'
        }).on('click', function () {
            app_theme.set($(this).attr('name'), $(this).is(':checked'));
            $('.nav-sidebar').toggleClass('nav-compact', $(this).is(':checked'));
        })
        var $compact_sidebar_container = $('<label />', {
            'class': 'mb-1',
            'style': 'font-weight: 400; color: inherit;',
        }).append($compact_sidebar_checkbox).append('<span>Oldalmenü kompakt méret</span>')
        $container.append($compact_sidebar_container)

        var sidebar_colors = [
            'bg-primary',
            'bg-warning',
            'bg-info',
            'bg-danger',
            'bg-success',
            'bg-indigo',
            'bg-lightblue',
            'bg-navy',
            'bg-purple',
            'bg-fuchsia',
            'bg-pink',
            'bg-maroon',
            'bg-orange',
            'bg-lime',
            'bg-teal',
            'bg-olive'
        ]

        var accent_colors = [
            'accent-primary',
            'accent-warning',
            'accent-info',
            'accent-danger',
            'accent-success',
            'accent-indigo',
            'accent-lightblue',
            'accent-navy',
            'accent-purple',
            'accent-fuchsia',
            'accent-pink',
            'accent-maroon',
            'accent-orange',
            'accent-lime',
            'accent-teal',
            'accent-olive'
        ]

        var sidebar_skins = [
            'sidebar-dark-secondary',
            'sidebar-dark-primary',
            'sidebar-dark-warning',
            'sidebar-dark-info',
            'sidebar-dark-danger',
            'sidebar-dark-success',
            'sidebar-dark-indigo',
            'sidebar-dark-lightblue',
            'sidebar-dark-navy',
            'sidebar-dark-purple',
            'sidebar-dark-fuchsia',
            'sidebar-dark-pink',
            'sidebar-dark-maroon',
            'sidebar-dark-orange',
            'sidebar-dark-lime',
            'sidebar-dark-teal',
            'sidebar-dark-olive',
            'sidebar-light-primary',
            'sidebar-light-warning',
            'sidebar-light-info',
            'sidebar-light-danger',
            'sidebar-light-success',
            'sidebar-light-indigo',
            'sidebar-light-lightblue',
            'sidebar-light-navy',
            'sidebar-light-purple',
            'sidebar-light-fuchsia',
            'sidebar-light-pink',
            'sidebar-light-maroon',
            'sidebar-light-orange',
            'sidebar-light-lime',
            'sidebar-light-teal',
            'sidebar-light-olive'
        ]

        $container.append('<br><br><h6>Színsémák</h6>')

        var $navbar_variants = $('<div />', {
            'class': 'd-flex'
        })
        var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins);
        var logo_skins = navbar_all_colors;
        var $navbar_variants_colors = createSkinBlock('navbar', navbar_all_colors, function (e) {

            var color = $(e).data('color');

            // Navbar
            var $main_header = $('.main-header');
            $main_header/*.removeClass('navbar-dark')*/.removeClass('navbar-light');
            navbar_all_colors.map(function (color) {
                $main_header.removeClass(color);
            })
            // $main_header.toggleClass('navbar-dark', navbar_dark_skins.indexOf(color) > -1);

            $main_header.addClass(color);

            // Redefining primary color
            redefinePrimaryColors(color);

            // Logo
            var $logo = $('.brand-link')
            logo_skins.map(function (skin) {
                $logo.removeClass(skin)
            })
            $logo.addClass(color)

            // Sidebar
            var sidebar_class = 'sidebar-dark-' + color.replace('navbar-', '')
            var $sidebar = $('.main-sidebar')
            sidebar_skins.map(function (skin) {
                $sidebar.removeClass(skin)
            })
            $sidebar.addClass(sidebar_class)

        })
        $navbar_variants.append($navbar_variants_colors)
        $container.append($navbar_variants)

    function createSkinBlock(blockName, colors, callback) {
        blockName = 'app_theme_'+ blockName;
        var $block = $('<div />', {
            'class': 'd-flex flex-wrap mb-3',
            'id'   : blockName
        })

        colors.map(function (color) {
            var $color = $('<div />', {
                'class': (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-') + ' elevation-2',
                'data-color' : color,
            })

            $block.append($color)

            $color.data('color', color)

            $color.css({
                width: '40px',
                height: '20px',
                borderRadius: '25px',
                marginRight: 10,
                marginBottom: 10,
                opacity: 0.8,
                cursor: 'pointer'
            })

            $color.hover(function () {
                $(this).css({
                    opacity: 1
                }).removeClass('elevation-2').addClass('elevation-4')
            }, function () {
                $(this).css({
                    opacity: 0.8
                }).removeClass('elevation-4').addClass('elevation-2')
            })

            if (callback) {
                $color.on('click', function(e){
                    app_theme.set(blockName, $(this).data('color'));
                    callback($(this));
                });
            }
        })

        return $block
    }

})(jQuery);

function redefinePrimaryColors(color) {

    let realColor = null;
    if ($('.main-header').length) {
        realColor = $('.main-header').css('background-color');
    }

    realColor = realColor.substr(4, realColor.length - 5);
    // var parsedHex = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(realColor);
    // realColor = parsedHex ? ( parseInt(parsedHex[1], 16) +', '+ parseInt(parsedHex[2], 16) +', '+ parseInt(parsedHex[3], 16) ) : '0, 123, 255';

    $('#js-redefined-classes').html(`
    :root {
        --main-color: ${realColor};
    }
    .card.card-primary > .card-header,
    .bg-primary {
        background-color: ${realColor} !important;
    }
    a {
        color: ${realColor};
    }
    .text-primary {
        color: ${realColor} !important;
    }`);

}

// Theme handling object
let app_theme = (function (cookie_data) {

    let data = Object.assign(cookie_data ? JSON.parse(cookie_data) : {}, { set, clear });

    function set(key, value) {
        data[key] = value;
        $.cookie('app_theme', JSON.stringify(data), { expires: 365, path: '/' });
    }
    function clear() {
        $.cookie('app_theme', '');
    }

    return data;

})($.cookie('app_theme'));

// Restoring previous settings
for (let key in app_theme) {
    if (typeof app_theme[ key ] === 'boolean') {
        if (app_theme[ key ] === true)
            $('input[name='+ key).trigger('click');
    }
    else if (typeof app_theme[ key ] === 'string') {
        $(`#${key} [data-color='${app_theme[ key ]}']`).trigger('click');
        redefinePrimaryColors(app_theme[ key ]);
    }
}