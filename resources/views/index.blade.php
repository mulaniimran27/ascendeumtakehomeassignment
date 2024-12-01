@extends('app')

@section('title', 'Campaigns')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For icons -->
@endsection

@section('content')
    <table id="campaigns-table" class="display" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>UTM Campaign</th>
                <th>Revenue</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> <!-- For icons -->
    <script>
        $(document).ready(function () {
            $('#campaigns-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('campaigns.data') }}',
                    type: 'POST', // Use POST instead of GET
                    data: function (d) {
                        d._token = '{{ csrf_token() }}'; // Add CSRF token
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'utm_campaign', name: 'utm_campaign' },
                    { data: 'stats_sum_revenue', name: 'revenue' },
                    {
                        data: 'id', // Assuming the ID is needed to generate the link
                        name: 'action',
                        orderable: false, // Prevent sorting on this column
                        searchable: false, // Prevent searching on this column
                        render: function (data, type, row) {
                            // Use a predefined route or base URL
                            const url = '{{ url("/campaigns") }}/' + data;
                            return `<a href="${url}" class="btn btn-primary">
                                        <i class="fas fa-arrow-right"></i> Go to Next
                                    </a>`;
                        }
                    }
                ]
            });
        });
    </script>
@endsection
