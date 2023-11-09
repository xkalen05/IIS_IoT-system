@props(['login' => null, 'editable' => 1, 'header' => 0])

<tr>
    @if($header === 1)
        <th>LOGIN</th>
        @if($editable === 1)
            <th><a href="https://google.com">EDIT</a></th>
        @else
            <th>-</th>
        @endif
    @else
        <td>{{$login['login']}}</td>
        @if($editable === 1)
            <td><a href="{{url('admin/'.$login['login'])}}">EDIT</a></td>
        @else
            <td>-</td>
        @endif
    @endif
</tr>
