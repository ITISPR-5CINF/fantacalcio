import { API_URL } from "./lib.js";

let mainContentElement = document.getElementById("main-content");

async function main() {
    // Ottieni informazioni sull'utente
    let accountInfo = null;

    let response = await fetch(`${API_URL}/get_login_info.php`);
    if (response.ok) {
        accountInfo = await response.json();
    }

    if (!accountInfo) {
        // Redirect a login
        location.href = "login.html";
        return;
    }

    // Inserisci le informazioni dell'utente nella pagina
    mainContentElement.innerHTML = `
        <h2>Informazioni account</h2>
        <p>Username: ${accountInfo.username}</p>
        <p>Nome: ${accountInfo.nome}</p>
        <p>Cognome: ${accountInfo.cognome}</p>
        <p>Email: ${accountInfo.email}</p>
    `;
}

main();
