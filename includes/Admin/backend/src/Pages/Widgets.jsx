import React, {
	useState,
	useMemo,
	useEffect,
	useCallback,
	useRef,
} from "react";
import WidgetCard from "../components/WidgetCard";
import Switch from "../components/ui/Switch";
import widgetsData from "../data/widgets.json";
import { useToast } from "../hooks/useToast";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";

const Widgets = () => {
	const [searchTerm, setSearchTerm] = useState("");
	const [selectedCategory, setSelectedCategory] = useState("all");
	const [enableAllWidgets, setEnableAllWidgets] = useState(false);
	const [widgets, setWidgets] = useState(widgetsData.widgets);
	const [loading, setLoading] = useState(true);
	const [saving, setSaving] = useState(false);
	const [fadeIn, setFadeIn] = useState(false);
	const [gridFade, setGridFade] = useState(true);
	const [displayedCategory, setDisplayedCategory] =
		useState(selectedCategory);
	const [displayedSearchTerm, setDisplayedSearchTerm] = useState(searchTerm);

	// Interactive fade-out, update, fade-in for widgets grid
	useEffect(() => {
		if (
			displayedCategory !== selectedCategory ||
			displayedSearchTerm !== searchTerm
		) {
			setGridFade(false); // fade out
			const timeout = setTimeout(() => {
				setDisplayedCategory(selectedCategory);
				setDisplayedSearchTerm(searchTerm);
				setGridFade(true); // fade in
			}, 350); // match fade duration
			return () => clearTimeout(timeout);
		}
	}, [selectedCategory, searchTerm, displayedCategory, displayedSearchTerm]);
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

			const response = await fetch(`${apiBase}/widgets`, {
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

				// Batch update widgets for better performance
				setWidgets((prevWidgets) => {
					const updatedWidgets = prevWidgets.map((widget) => {
						const backendWidget = data[widget.id];
						return backendWidget
							? { ...widget, enabled: backendWidget.enabled }
							: widget;
					});
					return updatedWidgets;
				});
			} else {
				console.error("Failed to fetch widget settings");
				showError("Failed to load widget settings. Please try again.");
			}
		} catch (error) {
			if (error.name === "AbortError") {
				console.error("Request timeout");
				showError("Request timeout. Please try again.");
			} else {
				console.error("Error fetching widget settings:", error);
				showError(
					"Error connecting to server. Please check your connection.",
				);
			}
		} finally {
			setLoading(false);
		}
	}, [apiBase, nonce, showError]);

	// Fetch widget settings from WordPress
	useEffect(() => {
		fetchData();
	}, [fetchData]);

	const saveWidgetSettings = async (widgetSettings, showToast = false) => {
		try {
			setSaving(true);
			// console.log("Saving widget settings:", widgetSettings);

			const response = await fetch(`${apiBase}/widgets`, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					"X-WP-Nonce": nonce,
				},
				body: JSON.stringify(widgetSettings),
			});

			if (response.ok) {
				await response.json(); // Just consume the response
				// console.log("Widget settings saved successfully:", result);
				if (showToast) {
					showSuccess("Widget settings saved successfully!");
				}
				return true;
			} else {
				const errorData = await response.text();
				console.error(
					"Failed to save widget settings. Status:",
					response.status,
					"Error:",
					errorData,
				);
				if (showToast) {
					showError(
						"Failed to save widget settings. Please try again.",
					);
				}
				return false;
			}
		} catch (error) {
			console.error("Error saving widget settings:", error);
			if (showToast) {
				showError(
					"Error connecting to server. Please check your connection.",
				);
			}
			return false;
		} finally {
			setSaving(false);
		}
	};

	// Filter widgets based on displayed search and category (for animation)
	const filteredWidgets = useMemo(() => {
		let filtered = widgets;

		// Filter by category
		if (displayedCategory !== "all") {
			filtered = filtered.filter(
				(widget) => widget.category === displayedCategory,
			);
		}

		// Filter by search term
		if (displayedSearchTerm) {
			filtered = filtered.filter((widget) =>
				widget.name
					.toLowerCase()
					.includes(displayedSearchTerm.toLowerCase()),
			);
		}

		return filtered;
	}, [widgets, displayedCategory, displayedSearchTerm]);

	// Group widgets by category for display
	const groupedWidgets = useMemo(() => {
		const groups = {};

		filteredWidgets.forEach((widget) => {
			if (!groups[widget.category]) {
				groups[widget.category] = [];
			}
			groups[widget.category].push(widget);
		});

		return groups;
	}, [filteredWidgets]);

	// Get category name by id - memoized for performance
	const getCategoryName = useMemo(() => {
		const categoryMap = {};
		widgetsData.categories.forEach((cat) => {
			categoryMap[cat.id] = cat.name;
		});
		return (categoryId) => categoryMap[categoryId] || categoryId;
	}, []);

	// Handle widget toggle
	const handleWidgetToggle = async (widgetId, enabled) => {
		// Find the widget name for the toast message
		const widget = widgets.find((w) => w.id === widgetId);
		const widgetName = widget ? widget.name : "Widget";

		// Create settings object for API first (before state update)
		const widgetSettings = {};
		widgets.forEach((widget) => {
			if (widget.id === widgetId) {
				widgetSettings[widget.id] = enabled;
			} else {
				widgetSettings[widget.id] = widget.enabled;
			}
		});

		// Update local state immediately
		setWidgets((prevWidgets) =>
			prevWidgets.map((widget) =>
				widget.id === widgetId ? { ...widget, enabled } : widget,
			),
		);

		// Save to backend
		const success = await saveWidgetSettings(widgetSettings);
		if (!success) {
			// Revert on failure
			setWidgets((prevWidgets) =>
				prevWidgets.map((widget) =>
					widget.id === widgetId
						? { ...widget, enabled: !enabled }
						: widget,
				),
			);
			showError(
				`Failed to ${enabled ? "enable" : "disable"} ${widgetName}`,
			);
		} else {
			showSuccess(
				`${widgetName} ${
					enabled ? "enabled" : "disabled"
				} successfully!`,
			);
		}
	};

	// Handle enable all widgets
	const handleEnableAll = async (enabled) => {
		setEnableAllWidgets(enabled);

		// Update local state
		const updatedWidgets = widgets.map((widget) => ({
			...widget,
			enabled:
				widget.status === "pro" && !widget.enabled
					? widget.enabled
					: enabled,
		}));
		setWidgets(updatedWidgets);

		// Create settings object for API
		const widgetSettings = {};
		updatedWidgets.forEach((widget) => {
			widgetSettings[widget.id] = widget.enabled;
		});

		// Save to backend
		const success = await saveWidgetSettings(widgetSettings);
		if (!success) {
			// Revert on failure
			setEnableAllWidgets(!enabled);
			setWidgets(widgets); // Revert to previous state
			showError(
				`Failed to ${enabled ? "enable" : "disable"} all widgets`,
			);
		} else {
			const enabledCount = updatedWidgets.filter((w) => w.enabled).length;
			const totalCount = updatedWidgets.length;
			showSuccess(
				`All widgets ${
					enabled ? "enabled" : "disabled"
				} successfully! (${enabledCount}/${totalCount})`,
			);
		}
	};

	return (
		<div
			className={`flex gap-4 max-w-[1200px] mx-auto min-h-screen transition-opacity duration-200 ${
				fadeIn ? "opacity-100" : "opacity-0"
			}`}
		>
			{/* Sidebar */}
			<div className='w-54 bg-slate-200 rounded-lg p-4 sticky top-[72px] h-screen self-start'>
				<div className='space-y-2'>
					{widgetsData.categories.map((category) => (
						<button
							key={category.id}
							onClick={() => setSelectedCategory(category.id)}
							className={`
                w-full text-left px-4 py-2.5 my-0 rounded-lg text-zinc-900 text-base !font-medium transition-colors cursor-pointer
                ${
					selectedCategory === category.id
						? "bg-blue-600 !text-white"
						: "hover:bg-[#DBE3FF] hover:text-blue-600"
				}
              `}
						>
							<span className='flex items-center space-x-3'>
								<span>{category.icon}</span>
								<span>{category.name}</span>
							</span>
						</button>
					))}
				</div>
			</div>

			{/* Main Content */}
			<div className='flex-1'>
				{loading ? (
					<div className='flex items-center justify-center h-64'>
						<div className='text-center'>
							<div className='animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4'></div>
							<p className='text-gray-600'>Loading widgets...</p>
						</div>
					</div>
				) : (
					<>
						{/* Header */}
						<div className='py-3 px-4 bg-white rounded-lg mb-1'>
							<div className='flex items-center justify-between'>
								<h1 className='!text-zinc-900 !text-xl !my-0'>
									{getCategoryName(selectedCategory)}
								</h1>
								<div className='flex items-center space-x-3'>
									<div className='flex items-center rounded-lg border border-zinc-200 overflow-hidden'>
										<div className='relative border-r !border-zinc-200'>
											<input
												type='text'
												placeholder='Search...'
												value={searchTerm}
												onChange={(e) =>
													setSearchTerm(
														e.target.value,
													)
												}
												className='min-[220px] !h-9 !bg-slate-100 !pl-8 !rounded-tl-lg !rounded-bl-lg !border-transparent rounded-none transition duration-300 ease-in-out  focus:!bg-white focus:!rounded-tl-lg focus:!rounded-bl-lg focus:!shadow-[0px_0px_0px_3px_rgba(49,84,243,0.10)] border focus:!border-indigo-400'
												disabled={saving}
											/>
											<div className='absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none'>
												<svg
													className='h-4 w-4 text-gray-400'
													fill='none'
													stroke='currentColor'
													viewBox='0 0 24 24'
												>
													<path
														strokeLinecap='round'
														strokeLinejoin='round'
														strokeWidth={2}
														d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'
													/>
												</svg>
											</div>
										</div>

										<Select
											value={selectedCategory}
											onValueChange={setSelectedCategory}
										>
											<SelectTrigger className='w-[180px] w-32 h-24 bg-white text-zinc-900 text-sm !border-transparent rounded-none  rounded-tr-lg rounded-br-lg focus:!shadow-[0px_0px_0px_3px_rgba(49,84,243,0.10)] focus:border focus:!border-indigo-400'>
												<SelectValue placeholder='All Widgets' />
											</SelectTrigger>
											<SelectContent className='bg-white rounded-lg shadow-[0px_14px_20px_-10px_rgba(23,25,31,0.16)] border border-zinc-20'>
												{widgetsData.categories.map(
													(category) => (
														<SelectItem
															key={category.id}
															value={category.id}
															className='text-zinc-900 text-sm'
														>
															{category.name}
														</SelectItem>
													),
												)}
											</SelectContent>
										</Select>
									</div>
									<div className='flex items-center space-x-3 rounded-lg border border-zinc-200 px-3 py-2'>
										<span className='font-medium text-zinc-900 text-sm'>
											Enable All Widget
										</span>
										<Switch
											checked={enableAllWidgets}
											onChange={handleEnableAll}
										/>
									</div>
								</div>
							</div>
						</div>

						{/* Widgets Grid */}
						<div
							className={`space-y-8 transition-opacity duration-700 ease-in-out ${
								gridFade ? "opacity-100" : "opacity-0"
							}`}
							style={{
								pointerEvents: gridFade ? "auto" : "none",
							}}
						>
							{selectedCategory === "all" ? (
								// Show all categories with their widgets
								Object.entries(groupedWidgets).map(
									([categoryId, categoryWidgets]) => (
										<div
											className='bg-white rounded-lg mb-4 py-4 px-3.5'
											key={categoryId}
										>
											<h2 className='text-lg font-semibold text-gray-900 mb-4 !mt-0'>
												{getCategoryName(categoryId)}{" "}
												Widgets
											</h2>
											<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 bg-slate-100 rounded-lg p-1'>
												{categoryWidgets.map(
													(widget) => (
														<WidgetCard
															key={widget.id}
															widget={widget}
															onToggle={
																handleWidgetToggle
															}
														/>
													),
												)}
											</div>
										</div>
									),
								)
							) : (
								// Show only selected category widgets
								<div className='bg-white rounded-lg mb-4 py-4 px-3.5'>
									<h2 className='text-lg font-semibold text-gray-900 mb-4 !mt-0'>
										{getCategoryName(selectedCategory)}{" "}
										Widgets
									</h2>
									<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 bg-slate-100 rounded-lg p-1'>
										{filteredWidgets.map((widget) => (
											<WidgetCard
												key={widget.id}
												widget={widget}
												onToggle={handleWidgetToggle}
											/>
										))}
									</div>
								</div>
							)}

							{filteredWidgets.length === 0 && (
								<div className='text-center py-12'>
									<div className='text-gray-400 text-lg mb-2'>
										No widgets found
									</div>
									<p className='text-gray-500'>
										Try adjusting your search or filter
										criteria
									</p>
								</div>
							)}
						</div>
					</>
				)}
			</div>
		</div>
	);
};

export default Widgets;
