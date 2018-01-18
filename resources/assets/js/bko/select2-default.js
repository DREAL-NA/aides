window.$.fn.select2.defaults.set( "theme", "bootstrap" );
window.$.fn.select2.defaults.set( "language", "fr" );
window.$.fn.select2.defaults.set( "placeholder", "Choisissez une option" );


$('.select2-input').select2();

$('.select2-allow-clear').select2();
window.utils.select2__allowClearStayClosed('.select2-allow-clear')