@if ($paginator->hasPages())
	<nav role="navigation" class="pagination-nav">
		<ul class="pagination no-space">
			@if ($paginator->onFirstPage())
				<li class="disabled"><span><</span></li>
			@else
				<li class="button"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><</a></li>
			@endif

			@foreach ($elements as $element)
				@if (is_string($element))
					<li><span>{{ $element }}</span></li>
				@endif

				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="current"><span>{{ $page }}</span></li>
						@else
							<li><a href="{{ $url }}">{{ $page }}</a></li>
						@endif
					@endforeach
				@endif
			@endforeach

			@if ($paginator->hasMorePages())
				<li class="button"><a href="{{ $paginator->nextPageUrl() }}" rel="next">></a></li>
			@else
				<li class="disabled"><span>></span></li>
			@endif
		</ul>
	</nav>
@endif
