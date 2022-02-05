@foreach ($peserta as $ps)
<tr>
    <td>{{ ($loop->remaining + 1) }}</td>
    <td>{{ $ps->seminar->nama }}</td>
    <td>{{ $ps->seminar->phone }}</td>
    <td>{{ $ps->created_at->format('H:i:s') }}</td>
    <td>
        <button class="btn btn-sm" onclick="ShowDelete({{ $ps->id }})">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
@endforeach