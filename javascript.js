/* actualmente es una modificacion de un ejemplo de
 * w3schools, pero deberia servir de base
 */
function mostrarRelojID(tagid) {
	var today = new Date();
	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();
	m = (m < 10) ? "0" + m : m;
	s = (s < 10) ? "0" + s : s;
	document.getElementById(tagid).innerHTML =
	h + ":" + m + ":" + s;
	/* esto se hace para obligar la ejecucion? */
	/* por qué no simplemente usar ()          */
	var t = setTimeout(mostrarReloj, 500);
}

