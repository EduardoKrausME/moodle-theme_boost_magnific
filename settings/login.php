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
 * Login file
 *
 * @package   theme_boost_magnific
 * @copyright 2025 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG, $OUTPUT, $PAGE;
require_once("{$CFG->dirroot}/theme/boost_magnific/lib.php");

$page = new admin_settingpage("theme_boost_magnific_login",
    get_string("loginsettings", "theme_boost_magnific"));

$options = [
    "aurora" => get_string("logintheme_aurora", "theme_boost_magnific"),
    "dark-elegante" => get_string("logintheme_dark-elegante", "theme_boost_magnific"),
    "selva-canopy" => get_string("logintheme_selva-canopy", "theme_boost_magnific"),
    "clean-minimal" => get_string("logintheme_clean-minimal", "theme_boost_magnific"),
    "clean-outline" => get_string("logintheme_clean-outline", "theme_boost_magnific"),
];
$setting = new admin_setting_configselect("theme_boost_magnific/logintheme",
    get_string("logintheme", "theme_boost_magnific"),
    get_string("logintheme_desc", "theme_boost_magnific"),
    "aurora", $options);
$page->add($setting);

// Login Background image setting.
$setting = new admin_setting_configstoredfile("theme_boost_magnific/loginbackgroundimage",
    get_string("loginbackgroundimage", "theme_boost_magnific"),
    get_string("loginbackgroundimage_desc", "theme_boost_magnific"), "loginbackgroundimage");
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

// Small logo file setting.
$setting = new admin_setting_configstoredfile("theme_boost_magnific/loginlogo",
    get_string("loginlogo", "theme_boost_magnific"),
    get_string("loginlogo_desc", "theme_boost_magnific"),
    "loginlogo", 0,
    ["maxfiles" => 1, "accepted_types" => [".jpg", ".jpeg", ".svg", ".png"]]);
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

$settings->add($page);
