import React, { useState, useEffect, useCallback, useRef } from "react";
import Switch from "../components/ui/Switch";
import widgetsData from "../data/widgets.json";
import { useToast } from "../hooks/useToast";

const Extensions = () => {
	const [extensions, setExtensions] = useState(widgetsData.extensions);
	const [loading, setLoading] = useState(true);
	const [saving, setSaving] = useState(false);
	const [fadeIn, setFadeIn] = useState(false);
	const [hasInitialized, setHasInitialized] = useState(false);
	const saveTimeoutRef = useRef(null);

	const { showSuccess, showError } = useToast();

	// WordPress REST API base URL
	const apiBase = (
		window.decentElements?.apiUrl || "/wp-json/decent-elements/v1"
	).replace(/\/$/, "");
	const nonce = window.decentElements?.nonce || "";

	// Start fade in animation after component mounts
	useEffect(() => {
		const timer = setTimeout(() => setFadeIn(true), 50);
		return () => clearTimeout(timer);
	}, []);

	// Optimized fetch function with timeout
	const fetchData = useCallback(async () => {
		try {
			setLoading(true);

			// Add timeout to prevent hanging
			const controller = new AbortController();
			const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

			const response = await fetch(`${apiBase}/extensions`, {
				method: "GET",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": nonce,
				},
				signal: controller.signal,
			});

			clearTimeout(timeoutId);

			if (response.ok) {
				const data = await response.json();

				// Batch update extensions for better performance
				setExtensions((prevExtensions) => {
					const updatedExtensions = prevExtensions.map(
						(extension) => {
							const backendExtension = data[extension.id];
							return backendExtension
								? {
										...extension,
										enabled: backendExtension.enabled,
								  }
								: extension;
						},
					);
					return updatedExtensions;
				});

				// Mark as initialized after first successful load
				setHasInitialized(true);
			} else {
				console.error("Failed to fetch extension settings");
				showError(
					"Failed to load extension settings. Please try again.",
				);
			}
		} catch (error) {
			if (error.name === "AbortError") {
				console.log("Request was aborted");
				showError(
					"Request timed out. Please check your connection and try again.",
				);
			} else {
				console.error("Error fetching extension settings:", error);
				showError(
					"An error occurred while loading extension settings.",
				);
			}
		} finally {
			setLoading(false);
		}
	}, [apiBase, nonce, showError]);

	// Initial load
	useEffect(() => {
		fetchData();
	}, [fetchData]);

	// Save function with debouncing and batch updates
	const saveExtensions = useCallback(
		async (extensionsToSave) => {
			if (saving) return; // Prevent concurrent saves

			try {
				setSaving(true);

				const extensionSettings = {};
				extensionsToSave.forEach((extension) => {
					extensionSettings[extension.id] = extension.enabled;
				});

				const response = await fetch(`${apiBase}/extensions`, {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-WP-Nonce": nonce,
					},
					body: JSON.stringify(extensionSettings),
				});

				if (response.ok) {
					const result = await response.json();
					if (result.success) {
						showSuccess("Extension settings saved successfully!");
					} else {
						showError(
							result.message ||
								"Failed to save extension settings.",
						);
					}
				} else {
					showError(
						"Failed to save extension settings. Please try again.",
					);
				}
			} catch (error) {
				console.error("Error saving extension settings:", error);
				showError("An error occurred while saving extension settings.");
			} finally {
				setSaving(false);
			}
		},
		[apiBase, nonce, saving, showSuccess, showError],
	);

	// Toggle individual extension
	const toggleExtension = useCallback(
		(extensionId) => {
			setExtensions((prev) => {
				const updatedExtensions = prev.map((extension) =>
					extension.id === extensionId
						? { ...extension, enabled: !extension.enabled }
						: extension,
				);

				// Immediately save after toggle (no auto-save needed)
				if (hasInitialized) {
					// Clear any existing timeout
					if (saveTimeoutRef.current) {
						clearTimeout(saveTimeoutRef.current);
					}

					// Save with short delay
					saveTimeoutRef.current = setTimeout(() => {
						saveExtensions(updatedExtensions);
					}, 300);
				}

				return updatedExtensions;
			});
		},
		[hasInitialized, saveExtensions],
	);

	const enabledCount = extensions.filter(
		(extension) => extension.enabled,
	).length;
	const totalCount = extensions.length;

	if (loading) {
		return (
			<div className='max-w-[1200px] mx-auto py-8 px-3'>
				<div className='flex items-center justify-center min-h-[400px]'>
					<div className='flex flex-col items-center gap-4'>
						<div className='animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600'></div>
						<p className='text-gray-600'>Loading extensions...</p>
					</div>
				</div>
			</div>
		);
	}

	return (
		<div className='max-w-[1200px] mx-auto py-8 px-3'>
			<div
				className={`transition-all duration-700 ease-out ${
					fadeIn
						? "opacity-100 translate-y-0"
						: "opacity-0 translate-y-4"
				}`}
			>
				{/* Header */}
				<div className='mb-2'>
					<div className='flex items-center justify-between bg-white p-6 rounded-lg shadow-md'>
						<div>
							<h1 className='text-2xl font-bold text-gray-900 !mb-1 !mt-0'>
								Extensions
							</h1>
							<p className='text-gray-600 !my-0'>
								Extend your website's functionality with these
								powerful extensions.
							</p>
						</div>
						<div className='text-right'>
							<div className='text-sm text-gray-500'>
								{enabledCount} of {totalCount} enabled
							</div>
						</div>
					</div>
				</div>

				{/* Extensions Grid */}
				<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2'>
					{extensions.map((extension, index) => (
						<div
							key={extension.id}
							className={`bg-white p-6 rounded-md hover:shadow-md transition-all duration-300 ${
								extension.enabled
									? "ring-2 ring-blue-100 border-blue-200"
									: ""
							}`}
							style={{
								animationDelay: `${index * 50}ms`,
							}}
						>
							<div className='flex items-start justify-between mb-4'>
								<div className='flex items-center gap-3'>
									<div
										className='text-2xl'
										title={extension.name}
									>
										{extension.icon}
									</div>
									<div>
										<h3 className='font-semibold text-gray-900 text-base !mt-0'>
											{extension.name}
										</h3>
									</div>
								</div>
								<Switch
									checked={extension.enabled}
									onChange={() =>
										toggleExtension(extension.id)
									}
									disabled={saving}
								/>
							</div>

							<div className='space-y-3'>
								{extension.link && (
									<div>
										<a
											href={extension.link}
											target='_blank'
											rel='noopener noreferrer'
											className='inline-flex items-center text-sm text-blue-600 hover:text-blue-700 transition-colors'
										>
											Learn more
											<svg
												className='w-3 h-3 ml-1'
												fill='none'
												stroke='currentColor'
												viewBox='0 0 24 24'
											>
												<path
													strokeLinecap='round'
													strokeLinejoin='round'
													strokeWidth={2}
													d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'
												/>
											</svg>
										</a>
									</div>
								)}
							</div>

							{/* Status indicator */}
							<div className='mt-4 pt-4 border-t border-gray-100'>
								<div className='flex items-center justify-between'>
									<span
										className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
											extension.enabled
												? "bg-green-100 text-green-800"
												: "bg-gray-100 text-gray-800"
										}`}
									>
										{extension.enabled
											? "Enabled"
											: "Disabled"}
									</span>
								</div>
							</div>
						</div>
					))}
				</div>

				{/* Save indicator */}
				{saving && (
					<div className='fixed bottom-6 right-6 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg flex items-center gap-2'>
						<div className='animate-spin rounded-full h-4 w-4 border-b-2 border-white'></div>
						<span>Saving...</span>
					</div>
				)}
			</div>
		</div>
	);
};

export default Extensions;
