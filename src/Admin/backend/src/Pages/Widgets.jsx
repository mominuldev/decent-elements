import React, { useState, useMemo, useEffect } from "react";
import WidgetCard from "@/components/WidgetCard";
import Switch from "@/components/ui/Switch";
import { useRegistry } from "@/hooks/useRegistry";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";

/**
 * Widget management screen.
 *
 * Renders from the PHP module registry rather than a checked-in widgets.json.
 * That file listed 47 widgets while the plugin implements 7, so 42 toggles
 * wrote ids the server discarded — and still showed a success toast — while
 * two real widgets were missing from it and could not be toggled at all.
 */
const Widgets = () => {
	const { categories, items, loading, saving, toggle, toggleAll } =
		useRegistry("widgets");

	const [searchTerm, setSearchTerm] = useState("");
	const [selectedCategory, setSelectedCategory] = useState("all");
	const [fadeIn, setFadeIn] = useState(false);
	const [gridFade, setGridFade] = useState(true);
	const [displayedCategory, setDisplayedCategory] = useState("all");
	const [displayedSearchTerm, setDisplayedSearchTerm] = useState("");

	useEffect(() => {
		const timer = setTimeout(() => setFadeIn(true), 50);
		return () => clearTimeout(timer);
	}, []);

	// Fade the grid out, swap the filters, fade back in.
	useEffect(() => {
		if (
			displayedCategory !== selectedCategory ||
			displayedSearchTerm !== searchTerm
		) {
			setGridFade(false);
			const timeout = setTimeout(() => {
				setDisplayedCategory(selectedCategory);
				setDisplayedSearchTerm(searchTerm);
				setGridFade(true);
			}, 350);
			return () => clearTimeout(timeout);
		}
	}, [selectedCategory, searchTerm, displayedCategory, displayedSearchTerm]);

	const allEnabled = useMemo(
		() => items.length > 0 && items.every((widget) => widget.enabled),
		[items],
	);

	const filteredWidgets = useMemo(() => {
		let filtered = items;

		if (displayedCategory !== "all") {
			filtered = filtered.filter(
				(widget) => widget.category === displayedCategory,
			);
		}

		if (displayedSearchTerm) {
			const needle = displayedSearchTerm.toLowerCase();
			filtered = filtered.filter((widget) =>
				widget.name.toLowerCase().includes(needle),
			);
		}

		return filtered;
	}, [items, displayedCategory, displayedSearchTerm]);

	const groupedWidgets = useMemo(() => {
		return filteredWidgets.reduce((groups, widget) => {
			(groups[widget.category] ||= []).push(widget);
			return groups;
		}, {});
	}, [filteredWidgets]);

	// Only show categories that actually contain a widget, plus "All".
	const visibleCategories = useMemo(() => {
		const populated = new Set(items.map((widget) => widget.category));
		return categories.filter(
			(category) => category.id === "all" || populated.has(category.id),
		);
	}, [categories, items]);

	const getCategoryName = useMemo(() => {
		const map = Object.fromEntries(
			categories.map((category) => [category.id, category.name]),
		);
		return (id) => map[id] || id;
	}, [categories]);

	const renderGrid = (widgets) => (
		<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1 bg-slate-100 rounded-lg p-1'>
			{widgets.map((widget) => (
				<WidgetCard
					key={widget.id}
					widget={widget}
					onToggle={toggle}
					disabled={saving}
				/>
			))}
		</div>
	);

	return (
		<div
			className={`flex gap-4 max-w-[1200px] mx-auto min-h-screen transition-opacity duration-200 ${
				fadeIn ? "opacity-100" : "opacity-0"
			}`}
		>
			{/* Sidebar */}
			<div className='w-54 bg-slate-200 rounded-lg p-4 sticky top-[72px] h-screen self-start'>
				<div className='space-y-2'>
					{visibleCategories.map((category) => (
						<button
							key={category.id}
							onClick={() => setSelectedCategory(category.id)}
							className={`w-full text-left px-4 py-2.5 my-0 rounded-lg text-zinc-900 text-base !font-medium transition-colors cursor-pointer ${
								selectedCategory === category.id
									? "bg-blue-600 !text-white"
									: "hover:bg-[#DBE3FF] hover:text-blue-600"
							}`}
						>
							<span className='flex items-center space-x-3'>
								<span>{category.icon}</span>
								<span>{category.name}</span>
							</span>
						</button>
					))}
				</div>
			</div>

			{/* Main content */}
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
												onChange={(event) =>
													setSearchTerm(event.target.value)
												}
												className='min-[220px] !h-9 !bg-slate-100 !pl-8 !rounded-tl-lg !rounded-bl-lg !border-transparent rounded-none transition duration-300 ease-in-out focus:!bg-white focus:!rounded-tl-lg focus:!rounded-bl-lg focus:!shadow-[0px_0px_0px_3px_rgba(49,84,243,0.10)] border focus:!border-indigo-400'
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
											<SelectTrigger className='w-[180px] h-24 bg-white text-zinc-900 text-sm !border-transparent rounded-none rounded-tr-lg rounded-br-lg focus:!shadow-[0px_0px_0px_3px_rgba(49,84,243,0.10)] focus:border focus:!border-indigo-400'>
												<SelectValue placeholder='All Widgets' />
											</SelectTrigger>
											<SelectContent className='bg-white rounded-lg shadow-[0px_14px_20px_-10px_rgba(23,25,31,0.16)] border border-zinc-20'>
												{visibleCategories.map((category) => (
													<SelectItem
														key={category.id}
														value={category.id}
														className='text-zinc-900 text-sm'
													>
														{category.name}
													</SelectItem>
												))}
											</SelectContent>
										</Select>
									</div>
									<div className='flex items-center space-x-3 rounded-lg border border-zinc-200 px-3 py-2'>
										<span className='font-medium text-zinc-900 text-sm'>
											Enable All Widget
										</span>
										<Switch
											checked={allEnabled}
											onChange={toggleAll}
											disabled={saving}
										/>
									</div>
								</div>
							</div>
						</div>

						<div
							className={`space-y-8 transition-opacity duration-700 ease-in-out ${
								gridFade ? "opacity-100" : "opacity-0"
							}`}
							style={{ pointerEvents: gridFade ? "auto" : "none" }}
						>
							{selectedCategory === "all"
								? Object.entries(groupedWidgets).map(
										([categoryId, categoryWidgets]) => (
											<div
												className='bg-white rounded-lg mb-4 py-4 px-3.5'
												key={categoryId}
											>
												<h2 className='text-lg font-semibold text-gray-900 mb-4 !mt-0'>
													{getCategoryName(categoryId)} Widgets
												</h2>
												{renderGrid(categoryWidgets)}
											</div>
										),
									)
								: (
									<div className='bg-white rounded-lg mb-4 py-4 px-3.5'>
										<h2 className='text-lg font-semibold text-gray-900 mb-4 !mt-0'>
											{getCategoryName(selectedCategory)} Widgets
										</h2>
										{renderGrid(filteredWidgets)}
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
					</>
				)}
			</div>
		</div>
	);
};

export default Widgets;
