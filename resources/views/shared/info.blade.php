@if (session('info'))
    <div class="alert {{session('class')}}">
    	@if(session('class') == 'alert-info')
        	<i class="fas fa-info-circle fa-lg text-info mr-2"></i>
        @elseif(session('class') == 'alert-success')
        	<i class="far fa-check-circle fa-lg text-success mr-2"></i>
        @elseif(session('class') == 'alert-warning')
        	<i class="fas fa-exclamation-triangle text-warning mr-2"></i>
        @elseif(session('class') == 'alert-danger')
        	<i class="fas fa-exclamation-triangle fa-lg text-danger mr-2"></i>
        @endif
        {{ session('info') }}
    </div>
@endif