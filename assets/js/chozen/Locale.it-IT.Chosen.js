/*
---
name: Locale.it-IT.Chosen
description: Italian Language File for Chosen
authors: A. Dessì
requires: [More/Locale]
provides: Locale.it-IT.Chosen
...
*/
Locale.define('it-IT', 'Chosen', {
	placeholder: function(multiple) {
		return (multiple ? 'Scegli elementi' : 'Scegli');
	},
	noResults: 'Nessun risultato'
});