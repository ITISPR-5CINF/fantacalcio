import { API_URL } from "./lib.js";

let listaGiocatoriElement = document.getElementById("lista_giocatori");

async function main() {
    let	response = await fetch(`${API_URL}/get_giocatori.php`);
	if (!response.ok) {
		listaGiocatoriElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

    let giocatori = await response.json();

	// Ottieni info sulle squadre
	response = await fetch(`${API_URL}/get_squadre.php`);
	if (!response.ok) {
		listaGiocatoriElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

	let squadre = await response.json();

	let squadra_id_to_nome = {};
	for (let squadra of squadre) {
		squadra_id_to_nome[squadra.squadra_id] = squadra.nome;
	}

	console.log(squadra_id_to_nome);

    let html = `
		<table>
			<tr>
				<th>Nome</th>
				<th>Data di nascita</th>
				<th>Posizione</th>
				<th>Crediti iniziali</th>
				<th>Crediti finali</th>
				<th>Nazionalità</th>
				<th>Squadra</th>
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
				<td>${giocatore.nazionalita.join(", ")}</td>
				<td>${squadra_id_to_nome[giocatore.squadra_id]}</td>
			</tr>
		`;
	}

    html += "</table>";

    listaGiocatoriElement.innerHTML = html;
}

main();
