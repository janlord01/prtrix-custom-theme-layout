<?php
/*
Plugin Name: Prtrix Theme Customizer
Description: A plugin to control the layout width, background color, and dynamic icons and text of the theme.
Version: 1.0
Author: Janlord Luga, Garry Rodriguez
Author URI: https://janlordluga.com/, https://janlordluga.com/
*/

// Enqueue necessary scripts and styles
function prtrix_theme_customizer_scripts($hook_suffix) {
    if ($hook_suffix !== 'settings_page_prtrix-theme-customizer') {
        return;
    }
    // Enqueue WordPress media scripts
    wp_enqueue_media();
    // Enqueue custom script
    wp_enqueue_script('prtrix-theme-customizer-script', plugins_url('/prtrix-theme-customizer.js', __FILE__), array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'prtrix_theme_customizer_scripts');

// Add settings page to admin panel
function prtrix_theme_customizer_settings_page() {
    ?>
    <div class="wrap">
        <h2>Prtrix Theme Customizer</h2>
        <h2 class="nav-tab-wrapper">
            <a href="#layout-tab" class="nav-tab nav-tab-active">Layout</a>
            <a href="#icons-tab" class="nav-tab">Icons</a>
            <a href="#buttons-tab" class="nav-tab">Buttons</a>
        </h2>
        <form method="post" action="options.php">
            <?php settings_fields('prtrix-theme-customizer-settings'); ?>
            <?php do_settings_sections('prtrix-theme-customizer-settings'); ?>
            <div id="layout-tab" class="tab-content active">
                <?php prtrix_theme_customizer_layout_settings(); ?>
            </div>
            <div id="icons-tab" class="tab-content">
                <?php prtrix_theme_customizer_icons_settings(); ?>
            </div>
            <div id="buttons-tab" class="tab-content">
                <?php prtrix_theme_customizer_buttons_settings(); ?>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.nav-tab').on('click', function(e) {
                e.preventDefault();
                $('.nav-tab').removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');

                $('.tab-content').removeClass('active');
                $($(this).attr('href')).addClass('active');
            });
        });
    </script>
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
    </style>
    <?php
}

// Register and sanitize settings
function prtrix_theme_customizer_settings() {
    register_setting('prtrix-theme-customizer-settings', 'layout_width', array('sanitize_callback' => 'absint'));
    register_setting('prtrix-theme-customizer-settings', 'background_color');
    register_setting('prtrix-theme-customizer-settings', 'header_background_color');
    register_setting('prtrix-theme-customizer-settings', 'header_2_background_color');
    register_setting('prtrix-theme-customizer-settings', 'footer_background_color');
    register_setting('prtrix-theme-customizer-settings', 'top_footer_background_color');
    register_setting('prtrix-theme-customizer-settings', 'force_fullwidth', array('sanitize_callback' => 'absint'));
    register_setting('prtrix-theme-customizer-settings', 'show_top_header_box', array('sanitize_callback' => 'absint'));

    // buttons
    register_setting('prtrix-theme-customizer-settings','primary_button_color');
    register_setting('prtrix-theme-customizer-settings','secondary_button_color');
    register_setting('prtrix-theme-customizer-settings','accent_button_color');
    register_setting('prtrix-theme-customizer-settings','dark_button_color');
    register_setting('prtrix-theme-customizer-settings', 'dark_page_button_color');
    register_setting('prtrix-theme-customizer-settings','positive_button_color');
    register_setting('prtrix-theme-customizer-settings','negative_button_color');
    register_setting('prtrix-theme-customizer-settings','info_button_color');
    register_setting('prtrix-theme-customizer-settings', 'warning_button_color');

    for ($i = 1; $i <= 4; $i++) {
        register_setting('prtrix-theme-customizer-settings', "icon_{$i}_image");
        register_setting('prtrix-theme-customizer-settings', "icon_{$i}_text");
    }
}
add_action('admin_init', 'prtrix_theme_customizer_settings');

