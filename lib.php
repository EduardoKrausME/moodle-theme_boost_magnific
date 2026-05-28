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
 * Theme functions.
 *
 * @package   theme_boost_magnific
 * @copyright 2025 Eduardo Kraus {@link https://eduardokraus.com}
 * @copyright based on work by 2016 Frédéric Massart - FMCorz.net
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\output\notification;
use Sabberworm\CSS\CSSList\Document;
use theme_boost_magnific\admin\setting_scss;
use theme_boost_magnific\autoprefixer;
use theme_boost_magnific\icon_extractor;
use theme_boost_magnific\output\footer_renderer;
use theme_boost_magnific\thumb_generator;

/**
 * Post process the CSS tree.
 *
 * @param Document $tree The CSS tree.
 * @param theme_config $theme The theme config object.
 */
function theme_boost_magnific_css_tree_post_processor($tree, $theme) {
    $prefixer = new autoprefixer($tree);
    $prefixer->prefix();
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 * @throws Exception
 */
function theme_boost_magnific_get_extra_scss($theme) {
    $content = "";

    // Sets the background image, and its settings.
    $imageurl = $theme->setting_file_url("backgroundimage", "backgroundimage");
    if (!empty($imageurl)) {
        $content .= "
            @media (min-width: 768px) {
                body {
                    background-image: url('{$imageurl}'); background-size: cover;
                }
            }";
    }

    $scsspos = "";
    if (isset($theme->settings->scsspos[5])) {
        $settingscss = new setting_scss("test", "test", "", "");
        $result = $settingscss->validate($theme->settings->scsspos);
        if ($result === true) {
            $scsspos = $theme->settings->scsspos;
        } else {
            $scsspos = "
                #page::before {
                    content: 'theme_boost_magnific::scsspos Error: {$result}';
                    color: #c00;
                    display: block;
                    padding: 8px 12px;
                    white-space: pre-wrap;
                    background: #FFEB3B;
                    margin: 14px;
                    border-radius: 10px;
                    font-weight: bold;
                } ";
        }
    }

    return "{$content}\n{$scsspos}";
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 * @throws Exception
 */
function theme_boost_magnific_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        if (strpos($filearea, "editor_") === 0) {
            $fullpath = sha1("/{$context->id}/theme_boost_magnific/{$filearea}/{$args[0]}/{$args[1]}");
            $fs = get_file_storage();
            if ($file = $fs->get_file_by_hash($fullpath)) {
                return send_stored_file($file, 0, 0, false, $options);
            }
        } else {
            $theme = theme_config::load("boost_magnific");
            // By default, theme files must be cache-able by both browsers and proxies.
            if (!array_key_exists("cacheability", $options)) {
                $options["cacheability"] = "public";
            }
            return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
        }
    } else if ($context->contextlevel == CONTEXT_MODULE) {
        $fs = get_file_storage();
        $fullpath = sha1("/{$context->id}/theme_boost_magnific/{$filearea}/{$args[0]}/{$args[1]}");
        if (!$file = $fs->get_file_by_hash($fullpath)) {
            return false;
        }
        if ($filearea == "theme_boost_magnific_customimage" || $filearea == "theme_boost_magnific_customicon") {
            $thumb = (new thumb_generator())
                ->set_height(($filearea == 'theme_boost_magnific_customicon') ? 50 : 150)
                ->set_cache_filearea("{$filearea}_thumb")
                ->set_cache_itemid($args[0])
                ->get_or_create($file, $context);
            if ($thumb) {
                return send_stored_file($thumb, 0, 0, false, $options);
            }
        }

        // Fallback: image original.
        return send_stored_file($file, 0, 0, false, $options);
    }

    send_file_not_found();
}

/**
 * Get the current user preferences that are available
 *
 * @return array[]
 */
