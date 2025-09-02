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
 * User profile file
 *
 * @package   theme_boost_magnific
 * @copyright 2025 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// User profile section.
$page = new admin_settingpage("theme_boost_magnific_userprofile",
    get_string("userprofilesettings", "theme_boost_magnific"));

$url = "{$CFG->wwwroot}/theme/boost_magnific/quickstart/#user-profile";
$setting = new admin_setting_heading("theme_boost_magnific_quickstart_userprofile", "",
    get_string("quickstart_settings_link", "theme_boost_magnific", $url));
$page->add($setting);

// Profile background image.
$setting = new admin_setting_configstoredfile("theme_boost_magnific/background_profile_image",
    get_string("background_profile_image", "theme_boost_magnific"),
    get_string("background_profile_image_desc", "theme_boost_magnific"),
    "background_profile_image", 0,
    ["maxfiles" => 1, "accepted_types" => [".jpg", ".jpeg", ".svg", ".png"]]);
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

$settings->add($page);
