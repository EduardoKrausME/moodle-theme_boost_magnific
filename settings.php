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
 * Theme block settings file
 *
 * @package   theme_boost_magnific
 * @copyright 2017 Eduardo Kraus
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingboost_magnific',
        get_string('configtitle', 'theme_boost_magnific'));
    $page = new admin_settingpage('theme_boost_magnific_general', get_string('generalsettings', 'theme_boost_magnific'));

    // Preset.
    $name = 'theme_boost_magnific/preset';
    $title = get_string('preset', 'theme_boost_magnific');
    $description = get_string('preset_desc', 'theme_boost_magnific');
    $default = 'blue';

    $choices = [];
    $choices['blue'] = 'Blue';
    $choices['green'] = 'Green';
    $choices['black'] = 'Black';
    $choices['red'] = 'Red';
    $choices['yellow'] = 'Light yellow';
    $choices['yellow2'] = 'Dark yellow';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Image Background.
    $name = 'theme_boost_magnific/background';
    $title = get_string('background', 'theme_boost_magnific');
    $description = get_string('background_desc', 'theme_boost_magnific');
    $default = 'math-write';

    $choices = [];
    $choices['math-black'] = 'math-black';
    $choices['math-write'] = 'math-write';
    $choices['users-black'] = 'users-black';
    $choices['users-write'] = 'users-write';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_boost_magnific/favicon';
    $title = get_string('favicon', 'theme_boost_magnific');
    $description = get_string('favicondesc', 'theme_boost_magnific');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0,
        array('maxfiles' => 1, 'accepted_types' => array('png', 'jpg', 'ico')));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Small logo file setting.
    $title = get_string('logocompact', 'admin');
    $description = get_string('logocompact_desc', 'admin');
    $setting = new admin_setting_configstoredfile('core_admin/logocompact', $title, $description, 'logocompact', 0,
        ['maxfiles' => 1, 'accepted_types' => ['.jpg', '.png']]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


    $page->add(new admin_setting_configtextarea('custommenuitems', new lang_string('custommenuitems', 'admin'),
        new lang_string('configcustommenuitems', 'admin'),
        "Home|/\n" . get_string ( 'courses' ) . "|/course/",
        PARAM_RAW,
        '50',
        '10'));
    $page->add(new admin_setting_configtextarea(
        'customusermenuitems',
        new lang_string('customusermenuitems', 'admin'),
        new lang_string('configcustomusermenuitems', 'admin'),
        "grades,grades|/grade/report/mygrades.php|grades\nmessages,message|/message/index.php|message\npreferences,moodle|/user/preferences.php|preferences",
        PARAM_RAW,
        '50',
        '10'
    ));


    // Add tab icons.
    $settings->add($page);

    // Icons.
    $page = new admin_settingpage('theme_boost_magnific_icons', get_string('icons', 'theme_boost_magnific'));

    $icons = [
        'android' => "Google Play Store",
        'apple' => 'Apple App Store',
        'youtube' => 'YouTube',
        'pinterest' => 'Pinterest',
        'linkedin' => 'LinkedIn',
        'instagram' => 'Instagram',
        'flickr' => 'Flickr',
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'website' => 'Website',
    ];

    foreach ($icons as $icon => $iconname) {
        $name = "theme_boost_magnific/icon_{$icon}";
        $title = get_string("icon", 'theme_boost_magnific', $iconname);
        $description = get_string('icondesc', 'theme_boost_magnific', $iconname);
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);
    }

    // Must add the page after definiting all the settings!
    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_boost_magnific_advanced', get_string('advancedsettings', 'theme_boost_magnific'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_boost_magnific/scsspre',
        get_string('rawscsspre', 'theme_boost_magnific'), get_string('rawscsspre_desc', 'theme_boost_magnific'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_boost_magnific/scss', get_string('rawscss', 'theme_boost_magnific'),
        get_string('rawscss_desc', 'theme_boost_magnific'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
