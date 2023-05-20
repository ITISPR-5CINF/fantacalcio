import { API_URL, getInfoUtente } from "./lib.js";

let infoFantalegaElement = document.getElementById("info-fantalega");
let listaFantasquadreElement = document.getElementById("lista-fantasquadre");

async function main() {
    let utente = await getInfoUtente();

    let params = new URLSearchParams(window.location.search);

	if (!params.has('fantalega_id')) {
        infoFantalegaElement.innerHTML = `ID fantalega non specificato`;
		return;
	}

    let fantalega_id = params.get('fantalega_id');

    let response = await fetch(`${API_URL}/get_fantalega.php?fantalega_id=${fantalega_id}`);
    if (!response.ok) {
        infoFantalegaElement.innerText = "Questa fantalega non esiste";
    }

    let fantalega = await response.json();

    infoFantalegaElement.innerHTML = `
        <h2>${fantalega.nome}</h2>
        <p>Nome: ${fantalega.nome}</p>
    `

    // Ottieni la lista di squadre
    let fantasquadre = [];
    response = await fetch(`${API_URL}/get_fantasquadre.php?fantalega_id=${fantalega_id}`);
    if (response.ok) {
        fantasquadre = await response.json();
    }

    let html = `
        <h2>Squadre ${
            utente && utente.utente_id == fantalega.admin_id ? `
                <a href="invita_utente.html?fantalega_id=${fantalega_id}">Invita</a>
            ` : ``
        }
        </h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Utente</th>
            </tr>
    `;
    if (fantasquadre.length > 0) {
        for (let fantasquadra of fantasquadre) {
            html += `
                <tr>
                    <td>${fantasquadra.nome}</td>
                    <td>${fantasquadra.utente}</td>
                </tr>
            `;
        }
    } else {
        html += `
            <tr>
                <td colspan="2">Nessuna squadra</td>
            </tr>
        `;
    }
    html += "</table>";

    listaFantasquadreElement.innerHTML = html;
}

main();
