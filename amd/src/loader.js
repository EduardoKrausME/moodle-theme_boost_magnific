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
 * Template renderer for Moodle. Load and render Moodle templates with Mustache.
 *
 * @module     core/templates
 * @package    core
 * @class      templates
 * @copyright  2015 Damyon Wiese <damyon@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
define(['jquery', './tether', 'core/event'], function (jQuery, Tether, Event) {

    window.jQuery = jQuery;
    window.Tether = Tether;

    require(['theme_boost_magnific/util',
            'theme_boost_magnific/alert',
            'theme_boost_magnific/button',
            'theme_boost_magnific/carousel',
            'theme_boost_magnific/collapse',
            'theme_boost_magnific/dropdown',
            'theme_boost_magnific/modal',
            'theme_boost_magnific/scrollspy',
            'theme_boost_magnific/tab',
            'theme_boost_magnific/tooltip',
            'theme_boost_magnific/popover'],
        function () {

            // We do twice because: https://github.com/twbs/bootstrap/issues/10547.
            jQuery('body').popover({
                trigger  : 'focus',
                selector : "[data-toggle=popover][data-trigger!=hover]"
            });

            jQuery("html").popover({
                container : "body",
                selector  : "[data-toggle=popover][data-trigger=hover]",
                trigger   : "hover",
                delay     : {
                    hide : 500
                }
            });

            // We need to call popover automatically if nodes are added to the page later.
            Event.getLegacyEvents().done(function (events) {
                jQuery(document).on(events.FILTER_CONTENT_UPDATED, function () {
                    jQuery('body').popover({
                        selector : '[data-toggle="popover"]',
                        trigger  : 'focus'
                    });
                });
            });
        });

    return {};
});
