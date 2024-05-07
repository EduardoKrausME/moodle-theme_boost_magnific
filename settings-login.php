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
 * @package     theme_boost_magnific
 * @copyright   2024 Eduardo Kraus https://eduardokraus.com/
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$page = new admin_settingpage('theme_boost_magnific_login', get_string('settings_login_heading', 'theme_boost_magnific'));

$choices = [
    'login_theme_block' => get_string('login_theme_block', 'theme_boost_magnific'),
    'login_theme_image_login' => get_string('login_theme_image_login', 'theme_boost_magnific'),
    'login_theme_imagetext_login' => get_string('login_theme_imagetext_login', 'theme_boost_magnific'),
    'login_theme_login' => get_string('login_theme_login', 'theme_boost_magnific'),
    'theme_login_branco' => get_string('theme_login_branco', 'theme_boost_magnific'),
];
$setting = new admin_setting_configselect('theme_boost_magnific/login_theme',
    get_string('login_theme', 'theme_boost_magnific'),
    get_string('login_theme_desc', 'theme_boost_magnific'),
    'login_theme_block', $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$link = '<a href="https://www.freepik.com/free-photo/teacher-talking-with-her-students-online_11332964.htm"
            target="_blank">Teacher talking with her students online</a>';
$setting = new admin_setting_configstoredfile("theme_boost_magnific/login_backgroundfoto",
    get_string('login_backgroundfoto', 'theme_boost_magnific'),
    get_string('login_backgroundfoto_desc', 'theme_boost_magnific', $link),
    "login_backgroundfoto");
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$setting = new admin_setting_configcolourpicker("theme_boost_magnific/login_backgroundcolor",
    get_string('login_backgroundcolor', 'theme_boost_magnific'),
    get_string('login_backgroundcolor_desc', 'theme_boost_magnific'), "");
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$setting = new admin_setting_confightmleditor('theme_boost_magnific/login_login_description',
    get_string('login_login_description', 'theme_boost_magnific'),
    get_string('login_login_description_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_confightmleditor('theme_boost_magnific/login_forgot_description',
    get_string('login_forgot_description', 'theme_boost_magnific'),
    get_string('login_forgot_description_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_confightmleditor('theme_boost_magnific/login_signup_description',
    get_string('login_signup_description', 'theme_boost_magnific'),
    get_string('login_signup_description_desc', 'theme_boost_magnific'), '');
$page->add($setting);

global $PAGE;
$PAGE->requires->js_call_amd('theme_boost_magnific/settings', 'login');

$settings->add($page);
