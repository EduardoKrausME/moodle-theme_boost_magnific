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
 * @package     theme_boost_magnific
 * @copyright   2024 Eduardo kraus (http://eduardokraus.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_boost_magnific\template;

use theme_boost_magnific\fonts\font_util;

/**
 * frontapage_data.php
 *
 * @package     theme_boost_magnific
 * @copyright   2024 Eduardo kraus (http://eduardokraus.com)
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontapage_data {

    /**
     * @return array
     *
     * @throws \dml_exception
     */
    public static function topo() {
        return [
            'logourl_header' => theme_boost_magnific_get_logo("header"),
        ];
    }

    /**
     * @return array
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function slideshow() {
        $slideshownumslides = theme_boost_magnific_get_setting("slideshow_numslides");
        $data = [
            "slideshow_numslides" => $slideshownumslides,
            "slideshow_edit_settings" => self::edit_settings("theme_boost_magnific_slideshow"),
            "slideshow_slides" => [],
        ];

        if (!$slideshownumslides) {
            return $data;
        }

        for ($i = 1; $i <= $slideshownumslides; $i++) {
            $slideshowimage = theme_boost_magnific_get_setting_image("slideshow_image_{$i}");
            $slideshowurl = theme_boost_magnific_get_setting("slideshow_url_{$i}", true);
            $slideshowtext = theme_boost_magnific_get_setting("slideshow_text_{$i}", true);

            if ($slideshowimage) {
                $data["slideshow_slides"][] = [
                    "slideshow_image" => $slideshowimage,
                    "slideshow_url" => $slideshowurl,
                    "slideshow_text" => $slideshowtext,
                    "slideshow_num" => $i,
                ];
            } else {
                $data["slideshow_numslides"]--;
            }
        }

        return $data;
    }

    /**
     * @return array
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function about() {
        global $OUTPUT;

        $frontpageaboutenable = theme_boost_magnific_get_setting("frontpage_about_enable");

        $logo = theme_boost_magnific_get_setting_image("frontpage_about_logo");
        if (!$logo) {
            /** @var \moodle_url $url */
            $url = $OUTPUT->get_logo_url();
            if ($url) {
                $logo = $url->out(false);
            }
        }

        $data = [
            "frontpage_about_enable" => $frontpageaboutenable,
            "frontpage_about_logo" => $logo,
            "frontpage_about_title" => theme_boost_magnific_get_setting("frontpage_about_title"),
            "frontpage_about_description" => theme_boost_magnific_get_setting("frontpage_about_description", FORMAT_HTML),
            "frontpage_about_edit_settings" => self::edit_settings("theme_boost_magnific_about"),
            "about_numbers" => [],
        ];
        if (!$frontpageaboutenable) {
            return $data;
        }

        for ($i = 1; $i <= 4; $i++) {
            $number = theme_boost_magnific_get_setting("frontpage_about_number_{$i}");
            $text = theme_boost_magnific_get_setting("frontpage_about_text_{$i}");

            if ($number && $text) {
                $data["about_numbers"][] = [
                    "frontpage_about_number" => $number,
                    "frontpage_about_text" => $text,
                ];
            }
        }

        return $data;
    }

    /**
     * @return array
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function home_html() {
        $hometype = get_config("theme_boost_magnific", "home_type");
        $chave = optional_param('chave', false, PARAM_TEXT);

        if ($hometype == 1 || $chave == "home") {
            if ($chave == 'home') {
                $htmldata = optional_param('htmldata', false, PARAM_RAW);
                $cssdata = optional_param('cssdata', false, PARAM_RAW);

                $htmldata = "{$htmldata}\n<style>{$cssdata}</style>";
            } else {
                $lang = current_language();
                $htmldata = get_config("theme_boost_magnific", "home_htmleditor_{$lang}");
                if (!isset($htmldata[3])) {
                    $htmldata = get_config("theme_boost_magnific", "home_htmleditor_all");
                }
            }

            $htmldata .= font_util::print_only_unique();
            return [
                'home_html' => true,
                'home_htmleditor' => $htmldata,
            ];
        } else {
            return [
                'home_html' => false,
            ];
        }
    }

    /**
     * @param string $hasteg
     *
     * @return bool|string
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    private static function edit_settings($hasteg) {
        global $CFG;

        $settingsedit = false;
        if (has_capability('moodle/site:config', \context_system::instance())) {
            $editlang = get_string("{$hasteg}_editbooton", "theme_boost_magnific");
            $settingsedit = "<a href='{$CFG->wwwroot}/admin/settings.php?section=themesettingboost_magnific#{$hasteg}'";
            $settingsedit .= "   class='bt-edit-setting' target='_blank'>";
            $settingsedit .= "    <img src = '{$CFG->wwwroot}/theme/boost_magnific/pix/edit.svg' >";
            $settingsedit .= "    {$editlang}";
            $settingsedit .= "</a>";
        }

        return $settingsedit;
    }
}
