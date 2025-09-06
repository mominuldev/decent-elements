import React from "react";

const Switch = ({ checked, onChange, disabled = false, size = "default" }) => {
	const sizeClasses = {
		small: "w-8 h-4",
		default: "w-11 h-6",
		large: "w-14 h-7",
	};

	const thumbSizeClasses = {
		small: "w-3 h-3",
		default: "w-5 h-5",
		large: "w-6 h-6",
	};

	const translateClasses = {
		small: checked ? "translate-x-4" : "translate-x-0",
		default: checked ? "translate-x-5" : "translate-x-0",
		large: checked ? "translate-x-7" : "translate-x-0",
	};

	return (
		<button
			type='button'
			className={`
        ${sizeClasses[size]}
        ${checked ? "bg-blue-600" : "bg-gray-200"}
        ${disabled ? "opacity-50 cursor-not-allowed" : "cursor-pointer"}
        relative inline-flex items-center rounded-full border-2 border-transparent 
        transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 
        focus:ring-blue-500 focus:ring-offset-2
      `}
			role='switch'
			aria-checked={checked}
			onClick={() => !disabled && onChange(!checked)}
			disabled={disabled}
		>
			<span
				aria-hidden='true'
				className={`
          ${thumbSizeClasses[size]}
          ${translateClasses[size]}
          pointer-events-none inline-block rounded-full bg-white shadow 
          transform ring-0 transition ease-in-out duration-200
        `}
			/>
		</button>
	);
};

export default Switch;
