import Logo from "/logo.png";
import ProIcon from "/crown-icon.svg";
import PromotIcon from "/mike-icon.svg";
import Menu from "./Menu";

const Navbar = () => {
	return (
		<div className='bg-white p-2 mb-4 shadow-[0px_4px_6px_-4px_rgba(23,25,31,0.10)]'>
			<div className='container max-w-[1200px] mx-auto'>
				<div className='flex items-center justify-between gap-2 '>
					<div className='flex items-center'>
						<img src={Logo} alt='Logo' className='' />
						<Menu />
					</div>

					<div className='flex items-center gap-4'>
						<p className='text-zinc-600 text-sm pr-3 border-r border-gray-300 border-solid '>
							Free Version:{" "}
							<span className='text-zinc-900 text-sm font-medium bg-slate-100 rounded-md px-1 py-[5px]'>
								1.0.0
							</span>
						</p>

						<a
							href='https://decentelements.com'
							target='_blank'
							rel='noreferrer'
							className='!text-fuchsia-600 text-sm font-medium flex items-center underline'
						>
							<img
								src={ProIcon}
								alt='Pro Icon'
								className='w-4 h-4 mr-1'
							/>
							Upgrade to PRO
						</a>

						<a
							href='https://decentelements.com'
							target='_blank'
							rel='noreferrer'
							className='w-8 h-8 bg-white rounded-full border border-gray-200 border-solid flex items-center justify-center'
						>
							<img
								src={PromotIcon}
								alt='Promote Icon'
								className='w-4 h-4 mr-1'
							/>
						</a>
					</div>
				</div>
			</div>
		</div>
	);
};

export default Navbar;