function theme_boost_magnific_user_preferences(): array {
    return [
        "drawer-open-block" => [
            "type" => PARAM_BOOL,
            "null" => NULL_NOT_ALLOWED,
            "default" => false,
            "permissioncallback" => [core_user::class, "is_current_user"],
        ],
        "drawer-open-index" => [
            "type" => PARAM_BOOL,
            "null" => NULL_NOT_ALLOWED,
            "default" => true,
            "permissioncallback" => [core_user::class, "is_current_user"],
        ],
    ];
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_boost_magnific_get_main_scss_content($theme) {
    global $CFG;
    return file_get_contents("{$CFG->dirroot}/theme/boost_magnific/scss/style.scss");
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 * @throws Exception
 */
function theme_boost_magnific_get_pre_scss($theme) {
    global $CFG;

    $scss = [];

    $primarycolor = "#314755";
    $brandcolor = get_config("theme_boost", "brandcolor");
    if (isset($brandcolor[3]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $brandcolor)) {
        $primarycolor = $brandcolor;
    }
    $scss[] = "\$primary      : {$primarycolor};";

    $secondarycolor = "#ced4da";
    $secondary = get_config("theme_boost", "secondary");
    if (isset($secondary[3]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $secondary)) {
        $secondarycolor = $secondary;
    }
    $scss[] = "\$secondary    : {$secondarycolor};";

    $footerbg = theme_boost_magnific_default("footer_background_color", $brandcolor, '/^#[a-fA-F0-9]{6}([a-fA-F0-9]{2})?$/');
    if ($footerbg) {
        $footercolor = footer_renderer::get_footer_color($footerbg, "#333333", "#ffffff");
        $scss[] = "\$footer-bg    : {$footerbg};";
        $scss[] = "\$footer-color : {$footercolor};\n";
    } else {
        $scss[] = "\$footer-bg    : {$primarycolor};";
        $scss[] = "\$footer-color : {$primarycolor};\n";
    }

    if (get_config("theme_boost_magnific", "navbarlayout") == "institutional") {
        $scss[] = "\$navbar-height : 127px;";
    }

    if ($CFG->theme == "degrade") {
        $angle = theme_boost_magnific_default("angle", 30, '/^-?\d+$/');
        $gradient1 = theme_boost_magnific_default("brandcolor_gradient_1", "#f54266", '/^#[a-fA-F0-9]{6}([a-fA-F0-9]{2})?$/');
        $gradient2 = theme_boost_magnific_default("brandcolor_gradient_2", "#3858f9", '/^#[a-fA-F0-9]{6}([a-fA-F0-9]{2})?$/');
        $scss[] = "
            .navbar.fixed-top.brandcolor-background {
                background: linear-gradient({$angle}deg, {$gradient1}, {$gradient2}) !important;
            }
            .navbar.fixed-top.brandcolor-background .navbar-content-background {
                background-color: transparent !important;
            }";
    } else {
        $topscrollbackgroundcolor = get_config("theme_boost_magnific", "top_scroll_background_color");
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $topscrollbackgroundcolor)) {
            $scss[] = "\$top_scroll_background_color: {$topscrollbackgroundcolor};";
        } else {
            $scss[] = "\$top_scroll_background_color: \$primary;";
        }
    }

    $courseid = optional_param("courseid", false, PARAM_INT);
    $profileid = optional_param("profileid", false, PARAM_TEXT);
    if ($courseid) {
        $primarycolor = get_config("theme_boost_magnific", "override_course_primarycolor_{$courseid}");
        if (isset($primarycolor[3]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $primarycolor)) {
            $scss[] = "\$primary : {$primarycolor};";
        }

        $secondarycolor = get_config("theme_boost_magnific", "override_course_secondarycolor_{$courseid}");
        if (isset($secondarycolor[3]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $secondarycolor)) {
            $scss[] = "\$secondary : {$secondarycolor};";
        }
    } else if ($profileid) {
        $callbacks = get_plugins_with_function("krausthemes__get_pre_scss");
        foreach ($callbacks as $plugins) {
            foreach ($plugins as $callback) {
                if ($newscss = $callback($profileid)) {
                    $scss[] = $newscss;
                }
            }
        }
    }

    // Prepend pre-scss.
    if (isset($theme->settings->scsspre[5])) {
        $settingscss = new setting_scss("test", "test", "", "");
        $result = $settingscss->validate($theme->settings->scsspre);
        if ($result === true) {
            $scss[] = $theme->settings->scsspre;
        } else {
            $scss[] = "
                #page::before {
                    content: 'theme_boost_magnific::scsspre Error: {$result}';
                    color: #c00;
                    display: block;
                    padding: 8px 12px;
                    white-space: pre-wrap;
                    background: #FFEB3B;
                    margin: 14px;
                    border-radius: 10px;
                    font-weight: bold;
                }";
        }
    }

    return implode("\n", $scss);
}

/**
 * Function theme_boost_magnific_progress_content
 *
 * @return array
 * @throws coding_exception
 */
