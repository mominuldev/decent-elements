/**
 * Single REST client for the admin panel.
 *
 * Every page previously hand-rolled its own fetch: its own base-URL fallback,
 * its own nonce lookup, its own AbortController, its own error handling. Four
 * copies that drifted. This is the one place any of that lives.
 */

const globals = typeof window !== "undefined" ? window.decentElements : undefined;

/** REST root, without a trailing slash. */
const API_BASE = (globals?.apiUrl || "/wp-json/decent-elements/v1").replace(
	/\/$/,
	"",
);

/** REST nonce. Requests without it are rejected by WordPress. */
const NONCE = globals?.nonce || "";

/** Requests that outlive this are aborted rather than hanging the UI. */
const TIMEOUT_MS = 15000;

/**
 * Error carrying the HTTP status, so callers can distinguish a 403 from a 500.
 */
export class ApiError extends Error {
	constructor(message, { status = 0, data = null } = {}) {
		super(message);
		this.name = "ApiError";
		this.status = status;
		this.data = data;
	}
}

async function request(path, { method = "GET", body, signal } = {}) {
	const controller = new AbortController();
	const timeout = setTimeout(() => controller.abort(), TIMEOUT_MS);

	// Honour a caller-supplied signal alongside the timeout.
	if (signal) {
		signal.addEventListener("abort", () => controller.abort(), { once: true });
	}

	try {
		const response = await fetch(`${API_BASE}${path}`, {
			method,
			headers: {
				"Content-Type": "application/json",
				"X-WP-Nonce": NONCE,
			},
			body: body === undefined ? undefined : JSON.stringify(body),
			signal: controller.signal,
		});

		const text = await response.text();
		let payload = null;

		if (text) {
			try {
				payload = JSON.parse(text);
			} catch {
				payload = null;
			}
		}

		if (!response.ok) {
			throw new ApiError(
				payload?.message || `Request failed (${response.status})`,
				{ status: response.status, data: payload },
			);
		}

		return payload;
	} catch (error) {
		if (error.name === "AbortError") {
			throw new ApiError("The request timed out. Please try again.", {
				status: 0,
			});
		}
		if (error instanceof ApiError) {
			throw error;
		}
		throw new ApiError(
			"Could not reach the server. Please check your connection.",
			{ status: 0 },
		);
	} finally {
		clearTimeout(timeout);
	}
}

export const api = {
	/**
	 * Everything the panel needs to render: categories, widgets, extensions.
	 *
	 * This replaces the checked-in widgets.json. That file listed 47 widgets
	 * against 7 real ones, so most of its toggles wrote ids the server discarded
	 * while the UI still reported success.
	 */
	getRegistry: (signal) => request("/registry", { signal }),

	getWidgets: (signal) => request("/widgets", { signal }),
	getExtensions: (signal) => request("/extensions", { signal }),

	/** @param {Record<string, boolean>} states Keyed by bare module id. */
	saveWidgets: (states) => request("/widgets", { method: "POST", body: states }),

	/** @param {Record<string, boolean>} states Keyed by bare module id. */
	saveExtensions: (states) =>
		request("/extensions", { method: "POST", body: states }),

	getOptimization: (signal) => request("/settings/optimization", { signal }),
	setOptimization: (enabled) =>
		request("/settings/optimization", {
			method: "POST",
			body: { enabled },
		}),
	getOptimizationStats: (signal) => request("/optimization/stats", { signal }),
	generateOptimizedAssets: () =>
		request("/optimization/generate", { method: "POST" }),
	clearOptimizedAssets: () =>
		request("/optimization/clear", { method: "POST" }),
};

export default api;
