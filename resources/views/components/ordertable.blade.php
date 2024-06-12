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
            <tr id="row_{{ $row[0] }}">
                @foreach($row as $index => $cell)
                    <td>
                        @if ($index === count($row) - 1) 
                            <form id="updateForm_{{ $row[0] }}" class="update-form" data-order-id="{{ $row[0] }}" method="POST" action="{{ route('admin.pendingorders.update', $row[0]) }}" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="button" class="btn btn-link update-btn">
                                    <i class="fas fa-check text-success fa-lg"></i>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@vite(['resources/js/custom/orderupdate.js'])


