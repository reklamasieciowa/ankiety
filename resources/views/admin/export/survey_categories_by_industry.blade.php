
<table>
    <thead>
    <tr>
        <th>Branża</th>
        
        @foreach($data->first() as $name => $category)
          <th>{{ $name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $name => $post)
        <tr>
            <td>{{ $name }}</td>

            @foreach($post as $category)
              <td>{{ $category }}</td>
            @endforeach
        
        </tr>
    @endforeach
    </tbody>
</table>
