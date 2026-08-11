import React, { useEffect, useMemo, useState } from "react";
import Switch from "@/components/ui/Switch";
import { useRegistry } from "@/hooks/useRegistry";

/**
 * Extension management screen.
 *
 * Driven by the PHP module registry, like the widgets screen. The previous
 * implementation seeded state from a checked-in JSON file, hand-rolled its own
 * fetch, and debounced saves through a 300 ms timer that could fire after
 * unmount.
 */
const Extensions = () => {
	const { items, loading, saving, toggle } = useRegistry("extensions");
	const [fadeIn, setFadeIn] = useState(false);

	useEffect(() => {
		const timer = setTimeout(() => setFadeIn(true), 50);
		return () => clearTimeout(timer);
	}, []);

	const enabledCount = useMemo(
		() => items.filter((extension) => extension.enabled).length,
		[items],
	);

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
								Extend your website&apos;s functionality with these
								powerful extensions.
							</p>
						</div>
						<div className='text-right'>
							<div className='text-sm text-gray-500'>
								{enabledCount} of {items.length} enabled
							</div>
						</div>
					</div>
				</div>

				{/* Grid */}
				<div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2'>
					{items.map((extension, index) => (
						<div
							key={extension.id}
							className={`bg-white py-4 px-6 rounded-md hover:shadow-md transition-all duration-300 ${
								extension.enabled
									? "ring-2 ring-blue-100 border-blue-200"
									: ""
							}`}
							style={{ animationDelay: `${index * 50}ms` }}
						>
							<div className='flex items-start justify-between mb-4'>
								<div className='flex items-center gap-3'>
									<div className='text-2xl' title={extension.name}>
										{extension.icon}
									</div>
									<div>
										<h3 className='font-semibold text-gray-900 text-base !my-0'>
											{extension.name}
										</h3>
									</div>
								</div>
								<Switch
									checked={extension.enabled}
									onChange={(checked) =>
										toggle(extension.id, checked)
									}
									disabled={saving}
								/>
							</div>

							{extension.docsLink && (
								<div className='space-y-3'>
									<a
										href={extension.docsLink}
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

							<div className='mt-4 pt-4 border-t border-gray-100'>
								<span
									className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
										extension.enabled
											? "bg-green-100 text-green-800"
											: "bg-gray-100 text-gray-800"
									}`}
								>
									{extension.enabled ? "Enabled" : "Disabled"}
								</span>
							</div>
						</div>
					))}
				</div>
			</div>
		</div>
	);
};

export default Extensions;
