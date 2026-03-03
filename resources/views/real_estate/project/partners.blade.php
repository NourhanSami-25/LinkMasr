@extends('layout.app')

@section('title')
    {{ __('Partner Management') }} - {{ $project->subject }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('Project Partners') }}</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
                    {{ __('Add Partner') }}
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Partner Name') }}</th>
                            <th>{{ __('Share %') }}</th>
                            <th>{{ __('Mgmt Fee %') }}</th>
                            <th>{{ __('Net Income (Project)') }}</th>
                            <th>{{ __('Mgmt Fee Amount') }}</th>
                            <th>{{ __('Distributable') }}</th>
                            <th>{{ __('Partner Share') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partnersData as $partner)
                        <tr>
                            <td>{{ $partner->name }}</td>
                            <td>{{ $partner->pivot->share_percentage }}%</td>
                            <td>{{ $partner->pivot->management_fee_percentage }}%</td>
                            <td>{{ number_format($partner->financials['net_income'], 2) }}</td>
                            <td>{{ number_format($partner->financials['management_fee'], 2) }}</td>
                            <td>{{ number_format($partner->financials['distributable'], 2) }}</td>
                            <td class="text-success fw-bold">{{ number_format($partner->financials['share_amount'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Partner Modal -->
<div class="modal fade" id="addPartnerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('projects.partners.store', $project->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add New Partner') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>{{ __('Select User') }}</label>
                        <select name="partner_id" class="form-control" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('Share Percentage (%)') }}</label>
                        <input type="number" step="0.01" name="share_percentage" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>{{ __('Management Fee Percentage (%)') }}</label>
                        <input type="number" step="0.01" name="management_fee_percentage" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
