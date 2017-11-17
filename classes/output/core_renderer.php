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
 * Core renderer.
 *
 * @package    theme_boost_magnific
 * @copyright  2017 Eduardo Kraus
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_boost_magnific\output;
defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_boost_magnific
 * @copyright  2012 Bas Brands, www.basbrands.nl
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {
    /**
     * Renders the custom favicon
     *
     * @return string
     */
    public function favicon() {
        if ($this->page->theme->settings->favicon) {
            return $this->page->theme->setting_file_url('favicon', 'favicon');
        }

        if (method_exists($this->page->theme, "image_url")) {
            return $this->page->theme->image_url('favicon', 'theme');
        } else {
            return $this->page->theme->pix_url('favicon', 'theme');
        }
    }

    /**
     * Renders the icons footer
     *
     * @return string
     */
    public function get_icons_footer() {
        $returnicones = '';

        foreach ($this->page->theme->settings as $iconname => $setting) {
            if (strpos($iconname, 'icon_') === 0) {
                if (!empty($setting)) {

                    $icon = str_replace('icon_', '', $iconname);

                    if ($icon == 'website') {
                        $returnicones .= '<a target="_blank" href="' . $setting . '"><span
                                             class="footer-icon ' . $icon . '"><i class="material-icons">pages</i></span></a>';
                    } else {
                        $returnicones .= '<a target="_blank" href="' . $setting . '"><span
                                             class="footer-icon ' . $icon . '"><i class="fa fa-' . $icon . '"></i></span></a>';
                    }
                }
            }
        }

        return "<div class=\"icones\">$returnicones</div>";
    }
}