function theme_boost_magnific_progress_content() {
    global $USER, $COURSE, $SESSION;

    $completion = new completion_info($COURSE);

    // First, let's make sure completion is enabled.
    if (!$completion->is_enabled()) {
        return ["isprogress" => false];
    }

    if (!$completion->is_tracked_user($USER->id)) {
        $SESSION->notifications[] = (object) [
            "message" => get_string("notenrolledincourse", "theme_boost_magnific"),
            "type" => notification::NOTIFY_WARNING,
        ];
        return ["isprogress" => false];
    }

    // Before we check how many modules have been completed see if the course has.
    if ($completion->is_course_complete($USER->id)) {
        return [
            "isprogress" => true,
            "progress" => 100,
        ];
    }

    // Get the number of modules that support completion.
    $modules = $completion->get_activities();
    $count = count($modules);
    if (!$count) {
        return ["isprogress" => false];
    }

    // Get the number of modules that have been completed.
    $completed = 0;
    foreach ($modules as $module) {
        $data = $completion->get_data($module, true, $USER->id);
        if (($data->completionstate == COMPLETION_INCOMPLETE) || ($data->completionstate == COMPLETION_COMPLETE_FAIL)) {
            $completed += 0;
        } else {
            $completed += 1;
        }
    }

    return [
        "isprogress" => true,
        "progress" => intval(($completed / $count) * 100),
        "progress_completed" => $completed,
        "progress_count" => $count,
    ];
}

/**
 * Function theme_boost_magnific_setting_file_url
 *
 * @param $setting
 * @return bool|moodle_url
 * @throws dml_exception
 */
function theme_boost_magnific_setting_file_url($setting) {
    $filepath = get_config("theme_boost_magnific", $setting);
    if (!$filepath) {
        return false;
    }
    $syscontext = context_system::instance();

    $url = moodle_url::make_pluginfile_url($syscontext->id, "theme_boost_magnific", $setting, 0, "/", $filepath);

    return $url;
}

/**
 * theme_boost_magnific_coursemodule_standard_elements
 *
 * @param moodleform_mod $formwrapper The moodle quickforms wrapper object.
 * @param MoodleQuickForm $mform The actual form object (required to modify the form).
 * @throws Exception
 */
function theme_boost_magnific_coursemodule_standard_elements(&$formwrapper, $mform) {
    static $executed = false;
    if ($executed) {
        return;
    }
    $executed = true;

    if ($formwrapper->get_current()->modulename == "label") {
        return;
    }

    global $CFG, $PAGE, $COURSE;
    if ($CFG->theme == "boost_magnific" || $CFG->theme == "eadflix") {
        // Icones.
        $mform->addElement(
            "header",
            "theme_boost_magnific_icons",
            get_string("settings_icons_change_icons", "theme_boost_magnific")
        );

        $filemanageroptions = [
            "accepted_types" => [".svg", ".png", ".jpg", ".jpeg"],
            "maxbytes" => -1,
            "maxfiles" => 1,
        ];

        $hasicons = (int) get_config("theme_boost_magnific", "course_sections_icons_{$COURSE->id}");
        if ($hasicons) {
            // Background.
            if (isset($formwrapper->get_current()->coursemodule) && $formwrapper->get_current()->coursemodule) {
                $context = context_module::instance($formwrapper->get_current()->coursemodule);
                $draftitemid = file_get_submitted_draft_itemid("theme_boost_magnific_customimage");
                file_prepare_draft_area(
                    $draftitemid,
                    $context->id,
                    "theme_boost_magnific",
                    "theme_boost_magnific_customimage",
                    $formwrapper->get_current()->coursemodule
                );
                $formwrapper->set_data(["theme_boost_magnific_customimage" => $draftitemid]);
            }
            $mform->addElement(
                "filemanager",
                "theme_boost_magnific_customimage",
                get_string("settings_icons_upload_image", "theme_boost_magnific"),
                null,
                $filemanageroptions
            );
        }

        $mform->addElement(
            "static",
            "theme_boost_magnific_custom",
            "",
            get_string("settings_icons_upload_image_desc", "theme_boost_magnific")
        );

        // Icon.
        if (isset($formwrapper->get_current()->coursemodule) && $formwrapper->get_current()->coursemodule) {
            $context = context_module::instance($formwrapper->get_current()->coursemodule);

            $draftitemid = file_get_submitted_draft_itemid("theme_boost_magnific_customicon");
            file_prepare_draft_area(
                $draftitemid,
                $context->id,
                "theme_boost_magnific",
                "theme_boost_magnific_customicon",
                $formwrapper->get_current()->coursemodule
            );
            $formwrapper->set_data(["theme_boost_magnific_customicon" => $draftitemid]);
        }
        $filemanageroptions["accepted_types"] = [".svg", ".png"];
        $mform->addElement(
            "filemanager",
            "theme_boost_magnific_customicon",
            get_string("settings_icons_upload_icon", "theme_boost_magnific"),
            null,
            $filemanageroptions
        );

        // Color.
        $mform->addElement(
            "text",
            "theme_boost_magnific_customcolor",
            get_string("settings_icons_color_icon", "theme_boost_magnific"),
            []
        );
        $mform->setType("theme_boost_magnific_customcolor", PARAM_TEXT);
        $PAGE->requires->js_call_amd(
            "theme_boost_magnific/settings",
            "minicolors",
            ["id_theme_boost_magnific_customcolor"]
        );

        $mform->addElement(
            "static",
            "theme_boost_magnific_custom",
            "",
            get_string("settings_icons_color_icon_desc", "theme_boost_magnific")
        );
    }
}

