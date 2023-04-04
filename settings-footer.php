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
 * Time: 19:16
 */

defined('MOODLE_INTERNAL') || die;

$temp = new admin_settingpage('theme_boost_magnific_footer', get_string('settings_footer_heading', 'theme_boost_magnific'));

$name = 'theme_boost_magnific_footerblock_description';
$heading = get_string('footerblock_description', 'theme_boost_magnific');
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

$name = 'theme_boost_magnific/footer_description';
$title = get_string('footer_description', 'theme_boost_magnific');
$description = get_string('footer_description_desc', 'theme_boost_magnific');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$temp->add($setting);


$name = 'theme_boost_magnific_footerblock_links';
$heading = get_string('footerblock_links', 'theme_boost_magnific');
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

$name = 'theme_boost_magnific/footer_links_title';
$title = get_string('footer_links_title', 'theme_boost_magnific');
$description = '';
$default = get_string("footer_links_title_default", "theme_boost_magnific");
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$name = 'theme_boost_magnific/footer_links';
$title = get_string('footerblink', 'theme_boost_magnific') . ' 2';
$description = get_string('footerblink_desc', 'theme_boost_magnific');
$default = "";
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$temp->add($setting);


$name = 'theme_boost_magnific_footerblock_social';
$heading = get_string('footerblock_social', 'theme_boost_magnific');
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

$name = 'theme_boost_magnific/footer_social_title';
$title = get_string('footer_social_title', 'theme_boost_magnific');
$description = get_string('footer_social_title_desc', 'theme_boost_magnific');
$default = get_string("footer_social_title_default", "theme_boost_magnific");
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);


$name = 'theme_boost_magnific/social_facebook';
$title = get_string('social_facebook', 'theme_boost_magnific');
$description = get_string('social_facebook_desc', 'theme_boost_magnific');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$name = 'theme_boost_magnific/social_twitter';
$title = get_string('social_twitter', 'theme_boost_magnific');
$description = get_string('social_twitter_desc', 'theme_boost_magnific');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$name = 'theme_boost_magnific/social_instagram';
$title = get_string('social_instagram', 'theme_boost_magnific');
$description = get_string('social_instagram_desc', 'theme_boost_magnific');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);


$name = 'theme_boost_magnific_footerblock_contact';
$heading = get_string('footerblock_contact', 'theme_boost_magnific') . ' 4 ';
$information = '';
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);


$name = 'theme_boost_magnific/contact_footer_title';
$title = get_string('footer_contact_title', 'theme_boost_magnific');
$description = get_string('footer_contact_title_desc', 'theme_boost_magnific');
$default = get_string("footer_contact_title_default", "theme_boost_magnific");
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);


$name = 'theme_boost_magnific/contact_address';
$title = get_string('contact_address', 'theme_boost_magnific');
$description = '';
$default = "";
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$name = 'theme_boost_magnific/contact_phone';
$title = get_string('contact_phone', 'theme_boost_magnific');
$description = '';
$default = "";
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$name = 'theme_boost_magnific/contact_email';
$title = get_string('contact_email', 'theme_boost_magnific');
$description = '';
$default = "";
$setting = new admin_setting_configtext($name, $title, $description, $default);
$temp->add($setting);

$settings->add($temp);
