const topbarElement = document.getElementById("topbar");

const API_URL = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/server"

const ROOT = "https://webuser.itis.pr.it/~sBAREZZI/fantacalcio/client"

const PAGES = {
    "Home": `${ROOT}/`,
    "Squadre Serie A TIM": `${ROOT}/visualizza_squadre.html`,
    "Listone": `${ROOT}/listone.html`,
}

async function showLogin() {
	// Crea un dialogo per poter fare login
	let dialog = document.createElement("dialog");
	dialog.innerHTML = `
		<form method="dialog">
			<input type="text" placeholder="Username" required>
			<input type="password" placeholder="Password" required>
			<button type="submit">Login</button>
		</form>
	`;
	document.body.appendChild(dialog);

	// Mostra il dialogo
	dialog.showModal();

	// Quando viene inviato il form, fai login
	dialog.querySelector("form").addEventListener("submit", async (event) => {
		event.preventDefault();

		let username = dialog.querySelector("input[type='text']").value;
		let password = dialog.querySelector("input[type='password']").value;

		let response = await fetch(`${API_URL}/login.php`, {
			method: "POST",
			body: JSON.stringify({
				username,
				password
			})
		});

		if (response.ok) {
			dialog.close();
			location.reload();
		}
		else {
			alert("Credenziali errate");
		}
	});

	// Quando viene cliccato il pulsante "Annulla", chiudi il dialogo
	dialog.addEventListener("cancel", () => {
		dialog.close();
	});

	// Focus sul campo username
	dialog.querySelector("input[type='text']").focus();

	// Chiudi il dialogo quando viene premuto ESC
	dialog.querySelector("form").addEventListener("keydown", (event) => {
		if (event.key == "Escape") {
			dialog.close();
		}
	});
}

async function doLogout() {
	await fetch(`${API_URL}/logout.php`);

	window.location.reload();
}

async function injectTopbar() {
	// Ottieni informazioni sul login
	let loginInfo = null;

	let response = await fetch(`${API_URL}/get_login_info.php`);

	if (response.ok) {
		loginInfo = await response.json();
	}

    topbarElement.innerHTML = `
		<style>
			#topbar ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
				overflow: hidden;
				background-color: #333;
			}

			#topbar li {
				float: left;
			}

			#topbar li a {
				display: block;
				color: white;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
			}

			#topbar li a:hover:not(.active) {
				background-color: #111;
			}

			#topbar .active {
				background-color: #04AA6D;
			}
		</style>

		<ul>
			<li><a>Fantacalcio</a></li>

			${Object.keys(PAGES).map(page => `
				<li><a href="${PAGES[page]}" class="${window.location.pathname === PAGES[page] ? "active" : ""}">${page}</a></li>
			`).join("")}

			${loginInfo ? `
				<li style="float:right"><a href="javascript:doLogout()">Logout</a></li>
			` : `
				<li style="float:right"><a href="javascript:showLogin()">Login</a></li>
			`}
		</ul>
	`;

	// Aggiungi un dialogo per poter fare login
	// Allinea al pulsante di login
	if (!loginInfo) {
		let loginButton = document.querySelector("#topbar a[href$='login.html']");

		loginButton.addEventListener("click", async () => {
			let username = prompt("Username");
			let password = prompt("Password");

			if (!username || !password) {
				return;
			}

			let response = await fetch(`${API_URL}/login.php`, {
				method: "POST",
				body: JSON.stringify({
					username,
					password,
				}),
			});

			if (response.ok) {
				window.location.reload();
			} else {
				alert("Credenziali errate");
			}
		});
	}
}

injectTopbar();
