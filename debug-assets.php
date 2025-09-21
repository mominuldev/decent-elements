<?php
/**
 * Debug script for Decent Elements Asset Optimization
 * Run this file to debug why assets aren't being generated
 */

// WordPress environment
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Make sure we can access the asset manager
use Decent_Elements\Admin\Optimizer\Asset_Minifier_Manager;

echo "<h1>Decent Elements Asset Optimization Debug</h1>\n";

// Get the asset manager instance
$asset_manager = Asset_Minifier_Manager::instance();

// Run debug
$debug_info = $asset_manager->debug_asset_generation();

echo "<h2>Debug Information:</h2>\n";
echo "<pre>";
print_r($debug_info);
echo "</pre>\n";

// Try to force regenerate assets
echo "<h2>Force Regenerating Assets...</h2>\n";
$result = $asset_manager->force_regenerate_assets();
echo "Force regeneration result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";

// Get optimization stats
echo "<h2>Optimization Statistics:</h2>\n";
$stats = $asset_manager->get_optimization_stats();
echo "<pre>";
print_r($stats);
echo "</pre>\n";
?>
