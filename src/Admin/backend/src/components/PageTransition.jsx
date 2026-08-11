import React, { useState, useEffect } from "react";
import { useLocation } from "react-router";

const PageTransition = ({ children }) => {
	const [isVisible, setIsVisible] = useState(false);
	const location = useLocation();

	useEffect(() => {
		// Fade out
		setIsVisible(false);

		// Fade in after a short delay
		const timer = setTimeout(() => {
			setIsVisible(true);
		}, 100);

		return () => clearTimeout(timer);
	}, [location.pathname]);

	return (
		<div
			className={`transition-opacity duration-300 ease-in-out ${
				isVisible ? "opacity-100" : "opacity-0"
			}`}
		>
			{children}
		</div>
	);
};

export default PageTransition;
