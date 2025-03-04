<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme custom Installation.
 *
 * @package   theme_boost_magnific
 * @copyright 2024 Eduardo kraus (http://eduardokraus.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Theme_boost_magnific install function.
 *
 * @return void
 * @throws Exception
 */
function xmldb_theme_boost_magnific_install() {
    global $DB, $SITE, $CFG;

    if (method_exists("core_plugin_manager", "reset_caches")) {
        core_plugin_manager::reset_caches();
    }

    set_config("background_color", "#007bc3", "theme_boost_magnific");
    set_config("background_text_color", "#ffffff", "theme_boost_magnific");
    set_config("theme_color", "theme_color_blue", "theme_boost_magnific");
    set_config("theme_color__color_primary", "#2B4E84", "theme_boost_magnific");
    set_config("theme_color__color_secondary", "#3E65A0", "theme_boost_magnific");
    set_config("theme_color__color_buttons", "#183054", "theme_boost_magnific");

    set_config("frontpage_about_title", "", "theme_boost_magnific");
    set_config("frontpage_avaliablecourses_text", "", "theme_boost_magnific");
    set_config("frontpage_avaliablecourses_instructor", 1, "theme_boost_magnific");

    set_config("top_scroll_background_color", "#5C5D5F", "theme_boost_magnific");
    set_config("top_scroll_text_color", "#FFFFFF", "theme_boost_magnific");

    set_config("slideshow_numslides", 0, "theme_boost_magnific");
    for ($i = 1; $i <= 9; $i++) {
        set_config("slideshow_info_{$i}", "", "theme_boost_magnific");
        set_config("slideshow_image_{$i}", "", "theme_boost_magnific");
        set_config("slideshow_text_{$i}", "", "theme_boost_magnific");
        set_config("slideshow_url_{$i}", $CFG->wwwroot, "theme_boost_magnific");
    }

    set_config("mycourses_numblocos", 4, "theme_boost_magnific");
    for ($i = 1; $i <= 4; $i++) {
        $blocks = [
            [
                "url" => "{$CFG->wwwroot}/message/index.php",
                "title" => get_string("messages", "message"),
                "icon" => "message",
                "color" => "#2441e7",
            ], [
                "url" => "{$CFG->wwwroot}/user/profile.php",
                "title" => get_string("profile"),
                "icon" => "profile",
                "color" => "#FF1053",
            ], [
                "url" => "{$CFG->wwwroot}/user/preferences.php",
                "title" => get_string("preferences"),
                "icon" => "preferences",
                "color" => "#00A78E",
            ], [
                "url" => "{$CFG->wwwroot}/grade/report/overview/index.php",
                "title" => get_string("grades", "grades"),
                "icon" => "grade",
                "color" => "#ECD06F",
            ],
        ];
        $block = $blocks[$i - 1];

        $fs = get_file_storage();
        $filerecord = new stdClass();
        $filerecord->component = "theme_boost_magnific";
        $filerecord->contextid = context_system::instance()->id;
        $filerecord->userid = get_admin()->id;
        $filerecord->filearea = "mycourses_icon_{$i}";
        $filerecord->filepath = "/";
        $filerecord->itemid = 0;
        $filerecord->filename = "{$block["icon"]}.svg";
        $file = $fs->create_file_from_pathname($filerecord, "{$CFG->dirroot}/theme/boost_magnific/pix/blocks/{$block["icon"]}.svg");

        set_config("mycourses_icon_{$i}", $file->get_id(), "theme_boost_magnific");
        set_config("mycourses_title_{$i}", $block["title"], "theme_boost_magnific");
        set_config("mycourses_url_{$i}", $block["url"], "theme_boost_magnific");
        set_config("mycourses_color_{$i}", $block["color"], "theme_boost_magnific");
        set_config("frontpage_about_text_{$i}", "", "theme_boost_magnific");
    }

    set_config("frontpage_about_enable", 0, "theme_boost_magnific");
    set_config("frontpage_about_logo", "", "theme_boost_magnific");
    set_config("frontpage_about_title", get_string("frontpage_about_title_default", "theme_boost_magnific"));
    set_config("frontpage_about_description", "", "theme_boost_magnific");
    for ($i = 1; $i <= 4; $i++) {
        set_config("frontpage_about_text_{$i}", get_string("frontpage_about_text_{$i}_defalt", "theme_boost_magnific"));
        if ($i == 1) {
            $count = $DB->get_field_select("course", "COUNT(*)", "id != {$SITE->id}");
            set_config("frontpage_about_number_{$i}", $count, "theme_boost_magnific");
        } else if ($i == 2) {
            $roleid = $DB->get_field_select("role", "id", "shortname = 'teacher'");
            $count = $DB->get_field_select("role_assignments", "COUNT(DISTINCT userid)", "roleid = {$roleid}");
            set_config("frontpage_about_number_{$i}", $count, "theme_boost_magnific");
        } else if ($i == 3) {
            $roleid = $DB->get_field_select("role", "id", "shortname = 'student'");
            $count = $DB->get_field_select("role_assignments", "COUNT(DISTINCT userid)", "roleid = {$roleid}");
            set_config("frontpage_about_number_{$i}", $count, "theme_boost_magnific");
        } else if ($i == 4) {
            $count = $DB->get_field_select("course_modules", "COUNT(*)", "visible = 1 AND course != {$SITE->id}");
            set_config("frontpage_about_number_{$i}", $count, "theme_boost_magnific");
        }
    }

    set_config("footer_links_title", "", "theme_boost_magnific");
    set_config("footer_social_title", "", "theme_boost_magnific");
    set_config("footer_type", 0, "theme_boost_magnific");
    set_config("footer_description", $SITE->fullname, "theme_boost_magnific");
    set_config("footer_links_title", get_string("footer_links_title_default", "theme_boost_magnific"));
    set_config("footer_links", "", "theme_boost_magnific");
    set_config("footer_social_title", get_string("footer_social_title_default", "theme_boost_magnific"));
    set_config("social_youtube", "", "theme_boost_magnific");
    set_config("social_linkedin", "", "theme_boost_magnific");
    set_config("social_facebook", "", "theme_boost_magnific");
    set_config("social_twitter", "", "theme_boost_magnific");
    set_config("social_instagram", "", "theme_boost_magnific");

    set_config("contact_footer_title", "", "theme_boost_magnific");
    set_config("contact_footer_title", get_string("footer_contact_title_default", "theme_boost_magnific"));
    set_config("contact_address", "", "theme_boost_magnific");
    set_config("contact_phone", "", "theme_boost_magnific");
    set_config("contact_email", "", "theme_boost_magnific");

    set_config("login_theme", "theme_image_login", "theme_boost_magnific");
    set_config("login_backgroundfoto", "", "theme_boost_magnific");
    set_config("login_backgroundcolor", "", "theme_boost_magnific");

    set_config("login_login_description", "", "theme_boost_magnific");
    set_config("login_forgot_description", "", "theme_boost_magnific");
    set_config("login_signup_description", "", "theme_boost_magnific");

    set_config("home_type", 0, "theme_boost_magnific");
    set_config("frontpage_mycourses_text", "", "theme_boost_magnific");
    set_config("frontpage_mycourses_instructor", "", "theme_boost_magnific");
    set_config("logo_color", "", "theme_boost_magnific");
    set_config("logo_write", "", "theme_boost_magnific");
    set_config("fontfamily", "Roboto", "theme_boost_magnific");
    set_config("fontfamily_title", "Bree Serif", "theme_boost_magnific");
    set_config("fontfamily_menus", "Roboto", "theme_boost_magnific");
    set_config("fontfamily_sitename", "Oswald", "theme_boost_magnific");
    set_config("customcss", "", "theme_boost_magnific");
    set_config("footer_show_copywriter", 1, "theme_boost_magnific");

    $fonts = "<style>\n@import url('https://fonts.googleapis.com/css2?" .
        "&family=Briem+Hand:wght@100..900&display=swap');\n</style>";
    set_config("sitefonts", $fonts, "theme_boost_magnific");

    require_once(__DIR__ . "/version-background_course_image.php");
    require_once(__DIR__ . "/version-2025020600.php");
}
