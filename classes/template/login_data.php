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
 * Frontpage template data
 *
 * @package   theme_boost_magnific
 * @copyright 2024 Eduardo kraus (http://eduardokraus.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_boost_magnific\template;

/**
 * login_data.php
 *
 * @package   theme_boost_magnific
 * @copyright 2024 Eduardo kraus (http://eduardokraus.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class login_data {

    /**
     * Function get_data
     *
     * @return array
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function get_data() {
        global $OUTPUT;

        $backgroundurl = theme_boost_magnific_get_setting_image("login_backgroundfoto");
        if (!$backgroundurl) {
            $backgroundurl = $OUTPUT->image_url("backgroundfoto", "theme");
        }

        $theme = theme_boost_magnific_get_setting("login_theme");

        $background = "background-image: url({$backgroundurl});";
        if ($theme == "login_theme_block") {
            $backgroundcolor = theme_boost_magnific_get_setting("login_backgroundcolor");
            $background = "background-color: {$backgroundcolor};background-image: url({$backgroundurl});";
        }

        return [
            "logourl_header" => theme_boost_magnific_get_logo("header"),
            "login_theme" => $theme,
            "login_backgroundcolor" => theme_boost_magnific_get_setting("login_backgroundcolor"),
            "login_background_image" => $background,

            "login_login_description" => theme_boost_magnific_get_setting("login_login_description", FORMAT_HTML),
            "login_forgot_description" => theme_boost_magnific_get_setting("login_forgot_description", FORMAT_HTML),
            "login_signup_description" => theme_boost_magnific_get_setting("login_signup_description", FORMAT_HTML),
        ];
    }
}
