<form action="{{ route('entry.changestatus', [$entry->id]) }}" method="POST">
	@csrf
	<button class="btn btn-sm btn-rounded status-preview" style="background-color: {{ $entry->status->color }};" type="submit">{{ $entry->status->name }}</button>
</form>