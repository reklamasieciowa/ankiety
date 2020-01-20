
<table>
    <thead>
    <tr>
        <th>Ankieta</th>
        <th>Grupa</th>

        @foreach($data['keys'] as $category)
          <th>{{ $category }}</th>
        @endforeach

    </tr>
    </thead>
    <tbody>
    @foreach($data as $groupname => $group)
        @if($groupname !== 'keys')
            
            @foreach($group as $levelname => $level)
                <tr>
                  <td>{{ $groupname }}</td>
                  <td>{{ $levelname }}</td>
                  
                    @foreach($level as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
            
        @endif
    @endforeach
    </tbody>
</table>
