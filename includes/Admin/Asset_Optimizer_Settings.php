<?php
/**
 * Asset Optimizer Settings
 *
 * @since 1.0.0
 */

namespace Decent_Elements\Admin;

use Decent_Elements\Admin\Optimizer\Asset_Minifier_Manager;

defined('ABSPATH') || exit;

class Asset_Optimizer_Settings
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('wp_ajax_decent_elements_regenerate_assets', [$this, 'regenerate_assets']);
        add_action('wp_ajax_decent_elements_clear_assets', [$this, 'clear_assets']);
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu()
    {
        add_submenu_page(
            'decent_elements',
            __('Decent Elements Asset Optimizer', 'decent-elements'),
            __('Asset Optimizer', 'decent-elements'),
            'manage_options',
            'decent-elements-optimizer',
            [$this, 'settings_page']
        );
    }

    /**
     * Register settings
     */
    public function register_settings()
    {
        register_setting('decent_elements_optimizer', 'decent_elements_enable_asset_optimization');
    }

    /**
     * Settings page
     */
    public function settings_page()
    {
        $optimizer = Asset_Minifier_Manager::instance();
        $stats = $optimizer->get_optimization_stats();
        ?>
        <div class="wrap">
            <h1><?php _e('Decent Elements Asset Optimizer', 'decent-elements'); ?></h1>

            <div class="notice notice-info">
                <p><?php _e('Asset optimization combines and minifies CSS and JavaScript files from enabled widgets and extensions to improve loading performance.', 'decent-elements'); ?></p>
            </div>

            <form method="post" action="options.php">
                <?php settings_fields('decent_elements_optimizer'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Enable Asset Optimization', 'decent-elements'); ?></th>
                        <td>
                            <label for="decent_elements_enable_asset_optimization">
                                <input type="checkbox"
                                       id="decent_elements_enable_asset_optimization"
                                       name="decent_elements_enable_asset_optimization"
                                       value="1"
                                       <?php checked(1, get_option('decent_elements_enable_asset_optimization', false)); ?> />
                                <?php _e('Combine and minify widget assets', 'decent-elements'); ?>
                            </label>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>

            <h2><?php _e('Optimization Statistics', 'decent-elements'); ?></h2>
            <table class="widefat fixed striped">
                <tbody>
                    <tr>
                        <td><strong><?php _e('Status:', 'decent-elements'); ?></strong></td>
                        <td><?php echo $stats['enabled'] ? __('Enabled', 'decent-elements') : __('Disabled', 'decent-elements'); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Active Widgets:', 'decent-elements'); ?></strong></td>
                        <td><?php echo $stats['total_widgets']; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Active Extensions:', 'decent-elements'); ?></strong></td>
                        <td><?php echo $stats['total_extensions']; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('CSS File:', 'decent-elements'); ?></strong></td>
                        <td>
                            <?php if ($stats['css_file_exists']): ?>
                                <span style="color: green;">✓ <?php _e('Generated', 'decent-elements'); ?></span>
                                (<?php echo size_format($stats['css_file_size']); ?>)
                            <?php else: ?>
                                <span style="color: red;">✗ <?php _e('Not generated', 'decent-elements'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('JS File:', 'decent-elements'); ?></strong></td>
                        <td>
                            <?php if ($stats['js_file_exists']): ?>
                                <span style="color: green;">✓ <?php _e('Generated', 'decent-elements'); ?></span>
                                (<?php echo size_format($stats['js_file_size']); ?>)
                            <?php else: ?>
                                <span style="color: red;">✗ <?php _e('Not generated', 'decent-elements'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php _e('Last Generated:', 'decent-elements'); ?></strong></td>
                        <td>
                            <?php
                            if ($stats['last_generated']) {
                                echo date('Y-m-d H:i:s', $stats['last_generated']);
                            } else {
                                _e('Never', 'decent-elements');
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2><?php _e('Actions', 'decent-elements'); ?></h2>
            <p>
                <button type="button" class="button button-primary" id="regenerate-assets">
                    <?php _e('Regenerate Optimized Assets', 'decent-elements'); ?>
                </button>
                <button type="button" class="button button-secondary" id="clear-assets">
                    <?php _e('Clear Optimized Assets', 'decent-elements'); ?>
                </button>
            </p>

            <script>
            jQuery(document).ready(function($) {
                $('#regenerate-assets').click(function() {
                    var button = $(this);
                    button.prop('disabled', true).text('<?php _e('Regenerating...', 'decent-elements'); ?>');

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'decent_elements_regenerate_assets',
                            nonce: '<?php echo wp_create_nonce('decent_elements_optimizer'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('<?php _e('Assets regenerated successfully!', 'decent-elements'); ?>');
                                location.reload();
                            } else {
                                alert('<?php _e('Error regenerating assets.', 'decent-elements'); ?>');
                            }
                        },
                        complete: function() {
                            button.prop('disabled', false).text('<?php _e('Regenerate Optimized Assets', 'decent-elements'); ?>');
                        }
                    });
                });

                $('#clear-assets').click(function() {
                    if (!confirm('<?php _e('Are you sure you want to clear optimized assets?', 'decent-elements'); ?>')) {
                        return;
                    }

                    var button = $(this);
                    button.prop('disabled', true).text('<?php _e('Clearing...', 'decent-elements'); ?>');

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'decent_elements_clear_assets',
                            nonce: '<?php echo wp_create_nonce('decent_elements_optimizer'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('<?php _e('Assets cleared successfully!', 'decent-elements'); ?>');
                                location.reload();
                            } else {
                                alert('<?php _e('Error clearing assets.', 'decent-elements'); ?>');
                            }
                        },
                        complete: function() {
                            button.prop('disabled', false).text('<?php _e('Clear Optimized Assets', 'decent-elements'); ?>');
                        }
                    });
                });
            });
            </script>
        </div>
        <?php
    }

    /**
     * AJAX handler to regenerate assets
     */
    public function regenerate_assets()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'decent_elements_optimizer') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $optimizer = Asset_Minifier_Manager::instance();
        $result = $optimizer->generate_minified_assets();

        wp_send_json_success($result);
    }

    /**
     * AJAX handler to clear assets
     */
    public function clear_assets()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'decent_elements_optimizer') || !current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $optimizer = Asset_Minifier_Manager::instance();
        $optimizer->clear_optimized_assets();

        wp_send_json_success(true);
    }
}

// Initialize the settings page
new Asset_Optimizer_Settings();
