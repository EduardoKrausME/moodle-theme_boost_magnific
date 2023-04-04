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
 * Time: 19:54
 */

defined('MOODLE_INTERNAL') || die;
global $PAGE;

$temp = new admin_settingpage('theme_boost_magnific_css', get_string('settings_theme_heading', 'theme_boost_magnific'));


// Theme Color scheme chooser.
$name = 'theme_boost_magnific/theme';
$title = get_string('theme', 'theme_boost_magnific');
$description = get_string('theme_desc', 'theme_boost_magnific');
$choices = [
    'theme_blue' => get_string('theme_blue', 'theme_boost_magnific'),
    'theme_violet' => get_string('theme_violet', 'theme_boost_magnific'),
    'theme_red_d' => get_string('theme_red_d', 'theme_boost_magnific'),
    'theme_green' => get_string('theme_green', 'theme_boost_magnific'),
    'theme_green_d' => get_string('theme_green_d', 'theme_boost_magnific')
];
$colorss = [
    'theme_blue' => [
        'background_color' => '#2b4e84',
        'color_primary' => '#2b4e84',
        'color_secondary' => '#3e65a0',
        'color_buttons' => '#183054',
        'color_names' => '#c0ccdc',
        'color_titles' => '#e8f0fb'
    ],
    'theme_violet' => [
        'background_color' => '#8e558e',
        'color_primary' => '#8e558e',
        'color_secondary' => '#a55ba5',
        'color_buttons' => '#382738',
        'color_names' => '#edd3ed',
        'color_titles' => '#feffef'
    ],
    'theme_red_d' => [
        'background_color' => '#561209',
        'color_primary' => '#561209',
        'color_secondary' => '#a64437',
        'color_buttons' => '#5e1e15',
        'color_names' => '#f7e3e1',
        'color_titles' => '#fff1ef'
    ],
    'theme_green' => [
        'background_color' => '#426e17',
        'color_primary' => '#426e17',
        'color_secondary' => '#7abb3b',
        'color_buttons' => '#2f510f',
        'color_names' => '#bad3a3',
        'color_titles' => '#f2fde8'
    ],
    'theme_green_d' => [
        'background_color' => '#20897b',
        'color_primary' => '#20897b',
        'color_secondary' => '#4ba89c',
        'color_buttons' => '#103430',
        'color_names' => '#c0dcdb',
        'color_titles' => '#e4f7f6'
    ]
];
foreach ($colorss as $colorname => $colors) {

    $html = "";
    foreach ($colors as $key => $cor) {
        if (strpos($key, "color_") === false) {
            continue;
        }
        $cor = strtoupper($cor);

        $styles = "display: inline-block;padding: 2px;margin: 3px;border-radius: 4px;";
        if (preg_match('/#[B-F]/', $cor)) {
            $html .= "<span style='background:{$cor};color:#515151;' style='{$styles}'
                            data-name='{$key}' data-color='{$cor}'>{$cor}</span>";
        } else {
            $html .= "<span style='background:{$cor};color:#ffffff;' style='{$styles}'
                            data-name='{$key}' data-color='{$cor}'>{$cor}</span>";
        }
    }
    $themename = get_string($colorname, 'theme_boost_magnific');
    $styles = "display: flex;align-items: center;background: #e6e6e6;width: fit-content;border-radius: 4px;margin-bottom: 5px;";
    $description .= "<div class='seletor-de-theme' id='theme-{$colorname}' style='{$styles}'
                          data-name='{$colorname}'>{$themename}: {$html}</div>";
}

$setting = new admin_setting_configselect($name, $title, $description, "theme_blue", $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


// Image Background.
$name = 'theme_boost_magnific/background_image';
$title = get_string('background_image', 'theme_boost_magnific');
$description = get_string('background_image_desc', 'theme_boost_magnific');
$default = 'math-write';
$choices = [
    'math-black' => 'math-black',
    'math-write' => 'math-write',
    'users-black' => 'users-black',
    'users-write' => 'users-write',
];
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$name = 'theme_boost_magnific/background_color';
$title = get_string('background_color', 'theme_boost_magnific');
$description = get_string('background_color_desc', 'theme_boost_magnific');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#2B4E84');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$name = 'theme_boost_magnific/color_primary';
$title = get_string('color_primary', 'theme_boost_magnific');
$description = get_string('color_primary_desc', 'theme_boost_magnific');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#2B4E84');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$name = 'theme_boost_magnific/color_secondary';
$title = get_string('color_secondary', 'theme_boost_magnific');
$description = get_string('color_secondary', 'theme_boost_magnific');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#3E65A0');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$name = 'theme_boost_magnific/color_buttons';
$title = get_string('color_buttons', 'theme_boost_magnific');
$description = get_string('color_buttons', 'theme_boost_magnific');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#183054');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$name = 'theme_boost_magnific/color_names';
$title = get_string('color_names', 'theme_boost_magnific');
$description = get_string('color_names', 'theme_boost_magnific');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#C0CCDC');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$name = 'theme_boost_magnific/color_titles';
$title = get_string('color_titles', 'theme_boost_magnific');
$description = get_string('color_titles', 'theme_boost_magnific');
$setting = new admin_setting_configcolourpicker($name, $title, $description, '#E8F0FB');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$PAGE->requires->js_call_amd('theme_boost_magnific/settings', 'theme');


// Custom CSS file.
$name = 'theme_boost_magnific/customcss';
$title = get_string('customcss', 'theme_boost_magnific');
$description = get_string('customcss_desc', 'theme_boost_magnific');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


$fontsarr = [
    'Roboto' => 'Roboto',
    'Open Sans' => 'Open Sans',
    'Lato' => 'Lato',
    'Montserrat' => 'Montserrat',
    'Poppins' => 'Poppins',
    'Nunito' => 'Nunito',
    'Inter' => 'Inter',
    'Raleway' => 'Raleway',
    'Sora' => 'Sora',
    'Epilogue' => 'Epilogue',
    'Manrope' => 'Manrope',
    'Oxygen' => 'Oxygen',
];

$name = 'theme_boost_magnific/fontfamily';
$title = get_string('fontfamily', 'theme_boost_magnific');
$description = get_string('fontfamily_desc', 'theme_boost_magnific');
$setting = new admin_setting_configselect($name, $title, $description, 'Roboto', $fontsarr);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$settings->add($temp);
