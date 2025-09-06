import React from "react";

const Switch = ({ checked, onChange, disabled = false, size = "small" }) => {
	const sizeClasses = {
		small: "w-8 h-4.5",
		default: "w-11 h-6",
		large: "w-14 h-7",
	};

	const thumbSizeClasses = {
		small: "w-3.5 h-3.5",
		default: "w-5 h-5",
		large: "w-6 h-7",
	};

	const translateClasses = {
		small: checked ? "translate-x-3.5" : "translate-x-0",
		default: checked ? "translate-x-5" : "translate-x-0",
		large: checked ? "translate-x-7" : "translate-x-0",
	};

	return (
		<button
			type='button'
			className={`
        ${sizeClasses[size]}
        ${checked ? "bg-blue-600" : "bg-slate-300"}
        ${disabled ? "opacity-50 cursor-not-allowed" : "cursor-pointer"}
        relative inline-flex items-center rounded-full border-2 border-transparent 
        transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 
        focus:ring-blue-500 focus:ring-offset-0 focus:outline-0 focus:shadow-[none]
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
          pointer-events-none inline-block bg-gradient-to-b from-white to-zinc-200 rounded-full shadow-[0px_4px_6px_-2px_rgba(23,25,31,0.40)] border border-white 
          transform ring-0 transition ease-in-out duration-200
        `}
			/>
		</button>
	);
};

export default Switch;
