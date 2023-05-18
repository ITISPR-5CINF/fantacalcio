import { API_URL } from "../js/lib.js";

const bottombarElement = document.getElementById("bottombar");

const ROOT = "/~sBAREZZI/fantacalcio/client"

const PAGES = {
    "Home": `${ROOT}/`,
    "Squadre Serie A TIM": `${ROOT}/visualizza_squadre.html`,
    "Listone": `${ROOT}/listone.html`,
}

async function injectBottombar() {
    bottombarElement.innerHTML = `
		<style>
			#bottombar ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
				overflow: hidden;
				background-color: #333;
			}

			#bottombar li {
				display: inline-block;
				float: left;
			}

			#bottombar li a {
				display: inline-block;
				color: white;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
			}

			#bottombar li a:hover:not(.active) {
				background-color: #111;
			}

			#bottombar .active {
				background-color: #04AA6D;
			}
		</style>

		<ul>
			<li><a>Fantacalcio</a></li>

			${Object.keys(PAGES).map(page => `
				<li><a href="${PAGES[page]}" class="${window.location.pathname === PAGES[page] ? "active" : ""}">${page}</a></li>
			`).join("")}

			${loginInfo ? `
				<li style="float:right;">
					<a href="${ROOT}/account_info.html" class="${
						window.location.pathname === `${ROOT}/account_info.html` ? "active" : ""
					}">${loginInfo.nome} ${loginInfo.cognome}</a>
					<a id="logoutButton">Logout</a>
				</li>
			` : `
				<li style="float:right"><a id="loginButton">Login</a></li>
			`}
		</ul>
	`;
}

injectBottombar();
