import { Link } from "react-router";

const Menu = () => {
	return (
		<ul className='flex items-center gap-4 ml-6'>
			<li>
				<Link
					to='/'
					className="text-black-500 text-sm font-medium font-['Inter'] leading-none hover:underline"
				>
					General
				</Link>
			</li>
			<li>
				<Link to='/widgets'>Widgets</Link>
			</li>
			<li>
				<Link to='/modules'>Modules</Link>
			</li>
			<li>
				<Link to='/settings'>Settings</Link>
			</li>
		</ul>
	);
};

export default Menu;
