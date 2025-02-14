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

$colors = [
    "#000428", // Azul Escuro.
    "#070000", // Preto.
    "#1a2a6c", // Azul Escuro.
    "#314755", // Cinza Escuro.
    "#007bc3", // Azul.
    "#007fff", // Azul Neon.
    "#00bf8f", // Verde Azulado.
    "#00c3b0", // Turquesa.
    "#30e8bf", // Verde Claro.
    "#83a4d4", // Azul Claro.
    "#7303c0", // Roxo.
    "#8000ff", // Roxo Neon.
    "#86377b", // Roxo Escuro.
    "#b21f1f", // Vermelho Escuro.
    "#c10f41", // Vermelho.
    "#d12924", // Vermelho Claro.
    "#fc354c", // Vermelho Claro.
    "#ff0000", // Vermelho Brilhante.
    "#ff007f", // Rosa Neon.
    "#ff00ff", // Magenta Brilhante.
    "#f55ff2", // Rosa.
    "#fd81b5", // Rosa Claro.
    "#ff512f", // Laranja Claro.
    "#e65c00", // Laranja.
    "#ff8000", // Laranja Neon.
    "#ffbf00", // Amarelo Neon.
    "#ceac7a", // Bege.
];

if (isset($_SERVER["REQUEST_URI"]) && strpos($_SERVER["REQUEST_URI"], "admin/upgradesettings.php") > 0) {
    $htmlselect = "<link rel=\"stylesheet\" href=\"{$CFG->wwwroot}/theme/boost_magnific/style/initial.css\" />";
    $htmlselect .= "<link rel=\"stylesheet\" href=\"{$CFG->wwwroot}/theme/boost_magnific/style/style.css\" />";
} else {
    $htmlselect = "";
}
foreach ($colors as $color) {
    $htmlselect .= $OUTPUT->render_from_template("theme_boost_magnific/settings/theme-boost_magnific", [
        "background" => $color,
    ]);
}
$setting = new admin_setting_configtext("theme_boost_magnific/background_color",
    get_string("background_color", "theme_boost_magnific"),
    get_string("background_color_desc", "theme_boost_magnific") . $htmlselect,
    "#007bc3");
$setting->set_updatedcallback("theme_reset_all_caches");
$PAGE->requires->js_call_amd("theme_boost_magnific/settings", "minicolors", [$setting->get_id()]);
$page->add($setting);

// Cores dos botões.
$colors = ["color_primary", "color_secondary", "color_buttons"];
foreach ($colors as $color) {

    $setting = new admin_setting_configtext("theme_boost_magnific/theme_color__{$color}",
        get_string("theme_color-{$color}", "theme_boost_magnific"),
        get_string("theme_color-{$color}_desc", "theme_boost_magnific"), "");
    $setting->set_updatedcallback("theme_reset_all_caches");
    $page->add($setting);
    $PAGE->requires->js_call_amd("theme_boost_magnific/settings", "minicolors", [$setting->get_id()]);
}

// Top text color.
$setting = new admin_setting_configtext("theme_boost_magnific/background_text_color",
    get_string("background_text_color", "theme_boost_magnific"),
    get_string("background_text_color_desc", "theme_boost_magnific"),
    "#FFFFFF");
$setting->set_updatedcallback("theme_reset_all_caches");
$PAGE->requires->js_call_amd("theme_boost_magnific/settings", "minicolors", [$setting->get_id()]);
$page->add($setting);