// Button Tab section
function prtrix_theme_customizer_buttons_settings(){
    ?>
    <table class="form-table">
        <tr valign="top"> 
            <th scope="row">Primary Button </th>
            <td>
                
                <input type="color"  name="primary_button_color" value="<?php echo esc_attr(get_option('primary_button_color', '#1976d2')); ?>" /><br />
                <label>.btn-primary</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Secondary Button Color</th>
            <td>
                <input type="color" name="secondary_button_color" value="<?php echo esc_attr(get_option('secondary_button_color', '#26a69a'))?>" /><br />
                <label>.btn-secondary</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Accent Button Color</th>
            <td>
                <input type="color" name="accent_button_color" value="<?php echo esc_attr(get_option('accent_button_color', '#9c27b0')) ?>" /><br />
                <label>.btn-accent</label>
            </td>
        </tr>
        <tr valigh="top">
            <th scope="row">Dark Button Color</th>
            <td>
                <input type="color" name="dark_button_color" value="<?php echo esc_attr(get_option('dark_button_color', '#1d1d1d')) ?>" /><br />
                <label>.btn-dark</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Dark Page Button Color</th>
            <td>
                <input type="color" name="dark_page_button_color" value="<?php echo esc_attr(get_option('dark_page_button_color', '#121212')) ?>" /><br />
                <label>.btn-dark-page</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Positive Button Color</th>
            <td>
                <input type="color" name="positive_button_color" value="<?php echo esc_attr(get_option('positive_button_color', '#21ba45')) ?>" /><br />
                <label>.btn-positive</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Negative Button Color</th>
            <td>
                <input type="color" name="negative_button_color" value="<?php echo esc_attr(get_option('negative_button_color', '#c10015')) ?>" /><br />
                <label>.btn-negative</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Info Button Color</th>
            <td>
               <input type="color" name="info_button_color" value="<?php echo esc_attr(get_option('info_button_color', '#31ccec')) ?>" /><br />
               <label>.btn-info</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Warning Button Color</th>
            <td>
                <input type="color" name="warning_button_color" value="<?php echo esc_attr(get_option('warning_button_color', '#f2c037')) ?>" /><br />
                <label>.btn-warning</label>
            </td>
        </tr>
        
    </table>
    <?php
}
 
// Layout settings section
function prtrix_theme_customizer_layout_settings() {
    ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Layout Width</th>
            <td>
                <input type="range" min="500" max="1600"
                    value="<?php echo esc_attr(get_option('layout_width', '1000')); ?>" name="layout_width"
                    id="layout-width">
                <label for="layout-width">500</label>
                <label for="layout-width">1600</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Force Fullwidth</th>
            <td>
                <label><input type="checkbox" name="force_fullwidth" value="1"
                        <?php checked(get_option('force_fullwidth'), 1); ?> /> Enable Fullwidth</label>
            </td>
        </tr>
        <tr valign="top">
            <th>Change Layout</th>
            <td>
                <input type="checkbox" name="show_top_header_box" value="1" <?php checked(get_option('show_top_header_box', 1)) ?> />
                <label for="show_top_header_box">Enable</label>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Body Background Color</th>
            <td>
                <label><input type="color" name="background_color"
                        value="<?php echo esc_attr(get_option('background_color', '#fff')) ?>"> </label><br>
            </td>
        </tr>
        <tr>
            <th valign="top">Header Background Color</th>
            <td>
                <input type="color" name="header_background_color"
                    value="<?php echo esc_attr(get_option('header_background_color', '#fff')); ?>" />
            </td>
        </tr>
        <tr>
            <th valign="top">Bottom header Background Color</th>
            <td>
                <input type="color" name="header_2_background_color"
                    value="<?php echo esc_attr(get_option('header_2_background_color', '#fff')); ?>" />
            </td>
        </tr>
        <tr>
            <th valign="top">Top Footer Background Color</th>
            <td>
                <input type="color" name="top_footer_background_color"
                    value="<?php echo esc_attr(get_option('top_footer_background_color','#fff')); ?>" />
            </td>
        </tr>
        <tr>
            <th valign="top">Main Footer Background Color</th>
            <td>
                <input type="color" name="footer_background_color"
                    value="<?php echo esc_attr(get_option('footer_background_color','#fff')) ?>" />
            </td>
        </tr>
    </table>
    <?php
}

// Icons settings section
function prtrix_theme_customizer_icons_settings() {
    ?>
    <table class="form-table">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <tr valign="top">
                <th scope="row">Icon <?php echo $i; ?> Image</th>
                <td>
                    <input type="text" name="icon_<?php echo $i; ?>_image" value="<?php echo esc_attr(get_option("icon_{$i}_image")); ?>" />
                    <button class="upload_image_button button">Upload Image</button>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Icon <?php echo $i; ?> Text</th>
                <td>
                    <input type="text" name="icon_<?php echo $i; ?>_text" value="<?php echo esc_attr(get_option("icon_{$i}_text")); ?>" />
                </td>
            </tr>
        <?php endfor; ?>
    </table>
    <script>
        jQuery(document).ready(function($){
            $('.upload_image_button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var custom_uploader = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                }).on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.prev('input').val(attachment.url);
                }).open();
            });
        });
    </script>
    <?php
}


// Callback function for the settings section
function prtrix_theme_customizer_section_callback() {
    echo '<p>Configure the layout, background color, and icons of your theme.</p>';
}

