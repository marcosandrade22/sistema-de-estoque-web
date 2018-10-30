/*
---
name: Locale.pt-BR.Chosen
description: Portuguese Language File for Chosen
authors: Jonnathan Soares
requires: [More/Locale]
provides: Locale.pt-BR.Chosen
...
*/
Locale.define('pt-BR', 'Chosen', {
	placeholder: function(multiple) {
		return (multiple ? 'Selecione algumas opções' : 'Selecione uma opção');
	},
	noResults: 'Nenhum resultado encontrado'
});