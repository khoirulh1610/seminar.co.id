@foreach ($peserta as $ps)
<tr>
    <td>{{ ($loop->remaining + 1) }}</td>
    <td>{{ $ps->nama }}</td>
    <td>{{ $ps->phone }}</td>
    <td>{{ $ps->absen_at->format('H:i:s') }}</td>
    <td>
        <a href="#">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>
@endforeach