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
 * General file
 *
 * @package   theme_boost_magnific
 * @copyright 2025 Eduardo Kraus {@link https://eduardokraus.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG, $OUTPUT, $PAGE;
require_once("{$CFG->dirroot}/theme/boost_magnific/lib.php");

$page = new admin_settingpage("theme_boost_magnific_general",
    get_string("generalsettings", "theme_boost_magnific"));

$url = "{$CFG->wwwroot}/theme/boost_magnific/quickstart/#brandcolor";
$setting = new admin_setting_heading("theme_boost_magnific_quickstart_brandcolor", "",
    get_string("quickstart_settings_link", "theme_boost_magnific", $url));
$page->add($setting);

if (file_exists(__DIR__ . "/general-colors.php")) {
    require_once(__DIR__ . "/general-colors.php");
} else {
    $htmlselect = "<link rel=\"stylesheet\" href=\"{$CFG->wwwroot}/theme/boost_magnific/scss/colors.css\" />";
    $config = get_config("theme_boost_magnific");
    if (!isset($config->startcolor[2])) {
        $htmlselect .= "\n\n" . $OUTPUT->render_from_template("theme_boost_magnific/settings/colors", [
                "startcolor" => true, "colors" => theme_boost_magnific_colors(),
                "defaultcolor" => theme_boost_magnific_default("startcolor", "#1a2a6c"),
            ]);

        $setting = new admin_setting_configtext(
            "theme_boost_magnific/startcolor", get_string("brandcolor", "theme_boost"),
            get_string("brandcolor_desc", "theme_boost_magnific") . $htmlselect, "#1a2a6c"
        );
        $PAGE->requires->js_call_amd("theme_boost_magnific/settings", "minicolors", [$setting->get_id()]);
        $setting->set_updatedcallback("theme_boost_magnific_change_color");
        $page->add($setting);
    } else {
        $htmlselect .= "\n\n" . $OUTPUT->render_from_template("theme_boost_magnific/settings/colors", [
                "brandcolor" => true, "colors" => theme_boost_magnific_colors(),
                "defaultcolor" => theme_boost_magnific_default("brandcolor", "#1a2a6c", "theme_boost"),
            ]);

        // We use an empty default value because the default colour should come from the preset.
        $setting = new admin_setting_configtext(
            "theme_boost/brandcolor", get_string("brandcolor", "theme_boost_magnific"),
            get_string("brandcolor_desc", "theme_boost_magnific") . $htmlselect, "#1a2a6c"
        );
        $setting->set_updatedcallback("theme_boost_magnific_change_color");
        $page->add($setting);
        $PAGE->requires->js_call_amd("theme_boost_magnific/settings", "minicolors", [$setting->get_id()]);
    }
}

$page->add(new admin_setting_configcheckbox("theme_boost_magnific/brandcolor_background_menu",
    get_string("brandcolor_background_menu", "theme_boost_magnific"),
    get_string("brandcolor_background_menu_desc", "theme_boost_magnific"), 0));

// Cores do topo.
$setting = new admin_setting_heading("theme_boost_magnific/top_color_heading",
    get_string("top_color_heading", "theme_boost_magnific"), "");
$page->add($setting);
$PAGE->requires->js_call_amd("theme_boost_magnific/settings", "form_hide");

$setting = new admin_setting_configcheckbox("theme_boost_magnific/top_scroll_fix",
    get_string("top_scroll_fix", "theme_boost_magnific"),
    get_string("top_scroll_fix_desc", "theme_boost_magnific"),
    0);
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

$setting = new admin_setting_configtext("theme_boost_magnific/top_scroll_background_color",
    get_string("top_scroll_background_color", "theme_boost_magnific"),
    get_string("top_scroll_background_color_desc", "theme_boost_magnific"), "");
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);
$PAGE->requires->js_call_amd("theme_boost_magnific/settings", "minicolors", [$setting->get_id()]);

// Images.
$setting = new admin_setting_heading("theme_boost_magnific/favicon_heading",
    get_string("logocompact", "admin") . " / " . get_string("favicon", "theme_boost_magnific"), "");
$page->add($setting);

// Small logo file setting.
$setting = new admin_setting_configstoredfile("core_admin/logocompact",
    get_string("logocompact", "admin"),
    get_string("logocompact_desc", "admin"),
    "logocompact", 0,
    ["maxfiles" => 1, "accepted_types" => [".jpg", ".jpeg", ".svg", ".png"]]);
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

// Favicon file setting.
$setting = new admin_setting_configstoredfile("core_admin/favicon",
    get_string("favicon", "theme_boost_magnific"),
    get_string("favicon_desc", "theme_boost_magnific"),
    "favicon", 0,
    ["maxfiles" => 1, "accepted_types" => [".jpg", ".jpeg", ".png"]]);
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

// Background image setting.
$setting = new admin_setting_heading("theme_boost_magnific/backgroundimage_heading",
    get_string("backgroundimage", "theme_boost_magnific"), "");
$page->add($setting);

$name = "theme_boost_magnific/backgroundimage";
$setting = new admin_setting_configstoredfile($name,
    get_string("backgroundimage", "theme_boost_magnific"),
    get_string("backgroundimage_desc", "theme_boost_magnific"),
    "backgroundimage", 0,
    ["maxfiles" => 1, "accepted_types" => [".jpg", ".jpeg", ".svg", ".png"]]);
$setting->set_updatedcallback("theme_reset_all_caches");
$page->add($setting);

$settings->add($page);
