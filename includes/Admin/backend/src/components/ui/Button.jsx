import React from 'react';

const Button = ({
	children,
	onClick,
	type = 'button',
	variant = 'default',
	size = 'default',
	disabled = false,
	className = '',
	...props
}) => {
	const baseClasses = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 outline-none focus:ring-2 focus:ring-blue-500';

	const variantClasses = {
		default: 'bg-blue-600 text-white shadow hover:bg-blue-700',
		destructive: 'bg-red-600 text-white shadow hover:bg-red-700',
		outline: 'border border-gray-300 bg-white shadow hover:bg-gray-50 hover:text-gray-900',
		secondary: 'bg-gray-200 text-gray-900 shadow hover:bg-gray-300',
		ghost: 'hover:bg-gray-100 hover:text-gray-900',
		link: 'text-blue-600 underline-offset-4 hover:underline'
	};

	const sizeClasses = {
		default: 'h-9 px-4 py-2',
		sm: 'h-8 px-3 py-1.5 text-xs',
		lg: 'h-10 px-6 py-2.5',
		icon: 'h-9 w-9'
	};

	const classes = `${baseClasses} ${variantClasses[variant]} ${sizeClasses[size]} ${className}`;

	return (
		<button
			type={type}
			onClick={onClick}
			disabled={disabled}
			className={classes}
			{...props}
		>
			{children}
		</button>
	);
};

export default Button;
