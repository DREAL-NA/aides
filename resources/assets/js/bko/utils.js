window.utils = {
	select2__ajaxOptions(url) {
		return {
			delay: 250,
			cache: true,
			url: url,
			dataType: 'json',
			method: 'post',
		};
	},
	saveNewItem(modalId, ajaxUrl, selector) {
		var modal = $('#'+modalId);

		modal.find('.alert').addClass('hidden');
		$.ajax({
			url: ajaxUrl,
			method: 'post',
			data: $('#form__'+modalId).serialize(),
			success: function(data){
				var option = new Option(data.name, data.id, true, true);
				$('#'+selector).append(option).trigger('change');
				modal.modal('hide');
			},
			error: function(data, json) {
				var alert_block = modal.find('.alert');
				alert_block.removeClass('hidden').empty();
				$.each(data.responseJSON.errors, function(k, item) {
					$.each(item, function(k2, item2) {
						alert_block.append($('<p>').html(item2));
					});
				});
			}
		});
	},
	deleteItem(modalId, ajaxUrl, id, successCallback = () => {}) {
		var modal = $('#'+modalId);

		$.ajax({
			url: ajaxUrl,
			method: 'post',
			data: {
				_method: 'DELETE',
			},
			success: function(data){
				modal.modal('hide');

				if(successCallback()) {
					successCallback();
				}
			},
			error: function(data, json) {
				console.log('Erreurs :');
				console.log(data.responseJSON);
			}
		});
	},
	deleteRow() {

	}
}