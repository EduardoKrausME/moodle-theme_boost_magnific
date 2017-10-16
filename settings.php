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
 * @package   theme_boosta
 * @copyright 2017 Eduardo Kraus
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingboosta', get_string('configtitle', 'theme_boosta'));
    $page = new admin_settingpage('theme_boosta_general', get_string('generalsettings', 'theme_boosta'));

    // Preset.
    $name = 'theme_boosta/preset';
    $title = get_string('preset', 'theme_boosta');
    $description = get_string('preset_desc', 'theme_boosta');
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
    $name = 'theme_boosta/background';
    $title = get_string('background', 'theme_boosta');
    $description = get_string('background_desc', 'theme_boosta');
    $default = 'math-write';

    $choices = [];
    $choices['math-black'] = 'math-black';
    $choices['math-write'] = 'math-write';
    $choices['users-black'] = 'users-black';
    $choices['users-write'] = 'users-write';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_boosta/favicon';
    $title = get_string ( 'favicon', 'theme_boosta' );
    $description = get_string ( 'favicondesc', 'theme_boosta' );
    $setting = new admin_setting_configstoredfile( $name, $title, $description, 'favicon', 0,
        array('maxfiles' => 1, 'accepted_types' => array('png', 'jpg', 'ico')));
    $setting->set_updatedcallback ( 'theme_reset_all_caches' );
    $page->add($setting);


    // Must add the page after definiting all the settings!
    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_boosta_advanced', get_string('advancedsettings', 'theme_boosta'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_boosta/scsspre',
        get_string('rawscsspre', 'theme_boosta'), get_string('rawscsspre_desc', 'theme_boosta'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_boosta/scss', get_string('rawscss', 'theme_boosta'),
        get_string('rawscss_desc', 'theme_boosta'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}
