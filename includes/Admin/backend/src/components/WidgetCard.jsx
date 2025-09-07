import Switch from "./ui/Switch";
import { Link } from "react-router";

const WidgetCard = ({ widget, onToggle }) => {
	const getStatusBadge = (status) => {
		const badges = {
			new: {
				text: "NEW",
				color: " bg-blue-500/10 inline-flex justify-center text-blue-500 text-xs font-semibold uppercase",
			},
			update: { text: "UPDATE", color: "bg-green-600/10 text-green-600" },
			freemium: {
				text: "FREEMIUM",
				color: "bg-rose-500/10 text-rose-500",
			},
			pro: { text: "PRO", color: "bg-orange-400/10 text-orange-400" },
			normal: null,
		};

		const badge = badges[status];
		if (!badge) return null;

		return (
			<span
				className={`${badge.color} px-2 py-[5px] text-xs font-semibold uppercase rounded-3xl leading-2`}
			>
				{badge.text}
			</span>
		);
	};

	return (
		<div className='bg-white rounded-md p-4 relative transition duration-300 ease-in-out hover:shadow-[0px_14px_20px_-10px_rgba(23,25,31,0.16)] hover:outline hover:outline-1 hover:outline-zinc-200 transition-shadow duration-200'>
			<div className='flex items-center justify-between mb-2'>
				<div className='text-xl'>{widget.icon}</div>
				{/* Widget Icon and Toggle */}
				<div className='flex gap-1 items-center justify-between'>
					{/* Status Badge - Top Right */}
					{widget.status !== "normal" &&
						getStatusBadge(widget.status)}
					<Switch
						checked={widget.enabled}
						onChange={(checked) => {
							console.log(
								`Toggle widget ${widget.id} to ${checked}`,
							);
							onToggle(widget.id, checked);
						}}
						disabled={widget.status === "pro" && !widget.enabled}
					/>
				</div>
			</div>

			{/* Widget Name */}
			<h3 className='!font-medium !text-gray-900 !text-sm !my-0 '>
				{widget.name}
			</h3>

			{/* Links */}
			<div className='flex items-center space-x-1 text-xs text-blue-600'>
				{widget.hasDemo && (
					<Link
						to={widget.demoLink}
						target='_blank'
						className='!text-neutral-400 text-xs font-medium hover:!text-blue-500'
					>
						Live Demo
					</Link>
				)}
				{widget.hasDocumentation && (
					<>
						<span className='text-gray-300'>•</span>
						<Link
							to={widget.docsLinks}
							className='!text-neutral-400 text-xs font-medium hover:!text-blue-500'
						>
							Documentation
						</Link>
					</>
				)}
			</div>
		</div>
	);
};

export default WidgetCard;
