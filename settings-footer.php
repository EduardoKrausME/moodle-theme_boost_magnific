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

$page = new admin_settingpage('theme_boost_magnific_footer',
    get_string('settings_footer_heading', 'theme_boost_magnific'));

$setting = new admin_setting_heading('theme_boost_magnific_footerblock_description',
    get_string('footerblock_description', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtextarea('theme_boost_magnific/footer_description',
    get_string('footer_description', 'theme_boost_magnific'),
    get_string('footer_description_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_heading('theme_boost_magnific_footerblock_links',
    get_string('footerblock_links', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/footer_links_title',
    get_string('footer_links_title', 'theme_boost_magnific'), '',
    get_string("footer_links_title_default", "theme_boost_magnific"));
$page->add($setting);

$setting = new admin_setting_configtextarea('theme_boost_magnific/footer_links',
    get_string('footerblink', 'theme_boost_magnific') . ' 2',
    get_string('footerblink_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_heading('theme_boost_magnific_footerblock_social',
    get_string('footerblock_social', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/footer_social_title',
    get_string('footer_social_title', 'theme_boost_magnific'),
    get_string('footer_social_title_desc', 'theme_boost_magnific'),
    get_string("footer_social_title_default", "theme_boost_magnific"));
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/social_facebook',
    get_string('social_facebook', 'theme_boost_magnific'),
    get_string('social_facebook_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/social_youtube',
    get_string('social_youtube', 'theme_boost_magnific'),
    get_string('social_youtube_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/social_linkedin',
    get_string('social_linkedin', 'theme_boost_magnific'),
    get_string('social_linkedin_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/social_twitter',
    get_string('social_twitter', 'theme_boost_magnific'),
    get_string('social_twitter_desc', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/social_instagram',
    get_string('social_instagram', 'theme_boost_magnific'),
    get_string('social_instagram_desc', 'theme_boost_magnific'), '');
$page->add($setting);


$setting = new admin_setting_heading('theme_boost_magnific_footerblock_contact',
    get_string('footerblock_contact', 'theme_boost_magnific') . ' 4 ', '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/contact_footer_title',
    get_string('footer_contact_title', 'theme_boost_magnific'),
    get_string('footer_contact_title_desc', 'theme_boost_magnific'),
    get_string("footer_contact_title_default", "theme_boost_magnific"));
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/contact_address',
    get_string('contact_address', 'theme_boost_magnific'), '', '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/contact_phone',
    get_string('contact_phone', 'theme_boost_magnific'), '', '');
$page->add($setting);

$setting = new admin_setting_configtext('theme_boost_magnific/contact_email',
    get_string('contact_email', 'theme_boost_magnific'), '', '');
$page->add($setting);

$setting = new admin_setting_heading('theme_boost_magnific_footerblock_copywriter',
    get_string('footerblock_copywriter', 'theme_boost_magnific'), '');
$page->add($setting);

$setting = new admin_setting_configcheckbox('theme_boost_magnific/footer_show_copywriter',
    get_string('footer_show_copywriter', 'theme_boost_magnific'),
    get_string('footer_show_copywriter_desc', 'theme_boost_magnific'), 1);
$page->add($setting);

$settings->add($page);