// Apply chosen layout width and background color to theme layout
function apply_prtrix_theme_customizer_settings() {
    $layout_width = get_option('layout_width', '1600');
    $background_color = get_option('background_color', '#f5f5f5');
    $force_fullwidth = get_option('force_fullwidth', 0);
    $header_background_color = get_option('header_background_color', '#000');
    $header_2_background_color = get_option('header_2_background_color', '#6da7cc');
    $top_footer_background_color = get_option('top_footer_background_color', '#f5f5f5');
    $footer_background_color = get_option('footer_background_color', '#cdac7a'); 
    $show_top_header_box = get_option('show_top_header_box', 0);

    $primary_button_color = get_option('primary_button_color');
    $secondary_button_color = get_option('secondary_button_color');
    $accent_button_color = get_option('accent_button_color');
    $dark_button_color = get_option('dark_button_color');
    $dark_page_button_color = get_option('dark_page_button_color');
    $positive_button_color = get_option('positive_button_color');
    $negative_button_color = get_option('negative_button_color');
    $info_button_color = get_option('info_button_color');
    $warning_button_color = get_option('warning_button_color');

    echo '<style>';
    if ($force_fullwidth) {
        echo '#body-achadata { max-width: 100%; margin: 0 auto; background-color: ' . esc_attr($background_color) . '; }';
    } else {
        echo '#body-achadata { max-width: ' . esc_attr($layout_width) . 'px; margin: 0 auto; background-color: ' . esc_attr($background_color) . '; }';
    }
    echo '#header-achadata { background-color:' . esc_attr($header_background_color) . '; }';
    echo '#header-top-text { background-color:' . esc_attr($header_2_background_color) .';}';
    echo '#header-top-text { background-color:' . esc_attr($header_2_background_color) . '; }';
    echo '#widgets-footer { background-color:' . esc_attr($footer_background_color) . '; }'; 
    echo '#top-footer { background-color:' . esc_attr($top_footer_background_color) . '; }';
    if ($show_top_header_box) {
        echo '#header-achadata a { display: block; margin-top: 10px; }';
        echo '.custom-logo{-webkit-filter: brightness(1) !important; filter: brightness(1) !important;}';
        echo '#top-footer div img{filter: brightness(100)}';
        echo '#top-footer div p{color:#fff}';
    }
    echo '.btn-primary{background-color: '. esc_attr($primary_button_color) .';}';
    echo '.btn-secondary{background-color: '. esc_attr($secondary_button_color) .';}';
    echo '.btn-accent{background-color: '. esc_attr($accent_button_color) .';}';
    echo '.btn-dark{background-color: '. esc_attr($dark_button_color) .';}';
    echo '.btn-dark-page{background-color: '. esc_attr($dark_page_button_color) .';}';
    echo '.btn-negative{background-color: '. esc_attr($negative_button_color) .';}';
    echo '.btn-info{background-color: '. esc_attr($info_button_color) .';}';
    echo '.btn-warning{background-color: '. esc_attr($warning_button_color) .';}';
    echo '</style>';
}
add_action('wp_head', 'apply_prtrix_theme_customizer_settings');

// Enqueue JavaScript for collapsible functionality
function prtrix_theme_customizer_collapsible_script() {
    wp_enqueue_script('prtrix-theme-customizer-script', plugins_url('/prtrix-theme-customizer.js', __FILE__), array('jquery'), '', true);
}
add_action('admin_enqueue_scripts', 'prtrix_theme_customizer_collapsible_script');

// Add settings page to admin menu
function prtrix_theme_customizer_menu() {
    add_options_page('Prtrix Theme Customizer', 'Prtrix Theme Customizer', 'manage_options', 'prtrix-theme-customizer', 'prtrix_theme_customizer_settings_page');
}
add_action('admin_menu', 'prtrix_theme_customizer_menu');

// Enqueue CSS for custom styles
function prtrix_theme_customer_styles(){
    wp_enqueue_style('prtrix-theme-customizer-style', plugins_url('/prtrix-theme-customizer.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'prtrix_theme_customer_styles');

// Function to get icon data
function get_prtrix_icon_data($index) {
    return array(
        'image' => get_option("icon_{$index}_image"),
        'text'  => get_option("icon_{$index}_text")
    );
}

// Render header icons
function render_prtrix_header_icons() {
    for ($i = 1; $i <= 4; $i++) {
        $icon = get_prtrix_icon_data($i);
        if ($icon['image'] && $icon['text']) {
            echo '<div>';
            echo '<img loading="lazy" width="60" height="60" src="' . esc_url($icon['image']) . '" alt="Icon ' . $i . '">';
            echo '<p>' . wp_kses_post($icon['text']) . '</p>';
            echo '</div>';
        }
    }
}

// Render footer icons
function render_prtrix_footer_icons() {
    for ($i = 1; $i <= 4; $i++) {
        $icon = get_prtrix_icon_data($i);
        if ($icon['image'] && $icon['text']) {
            echo '<div>';
            echo '<img loading="lazy" width="60" height="60" src="' . esc_url($icon['image']) . '" alt="Icon ' . $i . '">';
            echo '<p>' . wp_kses_post($icon['text']) . '</p>';
            echo '</div>';
        }
    }
}


