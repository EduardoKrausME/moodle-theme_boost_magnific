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
 * Theme Settings File
 *
 * @package   theme_boost_magnific
 * @copyright 2024 Eduardo Kraus https://eduardokraus.com/
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
global $PAGE;

$page = new admin_settingpage('theme_boost_magnific_theme',
    get_string('settings_theme_heading', 'theme_boost_magnific'));

if (file_exists(__DIR__ . "/theme-boost_magnific.php")) {
    require_once(__DIR__ . "/theme-boost_magnific.php");
}

$setting = new admin_setting_configstoredfile('theme_boost_magnific/logo_color',
    get_string('logo_color', 'theme_boost_magnific'),
    get_string('logo_color_desc', 'theme_boost_magnific'),
    'logo_color', 0,
    ['maxfiles' => 1, 'accepted_types' => [".jpg", ".jpeg", ".svg", ".png"]]);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Cores do topo.
if ($CFG->theme != "boost_training" && $CFG->theme != "degrade") {

    $setting = new admin_setting_configcheckbox('theme_boost_magnific/top_scroll',
        get_string('top_scroll', 'theme_boost_magnific'),
        get_string('top_scroll_desc', 'theme_boost_magnific'),
        0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    $PAGE->requires->js_call_amd('theme_boost_magnific/settings', 'top_scroll');

    $setting = new admin_setting_heading("theme_boost_magnific/top_color_heading",
        get_string('top_color_heading', 'theme_boost_magnific'), '');
    $page->add($setting);

    $setting = new admin_setting_configtext("theme_boost_magnific/top_scroll_background_color",
        get_string("top_scroll_background_color", 'theme_boost_magnific'),
        get_string("top_scroll_background_color_desc", 'theme_boost_magnific'), '#5C5D5F');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    $PAGE->requires->js_call_amd('theme_boost_magnific/settings', 'minicolors', [$setting->get_id()]);

    $setting = new admin_setting_configtext("theme_boost_magnific/top_scroll_text_color",
        get_string("top_scroll_text_color", 'theme_boost_magnific'),
        get_string("top_scroll_text_color_desc", 'theme_boost_magnific'), '#FFFFFF');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    $PAGE->requires->js_call_amd('theme_boost_magnific/settings', 'minicolors', [$setting->get_id()]);

    $setting = new admin_setting_configstoredfile('theme_boost_magnific/logo_write',
        get_string('logo_write', 'theme_boost_magnific'),
        get_string('logo_write_desc', 'theme_boost_magnific'),
        'logo_write', 0,
        ['maxfiles' => 1, 'accepted_types' => [".jpg", ".jpeg", ".svg", ".png"]]);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
}

// Favicon.
$setting = new admin_setting_heading("theme_boost_magnific/favicon_heading",
    get_string('favicon', 'admin'), '');
$page->add($setting);

$setting = new admin_setting_configstoredfile('core_admin/favicon',
    get_string('favicon', 'theme_boost_magnific'),
    get_string('favicon_desc', 'theme_boost_magnific'),
    'favicon', 0,
    ['maxfiles' => 1, 'accepted_types' => ['.png', '.ico']]);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);
