const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

let listaSquadreElement = document.getElementById("lista_squadre");

async function main() {
	let	response = await fetch(`${API_URL}/get_squadre.php`);
	if (!response.ok) {
		listaSquadreElement.innerHTML = `Errore ${response.status}: ${response.statusText}`;
		return;
	}

	let squadre = await response.json();

	let html = `
		<h2>Squadre</h2>
		
		<div class="grid-container">
	`;

	for (let squadra of squadre) {
		html += `
			<div class="grid-item">
				<a href="visualizza_squadra.html?squadra_id=${squadra.id}">${squadra.nome}</a>
			</div>
		`;
	}

	html += `
		</div>
	`;

	listaSquadreElement.innerHTML = html;
}

main();
