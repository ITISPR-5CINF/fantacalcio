import { API_URL } from "./lib.js";

async function main() {
    let registerForm = document.getElementById("register-form");

    registerForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;
        let nome = document.getElementById("nome").value;
        let cognome = document.getElementById("cognome").value;
        let email = document.getElementById("email").value;

        let response = await fetch(`${API_URL}/register.php`, {
            method: "POST",
            body: JSON.stringify({
                username,
                password,
                nome,
                cognome,
                email,
            })
        });

        if (response.ok) {
            alert("Registrazione effettuata con successo");
            location.href = "index.html";
        } else {
            alert("Errore durante la registrazione");
        }
    });
}

main();
