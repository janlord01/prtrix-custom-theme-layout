<?php
/*
Plugin Name: Prtrix Theme Customizer
Description: A plugin to control the layout width and background color of the theme.
Version: 1.0
Author: Janlord Luga, Garry Rodriguez
Author URI: https://janlordluga.com/, https://janlordluga.com/
*/

// Add settings page to admin panel
function prtrix_theme_customizer_settings_page() {
    ?>
<div class="wrap">
    <h2>Prtrix Theme Customizer</h2>
    <form method="post" action="options.php">
        <?php settings_fields('prtrix-theme-customizer-settings'); ?>
        <?php do_settings_sections('prtrix-theme-customizer-settings'); ?>
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
                <th scope="row">Body Background Color</th>
                <td>
                    <label><input type="color" name="background_color"
                            value="<?php echo esc_attr(get_option('background_color', '#fff')) ?>"> </label><br>
                    <!-- Repeat for other colors as needed -->
                </td>
            </tr>
            <tr>
                <th valign="top">Header Background Color</th>
                <td>
                    <input type="color" name="header_background_color"
                        value="<?php echo esc_attr(get_option('header_backgound_color', '#fff')); ?>" />
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
        <?php submit_button(); ?>
    </form>
</div>
<?php
}

// Register and sanitize settings
function prtrix_theme_customizer_settings() {
    register_setting('prtrix-theme-customizer-settings', 'layout_width', array('sanitize_callback' => 'absint'));
    register_setting('prtrix-theme-customizer-settings', 'background_color');
    register_setting('prtrix-theme-customizer-settings', 'header_background_color');
    register_setting('prtrix-theme-customizer-settings', 'header_2_background_color');
    register_setting('prtrix-theme-customizer-settings', 'footer_background_color');
    register_setting('prtrix-theme-customizer-settings', 'force_fullwidth', array('sanitize_callback' => 'absint'));

    // Define a section
    add_settings_section('prtrix-theme-customizer-section', 'Prtrix Theme Customizer Settings', 'prtrix_theme_customizer_section_callback', 'prtrix-theme-customizer-settings');
}
add_action('admin_init', 'prtrix_theme_customizer_settings');

// Callback function for the settings section
function prtrix_theme_customizer_section_callback() {
    echo '<p>Configure the layout and background color of your theme.</p>';
}

// Apply chosen layout width and background color to theme layout
function apply_prtrix_theme_customizer_settings() {
    $layout_width = get_option('layout_width', '1000');
    $background_color = get_option('background_color', '#ffffff');
    $force_fullwidth = get_option('force_fullwidth', 0);
    $header_background_color = get_option('header_background_color', '#fff');
    $header_2_background_color = get_option('header_2_background_color', '#fff');
    $footer_background_color = get_option('footer_background_color', '#fff');

    // Apply layout width and background color
    echo '<style>';
    if ($force_fullwidth) {
    echo '#body-achadata { max-width: 100%; margin: 0 auto; background-color: ' . esc_attr($background_color) . '; }';
        
    }else{
    echo '#body-achadata { max-width: ' . esc_attr($layout_width) . 'px; margin: 0 auto; background-color: ' . esc_attr($background_color) . '; }';

    }
    echo '#header-achadata{ background-color:' . esc_attr($header_background_color) . ';}';
    echo '#header-top-text { background-color:' . esc_attr($header_2_background_color) . ';}';
    echo '#widgets-footer{background-color:' . esc_attr($footer_background_color) . ';}'; 
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

// Enqueue Css for custom Styles
function prtrix_theme_customer_styles(){
    wp_enqueue_style('prtrix-theme-customizer-style', plugins_url('/prtrix-theme-customizer.css', __FILE__));
}

add_action('wp_enqueue_scripts','prtrix_theme_customer_styles');
?>