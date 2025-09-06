import React, { useState, useMemo } from "react";
import WidgetCard from "../components/WidgetCard";
import Switch from "../components/ui/Switch";
import widgetsData from "../data/widgets.json";

const Widgets = () => {
	const [searchTerm, setSearchTerm] = useState("");
	const [selectedCategory, setSelectedCategory] = useState("all");
	const [enableAllWidgets, setEnableAllWidgets] = useState(false);
	const [widgets, setWidgets] = useState(widgetsData.widgets);

	// Filter widgets based on search and category
	const filteredWidgets = useMemo(() => {
		let filtered = widgets;

		// Filter by category
		if (selectedCategory !== "all") {
			filtered = filtered.filter(
				(widget) => widget.category === selectedCategory,
			);
		}

		// Filter by search term
		if (searchTerm) {
			filtered = filtered.filter((widget) =>
				widget.name.toLowerCase().includes(searchTerm.toLowerCase()),
			);
		}

		return filtered;
	}, [widgets, selectedCategory, searchTerm]);

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

	// Get category name by id
	const getCategoryName = (categoryId) => {
		const category = widgetsData.categories.find(
			(cat) => cat.id === categoryId,
		);
		return category ? category.name : categoryId;
	};

	// Handle widget toggle
	const handleWidgetToggle = (widgetId, enabled) => {
		setWidgets((prevWidgets) =>
			prevWidgets.map((widget) =>
				widget.id === widgetId ? { ...widget, enabled } : widget,
			),
		);
	};

	// Handle enable all widgets
	const handleEnableAll = (enabled) => {
		setEnableAllWidgets(enabled);
		setWidgets((prevWidgets) =>
			prevWidgets.map((widget) => ({
				...widget,
				enabled:
					widget.status === "pro" && !widget.enabled
						? widget.enabled
						: enabled,
			})),
		);
	};

	return (
		<div className='flex min-h-screen bg-gray-50'>
			{/* Sidebar */}
			<div className='w-64 bg-white border-r border-gray-200 p-6'>
				<div className='space-y-2'>
					{widgetsData.categories.map((category) => (
						<button
							key={category.id}
							onClick={() => setSelectedCategory(category.id)}
							className={`
                w-full text-left px-4 py-3 rounded-lg text-sm font-medium transition-colors
                ${
					selectedCategory === category.id
						? "bg-blue-600 text-white"
						: "text-gray-700 hover:bg-gray-100"
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
			<div className='flex-1 p-6'>
				{/* Header */}
				<div className='mb-6'>
					<div className='flex items-center justify-between mb-6'>
						<h1 className='text-2xl font-bold text-gray-900'>
							{getCategoryName(selectedCategory)}
						</h1>
						<div className='flex items-center space-x-4'>
							<div className='relative'>
								<input
									type='text'
									placeholder='Search...'
									value={searchTerm}
									onChange={(e) =>
										setSearchTerm(e.target.value)
									}
									className='w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm'
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
							<select
								value={selectedCategory}
								onChange={(e) =>
									setSelectedCategory(e.target.value)
								}
								className='px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm'
							>
								{widgetsData.categories.map((category) => (
									<option
										key={category.id}
										value={category.id}
									>
										{category.name}
									</option>
								))}
							</select>
							<div className='flex items-center space-x-3'>
								<span className='text-sm text-gray-700 font-medium'>
									Enable All Widgets
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
				<div className='space-y-8'>
					{selectedCategory === "all" ? (
						// Show all categories with their widgets
						Object.entries(groupedWidgets).map(
							([categoryId, categoryWidgets]) => (
								<div key={categoryId}>
									<h2 className='text-lg font-semibold text-gray-900 mb-4'>
										{getCategoryName(categoryId)} Widgets
									</h2>
									<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
										{categoryWidgets.map((widget) => (
											<WidgetCard
												key={widget.id}
												widget={widget}
												onToggle={handleWidgetToggle}
											/>
										))}
									</div>
								</div>
							),
						)
					) : (
						// Show only selected category widgets
						<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
							{filteredWidgets.map((widget) => (
								<WidgetCard
									key={widget.id}
									widget={widget}
									onToggle={handleWidgetToggle}
								/>
							))}
						</div>
					)}

					{filteredWidgets.length === 0 && (
						<div className='text-center py-12'>
							<div className='text-gray-400 text-lg mb-2'>
								No widgets found
							</div>
							<p className='text-gray-500'>
								Try adjusting your search or filter criteria
							</p>
						</div>
					)}
				</div>
			</div>
		</div>
	);
};

export default Widgets;
