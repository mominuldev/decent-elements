import Menu from "./Menu";
import { Button } from "@/components/ui/button";
import {
	Drawer,
	DrawerClose,
	DrawerContent,
	DrawerDescription,
	DrawerFooter,
	DrawerHeader,
	DrawerTitle,
	DrawerTrigger,
} from "@/components/ui/drawer";

const Navbar = () => {
	// Get the plugin base URL from WordPress
	const baseUrl = window.decentElements?.baseUrl || "";
	const logoUrl = `${baseUrl}includes/admin/assets/js/decent-logo.svg`;
	const ProIcon = `${baseUrl}includes/admin/assets/js/crown-icon.svg`;
	const PromotIcon = `${baseUrl}includes/admin/assets/js/mike-icon.svg`;
	// const logoUrl = `https://decentelements.com/wp-content/uploads/2024/05/decent-logo.svg`; // For testing purpose

	return (
		<div className='bg-white h-[50px] mb-10 shadow-[0px_4px_6px_-4px_rgba(23,25,31,0.10)]'>
			<div className='max-w-[1200px] mx-auto'>
				<div className='flex items-center justify-between gap-2 '>
					<div className='flex items-center'>
						<img
							src={logoUrl}
							alt='Logo'
							className='max-w-[150px]'
						/>
						<Menu />
					</div>

					<div className='flex items-center gap-4'>
						<p className='text-zinc-600 text-sm pr-3 border-r border-gray-300 border-solid !my-0'>
							Free Version:{" "}
							<span className='text-zinc-900 text-sm font-medium bg-slate-100 rounded-sm px-1 py-[2px]'>
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

						<Drawer direction='right'>
							<DrawerTrigger className='w-8 h-8 bg-white rounded-full border border-gray-200 border-solid flex items-center justify-center transition-all duration-300 ease-in-out hover:bg-slate-100 cursor-pointer'>
								<img
									src={PromotIcon}
									alt='Promote Icon'
									className='w-4 h-4 !ml-0'
								/>
							</DrawerTrigger>
							<DrawerContent className='max-w-70'>
								<DrawerHeader>
									<DrawerTitle>
										Are you absolutely sure?
									</DrawerTitle>
									<DrawerDescription>
										This action cannot be undone.
									</DrawerDescription>
								</DrawerHeader>
								<DrawerFooter>
									<Button>Submit</Button>
									<DrawerClose>
										<Button variant='outline'>
											Cancel
										</Button>
									</DrawerClose>
								</DrawerFooter>
							</DrawerContent>
						</Drawer>
					</div>
				</div>
			</div>
		</div>
	);
};

export default Navbar;
