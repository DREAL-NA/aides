require('./datatables-sort-natural');

window.$.extend(true, $.fn.dataTable.defaults, {
	column: {
		type: 'natural'
	}
});

window.$.extend(true, $.fn.dataTable.defaults, {
	lengthChange: false,
	language: {
		processing: "Traitement en cours...",
		search: "Rechercher&nbsp;:",
		lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
		info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
		infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		infoPostFix: "",
		loadingRecords: "Chargement en cours...",
		zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
		emptyTable: "Aucune donnée disponible dans le tableau",
		paginate: {
			first: "Premier",
			previous: "Pr&eacute;c&eacute;dent",
			next: "Suivant",
			last: "Dernier"
		},
		aria: {
			sortAscending: ": activer pour trier la colonne par ordre croissant",
			sortDescending: ": activer pour trier la colonne par ordre décroissant"
		}
	},
	mark: {
		diacritics: true
	}
});

$.extend($.fn.dataTableExt.oSort, {
	"date-uk-pre": function (a) {
		if (a == null || a == "") {
			return 0;
		}
		var ukDatea = a.split('/');
		return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
	},

	"date-uk-asc": function (a, b) {
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	},

	"date-uk-desc": function (a, b) {
		return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	}
});

$.fn.DataTable.ext.type.search.string = function (data) {
	return !data ?
		'' :
		typeof data === 'string' ?
			window.utils.dt__replaceString(data) :
			data;
};

