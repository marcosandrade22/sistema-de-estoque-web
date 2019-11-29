/*
---
name: Locale.en-US.Chosen
description: English Language File for Chosen
authors: Jonnathan Soares
requires: [More/Locale]
provides: Locale.en-US.Chosen
...
*/
Locale.define('en-US', 'Chosen', {
	placeholder: function(multiple) {
		return (multiple ? 'Select Some Options' : 'Select an Option');
	},
	noResults: 'No results match'
});