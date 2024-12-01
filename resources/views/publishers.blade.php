@extends('app')

@section('title', 'Campaign Publishers')

@section('content')
    <h1>Publishers for {{ $campaign->utm_campaign }}</h1>
    <a href="{{ route('campaign', $campaign->id) }}">Back to Campaign Details</a>

    <!-- Table for DataTables -->
    <table id="campaignPublishersTable" class="display">
        <thead>
            <tr>
                <th>Publisher (utm_term)</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stats as $stat)
                <tr>
                    <td>{{ $stat->utm_term }}</td>
                    <td>{{ $stat->revenue }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#campaignPublishersTable').DataTable();
        });
    </script>
@endsection
