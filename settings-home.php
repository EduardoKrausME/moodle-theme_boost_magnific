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

$page = new admin_settingpage('theme_boost_magnific_frontpage_home',
    get_string('theme_boost_magnific_frontpage_home', 'theme_boost_magnific'));

$home = get_string('content_type_home', 'theme_boost_magnific');
if (get_config('theme_boost_magnific', 'home_type') != 0) {
    $description = get_string('content_type_home_desc', 'theme_boost_magnific', $home) . "<br>";

    $emptytext = get_string('content_type_empty', 'theme_boost_magnific');

    $text = get_string('editor_link_home_all', 'theme_boost_magnific');
    $html = "<a class='btn btn-info mt-1 mb-2'
                href='{$CFG->wwwroot}/theme/boost_magnific/_editor/?chave=home&editlang=all'>{$text}</a>";
    if (!isset(get_config("theme_boost_magnific", "home_htmleditor_all")[40])) {
        $html = "{$html} <strong class='alert-warning'>{$emptytext}</strong>";
    }
    $description .= "{$html}<br>";

    if ($CFG->langmenu) {
        $listoftranslations = get_string_manager()->get_list_of_translations();
        $langname = $listoftranslations[$CFG->lang];

        $text = get_string('editor_link_home', 'theme_boost_magnific', $langname);
        $html = "<a class='btn btn-info mt-1 mb-2'
                    href='{$CFG->wwwroot}/theme/boost_magnific/_editor/?chave=home&editlang={$CFG->lang}'>{$text}</a>";
        if (!isset(get_config("theme_boost_magnific", "home_htmleditor_{$CFG->lang}")[40])) {
            $html = "{$html} <strong class='alert-warning'>{$emptytext}</strong>";
        }
        $description .= "{$html}<br>";

        foreach ($listoftranslations as $langkey => $langname) {
            if ($CFG->lang == $langkey) {
                continue;
            }

            $text = get_string('editor_link_home', 'theme_boost_magnific', $langname);
            $html = "<a class='btn btn-info mt-1'
                        href='{$CFG->wwwroot}/theme/boost_magnific/_editor/?chave=home&editlang={$langkey}'>{$text}</a>";
            if (!isset(get_config("theme_boost_magnific", "home_htmleditor_{$langkey}")[40])) {
                $html = "{$html} <strong class='alert-warning'>{$emptytext}</strong>";
            }
            $description .= "{$html}<br>";
        }
    }

} else {
    $description = get_string('content_type_home_desc', 'theme_boost_magnific');
}
$choices = [
    0 => get_string("content_type_default", 'theme_boost_magnific'),
    1 => get_string("content_type_html", 'theme_boost_magnific'),
];
$setting = new admin_setting_configselect('theme_boost_magnific/home_type',
    get_string('content_type_home', 'theme_boost_magnific'),
    $description, 0, $choices);
$page->add($setting);
$PAGE->requires->js_call_amd('theme_boost_magnific/settings', 'autosubmit', [$setting->get_id()]);

if (get_config('theme_boost_magnific', 'home_type') != 0) {
    $icon = $OUTPUT->image_url("google-fonts", "theme_boost_magnific")->out(false);
    $setting = new admin_setting_configtextarea('theme_boost_magnific/pagefonts',
        get_string('content_pagefonts', 'theme_boost_magnific'),
        get_string('content_pagefonts_desc', 'theme_boost_magnific', $icon), "");
    $page->add($setting);
}

if (get_config('theme_boost_magnific', 'home_type') == 0) {
    $setting = new admin_setting_heading("theme_boost_magnific/heart", '',
        get_string('heart', 'theme_boost_magnific', 'https://moodle.org/plugins/theme_boost_magnific'));
    $page->add($setting);

    $setting = new admin_setting_heading("theme_boost_magnific/theme_boost_magnific_frontpage_bloco",
        get_string('theme_boost_magnific_frontpage_bloco', 'theme_boost_magnific', get_string('availablecourses')), '');
    $page->add($setting);

    $setting = new admin_setting_configtextarea('theme_boost_magnific/frontpage_avaliablecourses_text',
        get_string('footer_frontpage_blockcourses_text', 'theme_boost_magnific', get_string('availablecourses')),
        get_string('footer_frontpage_blockcourses_text_desc', 'theme_boost_magnific', get_string('availablecourses')), '');
    $page->add($setting);

    $setting = new admin_setting_configcheckbox('theme_boost_magnific/frontpage_avaliablecourses_instructor',
        get_string('footer_frontpage_blockcourses_instructor', 'theme_boost_magnific'),
        get_string('footer_frontpage_blockcourses_instructor_desc', 'theme_boost_magnific'),
        1);
    $page->add($setting);

    $setting = new admin_setting_heading("theme_boost_magnific/theme_boost_magnific_frontpage_bloco",
        get_string('theme_boost_magnific_frontpage_bloco', 'theme_boost_magnific', get_string('mycourses')), '');
    $page->add($setting);

    $setting = new admin_setting_configtextarea('theme_boost_magnific/frontpage_mycourses_text',
        get_string('footer_frontpage_blockcourses_text', 'theme_boost_magnific', get_string('mycourses')),
        get_string('footer_frontpage_blockcourses_text_desc', 'theme_boost_magnific', get_string('mycourses')), '');
    $page->add($setting);

    $setting = new admin_setting_configcheckbox('theme_boost_magnific/frontpage_mycourses_instructor',
        get_string('footer_frontpage_blockcourses_instructor', 'theme_boost_magnific'),
        get_string('footer_frontpage_blockcourses_instructor_desc', 'theme_boost_magnific'),
        1);
    $page->add($setting);
}

$settings->add($page);
