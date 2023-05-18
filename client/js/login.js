import { API_URL } from "./lib.js";

async function main() {
    let loginForm = document.getElementById("login-form");

    loginForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        let response = await fetch(`${API_URL}/login.php`, {
            method: "POST",
            body: JSON.stringify({
                username,
                password,
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