/**
 * Hook the add/edit of the course module.
 *
 * @param stdClass $data Data from the form submission.
 * @param stdClass $course The course.
 * @return stdClass
 * @throws Exception
 */
function theme_boost_magnific_coursemodule_edit_post_actions($data, $course) {
    $cmid = (int) $data->coursemodule;
    $context = context_module::instance($cmid);

    $component = "theme_boost_magnific";
    $imagearea = "theme_boost_magnific_customimage";
    $iconarea = "theme_boost_magnific_customicon";

    $purgecache = false;

    $options = [
        "subdirs" => true,
        "embed" => true,
        "maxfiles" => 1,
    ];

    $imagefieldsubmitted = property_exists($data, "theme_boost_magnific_customimage");
    $iconfieldsubmitted = property_exists($data, "theme_boost_magnific_customicon");

    $hadcustomimage = theme_boost_magnific_filearea_has_real_files(
        $context->id,
        $component,
        $imagearea,
        $cmid
    );

    $hadcustomicon = theme_boost_magnific_filearea_has_real_files(
        $context->id,
        $component,
        $iconarea,
        $cmid
    );

    // Save or remove background image.
    if ($imagefieldsubmitted) {
        file_save_draft_area_files(
            (int) $data->theme_boost_magnific_customimage,
            $context->id,
            $component,
            $imagearea,
            $cmid,
            $options
        );

        $hascustomimage = theme_boost_magnific_filearea_has_real_files(
            $context->id,
            $component,
            $imagearea,
            $cmid
        );

        $name = "theme_boost_magnific_customimage_{$cmid}";
        if ($hascustomimage) {
            set_config($name, 1, "theme_boost_magnific");
        } else {
            unset_config($name, "theme_boost_magnific");
        }

        $purgecache = true;
    } else {
        $hascustomimage = $hadcustomimage;
    }

    // Save or remove custom icon.
    if ($iconfieldsubmitted) {
        file_save_draft_area_files(
            (int) $data->theme_boost_magnific_customicon,
            $context->id,
            $component,
            $iconarea,
            $cmid,
            $options
        );

        $hascustomicon = theme_boost_magnific_filearea_has_real_files(
            $context->id,
            $component,
            $iconarea,
            $cmid
        );

        $name = "theme_boost_magnific_customicon_{$cmid}";
        if ($hascustomicon) {
            set_config($name, 1, "theme_boost_magnific");
        } else {
            unset_config($name, "theme_boost_magnific");
        }

        $purgecache = true;
    } else {
        $hascustomicon = $hadcustomicon;
    }

    // Save or remove icon color.
    if (property_exists($data, "theme_boost_magnific_customcolor")) {
        $name = "theme_boost_magnific_customcolor_{$cmid}";
        $color = trim((string) $data->theme_boost_magnific_customcolor);

        if ($color === "") {
            unset_config($name, "theme_boost_magnific");
        } else {
            set_config($name, $color, "theme_boost_magnific");
        }

        $purgecache = true;
    }

    // Do not regenerate the icon when the user intentionally removed it.
    $iconwasremoved = $iconfieldsubmitted && $hadcustomicon && !$hascustomicon;

    // Auto-generate icon when there is a custom image and no custom icon.
    if ($imagefieldsubmitted && $hascustomimage && !$hascustomicon && !$iconwasremoved) {
        $fs = get_file_storage();

        $areafiles = $fs->get_area_files(
            $context->id,
            $component,
            $imagearea,
            $cmid,
            "id DESC",
            false
        );

        if (!empty($areafiles)) {
            /** @var stored_file $sourcefile */
            $sourcefile = reset($areafiles);

            // Only raster images can be processed by GD.
            $mimetype = $sourcefile->get_mimetype();
            $supported = ["image/png", "image/jpeg"];

            if (in_array($mimetype, $supported, true)) {
                try {
                    $extractor = new icon_extractor();

                    $tmpdir = make_temp_directory("theme_boost_magnific_icons");
                    $tmpfile = $tmpdir . DIRECTORY_SEPARATOR . "cm{$cmid}_" . uniqid("", true) . ".png";

                    $extractor->set_source_blob($sourcefile->get_content())
                        ->set_cornertolerance(20)
                        ->set_backgroundtolerance(20)
                        ->set_croppadding(2)
                        ->process()
                        ->get_result_png($tmpfile, 45);

                    if (!file_exists($tmpfile) || filesize($tmpfile) <= 0) {
                        @unlink($tmpfile);
                        throw new Exception("File not generated");
                    }

                    // Make sure there is no stale generated icon.
                    $fs->delete_area_files($context->id, $component, $iconarea, $cmid);

                    global $USER;

                    $filerecord = [
                        "contextid" => $context->id,
                        "component" => $component,
                        "filearea" => $iconarea,
                        "itemid" => $cmid,
                        "filepath" => "/",
                        "filename" => "generated-icon.png",
                        "userid" => $USER->id,
                        "mimetype" => "image/png",
                    ];

                    $fs->create_file_from_pathname($filerecord, $tmpfile);

                    $name = "theme_boost_magnific_customicon_{$cmid}";
                    set_config($name, 1, "theme_boost_magnific");

                    @unlink($tmpfile);
                    $purgecache = true;
                } catch (Throwable $e) {
                    // Fail silently: image was saved, but icon generation failed.
                    debugging("Icon generation failed: {$e->getMessage()}", DEBUG_DEVELOPER);
                }
            }
        }
    }

    if ($purgecache) {
        cache::make("theme_boost_magnific", "css_cache")->purge();
    }

    return $data;
}

