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
 * The secure layout.
 *
 * @package   theme_boost_magnific
 * @copyright 2024 Eduardo kraus (http://eduardokraus.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// phpcs:ignore
defined('MOODLE_INTERNAL') || die;

// Get the HTML for the settings bits.
$html = theme_boost_magnific_get_html_for_settings($OUTPUT, $PAGE);

echo "{$OUTPUT->doctype()}
<html {$OUTPUT->htmlattributes()}>
<head>
    <title>{$OUTPUT->page_title()}</title>
    <link rel=\"shortcut icon\" href=\"{$OUTPUT->favicon()}\"/>
    {$OUTPUT->standard_head_html()}
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
</head>

<body data-layout=\"secure\" {$OUTPUT->body_attributes([theme_boost_magnific_get_body_class()])}>

{$OUTPUT->standard_top_of_body_html()}";

require_once($CFG->libdir . '/behat/lib.php');
$extraclasses = [theme_boost_magnific_get_body_class()];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();
$logo = theme_boost_magnific_get_logo("header");

$custom = $OUTPUT->custom_menu();

if ($custom == '') {
    $class = "navbar-toggler navbar-toggler-right d-lg-none nocontent-navbar";
} else {
    $class = "navbar-toggler navbar-toggler-right d-lg-none";
}

$templatedata = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
    'logo' => $logo,
    "customclass" => $class,
];

echo $OUTPUT->render_from_template('theme_boost_magnific/includes/header', $templatedata);

echo "
<div id=\"page\">
    <header id=\"page-header\" class=\"clearfix\">
        {$html->heading}
    </header>

    <div id=\"page\" class=\"container\">
        <div id=\"page-content\" class=\"row\">
            <div id=\"region-bs-main-and-pre\" class=\"col-md-9\">
                <div class=\"row\">
                    <section id=\"region-main\" class=\"col-md-8 pull-right\">
                        {$OUTPUT->main_content()}
                    </section>
                    {$OUTPUT->blocks('side-pre', 'col-md-4 desktop-first-column')}
                </div>
            </div>
            {$OUTPUT->blocks('side-post', 'col-md-3')}
        </div>
    </div>
</div>";

$USER->ajax_updatable_user_prefs['drawer-open-nav'] = PARAM_ALPHA;
$extraclasses = [theme_boost_magnific_get_body_class()];
$bodyattributes = $OUTPUT->body_attributes($extraclasses);
$blockshtml = $OUTPUT->blocks('side-pre');
$hasblocks = strpos($blockshtml, 'data-block=') !== false;
$regionmainsettingsmenu = $OUTPUT->region_main_settings_menu();

$templatedata = [
    'sitename' => format_string($SITE->shortname, true, ['context' => context_course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'sidepreblocks' => $blockshtml,
    'hasblocks' => $hasblocks,
    'bodyattributes' => $bodyattributes,
    'regionmainsettingsmenu' => $regionmainsettingsmenu,
    'hasregionmainsettingsmenu' => !empty($regionmainsettingsmenu),
];

$templatedata = array_merge($templatedata, \theme_boost_magnific\template\footer_data::get_data());
$footerlayout = $OUTPUT->render_from_template('theme_boost_magnific/includes/footer', $templatedata);

echo $OUTPUT->standard_end_of_body_html();

echo "</body>
</html>";
