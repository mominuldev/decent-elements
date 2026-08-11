import { useCallback, useEffect, useRef, useState } from "react";
import api from "@/api/client";
import { useToast } from "@/hooks/useToast";

/**
 * Loads the module registry and persists toggles.
 *
 * The registry is served by PHP, so the admin panel and the plugin can no
 * longer disagree about which widgets exist. Only real modules are returned,
 * which is what removes the 42 toggles that used to silently do nothing.
 *
 * @param {"widgets"|"extensions"} kind Which module type to manage.
 */
export function useRegistry(kind) {
	const [categories, setCategories] = useState([]);
	const [items, setItems] = useState([]);
	const [loading, setLoading] = useState(true);
	const [saving, setSaving] = useState(false);
	const { showSuccess, showError } = useToast();

	// Guards against a state update after unmount.
	const mounted = useRef(true);
	useEffect(() => {
		mounted.current = true;
		return () => {
			mounted.current = false;
		};
	}, []);

	const load = useCallback(
		async (signal) => {
			try {
				setLoading(true);
				const payload = await api.getRegistry(signal);
				if (!mounted.current) return;

				setCategories(payload?.data?.categories ?? []);
				setItems(payload?.data?.[kind] ?? []);
			} catch (error) {
				if (mounted.current) showError(error.message);
			} finally {
				if (mounted.current) setLoading(false);
			}
		},
		[kind, showError],
	);

	useEffect(() => {
		const controller = new AbortController();
		load(controller.signal);
		return () => controller.abort();
	}, [load]);

	/**
	 * Toggle one module.
	 *
	 * Sends only the module that changed. The previous implementation POSTed
	 * the entire set on every toggle.
	 */
	const toggle = useCallback(
		async (id, enabled) => {
			const item = items.find((entry) => entry.id === id);
			const label = item?.name ?? "Module";
			const previous = items;

			setItems((current) =>
				current.map((entry) =>
					entry.id === id ? { ...entry, enabled } : entry,
				),
			);
			setSaving(true);

			try {
				const save = kind === "widgets" ? api.saveWidgets : api.saveExtensions;
				await save({ [id]: enabled });
				showSuccess(`${label} ${enabled ? "enabled" : "disabled"}.`);
				return true;
			} catch (error) {
				setItems(previous);
				showError(`Could not update ${label}. ${error.message}`);
				return false;
			} finally {
				if (mounted.current) setSaving(false);
			}
		},
		[items, kind, showSuccess, showError],
	);

	/** Toggle every module of this kind in one request. */
	const toggleAll = useCallback(
		async (enabled) => {
			const previous = items;
			const states = Object.fromEntries(
				items.map((entry) => [entry.id, enabled]),
			);

			setItems((current) => current.map((entry) => ({ ...entry, enabled })));
			setSaving(true);

			try {
				const save = kind === "widgets" ? api.saveWidgets : api.saveExtensions;
				await save(states);
				showSuccess(
					`All ${items.length} ${kind} ${enabled ? "enabled" : "disabled"}.`,
				);
				return true;
			} catch (error) {
				setItems(previous);
				showError(error.message);
				return false;
			} finally {
				if (mounted.current) setSaving(false);
			}
		},
		[items, kind, showSuccess, showError],
	);

	return { categories, items, loading, saving, toggle, toggleAll, reload: load };
}

export default useRegistry;
