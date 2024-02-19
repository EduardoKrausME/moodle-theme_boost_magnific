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
 * Time: 20:20
 */

defined('MOODLE_INTERNAL') || die;

$page = new admin_settingpage('theme_boost_magnific_frontpage_home',
    get_string('theme_boost_magnific_frontpage_home', 'theme_boost_magnific'));

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


$settings->add($page);
