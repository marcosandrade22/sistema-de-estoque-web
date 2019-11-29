/*
---
name: Locale.de-DE.Chosen
description: German Language File for Chosen
authors: Clemens Kaposi
requires: [More/Locale]
provides: Locale.de-DE.Chosen
...
*/
Locale.define('de-DE', 'Chosen', {
	placeholder: function(multiple) {
		return (multiple ? 'Wählen Sie beliebige Optionen' : 'Wählen Sie eine Option');
	},
	noResults: 'Keine Übereinstimmungen'
});
