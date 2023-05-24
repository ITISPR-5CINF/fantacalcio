//
// Libreria fantacalcio
//

/**
 * URL della API
 */
export const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

/**
 * Ottiene le informazioni dell'utente loggato
 * @returns {Promise<Object>} Le informazioni dell'utente loggato
 */
export async function getInfoUtente() {
    let response = await fetch(`${API_URL}/get_login_info.php`);
    if (!response.ok) {
        return null;
    }

    let utente = await response.json();
    return utente;
}

/**
 * Imposta il titolo della pagina
 * @param {string} title Il titolo della pagina
 */
export function setTitolo(title) {
    document.title = title;
}

const IMG_ROOT = "https://sport.virgilio.it/img/loghi"
const FIX_SQUADRA_IMG = {
	"Hellas Verona": "verona"
}

/**
 * Ottieni l'URL del logo della squadra
 * @param {string} nomeSquadra nome della squadra
 * @returns {string} URL del logo della squadra
 */
export function getLogoSquadra(nomeSquadra) {
    return `${IMG_ROOT}/${FIX_SQUADRA_IMG[nomeSquadra] || nomeSquadra.toLowerCase()}.svg`
}

/**
 * Ottieni informazioni su un utente
 * @param {number} utenteId ID dell'utente
 * @returns {Promise<Object>} Le informazioni dell'utente
 */
export async function getUtente(utenteId) {
    let response = await fetch(`${API_URL}/get_utente.php?utente_id=${utenteId}`);
    if (!response.ok) {
        return null;
    }

    let utente = await response.json();
    return utente;
}
