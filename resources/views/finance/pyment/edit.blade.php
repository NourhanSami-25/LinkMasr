@extends('layout.app')

@section('title')
    {{ __('general.edit_payment') }} #{{ $pyment->number }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('pyments.index') }}" class="text-muted text-hover-primary">{{ __('general.payments') }}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">{{ $pyment->number }}</li>
@endsection

@section('content')
    <div class="card card-flush border-0">
        <div class="card-body">
            <form id="kt_pyment_form" action="{{ route('pyments.update', $pyment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-8">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ __('general.payment_number') }}</label>
                        <input type="text" name="number" class="form-control form-control-solid"
                            value="{{ $pyment->number }}" readonly />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold required">{{ __('general.client') }}</label>
                        <select name="client_id" id="clientSelect" class="form-select form-select-solid"
                            data-control="select2" required>
                            <option value="">{{ __('general.select_client') }}</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $pyment->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ __('general.date') }}</label>
                        <input type="date" name="date" class="form-control form-control-solid"
                            value="{{ $pyment->date->format('Y-m-d') }}" required />
                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">{{ __('general.related_to') }}</label>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <select name="invoice_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="{{ __('general.invoice') }}">
                                    <option value="">{{ __('general.none') }}</option>
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}" {{ $pyment->invoice_id == $invoice->id ? 'selected' : '' }}>#{{ $invoice->number }} ({{ $invoice->client_name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="expense_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="{{ __('general.expense') }}">
                                    <option value="">{{ __('general.none') }}</option>
                                    @foreach($expenses as $expense)
                                        <option value="{{ $expense->id }}" {{ $pyment->expense_id == $expense->id ? 'selected' : '' }}>#{{ $expense->number }} ({{ $expense->client_name }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold required">{{ __('general.amount') }}</label>
                        <div class="input-group input-group-solid">
                            <input type="number" step="0.01" name="total" class="form-control" value="{{ $pyment->total }}"
                                required />
                            <select name="currency" class="form-select w-100px" data-control="select2"
                                data-hide-search="true">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->code }}" {{ $pyment->currency == $currency->code ? 'selected' : '' }}>{{ $currency->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-8">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ __('general.payment_method') }}</label>
                        <select name="payment_method" class="form-select form-select-solid" data-control="select2"
                            data-hide-search="true">
                            <option value="Cash" {{ $pyment->payment_method == 'Cash' ? 'selected' : '' }}>
                                {{ __('general.cash') }}</option>
                            <option value="Bank" {{ $pyment->payment_method == 'Bank' ? 'selected' : '' }}>
                                {{ __('general.bank_transfer') }}</option>
                            <option value="Check" {{ $pyment->payment_method == 'Check' ? 'selected' : '' }}>
                                {{ __('general.check') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ __('general.transaction_number') }}</label>
                        <input type="text" name="transaction_number" class="form-control form-control-solid"
                            value="{{ $pyment->transaction_number }}" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ __('general.status') }}</label>
                        <select name="status" class="form-select form-select-solid" data-control="select2"
                            data-hide-search="true">
                            <option value="paid" {{ $pyment->status == 'paid' ? 'selected' : '' }}>{{ __('general.paid') }}
                            </option>
                            <option value="draft" {{ $pyment->status == 'draft' ? 'selected' : '' }}>{{ __('general.draft') }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="form-label fw-bold">{{ __('general.note') }}</label>
                    <textarea name="note" class="form-control form-control-solid" rows="3">{{ $pyment->note }}</textarea>
                </div>

                <div class="separator separator-dashed mb-8"></div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('pyments.index') }}" class="btn btn-light me-3">{{ __('general.cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('general.save_changes') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const clientsData = @json($clients);
    </script>
@endsection