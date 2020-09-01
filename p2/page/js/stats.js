"use strict"


window.addEventListener("load", () => {
	console.log("fully loaded!")
	fetch("http://localhost:1337/loadstats.php")
	.then(response => response.json())
	.then(res => console.log(res));
});