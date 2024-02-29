define([
    "jquery",
], function($) {
    var theme = {

        theme_color         : function() {
            var boost_magnific_theme_color = $("#id_s_theme_boost_magnific_theme_color");

            $(".seletor-de-theme-boost_magnific").click(function() {
                var themename = $(this).attr("data-name");
                theme._theme_color_select(themename);

                boost_magnific_theme_color.val(themename);
            });
            boost_magnific_theme_color.change(function() {
                var themename = boost_magnific_theme_color.val();
                theme._theme_color_select(themename);

                boost_magnific_theme_color.val(themename);
            });
        },
        _theme_color_select : function(themename) {
            var $themename = $("#theme-" + themename);

            var color_primary = $themename.find(".color_primary").attr('data-color');
            var color_secondary = $themename.find(".color_secondary").attr('data-color');
            var color_buttons = $themename.find(".color_buttons").attr('data-color');
            var color_names = $themename.find(".color_names").attr('data-color');
            var color_titles = $themename.find(".color_titles").attr('data-color');

            $("#id_s_theme_boost_magnific_theme_color__color_primary").val(color_primary);
            $("#id_s_theme_boost_magnific_theme_color__color_secondary").val(color_secondary);
            $("#id_s_theme_boost_magnific_theme_color__color_buttons").val(color_buttons);
            $("#id_s_theme_boost_magnific_theme_color__color_names").val(color_names);
            $("#id_s_theme_boost_magnific_theme_color__color_titles").val(color_titles);
        },

        numslides          : function() {
            var theme_boost_magnific_slideshow_numslides = $("#id_s_theme_boost_magnific_slideshow_numslides");

            theme_boost_magnific_slideshow_numslides.change(function() {
                theme._numslides_changue(theme_boost_magnific_slideshow_numslides.val());
            });

            theme._numslides_changue(theme_boost_magnific_slideshow_numslides.val());
        },
        _numslides_changue : function(numslides) {
            for (var i = 0; i <= 9; i++) {
                if (numslides >= i) {
                    $("#admin-slideshow_info_" + i).parent().show();
                    $("#admin-slideshow_image_" + i).show();
                    $("#admin-slideshow_text_" + i).show();
                    $("#admin-slideshow_url_" + i).show();
                } else {
                    $("#admin-slideshow_info_" + i).parent().hide();
                    $("#admin-slideshow_image_" + i).hide();
                    $("#admin-slideshow_text_" + i).hide();
                    $("#admin-slideshow_url_" + i).hide();
                }
            }
        },

        login : function() {
            var login_theme = $("#id_s_theme_boost_magnific_login_theme");

            login_theme.change(function() {
                theme._login_changue(login_theme.val());
            });

            theme._login_changue(login_theme.val());
        },

        _login_changue : function(themename) {
            var login_backgroundfoto = $("#admin-login_backgroundfoto");
            var login_description = $("#admin-login_login_description, #admin-login_forgot_description, #admin-login_signup_description");
            var login_backgroundcolor = $("#admin-login_backgroundcolor");

            login_backgroundfoto.hide();
            login_description.hide();
            login_backgroundcolor.hide();

            switch (themename) {
                case 'login_theme_block':
                    login_backgroundfoto.show();
                    login_backgroundcolor.show();
                    break;
                case 'login_theme_image_login' :
                    login_backgroundfoto.show();
                    break;
                case 'login_theme_imagetext_login' :
                    login_backgroundfoto.show();
                    login_description.show();
                    break;
                case  'login_theme_login' :
                    break;
                case 'theme_login_branco' :
                    break;
            }
        }
    };

    return theme;
});


