import { API_URL } from "./lib.js";

const IMG_ROOT = "https://sport.virgilio.it/img/loghi"
const FIX_SQUADRA_IMG = {
	"Hellas Verona": "verona"
}

let listaSquadreElement = document.getElementById("lista_squadre");

let squadre;

async function main() {
	let	response = await fetch(`${API_URL}/get_squadre.php`);
	if (!response.ok) {
		listaSquadreElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

	squadre = await response.json();
	squadre.sort((a, b) => a.nome.localeCompare(b.nome));

	let html = `
		<h2>Squadre Serie A TIM</h2>

		<div class="grid-container">
	`;

	for (let squadra of squadre) {
		html += `
			<a class="grid-item" href="visualizza_squadra.html?squadra_id=${squadra.squadra_id}">	
				<img src="${IMG_ROOT}/${FIX_SQUADRA_IMG[squadra.nome] || squadra.nome.toLowerCase()}.svg" alt="${squadra.nome}">
				<p>${squadra.nome}</p>
			</a>
		`;
	}

	html += `
		</div>
	`;

	listaSquadreElement.innerHTML = html;
}

main();
