import { API_URL, getLogoSquadra } from "./lib.js";

let infoSquadraElement = document.getElementById("info-squadra");
let listaGiocatoriElement = document.getElementById("lista-giocatori");

async function main() {
	let params = new URLSearchParams(window.location.search);

	if (!params.has('squadra_id')) {
		return;
	}

	let squadra_id = params.get('squadra_id');

	let	response = await fetch(`${API_URL}/get_squadra.php?squadra_id=${squadra_id}`);
	if (!response.ok) {
		infoSquadraElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

	let squadra = await response.json();

	infoSquadraElement.innerHTML = `
		<div id="squadra-info">
			<h2>${squadra.nome}</h2>
			<p>Nome: ${squadra.nome}</p>
			<p>Città: ${squadra.citta}</p>
			<p>Anno fondazione: ${squadra.anno_fondazione}</p>
		</div>

		<div id="squadra-logo">
			<img src="${getLogoSquadra(squadra.nome)}" alt="${squadra.nome}">
		</div>
	`

	response = await fetch(`${API_URL}/get_giocatori.php?squadra_id=${squadra_id}`);
	if (!response.ok) {
		listaGiocatoriElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

	let giocatori = await response.json();

	// Ordina per posizione, poi per crediti finali
	// P, D, C, A
	giocatori.sort((a, b) => {
		if (a.posizione == b.posizione) {
			return b.crediti_finali - a.crediti_finali;
		}

		let ordinePosizioni = ["P", "D", "C", "A"];
		return ordinePosizioni.indexOf(a.posizione) - ordinePosizioni.indexOf(b.posizione);
	});

	let html = `
		<h2>Giocatori</h2>
		<table>
			<tr>
				<th>Nome</th>
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
				<td>${giocatore.nazionalita.join(", ")}</td>
			</tr>
		`;
	}

	html += "</table>";

	listaGiocatoriElement.innerHTML = html;
}

main();
