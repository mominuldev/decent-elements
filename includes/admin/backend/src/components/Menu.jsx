import { Link, useLocation } from "react-router";

const Menu = () => {
	const location = useLocation();

	const menuItems = [
		{ path: "/", label: "General" },
		{ path: "/widgets", label: "Widgets" },
		{ path: "/modules", label: "Extensions" },
		{ path: "/settings", label: "Settings" },
	];

	const isActive = (path) => {
		if (path === "/") {
			return location.pathname === "/";
		}
		return location.pathname.startsWith(path);
	};

	return (
		<ul className='flex items-center gap-8 ml-6'>
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
					{isActive(item.path) && (
						<div className='absolute bottom-0 left-0 w-full h-[1px] bg-blue-600'></div>
					)}
				</li>
			))}
		</ul>
	);
};

export default Menu;
