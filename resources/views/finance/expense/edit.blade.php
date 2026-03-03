@extends('layout.app')

@section('title')
    {{ __('general.edit_expense') }} #{{ $expense->number }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('expenses.index') }}" class="text-muted text-hover-primary">{{ __('general.expenses') }}</a>
    </li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-muted">{{ $expense->number }}</li>
@endsection

@section('content')
    <div class="card card-flush border-0">
        <div class="card-body">
            <form id="kt_invoice_form" action="{{ route('expenses.update', $expense->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                        <div class="card card-flush border-0">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column align-items-start flex-xxl-row">
                                    <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                        <span class="fs-2x fw-bold text-gray-800">{{ __('general.expense') }} #</span>
                                        <input type="text" name="number"
                                            class="form-control form-control-flush fw-bold fs-2x w-100px"
                                            value="{{ $expense->number }}" />
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-10"></div>
                                <div class="row gx-10 mb-5">
                                    <div class="col-lg-6">
                                        <label
                                            class="form-label fs-6 fw-bold text-gray-700 mb-3 required">{{ __('general.client') }}</label>
                                        <select name="client_id" id="clientSelect" class="form-select form-select-solid"
                                            data-control="select2" required>
                                            <option value="">{{ __('general.select_client') }}</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ $expense->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" id="clientAddress" name="billing_address"
                                            class="form-control form-control-solid mt-3" readonly
                                            value="{{ $expense->billing_address }}" />
                                    </div>
                                    <div class="col-lg-6">
                                        <label
                                            class="form-label fs-6 fw-bold text-gray-700 mb-3 required">{{ __('general.date') }}</label>
                                        <input type="date" name="date" class="form-control form-control-solid"
                                            value="{{ $expense->date }}" required />
                                    </div>
                                </div>

                                <div class="row gx-10 mb-5 text-gray-700">
                                    <div class="col-lg-4">
                                        <label class="form-label fs-6 fw-bold mb-3">{{ __('general.project') }}</label>
                                        <select name="project_id" class="form-select form-select-solid"
                                            data-control="select2">
                                            <option value="">{{ __('general.none') }}</option>
                                            @foreach($projects as $project)
                                                <option value="{{ $project->id }}" {{ $expense->project_id == $project->id ? 'selected' : '' }}>{{ $project->subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label fs-6 fw-bold mb-3">{{ __('general.task') }}</label>
                                        <select name="task_id" class="form-select form-select-solid" data-control="select2">
                                            <option value="">{{ __('general.none') }}</option>
                                            @foreach($tasks as $task)
                                                <option value="{{ $task->id }}" {{ $expense->task_id == $task->id ? 'selected' : '' }}>{{ $task->subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label
                                            class="form-label fs-6 fw-bold mb-3 required">{{ __('general.expense_type') }}</label>
                                        <select name="type" class="form-select form-select-solid" data-control="select2"
                                            required>
                                            <option value="operational" {{ $expense->type == 'operational' ? 'selected' : '' }}>{{ __('general.operational') }}</option>
                                            <option value="capital" {{ $expense->type == 'capital' ? 'selected' : '' }}>
                                                {{ __('general.capital') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive mb-10 mt-10">
                                    <table class="table g-5 gs-0 mb-0 fw-bold text-gray-700" data-kt-element="items">
                                        <thead>
                                            <tr class="border-bottom fs-7 fw-bold text-gray-400 text-uppercase">
                                                <th class="min-w-300px w-475px">{{ __('general.item') }}</th>
                                                <th class="min-w-100px w-100px">{{ __('general.qty') }}</th>
                                                <th class="min-w-150px w-150px">{{ __('general.price') }}</th>
                                                <th class="min-w-100px w-150px">{{ __('general.tax') }}</th>
                                                <th class="min-w-150px w-150px text-end">{{ __('general.total') }}</th>
                                                <th class="min-w-75px w-75px text-end">{{ __('general.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $index => $item)
                                                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                    <td class="pe-7">
                                                        <input type="text" class="form-control form-control-solid mb-2"
                                                            name="finance_items[{{ $index }}][name]" value="{{ $item->name }}"
                                                            required />
                                                        <textarea class="form-control form-control-solid" rows="2"
                                                            name="finance_items[{{ $index }}][description]">{{ $item->description }}</textarea>
                                                    </td>
                                                    <td class="ps-0">
                                                        <input class="form-control form-control-solid" type="number" min="1"
                                                            name="finance_items[{{ $index }}][qty]" value="{{ $item->qty }}"
                                                            data-kt-element="quantity" />
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-solid text-end" type="number"
                                                            step="0.01" name="finance_items[{{ $index }}][amount]"
                                                            value="{{ $item->amount }}" data-kt-element="price" />
                                                    </td>
                                                    <td>
                                                        <select name="finance_items[{{ $index }}][tax]"
                                                            class="form-select form-select-solid" data-kt-element="tax">
                                                            <option value="0" {{ $item->tax == 0 ? 'selected' : '' }}>0%</option>
                                                            <option value="14" {{ $item->tax == 14 ? 'selected' : '' }}>14%
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td class="pt-8 text-end fs-6 fw-bold text-gray-800">
                                                        <span
                                                            data-kt-element="total">{{ number_format($item->subtotal, 2) }}</span>
                                                    </td>
                                                    <td class="pt-5 text-end">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-active-color-primary"
                                                            data-kt-element="remove-item">
                                                            <i class="ki-outline ki-trash fs-3"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="border-top border-top-dashed align-top fs-6 fw-bold text-gray-700">
                                                <th colspan="2">
                                                    <button type="button" class="btn btn-link py-1"
                                                        data-kt-element="add-item">{{ __('general.add_item') }}</button>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-lg-250px w-xl-300px mb-10">
                        <div class="card card-flush border-0 bg-light-primary mb-5">
                            <div class="card-body">
                                <div class="d-flex flex-stack mb-3">
                                    <div class="fw-semibold text-gray-600 fs-7">{{ __('general.subtotal') }}:</div>
                                    <div class="fw-bold text-gray-800 fs-6" data-kt-element="sub-total">
                                        {{ number_format($expense->subtotal, 2) }}</div>
                                </div>
                                <div class="d-flex flex-stack mb-3">
                                    <div class="fw-semibold text-gray-600 fs-7">{{ __('general.tax') }}:</div>
                                    <div class="fw-bold text-gray-800 fs-6" data-kt-element="invoice-tax-field">
                                        {{ number_format($expense->total_tax, 2) }}</div>
                                </div>
                                <div class="separator separator-dashed mb-3"></div>
                                <div class="d-flex flex-stack">
                                    <div class="fw-bolder text-gray-800 fs-5">{{ __('general.total') }}:</div>
                                    <div class="fw-bolder text-primary fs-5">
                                        <span data-kt-element="grand-total">{{ number_format($expense->total, 2) }}</span>
                                        <input type="hidden" name="total" value="{{ $expense->total }}"
                                            data-kt-element="grand-total-hidden-input" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-flush border-0">
                            <div class="card-body">
                                <div class="mb-5">
                                    <label class="form-label fw-bold">{{ __('general.currency') }}</label>
                                    <select name="currency" id="clientCurrency" class="form-select form-select-solid"
                                        data-control="select2">
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->code }}" {{ $expense->currency == $currency->code ? 'selected' : '' }}>{{ $currency->code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label fw-bold">{{ __('general.status') }}</label>
                                    <select name="status" class="form-select form-select-solid" data-control="select2">
                                        <option value="unpaid" {{ $expense->status == 'unpaid' ? 'selected' : '' }}>
                                            {{ __('general.unpaid') }}</option>
                                        <option value="paid" {{ $expense->status == 'paid' ? 'selected' : '' }}>
                                            {{ __('general.paid') }}</option>
                                        <option value="draft" {{ $expense->status == 'draft' ? 'selected' : '' }}>
                                            {{ __('general.draft') }}</option>
                                    </select>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary w-100 mt-5">{{ __('general.save_changes') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Templates for dynamic items -->
    <table class="d-none" data-kt-element="item-template">
        <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
            <td class="pe-7">
                <input type="text" class="form-control form-control-solid mb-2" name="finance_items[x][name]"
                    placeholder="{{ __('general.item_name') }}" required />
                <textarea class="form-control form-control-solid" rows="2" name="finance_items[x][description]"
                    placeholder="{{ __('general.description') }}"></textarea>
            </td>
            <td class="ps-0">
                <input class="form-control form-control-solid" type="number" min="1" name="finance_items[x][qty]" value="1"
                    data-kt-element="quantity" />
            </td>
            <td>
                <input class="form-control form-control-solid text-end" type="number" step="0.01"
                    name="finance_items[x][amount]" value="0" data-kt-element="price" />
            </td>
            <td>
                <select name="finance_items[x][tax]" class="form-select form-select-solid" data-kt-element="tax">
                    <option value="0">0%</option>
                    <option value="14">14%</option>
                </select>
            </td>
            <td class="pt-8 text-end fs-6 fw-bold text-gray-800">
                <span data-kt-element="total">0.00</span>
            </td>
            <td class="pt-5 text-end">
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-kt-element="remove-item">
                    <i class="ki-outline ki-trash fs-3"></i>
                </button>
            </td>
        </tr>
    </table>
@endsection

@section('scripts')
    <script>
        const clientsData = @json($clients);
    </script>
    <script src="{{ asset('assets/js/models/finance/create.js') }}"></script>
@endsection