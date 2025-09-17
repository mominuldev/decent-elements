import React, { useState, useEffect, useCallback } from "react";
import Switch from "../components/ui/Switch";
import Button from "../components/ui/Button";
import { useToast } from "../hooks/useToast";

const Optimizer = () => {
	const [optimizationEnabled, setOptimizationEnabled] = useState(false);
	const [loading, setLoading] = useState(true);
	const [generating, setGenerating] = useState(false);
	const [clearing, setClearing] = useState(false);
	const [stats, setStats] = useState({
		enabled: false,
		last_generated: 0,
		js_file_exists: false,
		css_file_exists: false,
		js_file_size: 0,
		css_file_size: 0,
		total_widgets: 0,
		total_extensions: 0
	});
	const [fadeIn, setFadeIn] = useState(false);

	const { showSuccess, showError } = useToast();

	// WordPress REST API base URL
	const apiBase = (
		window.decentElements?.apiUrl || "/wp-json/decent-elements/v1"
	).replace(/\/$/, "");
	const nonce = window.decentElements?.nonce || '';

	// Load optimization settings on mount
	useEffect(() => {
		const timer = setTimeout(() => {
			setLoading(false);
			setFadeIn(true);
		}, 800);

		loadOptimizationSettings();
		loadOptimizationStats();

		return () => clearTimeout(timer);
	}, []);

	// Load optimization settings
	const loadOptimizationSettings = useCallback(async () => {
		try {
			const response = await fetch(`${apiBase}/settings/optimization`, {
				headers: {
					'X-WP-Nonce': nonce,
				},
			});
			const data = await response.json();
			if (data.success) {
				setOptimizationEnabled(data.data.enabled || false);
			}
		} catch (error) {
			console.error('Error loading optimization settings:', error);
		}
	}, [apiBase, nonce]);

	// Load optimization statistics
	const loadOptimizationStats = useCallback(async () => {
		try {
			const response = await fetch(`${apiBase}/optimization/stats`, {
				headers: {
					'X-WP-Nonce': nonce,
				},
			});
			const data = await response.json();
			if (data.success) {
				setStats(data.data);
			}
		} catch (error) {
			console.error('Error loading optimization stats:', error);
		}
	}, [apiBase, nonce]);

	// Handle optimization toggle
	const handleOptimizationToggle = useCallback(async (enabled) => {
		try {
			const response = await fetch(`${apiBase}/settings/optimization`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': nonce,
				},
				body: JSON.stringify({
					enabled: enabled
				}),
			});

			const data = await response.json();
			if (data.success) {
				setOptimizationEnabled(enabled);
				showSuccess(`Asset optimization ${enabled ? 'enabled' : 'disabled'} successfully`);

				// Reload stats after toggle
				setTimeout(() => {
					loadOptimizationStats();
				}, 500);
			} else {
				throw new Error(data.message || 'Failed to update optimization setting');
			}
		} catch (error) {
			showError(error.message || 'Failed to update optimization setting');
		}
	}, [apiBase, nonce, showSuccess, showError, loadOptimizationStats]);

	// Generate optimized assets
	const handleGenerateAssets = useCallback(async () => {
		setGenerating(true);
		try {
			const response = await fetch(`${apiBase}/optimization/generate`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': nonce,
				},
			});

			const data = await response.json();
			if (data.success) {
				showSuccess('Optimized assets generated successfully');
				loadOptimizationStats();
			} else {
				throw new Error(data.message || 'Failed to generate optimized assets');
			}
		} catch (error) {
			showError(error.message || 'Failed to generate optimized assets');
		} finally {
			setGenerating(false);
		}
	}, [apiBase, nonce, showSuccess, showError, loadOptimizationStats]);

	// Clear optimized assets
	const handleClearAssets = useCallback(async () => {
		if (!confirm('Are you sure you want to clear all optimized assets?')) return;

		setClearing(true);
		try {
			const response = await fetch(`${apiBase}/optimization/clear`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': nonce,
				},
			});

			const data = await response.json();
			if (data.success) {
				showSuccess('Optimized assets cleared successfully');
				loadOptimizationStats();
			} else {
				throw new Error(data.message || 'Failed to clear optimized assets');
			}
		} catch (error) {
			showError(error.message || 'Failed to clear optimized assets');
		} finally {
			setClearing(false);
		}
	}, [apiBase, nonce, showSuccess, showError, loadOptimizationStats]);

	// Format file size
	const formatFileSize = (bytes) => {
		if (bytes === 0) return '0 Bytes';
		const k = 1024;
		const sizes = ['Bytes', 'KB', 'MB', 'GB'];
		const i = Math.floor(Math.log(bytes) / Math.log(k));
		return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
	};

	// Format date
	const formatDate = (timestamp) => {
		if (!timestamp) return 'Never';
		return new Date(timestamp * 1000).toLocaleString();
	};

	if (loading) {
		return (
			<div className="flex items-center justify-center min-h-[400px]">
				<div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
			</div>
		);
	}

	return (
		<div className={`p-4 bg-white rounded-lg shadow-md max-w-[1200px] mx-auto transition-opacity duration-700 ${fadeIn ? 'opacity-100' : 'opacity-0'}`}>
			{/* Header */}
			<div className="mb-6">
				<h1 className="text-2xl font-bold mb-2">Asset Optimization</h1>
				<p className="text-gray-600">
					Optimize your website performance by minifying and combining CSS and JavaScript files
				</p>
			</div>

			{/* Main Toggle */}
			<div className="bg-gray-50 rounded-lg p-6 mb-6">
				<div className="flex items-center justify-between">
					<div>
						<h3 className="text-lg font-semibold mb-2">Enable Asset Optimization</h3>
						<p className="text-gray-600 text-sm">
							Automatically minify and combine CSS/JS files for better performance
						</p>
					</div>
					<Switch
						checked={optimizationEnabled}
						onChange={handleOptimizationToggle}
						size="default"
					/>
				</div>
			</div>

			{/* Statistics */}
			<div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
				<div className="bg-blue-50 rounded-lg p-4">
					<div className="text-2xl font-bold text-blue-600">{stats.total_widgets}</div>
					<div className="text-sm text-gray-600">Active Widgets</div>
				</div>
				<div className="bg-green-50 rounded-lg p-4">
					<div className="text-2xl font-bold text-green-600">{stats.total_extensions}</div>
					<div className="text-sm text-gray-600">Active Extensions</div>
				</div>
				<div className="bg-purple-50 rounded-lg p-4">
					<div className="text-2xl font-bold text-purple-600">
						{formatFileSize(stats.css_file_size)}
					</div>
					<div className="text-sm text-gray-600">CSS File Size</div>
				</div>
				<div className="bg-orange-50 rounded-lg p-4">
					<div className="text-2xl font-bold text-orange-600">
						{formatFileSize(stats.js_file_size)}
					</div>
					<div className="text-sm text-gray-600">JS File Size</div>
				</div>
			</div>

			{/* File Status */}
			<div className="bg-gray-50 rounded-lg p-6 mb-6">
				<h3 className="text-lg font-semibold mb-4">Optimization Status</h3>
				<div className="grid grid-cols-1 md:grid-cols-2 gap-6">
					<div>
						<div className="flex items-center justify-between mb-2">
							<span className="font-medium">CSS Files</span>
							<span className={`px-2 py-1 text-xs rounded-full ${
								stats.css_file_exists ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
							}`}>
								{stats.css_file_exists ? 'Generated' : 'Not Generated'}
							</span>
						</div>
						{stats.css_file_exists && (
							<div className="text-sm text-gray-600">
								Size: {formatFileSize(stats.css_file_size)}
							</div>
						)}
					</div>
					<div>
						<div className="flex items-center justify-between mb-2">
							<span className="font-medium">JavaScript Files</span>
							<span className={`px-2 py-1 text-xs rounded-full ${
								stats.js_file_exists ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
							}`}>
								{stats.js_file_exists ? 'Generated' : 'Not Generated'}
							</span>
						</div>
						{stats.js_file_exists && (
							<div className="text-sm text-gray-600">
								Size: {formatFileSize(stats.js_file_size)}
							</div>
						)}
					</div>
				</div>
				{stats.last_generated > 0 && (
					<div className="mt-4 pt-4 border-t border-gray-200">
						<div className="text-sm text-gray-600">
							Last generated: {formatDate(stats.last_generated)}
						</div>
					</div>
				)}
			</div>

			{/* Actions */}
			<div className="flex flex-wrap gap-4">
				<Button
					onClick={handleGenerateAssets}
					disabled={generating || !optimizationEnabled}
					className="bg-blue-600 hover:bg-blue-700 text-white"
				>
					{generating ? 'Generating...' : 'Generate Assets'}
				</Button>

				<Button
					onClick={handleClearAssets}
					disabled={clearing}
					variant="destructive"
				>
					{clearing ? 'Clearing...' : 'Clear Assets'}
				</Button>

				<Button
					onClick={loadOptimizationStats}
					variant="outline"
				>
					Refresh Stats
				</Button>
			</div>

			{/* Help Text */}
			<div className="mt-8 p-4 bg-blue-50 rounded-lg">
				<h4 className="font-semibold text-blue-900 mb-2">How Asset Optimization Works</h4>
				<ul className="text-sm text-blue-800 space-y-1">
					<li>• Combines multiple CSS files into a single minified file</li>
					<li>• Combines multiple JavaScript files into a single minified file</li>
					<li>• Reduces file sizes by removing unnecessary whitespace and comments</li>
					<li>• Automatically regenerates files when widget/extension settings change</li>
					<li>• Improves page load speed by reducing HTTP requests</li>
				</ul>
			</div>
		</div>
	);
};

export default Optimizer;
