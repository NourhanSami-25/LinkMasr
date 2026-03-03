@extends('layout.app')

@section('title', __('general.add_vendor') ?? 'إضافة مورد')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('vendors.index') }}" class="text-muted text-hover-primary">{{ __('general.vendors') ?? 'الموردين' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.add') ?? 'إضافة' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <form action="{{ route('vendors.store') }}" method="POST">
            @csrf
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ __('general.add_vendor') ?? 'إضافة مورد جديد' }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.name') ?? 'الاسم' }}</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.type') ?? 'النوع' }}</label>
                        <select name="type" class="form-select" required>
                            <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>{{ __('general.supplier') ?? 'مورد' }}</option>
                            <option value="subcontractor" {{ old('type') == 'subcontractor' ? 'selected' : '' }}>{{ __('general.subcontractor') ?? 'مقاول باطن' }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.tax_number') ?? 'الرقم الضريبي' }}</label>
                        <input type="text" name="tax_number" class="form-control" value="{{ old('tax_number') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.commercial_register') ?? 'السجل التجاري' }}</label>
                        <input type="text" name="commercial_register" class="form-control" value="{{ old('commercial_register') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.phone') ?? 'الهاتف' }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('general.email') ?? 'البريد الإلكتروني' }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('general.address') ?? 'العنوان' }}</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>
                </div>
                
                <hr>
                <h6 class="text-muted mb-3">{{ __('general.bank_info') ?? 'البيانات البنكية' }}</h6>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.bank_name') ?? 'اسم البنك' }}</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.bank_account') ?? 'رقم الحساب' }}</label>
                        <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.iban') ?? 'IBAN' }}</label>
                        <input type="text" name="iban" class="form-control" value="{{ old('iban') }}">
                    </div>
                </div>
                
                <hr>
                <h6 class="text-muted mb-3">{{ __('general.contact_person') ?? 'جهة الاتصال' }}</h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('general.contact_name') ?? 'اسم جهة الاتصال' }}</label>
                        <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('general.contact_phone') ?? 'هاتف جهة الاتصال' }}</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone') }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ __('general.save') ?? 'حفظ' }}
                </button>
                <a href="{{ route('vendors.index') }}" class="btn btn-light">{{ __('general.cancel') ?? 'إلغاء' }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
