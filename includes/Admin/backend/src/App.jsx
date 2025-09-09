import { Button } from "@/components/ui/button";
import Navbar from "@/components/Navbar";
import { Routes, Route } from "react-router";
import General from "@/pages/General";
import Widgets from "@/pages/Widgets";
import Modules from "@/pages/Modules";
import Extensions from "@/pages/Extensions";
import Settings from "@/pages/Settings";
import { ToastProvider } from "@/components/ui/ToastProvider";
import PageTransition from "@/components/PageTransition";

function App() {
	return (
		<ToastProvider>
			<div>
				<Navbar />
				<main className='bg-[#EEEFF4]'>
					<PageTransition>
						<Routes>
							<Route path='/' element={<General />} />
							<Route path='/widgets' element={<Widgets />} />
							<Route
								path='/extensions'
								element={<Extensions />}
							/>
							<Route path='/settings' element={<Settings />} />
						</Routes>
					</PageTransition>
				</main>
			</div>
		</ToastProvider>
	);
}

export default App;
