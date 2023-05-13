const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

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
		<h2>Squadre</h2>
		
		<div class="grid-container">
	`;

	for (let squadra of squadre) {
		html += `
			<a href="visualizza_squadra.html?squadra_id=${squadra.squadra_id}">	
				<div class="grid-item">
					<img src="${IMG_ROOT}/${FIX_SQUADRA_IMG[squadra.nome] || squadra.nome.toLowerCase()}.svg" alt="${squadra.nome}">
					<p>${squadra.nome}</p>
				</div>
			</a>
		`;
	}

	html += `
		</div>
	`;

	listaSquadreElement.innerHTML = html;
}

main();
