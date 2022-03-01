/**
 * Generate a random hex id to use with vue components.
 *
 * WARNING: This method does not use a secure random generator and isn't suited for
 * cryptographic purposes.
 *
 * @return {string} A random hex id
 */
 export function randomId() {
	return Math.random().toString(16).slice(2)
}