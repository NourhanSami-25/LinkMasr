@extends('layout.app')

@section('title', $vendor->name)

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('vendors.index') }}" class="text-muted text-hover-primary">{{ __('general.vendors') ?? 'الموردين' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ $vendor->name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Vendor Header -->
    <div class="card mb-5">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-3">
                        <div class="symbol symbol-60px symbol-circle me-4">
                            <span class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                {{ mb_substr($vendor->name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $vendor->name }}</h3>
                            <div>
                                @if($vendor->type == 'supplier')
                                    <span class="badge badge-light-primary fs-7 fw-bold">{{ __('general.supplier') ?? 'مورد' }}</span>
                                @else
                                    <span class="badge badge-light-warning fs-7 fw-bold">{{ __('general.subcontractor') ?? 'مقاول باطن' }}</span>
                                @endif
                                @if($vendor->is_active)
                                    <span class="badge badge-light-success fs-7 fw-bold ms-2">{{ __('general.active') ?? 'نشط' }}</span>
                                @else
                                    <span class="badge badge-light-danger fs-7 fw-bold ms-2">{{ __('general.inactive') ?? 'غير نشط' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i> {{ __('general.edit') ?? 'تعديل' }}
                    </a>
                    <form action="{{ route('vendors.toggle-status', $vendor->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $vendor->is_active ? 'btn-secondary' : 'btn-success' }}">
                            <i class="fa fa-{{ $vendor->is_active ? 'ban' : 'check' }}"></i>
                            {{ $vendor->is_active ? 'تعطيل' : 'تفعيل' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Contact Info -->
        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-header py-5 border-bottom">
                    <h5 class="mb-0"><i class="fa fa-address-card me-2"></i>{{ __('general.contact_info') ?? 'معلومات الاتصال' }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">{{ __('general.phone') ?? 'الهاتف' }}</th>
                            <td>{{ $vendor->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.email') ?? 'البريد الإلكتروني' }}</th>
                            <td>{{ $vendor->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.address') ?? 'العنوان' }}</th>
                            <td>{{ $vendor->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.contact_person') ?? 'جهة الاتصال' }}</th>
                            <td>{{ $vendor->contact_person ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.contact_phone') ?? 'هاتف جهة الاتصال' }}</th>
                            <td>{{ $vendor->contact_phone ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Legal & Bank Info -->
        <div class="col-md-6">
            <div class="card mb-5">
                <div class="card-header py-5 border-bottom">
                    <h5 class="mb-0"><i class="fa fa-university me-2"></i>{{ __('general.legal_bank_info') ?? 'المعلومات القانونية والبنكية' }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">{{ __('general.tax_number') ?? 'الرقم الضريبي' }}</th>
                            <td>{{ $vendor->tax_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.commercial_register') ?? 'السجل التجاري' }}</th>
                            <td>{{ $vendor->commercial_register ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.bank_name') ?? 'اسم البنك' }}</th>
                            <td>{{ $vendor->bank_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.bank_account') ?? 'رقم الحساب' }}</th>
                            <td>{{ $vendor->bank_account ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('general.iban') ?? 'IBAN' }}</th>
                            <td>{{ $vendor->iban ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Subcontracts -->
    @if($vendor->subcontracts && $vendor->subcontracts->count() > 0)
    <div class="card mb-5">
        <div class="card-header">
            <h5 class="mb-0"><i class="fa fa-file-contract me-2"></i>{{ __('general.subcontracts') ?? 'عقود المقاولة' }} ({{ $vendor->subcontracts->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('general.contract_number') ?? 'رقم العقد' }}</th>
                            <th>{{ __('general.project') ?? 'المشروع' }}</th>
                            <th>{{ __('general.value') ?? 'القيمة' }}</th>
                            <th>{{ __('general.status') ?? 'الحالة' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendor->subcontracts as $contract)
                        <tr>
                            <td>
                                <a href="{{ route('subcontracts.show', $contract->id) }}">{{ $contract->contract_number }}</a>
                            </td>
                            <td>{{ $contract->project->subject ?? '-' }}</td>
                            <td>{{ number_format($contract->total_value, 2) }}</td>
                            <td>
                                <span class="badge badge-light-{{ $contract->status == 'active' ? 'success' : ($contract->status == 'completed' ? 'primary' : 'secondary') }}">
                                    {{ $contract->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Bids -->
    @if($vendor->bids && $vendor->bids->count() > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fa fa-gavel me-2"></i>{{ __('general.bids') ?? 'العروض المقدمة' }} ({{ $vendor->bids->count() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('general.tender') ?? 'المناقصة' }}</th>
                            <th>{{ __('general.bid_amount') ?? 'قيمة العرض' }}</th>
                            <th>{{ __('general.status') ?? 'الحالة' }}</th>
                            <th>{{ __('general.submitted_at') ?? 'تاريخ التقديم' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendor->bids as $bid)
                        <tr>
                            <td>{{ $bid->tender->title ?? '-' }}</td>
                            <td>{{ number_format($bid->bid_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-light-{{ $bid->status == 'winner' ? 'success' : ($bid->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ $bid->status }}
                                </span>
                            </td>
                            <td>{{ $bid->created_at ? $bid->created_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
