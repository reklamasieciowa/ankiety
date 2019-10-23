@if ($errors->any())
	<div id="errors" class="alert alert-danger">
		@foreach ($errors->all() as $error)
			<p><i class="fas fa-exclamation-triangle text-danger mr-2"></i>{{ $error }}</p>
		@endforeach
	</div>
@endif