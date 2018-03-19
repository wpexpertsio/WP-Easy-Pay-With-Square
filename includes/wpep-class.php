<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

if (!class_exists('WPEP_Settings')) {

    class WPEP_Settings {

        /**
         * Class Constructor
         */
        public function __construct() {
			
			//add admin_menu
            add_action('admin_menu', array($this, 'wpep_settings'));
            //add admin script
            add_action('admin_enqueue_scripts', array($this, 'wpep_admin_scripts'));
			
        }

        public function wpep_settings() {
            add_menu_page('WPEP Settings', 'WPEP Settings', 'manage_options', 'wpep-settings', array($this, 'wpep_settings_html'));
            add_submenu_page('wpep-settings', 'WPEP Button', 'Button', 'manage_options', 'wpep-button', array($this, 'wpep_button_html'));
			//call register settings function
            add_action('admin_init', array($this, 'wpep_register_settings'));
        }

        public function wpep_register_settings() {
            register_setting('wpep-settings-group', 'wpep_square_mode');
            register_setting('wpep-settings-group', 'wpep_test_appid');
            register_setting('wpep-settings-group', 'wpep_test_token');
            register_setting('wpep-settings-group', 'wpep_test_locationid');
            register_setting('wpep-settings-group', 'wpep_live_appid');
            register_setting('wpep-settings-group', 'wpep_live_token');
            register_setting('wpep-settings-group', 'wpep_live_locationid');

            register_setting('wpep-button-settings-group', 'wpep_button_type');
            register_setting('wpep-button-settings-group', 'wpep_button_text');
            register_setting('wpep-button-settings-group', 'wpep_amount');
            register_setting('wpep-button-settings-group', 'wpep_donation_organization_name');
            register_setting('wpep-button-settings-group', 'wpep_donation_user_amount');
            register_setting('wpep-button-settings-group', 'wpep_notification_email');
        }

        public function wpep_settings_html() {
            ?>            
            <div class="wrap">
                <h1>WPEP Square Settings</h1>
                <p><?php echo sprintf(__('Get Square API keys from <a href="%s" target="_blank">here</a>.', 'wp-easy-pay'), 'https://connect.squareup.com/apps'); ?></p>

                <form method="post" action="options.php">
                    <?php settings_fields('wpep-settings-group'); ?>
                    <?php do_settings_sections('wpep-settings-group'); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th>Mode</th>
                            <td>
                                <input type="radio" <?php if (get_option('wpep_square_mode') == 'live'): ?>checked="checked"<?php endif; ?> value="live" id="wpep_square_mode_live" name="wpep_square_mode">
                                <label for="wpep_square_mode_live" class="inline"><?php _e('Live', 'wp-easy-pay') ?></label>
                                &nbsp;&nbsp;&nbsp; <input type="radio" <?php if (get_option('wpep_square_mode') == 'test' || get_option('wpep_square_mode') == ''): ?>checked="checked"<?php endif; ?> value="test" id="wpep_square_mode_test" name="wpep_square_mode">
                                <label for="wpep_square_mode_test" class="inline"><?php _e('Test', 'wp-easy-pay') ?></label>                                
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2"><?php _e('Test Account', 'wp-easy-pay') ?> <hr></th>
                        </tr>
                        <tr>
                            <th>
                                <?php _e('Test Application ID', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input style="width: 60%;" type="text" value="<?php echo get_option('wpep_test_appid'); ?>" name="wpep_test_appid">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _e('Test Token', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input style="width: 60%;" type="text" value="<?php echo get_option('wpep_test_token'); ?>" name="wpep_test_token">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _e('Test Location ID', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input style="width: 60%;" type="text" value="<?php echo get_option('wpep_test_locationid'); ?>" name="wpep_test_locationid">
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2"><?php _e('Live Account', 'wp-easy-pay') ?> <hr></th>
                        </tr>
                        <tr>
                            <th>
                                <?php _e('Live Application ID', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input style="width: 60%;" type="text" value="<?php echo get_option('wpep_live_appid'); ?>" name="wpep_live_appid">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _e('Live Token', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input style="width: 60%;" type="text" value="<?php echo get_option('wpep_live_token'); ?>" name="wpep_live_token">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <?php _e('Live Location ID', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input style="width: 60%;" type="text" value="<?php echo get_option('wpep_live_locationid'); ?>" name="wpep_live_locationid">
                            </td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
            <?php
        }

        public function wpep_button_html() {
            ?>            
            <div class="wrap">
                <h1>WPEP Button</h1>

                <form method="post" action="options.php">     
                    <?php settings_fields('wpep-button-settings-group'); ?>
                    <?php do_settings_sections('wpep-button--settings-group'); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th>
                                <?php _e('Short Code', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input type="text" value="[wpep_form]" readonly=""/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>
                                <?php _e('Notification Email', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input type="email" value="<?php echo get_option('wpep_notification_email', get_option('admin_email')); ?>" name="wpep_notification_email">
                            </td>
                        </tr>
                        <tr valign="top">
                            <th><?php _e('Type', 'wp-easy-pay') ?></th>
                            <td>
                                <input type="radio" <?php if (get_option('wpep_button_type') == 'simple' || get_option('wpep_button_type') == ''): ?>checked="checked"<?php endif; ?> value="simple" id="wpep_button_type" class="wpep_button_type" name="wpep_button_type">
                                <label for="wpep_button_type" class="inline"><?php _e('Simple Payment', 'wp-easy-pay') ?></label>
                                &nbsp;&nbsp;&nbsp; <input type="radio" <?php if (get_option('wpep_button_type') == 'donation'): ?>checked="checked"<?php endif; ?> value="donation" id="wpep_button_type_donation" class="wpep_button_type" name="wpep_button_type">
                                <label for="wpep_button_type_donation" class="inline"><?php _e('Donation', 'wp-easy-pay') ?></label>                                
                            </td>
                        </tr>
                        <tr valign="top">
                            <th>
                                <?php _e('Button Text', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input type="text" value="<?php echo get_option('wpep_button_text'); ?>" name="wpep_button_text">
                            </td>
                        </tr>
                        <tr valign="top" class="wpep-amount">
                            <th>
                                <?php _e('Amount', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input type="number" value="<?php echo get_option('wpep_amount'); ?>" name="wpep_amount">
                            </td>
                        </tr>
                        <tr valign="top" class="wpep-donation">
                            <th>
                                <?php _e('Organization Name', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input type="text" value="<?php echo get_option('wpep_donation_organization_name'); ?>" name="wpep_donation_organization_name">
                            </td>
                        </tr>
                        <tr valign="top" class="wpep-donation">
                            <th>
                                <?php _e('User set donation amount', 'wp-easy-pay') ?>
                            </th>
                            <td>
                                <input class="donation_user_amount" type="checkbox" value="yes" <?php if (get_option('wpep_donation_user_amount') == 'yes'): ?>checked=""<?php endif; ?> name="wpep_donation_user_amount"/>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button(); ?>
                </form>
            </div>
            <?php
        }

        public function wpep_admin_scripts($hook) {
            if ($hook == 'wpep-settings_page_wpep-button') {
                wp_enqueue_script('wpep-script', WPEP_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), '', true);
            }
        }

    }

}