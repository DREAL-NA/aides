<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="{{ $id }}Label">{{ $title }}</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger hidden" role="alert"></div>
				{{ $slot }}
			</div>
			<div class="modal-footer">
				{{ $footer }}
			</div>
		</div>
	</div>
</div>