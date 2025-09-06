import React from "react";
import Switch from "./ui/Switch";

const WidgetCard = ({ widget, onToggle }) => {
	const getStatusBadge = (status) => {
		const badges = {
			new: { text: "NEW", color: "bg-blue-500" },
			update: { text: "UPDATE", color: "bg-green-500" },
			freemium: { text: "FREEMIUM", color: "bg-pink-500" },
			pro: { text: "PRO", color: "bg-orange-500" },
			normal: null,
		};

		const badge = badges[status];
		if (!badge) return null;

		return (
			<span
				className={`${badge.color} text-white text-xs px-2 py-1 rounded-full font-medium uppercase`}
			>
				{badge.text}
			</span>
		);
	};

	return (
		<div className='bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200 relative'>
			{/* Status Badge - Top Right */}
			{widget.status !== "normal" && (
				<div className='absolute top-3 right-3'>
					{getStatusBadge(widget.status)}
				</div>
			)}

			{/* Widget Icon and Toggle */}
			<div className='flex items-center justify-between mb-4'>
				<div className='w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-xl'>
					📝
				</div>
				<Switch
					checked={widget.enabled}
					onChange={(checked) => {
						console.log(`Toggle widget ${widget.id} to ${checked}`);
						onToggle(widget.id, checked);
					}}
					disabled={widget.status === "pro" && !widget.enabled}
				/>
			</div>

			{/* Widget Name */}
			<h3 className='font-medium text-gray-900 text-sm mb-3'>
				{widget.name}
			</h3>

			{/* Links */}
			<div className='flex items-center space-x-4 text-xs text-blue-600'>
				{widget.hasDemo && (
					<button className='hover:underline'>Live Demo</button>
				)}
				{widget.hasDocumentation && (
					<>
						<span className='text-gray-300'>•</span>
						<button className='hover:underline'>
							Documentation
						</button>
					</>
				)}
			</div>
		</div>
	);
};

export default WidgetCard;
