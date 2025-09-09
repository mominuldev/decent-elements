import { Link, useLocation } from "react-router";
import { useEffect, useState, useRef } from "react";

const Menu = () => {
	const location = useLocation();
	const [borderStyle, setBorderStyle] = useState({});
	const menuRef = useRef(null);

	const menuItems = [
		{ path: "/", label: "General" },
		{ path: "/widgets", label: "Widgets" },
		{ path: "/extensions", label: "Extensions" },
		{ path: "/settings", label: "Settings" },
	];

	const isActive = (path) => {
		if (path === "/") {
			return location.pathname === "/";
		}
		return location.pathname.startsWith(path);
	};

	useEffect(() => {
		const getActiveIndex = () => {
			return menuItems.findIndex((item) => isActive(item.path));
		};

		const activeIndex = getActiveIndex();
		if (activeIndex !== -1 && menuRef.current) {
			const activeItem = menuRef.current.children[activeIndex];
			if (activeItem) {
				const { offsetLeft, offsetWidth } = activeItem;
				setBorderStyle({
					transform: `translateX(${offsetLeft}px)`,
					width: `${offsetWidth}px`,
				});
			}
		}
	}, [location.pathname]);

	return (
		<div className='relative'>
			<ul ref={menuRef} className='flex items-center gap-8 ml-6'>
				{menuItems.map((item) => (
					<li key={item.path} className='relative !mb-0'>
						<Link
							to={item.path}
							className={`text-sm font-medium leading-none py-4.5 block transition-colors focus:!outline-0 focus:!shadow-[none] ${
								isActive(item.path)
									? "!text-blue-600"
									: "!text-zinc-900 hover:!text-blue-600"
							}`}
						>
							{item.label}
						</Link>
					</li>
				))}
			</ul>
			{/* Sliding border */}
			<div
				className='absolute bottom-0 h-[2px] bg-blue-600 transition-all duration-300 ease-in-out'
				style={borderStyle}
			></div>
		</div>
	);
};

export default Menu;
