export const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

export async function getInfoUtente() {
    let response = await fetch(`${API_URL}/get_login_info.php`);
    if (!response.ok) {
        return null;
    }

    let utente = await response.json();
    return utente;
}
