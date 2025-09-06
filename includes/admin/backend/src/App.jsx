import { Button } from "@/components/ui/button";
import Navbar from "@/components/Navbar";
import { Routes, Route } from "react-router";
import General from "@/pages/General";
import Widgets from "@/pages/Widgets";
import Modules from "@/pages/Modules";
import Settings from "@/pages/Settings";
import { ToastProvider } from "@/components/ui/ToastProvider";

function App() {
	return (
		<ToastProvider>
			<div>
				<Navbar />
				<main>
					<Routes>
						<Route
							path='/'
							element={
								<div className='container py-8 px-1'>
									<General />
								</div>
							}
						/>
						<Route path='/widgets' element={<Widgets />} />
						<Route
							path='/modules'
							element={
								<div className='container py-8 px-1'>
									<Modules />
								</div>
							}
						/>
						<Route
							path='/settings'
							element={
								<div className='container py-8 px-1'>
									<Settings />
								</div>
							}
						/>
					</Routes>
				</main>
			</div>
		</ToastProvider>
	);
}

export default App;
