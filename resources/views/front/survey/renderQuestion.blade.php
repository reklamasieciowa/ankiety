@if($question->question_type->name == "Select")
<p>{{ $question->name }}</p>
    @if(count($question->options))
      <select name="answers[{{ $question->id }}]" class="browser-default custom-select">
        @foreach($question->options as $option)
          <option value="{{ $option->value }}" {{ $question->required ? 'required' : '' }}>{{ $option->name }}</option>
        @endforeach
      </select>
    @else
      <p>Pytanie nie ma opcji</p>
    @endif
@elseif($question->question_type->name == "Radio")
  <p class="label">{{ $question->name }}</p>
  @if(count($question->options))
    @foreach($question->options as $option)

    @endforeach
  @else
    @foreach($question->scale->values as $scale)  
      <div class="custom-control custom-radio">
        <input type="radio" class="custom-control-input" id="q{{ $question->id }}a{{ $scale->value }}" name="answers[{{ $question->id }}]" value="{{ $scale->value }}" {{ $question->required ? 'required' : '' }}>
        <label class="custom-control-label" for="q{{ $question->id }}a{{ $scale->value }}">{{ $scale->name }}</label>
      </div>
    @endforeach
  @endif
@elseif($question->question_type->name == "String")
  <div class="form-group">
    <label for="q{{ $question->id }}">{{ $question->name }}</label>
    <input type="text" id="q{{ $question->id }}" name="answers[{{ $question->id }}]" class="form-control" {{ $question->required ? 'required' : '' }}>
  </div>
@elseif($question->question_type->name == "Text")
  <div class="form-group">
    <label for="q{{ $question->id }}">{{ $question->name }}</label>
    <textarea class="form-control rounded-0" id="q{{ $question->id }}" name="answers[{{ $question->id }}]" rows="10" {{ $question->required ? 'required' : '' }}></textarea>
  </div>
@endif