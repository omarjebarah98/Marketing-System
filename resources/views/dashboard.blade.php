@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        <form method="POST" action="{{ route('logout') }}" class="mb-4">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Total Templates</h5>
                    <p>{{ $stats['templates_count'] }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>Total Campaigns</h5>
                    <p>{{ $stats['campaigns_count'] }}</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <h3>Campaign Statistics</h3>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Template</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Total Sent</th>
                        <th>Delivered</th>
                        <th>Failed</th>
                        <th>Open Rate (%)</th>
                        <th>Click Rate (%)</th>
                        <th>Total Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stats['campaigns'] as $campaign)
                        <tr>
                            <td>{{ $campaign['title'] }}</td>
                            <td>{{ $campaign['template']['name'] ?? 'N/A' }}</td>
                            <td>{{ $campaign['start_date'] }}</td>
                            <td>{{ $campaign['end_date'] }}</td>
                            <td>{{ $campaign['status'] }}</td>
                            <td>{{ $campaign['total_sent'] }}</td>
                            <td>{{ $campaign['delivered'] }}</td>
                            <td>{{ $campaign['failed'] }}</td>
                            <td>{{ $campaign['open_rate'] }}</td>
                            <td>{{ $campaign['click_rate'] }}</td>
                            <td>{{ $campaign['total_cost'] }}</td>
                            <td>
                                <form method="POST" action="{{ route('campaigns.updateStatus', $campaign['id']) }}">
                                    @csrf
                                    @method('POST')
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="draft" {{ $campaign['status'] == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="active" {{ $campaign['status'] == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="paused" {{ $campaign['status'] == 'paused' ? 'selected' : '' }}>Paused</option>
                                        <option value="completed" {{ $campaign['status'] == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('campaigns.destroy', $campaign['id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
