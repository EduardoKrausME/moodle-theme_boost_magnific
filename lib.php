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

use theme_boost_magnific\admin\setting_scss;
use theme_boost_magnific\autoprefixer;

/**
 * Post process the CSS tree.
 *
 * @param string $tree The CSS tree.
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
 */
function theme_boost_magnific_get_extra_scss($theme) {
    $content = "";

    // Sets the background image, and its settings.
    $imageurl = $theme->setting_file_url("backgroundimage", "backgroundimage");
    if (!empty($imageurl)) {
        $content .= "
            @media (min-width: 768px) {
                body {
                    background-image: url('$imageurl'); background-size: cover;
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
        send_file_not_found();
    } else if ($context->contextlevel == CONTEXT_MODULE) {
        $fullpath = sha1("/{$context->id}/theme_boost_magnific/{$filearea}/{$args[0]}/{$args[1]}");
        $fs = get_file_storage();
        if ($file = $fs->get_file_by_hash($fullpath)) {
            return send_stored_file($file, 0, 0, false, $options);
        }
    } else {
        send_file_not_found();
    }

    return false;
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

    $primarycolorscss = "";
    $brandcolor = get_config("theme_boost", "brandcolor");
    if (isset($brandcolor[3]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $brandcolor)) {
        $primarycolorscss = "\$primary: {$brandcolor};\n";
    }
    $courseid = optional_param("courseid", 0, PARAM_INT);
    if ($courseid) {
        $coursecolor = get_config("theme_boost_magnific", "override_course_color_{$courseid}");
        if (isset($coursecolor[3]) && preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $coursecolor)) {
            $primarycolorscss = "\$primary: {$coursecolor};\n";
        }
    }
    $scss = $primarycolorscss;

    if ($CFG->theme == "degrade") {
        $angle = theme_boost_magnific_default("angle", 30);
        $gradient1 = theme_boost_magnific_default("brandcolor_gradient_1", "#f54266");
        $gradient2 = theme_boost_magnific_default("brandcolor_gradient_2", "#3858f9");
        $scss .= "
            .navbar.fixed-top.brandcolor-background {
                background: linear-gradient({$angle}deg, {$gradient1}, {$gradient2}) !important;
            }
            .navbar.fixed-top.brandcolor-background .navbar-content-background {
                background-color: transparent !important;
            }\n";
    } else {
        if ($topscrollbackgroundcolor = get_config("theme_boost_magnific", "top_scroll_background_color")) {
            $scss .= "\$top_scroll_background_color: {$topscrollbackgroundcolor};\n";
        }
    }

    $callbacks = get_plugins_with_function("theme_boost_magnific_get_pre_scss");
    foreach ($callbacks as $plugins) {
        foreach ($plugins as $callback) {
            if ($newscss = $callback()) {
                $scss = $newscss;
            }
        }
    }

    // Prepend pre-scss.
    if (isset($theme->settings->scsspre[5])) {
        $settingscss = new setting_scss("test", "test", "", "");
        $result = $settingscss->validate($theme->settings->scsspre);
        if ($result === true) {
            $scss .= $theme->settings->scsspre;
        } else {
            $scss .= "
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
                } ";
        }
    }

    return $scss;
}

/**
 * Function theme_boost_magnific_progress_content
 *
 * @return array
 */
function theme_boost_magnific_progress_content() {
    global $USER, $COURSE;

    $completion = new completion_info($COURSE);

    // First, let's make sure completion is enabled.
    if (!$completion->is_enabled()) {
        return ["isprogress" => false];
    }

    if (!$completion->is_tracked_user($USER->id)) {
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
        };
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
    global $CFG;

    $filepath = get_config("theme_boost_magnific", $setting);
    if (!$filepath) {
        return false;
    }
    $syscontext = context_system::instance();

    $url = moodle_url::make_file_url(
        "$CFG->wwwroot/pluginfile.php",
        "/{$syscontext->id}/theme_boost_magnific/{$setting}/0/{$filepath}"
    );

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
    if ($formwrapper->get_current()->modulename == "learningmap") {
        return;
    }

    global $CFG, $PAGE;
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

            $formwrapper->set_data([
                "theme_boost_magnific_customimage" => $draftitemid,
            ]);
        }
        $mform->addElement(
            "filemanager",
            "theme_boost_magnific_customimage",
            get_string("settings_icons_upload_image", "theme_boost_magnific"),
            null,
            $filemanageroptions
        );

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

            $formwrapper->set_data([
                "theme_boost_magnific_customicon" => $draftitemid,
            ]);
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
 * @param moodleform $data Data from the form submission.
 * @param stdClass $course The course.
 * @return moodleform
 * @throws Exception
 */
function theme_boost_magnific_coursemodule_edit_post_actions($data, $course) {
    $context = context_module::instance($data->coursemodule);

    if (isset($data->theme_boost_magnific_customimage)) {
        $options = ["subdirs" => true, "embed" => true];
        $filesave = file_save_draft_area_files(
            $data->theme_boost_magnific_customimage,
            $context->id,
            "theme_boost_magnific",
            "theme_boost_magnific_customimage",
            $data->coursemodule,
            $options
        );

        $name = "theme_boost_magnific_customimage_{$data->coursemodule}";
        set_config($name, $filesave, "theme_boost_magnific");

        cache::make("theme_boost_magnific", "css_cache")->purge();
    }

    if (isset($data->theme_boost_magnific_customicon)) {
        $options = ["subdirs" => true, "embed" => true];
        $filesave = file_save_draft_area_files(
            $data->theme_boost_magnific_customicon,
            $context->id,
            "theme_boost_magnific",
            "theme_boost_magnific_customicon",
            $data->coursemodule,
            $options
        );

        $name = "theme_boost_magnific_customicon_{$data->coursemodule}";
        set_config($name, $filesave, "theme_boost_magnific");

        cache::make("theme_boost_magnific", "css_cache")->purge();
    }

    if (isset($data->theme_boost_magnific_customcolor)) {
        $name = "theme_boost_magnific_customcolor_{$data->coursemodule}";
        set_config($name, $data->theme_boost_magnific_customcolor, "theme_boost_magnific");

        cache::make("theme_boost_magnific", "css_cache")->purge();
    }

    return $data;
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
 * @return string
 * @throws Exception
 */
function theme_boost_magnific_default($configname, $default, $plugin = "theme_boost_magnific") {
    $value = get_config($plugin, $configname);
    if ($value === false) {
        return $default;
    }

    return $value;
}

/**
 * theme_boost_magnific_get_footer_color
 *
 * @param string $bgcolor
 * @param string $darkcolor
 * @param string $lightcolor
 * @return float|null
 */
function theme_boost_magnific_get_footer_color($bgcolor, $darkcolor, $lightcolor) {
    // Remove o # e garante que tenha 6 caracteres.
    $bgcolor = ltrim($bgcolor, '#');
    if (strlen($bgcolor) !== 6) {
        return 1; // Cor inválida.
    }

    // Converte para números (base 16).
    $r = hexdec(substr($bgcolor, 0, 2));
    $g = hexdec(substr($bgcolor, 2, 2));
    $b = hexdec(substr($bgcolor, 4, 2));

    // Calcula a luminância percebida (fórmula de acessibilidade W3C).
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

    return $luminance > 0.6 ? $darkcolor : $lightcolor;
}
