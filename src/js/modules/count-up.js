// Count-up animation for stat numbers (Advertising page). Each element tagged with
// [data-countup] keeps its final value in the HTML (so no-JS and screen readers get
// the real number); on first scroll into view it animates from 0 up to that value,
// preserving the original format — decimal places and any prefix/suffix (M, K, %).

const SELECTOR = '[data-countup]';
const DURATION = 1500; // ms

// Split "4.7M" → { prefix:'', value:4.7, decimals:1, suffix:'M' }.
function parseValue(text) {
	const match = String(text).trim().match(/^(\D*)([\d.,]+)(.*)$/);
	if (!match) return null;
	const [, prefix, numStr, suffix] = match;
	const decimals = numStr.includes('.') ? numStr.split('.')[1].length : 0;
	const value = parseFloat(numStr.replace(/,/g, ''));
	if (Number.isNaN(value)) return null;
	return { prefix, value, decimals, suffix };
}

function formatValue(n, parsed) {
	return parsed.prefix + n.toFixed(parsed.decimals) + parsed.suffix;
}

function easeOutCubic(t) {
	return 1 - Math.pow(1 - t, 3);
}

function animate(el) {
	const parsed = el._countup;
	const start = performance.now();

	function tick(now) {
		const t = Math.min(1, (now - start) / DURATION);
		el.textContent = formatValue(parsed.value * easeOutCubic(t), parsed);
		if (t < 1) {
			requestAnimationFrame(tick);
		} else {
			el.textContent = formatValue(parsed.value, parsed);
		}
	}

	requestAnimationFrame(tick);
}

function initCountUp(scope = document) {
	const els = scope.querySelectorAll(SELECTOR);
	if (!els.length) return;

	const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	// No IntersectionObserver (or reduced motion): leave the final values as-is.
	if (reduce || typeof IntersectionObserver === 'undefined') return;

	const observer = new IntersectionObserver(
		(entries, obs) => {
			entries.forEach((entry) => {
				if (!entry.isIntersecting) return;
				animate(entry.target);
				obs.unobserve(entry.target);
			});
		},
		{ threshold: 0.4 }
	);

	els.forEach((el) => {
		const parsed = parseValue(el.textContent);
		if (!parsed) return;
		el._countup = parsed;
		el.textContent = formatValue(0, parsed); // start from zero
		observer.observe(el);
	});
}

export { initCountUp };
