
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Stanowisko</th>
        <th>Dział</th>
        <th>Branża</th>
        @foreach($survey->questions as $question)
          <th>{{ $question->{'name:pl'} }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($survey->people as $person)
        <tr>
            <td>{{ $person->id }}</td>
            <td>{{ $person->post->name }}</td>
            <td>{{ $person->department->name }}</td>
            <td>{{ $person->industry->name }}</td>

            @foreach($person->answers as $answer)
              <td>{{ $answer->value }}</td>
            @endforeach
            
        </tr>
    @endforeach
    </tbody>
</table>
