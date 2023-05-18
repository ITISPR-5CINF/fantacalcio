import { API_URL, getInfoUtente } from "./lib.js";

let mainContentElement = document.getElementById("main-content");

async function main() {
    let utente = await getInfoUtente();
    if (utente == null) {
        mainContentElement.innerHTML = `
            <h2>Non sei loggato</h2>
            <p><a href="login.html">Effettua il login</a></p>
        `;
        return;
    }

    // Ottieni la lista di fantaleghe a cui l'utente partecipa
    let response = await fetch(`${API_URL}/get_fantaleghe_utente.php`);
    if (!response.ok) {
        return;
    }

    let fantaleghe = await response.json();

    let html = `
        <h1>Ciao ${utente.nome}!</h1>
        <h2>Le tue fantaleghe</h2>
    `;

    if (fantaleghe.length > 0) {
        for (let fantalega of fantaleghe) {
            html += `
                <div>
                    <a href="fantalega.html?id=${fantalega.fantalega_id}">${fantalega.nome}</a>
                </div>
            `;
        }
    } else {
        html += `
            <p>Non partecipi a nessuna fantalega</p>
        `;
    }

    mainContentElement.innerHTML = html;
}

main();
