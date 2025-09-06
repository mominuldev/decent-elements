import { useState, useCallback } from "react";
import Toast from "./Toast";
import { ToastContext } from "../../contexts/ToastContext";

export const ToastProvider = ({ children }) => {
	const [toasts, setToasts] = useState([]);

	const addToast = useCallback(
		(message, type = "success", duration = 3000) => {
			const id = Date.now() + Math.random();
			const newToast = { id, message, type, duration };

			setToasts((prev) => [...prev, newToast]);
		},
		[],
	);

	const removeToast = useCallback((id) => {
		setToasts((prev) => prev.filter((toast) => toast.id !== id));
	}, []);

	const showSuccess = useCallback(
		(message) => {
			addToast(message, "success");
		},
		[addToast],
	);

	const showError = useCallback(
		(message) => {
			addToast(message, "error");
		},
		[addToast],
	);

	const showWarning = useCallback(
		(message) => {
			addToast(message, "warning");
		},
		[addToast],
	);

	const showInfo = useCallback(
		(message) => {
			addToast(message, "info");
		},
		[addToast],
	);

	const value = {
		showSuccess,
		showError,
		showWarning,
		showInfo,
	};

	return (
		<ToastContext.Provider value={value}>
			{children}
			<div className='fixed top-10 right-5 z-50 flex flex-col items-end space-y-2.5 pointer-events-none'>
				{toasts.map((toast) => (
					<div key={toast.id} className='pointer-events-auto'>
						<Toast
							message={toast.message}
							type={toast.type}
							duration={toast.duration}
							onClose={() => removeToast(toast.id)}
						/>
					</div>
				))}
			</div>
		</ToastContext.Provider>
	);
};
