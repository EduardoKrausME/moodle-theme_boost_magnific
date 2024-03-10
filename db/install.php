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
 * @package     theme_boost_magnific
 * @copyright   2024 Eduardo kraus (http://eduardokraus.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Theme_boost_magnific install function.
 *
 * @return void
 * @throws coding_exception
 * @throws dml_exception
 */
function xmldb_theme_boost_magnific_install() {
    global $DB, $SITE;

    if (method_exists('core_plugin_manager', 'reset_caches')) {
        core_plugin_manager::reset_caches();
    }

    magnific_set_config("frontpage_avaliablecourses_text", '');
    magnific_set_config("frontpage_avaliablecourses_instructor", 1);

    magnific_set_config("slideshow_numslides", 0);
    for ($i = 1; $i <= 9; $i++) {
        magnific_set_config("slideshow_info_{$i}", '');
        magnific_set_config("slideshow_image_{$i}", '');
        magnific_set_config("slideshow_url_{$i}", '');
        magnific_set_config("slideshow_text_{$i}", '');
    }

    magnific_set_config("frontpage_about_enable", 0);
    magnific_set_config("frontpage_about_logo", '');
    magnific_set_config("frontpage_about_title", magnific_get_string("frontpage_about_title_default"));
    magnific_set_config("frontpage_about_description", '');
    for ($i = 1; $i <= 4; $i++) {
        magnific_set_config("frontpage_about_text_{$i}", magnific_get_string("frontpage_about_text_{$i}_defalt"));
        if ($i == 1) {
            $count = $DB->get_field_select("course", "COUNT(*)", "id != {$SITE->id}");
            magnific_set_config("frontpage_about_number_{$i}", $count);
        } else if ($i == 2) {
            $roleid = $DB->get_field_select("role", "id", "shortname = 'teacher'");
            $count = $DB->get_field_select("role_assignments", "COUNT(DISTINCT userid)", "roleid = {$roleid}");
            magnific_set_config("frontpage_about_number_{$i}", $count);
        } else if ($i == 3) {
            $roleid = $DB->get_field_select("role", "id", "shortname = 'student'");
            $count = $DB->get_field_select("role_assignments", "COUNT(DISTINCT userid)", "roleid = {$roleid}");
            magnific_set_config("frontpage_about_number_{$i}", $count);
        } else if ($i == 4) {
            $count = $DB->get_field_select("course_modules", "COUNT(*)", "visible = 1 AND course != {$SITE->id}");
            magnific_set_config("frontpage_about_number_{$i}", $count);
        }
    }

    magnific_set_config("footer_description", $SITE->fullname);
    magnific_set_config("footer_links_title", magnific_get_string("footer_links_title_default"));
    magnific_set_config("footer_links", '');
    magnific_set_config("footer_social_title", magnific_get_string("footer_social_title_default"));
    magnific_set_config("social_youtube", '');
    magnific_set_config("social_linkedin", '');
    magnific_set_config("social_facebook", '');
    magnific_set_config("social_twitter", '');
    magnific_set_config("social_instagram", '');
    magnific_set_config("contact_footer_title", magnific_get_string("footer_contact_title_default"));
    magnific_set_config("contact_address", '');
    magnific_set_config("contact_phone", '');
    magnific_set_config("contact_email", '');

    magnific_set_config("login_theme", "theme_image_login");
    magnific_set_config("login_backgroundfoto", '');
    magnific_set_config("login_backgroundcolor", '');

    magnific_set_config("login_login_description", '');
    magnific_set_config("login_forgot_description", '');
    magnific_set_config("login_signup_description", '');

    magnific_set_config("frontpage_mycourses_text", '');
    magnific_set_config("frontpage_mycourses_instructor", '');
    magnific_set_config("logo_color", '');
    magnific_set_config("logo_write", '');
    magnific_set_config("fontfamily", 'Roboto');
    magnific_set_config("customcss", '');
    magnific_set_config("footer_show_copywriter", 1);
}

/**
 * @param $name
 * @param $value
 *
 * @return mixed
 */
function magnific_set_config($name, $value) {
    return set_config($name, $value, "theme_boost_magnific");
}

/**
 * @param $name
 *
 * @return string
 *
 * @throws coding_exception
 */
function magnific_get_string($name) {
    return get_string($name, "theme_boost_magnific");
}
