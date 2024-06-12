<table class="table">
    <thead>
        <tr>
            @foreach($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
            <tr>
                @foreach($row as $index => $cell)
                    <td>
                        @if ($index === count($row) - 1) 
                            <form method="POST" action="{{ route('admin.pendingorders.update', $row[0]) }}" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-link">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                        @else
                            {{ $cell }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