/**
 * Checks whether a file area has real files.
 *
 * @param int $contextid Context id.
 * @param string $component Component name.
 * @param string $filearea File area name.
 * @param int $itemid Item id.
 * @return bool
 * @throws \coding_exception
 */
function theme_boost_magnific_filearea_has_real_files(int $contextid, string $component, string $filearea, int $itemid): bool {
    $fs = get_file_storage();

    $files = $fs->get_area_files(
        $contextid,
        $component,
        $filearea,
        $itemid,
        "id ASC",
        false
    );

    return !empty($files);
}

/**
 * Helper: filemanager draft is always set, so we must check if it has files.
 *
 * @param $draftitemid
 * @return bool
 */
function theme_boost_magnific_draft_has_files($draftitemid): bool {
    if (empty($draftitemid)) {
        return false;
    }
    $info = file_get_draft_area_info($draftitemid);
    return !empty($info["filecount"]) && (int) $info["filecount"] > 0;
}

/**
 * List colors.
 *
 * @return array
 */
function theme_boost_magnific_colors() {
    return [
        "#000428", // Azul Escuro.
        "#070000", // Preto.
        "#314755", // Azul Escuro.
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
        "#c99b10", // Amarelo Neon.
        "#997540", // Bege.
    ];
}

/**
 * Change color.
 *
 * @throws dml_exception
 */
function theme_boost_magnific_change_color() {
    $config = get_config("theme_boost_magnific");
    $configboost = get_config("theme_boost");

    if (isset($config->startcolor[5])) {
        $brandcolor = $config->startcolor;
    } else {
        $brandcolor = $configboost->brandcolor;
    }

    set_config("startcolor", "#000", "theme_boost_magnific");
    set_config("footer_background_color", $brandcolor, "theme_boost_magnific");

    theme_reset_all_caches();
}

/**
 * get_config default
 *
 * @param string $configname
 * @param string $default
 * @param string $regexvalidate
 * @param string $plugin
 * @return string
 * @throws dml_exception
 */
function theme_boost_magnific_default($configname, $default, $regexvalidate, $plugin = "theme_boost_magnific") {
    $value = get_config($plugin, $configname);
    if ($value === false) {
        return $default;
    }

    if (!preg_match($regexvalidate, $value)) {
        return $default;
    }

    return $value;
}

/**
 * Function get secondary color
 *
 * @param int $courseid
 * @return string
 * @throws dml_exception
 */
function theme_boost_magnific_secondary_color($courseid = 0) {
    $secondary = get_config("theme_boost", "secondary");
    if ($courseid) {
        $secondaryoverride = get_config("theme_boost_magnific", "override_course_secondarycolor_{$courseid}");
        if ($secondaryoverride) {
            $secondary = $secondaryoverride;
        }
    }

    return $secondary;
}
