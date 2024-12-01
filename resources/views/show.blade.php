@extends('app')

@section('title', 'Campaign Stats')

@section('content')
    <h1>Stats for {{ $campaign->utm_campaign }}</h1>
    <a href="{{ route('publishers', $campaign->id) }}">View by Publishers</a>
    <table id="stats-table" class="display" style="width: 100%;">
        <thead>
            <tr>
                <th>Date</th>
                <th>Hour</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stats as $stat)
                <tr>
                    <td>{{ $stat->date }}</td>
                    <td>{{ $stat->hour }}</td>
                    <td>{{ $stat->revenue }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#stats-table').DataTable({
                paging: true,      // Enable pagination
                searching: true,   // Enable search functionality
                ordering: true,    // Enable column sorting
                columnDefs: [
                    { orderable: false, targets: [] } // Disable ordering for specific columns if needed
                ]
            });
        });
    </script>
@endsection
