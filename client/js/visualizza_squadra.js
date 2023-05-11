const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

let infoSquadraElement = document.getElementById("info_squadra");
let listaGiocatoriElement = document.getElementById("lista_giocatori");

async function main() {
	let params = new URLSearchParams(window.location.search);

	if (!params.has('squadra_id')) {
		return;
	}

	let squadra_id = params.get('squadra_id');

	let	response = await fetch(`${API_URL}/get_squadra.php?squadra_id=${squadra_id}`);
	if (!response.ok) {
		listaSquadreElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

	let squadra = await response.json();

	listaSquadreElement.innerHTML = `
		<h2>${squadra.nome}</h2>
		<p>Nome: ${squadra.nome}</p>
		<p>Città: ${squadra.citta}</p>
		<p>Anno fondazione: ${squadra.anno_fondazione}</p>
	`

	response = await fetch(`${API_URL}/get_giocatori.php?squadra_id=${squadra_id}`);
	if (!response.ok) {
		listaGiocatoriElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
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
