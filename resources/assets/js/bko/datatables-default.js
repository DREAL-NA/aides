window.$.extend( true, $.fn.dataTable.defaults, {
	lengthChange: false,
	language: {
		processing:     "Traitement en cours...",
		search:         "Rechercher&nbsp;:",
		lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
		info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
		infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		infoPostFix:    "",
		loadingRecords: "Chargement en cours...",
		zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
		emptyTable:     "Aucune donnée disponible dans le tableau",
		paginate: {
			first:      "Premier",
			previous:   "Pr&eacute;c&eacute;dent",
			next:       "Suivant",
			last:       "Dernier"
		},
		aria: {
			sortAscending:  ": activer pour trier la colonne par ordre croissant",
			sortDescending: ": activer pour trier la colonne par ordre décroissant"
		}
	},
	mark: {
		diacritics: true
	}
});

window.$.extend( true, $.fn.dataTable.oSort, {
	"date-eu-pre": function ( date ) {
		date = date.replace(" ", "");
		if ( ! date ) {
			return 0;
		}
		var year;
		var eu_date = date.split(/[\.\-\/]/);
		/*year (optional)*/
		if ( eu_date[2] ) {
			year = eu_date[2];
		}
		else {
			year = 0;
		}
		/*month*/
		var month = eu_date[1];
		if ( month.length == 1 ) {
			month = 0+month;
		}
		/*day*/
		var day = eu_date[0];
		if ( day.length == 1 ) {
			day = 0+day;
		}
		return (year + month + day) * 1;
	},
	"date-eu-asc": function ( a, b ) {
		return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	},
	"date-eu-desc": function ( a, b ) {
		return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	}
} );

$.fn.DataTable.ext.type.search.string = function ( data ) {
	return ! data ?
		'' :
		typeof data === 'string' ?
			data
				.replace( /έ/g, 'ε' )
				.replace( /[ύϋΰ]/g, 'υ' )
				.replace( /ό/g, 'ο' )
				.replace( /ώ/g, 'ω' )
				.replace( /ά/g, 'α' )
				.replace( /[ίϊΐ]/g, 'ι' )
				.replace( /ή/g, 'η' )
				.replace( /\n/g, ' ' )
				.replace( /á/g, 'a' )
				.replace( /é/g, 'e' )
				.replace( /í/g, 'i' )
				.replace( /ó/g, 'o' )
				.replace( /ú/g, 'u' )
				.replace( /ê/g, 'e' )
				.replace( /î/g, 'i' )
				.replace( /ô/g, 'o' )
				.replace( /è/g, 'e' )
				.replace( /ï/g, 'i' )
				.replace( /ü/g, 'u' )
				.replace( /ã/g, 'a' )
				.replace( /õ/g, 'o' )
				.replace( /ç/g, 'c' )
				.replace( /ì/g, 'i' ) :
			data;
};