<div class="row mt-3 text-center" id="stepper">
  @foreach($categories as $category)
    <div class="step {{ $category->id === $currentCategory->id ? 'active' : '' }}" style="width: {{100/count($categories)}}%">
        {{ $category->id }}
    </div>
  @endforeach
</div> 