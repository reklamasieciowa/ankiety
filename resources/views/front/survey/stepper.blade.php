<div class="row mt-3 text-center" id="stepper">
  @foreach($categories as $key => $category)
    <div class="step {{ $category->id === $currentCategory->id ? 'active' : '' }}" style="width: {{100/count($categories)}}%">
        {{ $key+1 }}
    </div>
  @endforeach
</div> 