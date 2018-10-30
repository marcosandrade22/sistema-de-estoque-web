/*
---
name: Locale.es-ES.Chosen
description: Spanish Language File for Chosen
authors: Jonnathan Soares
requires: [More/Locale]
provides: Locale.es-ES.Chosen
...
*/
Locale.define('es-ES', 'Chosen', {
	placeholder: function(multiple) {
		return (multiple ? 'Seleccionar algunas opciones' : 'Seleccione una opción');
	},
	noResults: 'No se encontraron resultados'
});