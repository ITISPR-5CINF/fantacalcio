const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

let listaGiocatoriElement = document.getElementById("lista_giocatori");

async function main() {
    let	response = await fetch(`${API_URL}/get_giocatori.php`);
	if (!response.ok) {
		listaSquadreElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

    giocatori = await response.json();

    let html = `
		<h2>Giocatori</h2>
		<table>
			<tr>
				<th>Cognome Nome</th>
				<th>Data di nascita</th>
				<th>Posizione</th>
				<th>Crediti iniziali</th>
				<th>Crediti finali</th>
				<th>Nazionalità</th>
			</tr>
	`;

    for (let giocatore of giocatori) {
		html += `
			<tr>
				<td>${giocatore.cognome_nome}</td>
				<td>${giocatore.data_nascita}</td>
				<td>${giocatore.posizione}</td>
				<td>${giocatore.crediti_iniziali}</td>
				<td>${giocatore.crediti_finali}</td>
				<td>${giocatore.nazionalita}</td>
			</tr>
		`;
	}

    html += "</table>";

    listaGiocatoriElement.innerHTML = html;
}

main();
