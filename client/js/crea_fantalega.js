import { API_URL, getInfoUtente } from "./lib.js";

let creaFantalegaForm = document.getElementById("crea-fantalega-form");

async function main() {
    let utente = await getInfoUtente();
    if (utente == null) {
        window.location.href = "login.html";
        return;
    }

    creaFantalegaForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        let nome = document.getElementById("nome").value;

        let response = await fetch(`${API_URL}/crea_fantalega.php`, {
            method: "POST",
            body: JSON.stringify({
                nome,
            })
        });

        if (response.ok) {
            location.href = "index.html";
        } else {
            alert("Errore durante la creazione della fantalega");
        }
    });
}

main();
