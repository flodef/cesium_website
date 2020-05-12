
/**
 * Open the menu, when click on the menu header button
 */
function openMenu() {

	var menu = document.querySelector("header nav ul");
	var maxHeight = (menu.childElementCount * 2 + 1) + "rem";

	if (menu.style.height != maxHeight) {
		menu.style.height = maxHeight;

	} else {
		menu.style.height = "0rem";
	}
}
document.querySelector("header nav button").addEventListener("click", openMenu);

/**
 * Detect if URL has a Cesium pattern (like '#/app/xxx'), then redirect to https://demo.cesium.app.
 * (Useful for OLD links http://g1.duniter.fr/#/app/xxx )
 */
function detectCesiumHash() {
	// Workaround to add String.startsWith() if not present
	if (typeof String.prototype.startsWith !== 'function') {
		console.debug("Adding String.prototype.startsWith() -> was missing on this platform");
		String.prototype.startsWith = function (prefix, position) {
			return this.indexOf(prefix, position) === 0;
		};
	}

	console.debug("[app] Trying to detect Cesium hash in '#/app/' in URL...");
	try {
		var hash = window.location.hash;
		if (hash && hash.startsWith('#/app/')) {
			var demoUrl = "https://demo.cesium.app/" + hash;
			console.debug("[app] Cesium hash detected! Redirect to: " + demoUrl);
			window.location = demoUrl;
		}
	} catch (err) {
		console.error(err);
	}
}

detectCesiumHash();
