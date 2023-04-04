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
 * User: Eduardo Kraus
 * Date: 02/04/2023
 * Time: 19:18
 */

defined('MOODLE_INTERNAL') || die;

$temp = new admin_settingpage('theme_boost_magnific_about', get_string('settings_about_heading', 'theme_boost_magnific'));

$name = 'theme_boost_magnific/frontpage_about_enable';
$title = get_string('frontpage_about_enable', 'theme_boost_magnific');
$description = get_string('frontpage_about_enable_desc', 'theme_boost_magnific');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$temp->add($setting);

$name = "theme_boost_magnific/frontpage_about_logo";
$title = get_string('frontpage_about_logo', 'theme_boost_magnific');
$description = get_string('frontpage_about_logo_desc', 'theme_boost_magnific');
$setting = new admin_setting_configstoredfile($name, $title, $description, "frontpage_about_logo");
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$name = 'theme_boost_magnific/frontpage_about_title';
$title = get_string('frontpage_about_title', 'theme_boost_magnific');
$description = '';
$default = "";
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$name = 'theme_boost_magnific/frontpage_about_description';
$title = get_string('frontpage_about_description', 'theme_boost_magnific');
$description = get_string('frontpage_about_description_desc', 'theme_boost_magnific');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$temp->add($setting);

for ($i = 1; $i <= 4; $i++) {

    $name = "theme_boost_magnific/frontpage_about_info_{$i}";
    $heading = get_string('frontpage_about_info', 'theme_boost_magnific', $i);
    $setting = new admin_setting_heading($name, $heading, "");
    $temp->add($setting);

    $name = "theme_boost_magnific/frontpage_about_text_{$i}";
    $title = get_string('frontpage_about_text', 'theme_boost_magnific');
    $description = get_string('frontpage_about_text_desc', 'theme_boost_magnific');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT);
    $temp->add($setting);

    $name = "theme_boost_magnific/frontpage_about_number_{$i}";
    $title = get_string('frontpage_about_number', 'theme_boost_magnific');
    $description = get_string('frontpage_about_number_desc', 'theme_boost_magnific');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_INT);
    $temp->add($setting);
}

$settings->add($temp);
