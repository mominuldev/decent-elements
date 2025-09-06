import React, { useState, useEffect } from "react";

const Toast = ({ message, type = "success", duration = 3000, onClose }) => {
	const [isVisible, setIsVisible] = useState(true);

	useEffect(() => {
		const timer = setTimeout(() => {
			setIsVisible(false);
			setTimeout(onClose, 300); // Wait for animation to complete
		}, duration);

		return () => clearTimeout(timer);
	}, [duration, onClose]);

	const getToastStyles = () => {
		const baseStyles =
			"fixed top-8 right-2 z-50 px-3 py-4 rounded-lg shadow-lg flex items-center space-x-2 transition-all duration-300 transform";

		const typeStyles = {
			success: "bg-white bg-green-500",
			error: "text-red-500 bg-white",
			warning: "bg-yellow-500 text-white",
			info: "bg-blue-500 text-white",
		};

		const visibilityStyles = isVisible
			? "translate-x-0 opacity-100"
			: "translate-x-full opacity-0";

		return `${baseStyles} ${typeStyles[type]} ${visibilityStyles}`;
	};

	const getIcon = () => {
		const icons = {
			success: (
				<svg
					className='w-5 h-5 p-0.5 text-white bg-green-500 rounded-full text-sm'
					fill='none'
					stroke='white'
					viewBox='0 0 24 24'
				>
					<path
						strokeLinecap='round'
						strokeLinejoin='round'
						strokeWidth={2}
						d='M5 13l4 4L19 7'
					/>
				</svg>
			),
			error: (
				<svg
					className='w-5 h-5 p-0.5 bg-red-500 text-white rounded-full'
					fill='none'
					stroke='white'
					viewBox='0 0 24 24'
				>
					<path
						strokeLinecap='round'
						strokeLinejoin='round'
						strokeWidth={2}
						d='M6 18L18 6M6 6l12 12'
					/>
				</svg>
			),
			warning: (
				<svg
					className='w-5 h-5 p-0.5 bg-yellow-500 text-white rounded-full'
					fill='none'
					stroke='white'
					viewBox='0 0 24 24'
				>
					<path
						strokeLinecap='round'
						strokeLinejoin='round'
						strokeWidth={2}
						d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.864-.833-2.634 0L3.098 16.5c-.77.833.192 2.5 1.732 2.5z'
					/>
				</svg>
			),
			info: (
				<svg
					className='w-5 h-5 bg-blue-500 text-white rounded-full'
					fill='none'
					stroke='white'
					viewBox='0 0 24 24'
				>
					<path
						strokeLinecap='round'
						strokeLinejoin='round'
						strokeWidth={2}
						d='M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
					/>
				</svg>
			),
		};

		return icons[type];
	};

	const getCloseButtonStyles = () => {
		const styles = {
			success: "text-green-500 hover:text-green-700",
			error: "text-red-500 hover:text-red-700",
			warning: "text-white hover:text-gray-200",
			info: "text-white hover:text-gray-200",
		};
		return styles[type];
	};

	return (
		<div className={getToastStyles()}>
			<div className='flex-shrink-0'>{getIcon()}</div>
			<div className='flex-1'>
				<p className='text-sm font-medium !my-0'>{message}</p>
			</div>
			<button
				onClick={() => {
					setIsVisible(false);
					setTimeout(onClose, 300);
				}}
				className={`flex-shrink-0 ml-2 transition-colors cursor-pointer ${getCloseButtonStyles()}`}
			>
				<svg
					className='w-4 h-4'
					fill='none'
					stroke='currentColor'
					viewBox='0 0 24 24'
				>
					<path
						strokeLinecap='round'
						strokeLinejoin='round'
						strokeWidth={2}
						d='M6 18L18 6M6 6l12 12'
					/>
				</svg>
			</button>
		</div>
	);
};

export default Toast;
