//
// Libreria fantacalcio
//

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
