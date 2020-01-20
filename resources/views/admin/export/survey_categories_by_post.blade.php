
<table>
    <thead>
    <tr>
        <th>Stanowisko</th>
        
        @foreach($data->first() as $name => $category)
          <th>{{ $name }}</th>
        @endforeach
        <th>Liczba osób</th>
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
