@extends('layout.app')

@section('title', __('general.edit_vendor') ?? 'تعديل المورد')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('vendors.index') }}" class="text-muted text-hover-primary">{{ __('general.vendors') ?? 'الموردين' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('vendors.show', $vendor->id) }}" class="text-muted text-hover-primary">{{ $vendor->name }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.edit') ?? 'تعديل' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">{{ __('general.edit_vendor') ?? 'تعديل بيانات المورد' }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Basic Info -->
                    <div class="col-md-6">
                        <h5 class="mb-4 border-bottom pb-2">{{ __('general.basic_info') ?? 'المعلومات الأساسية' }}</h5>
                        
                        <div class="mb-3">
                            <label class="form-label required">{{ __('general.name') ?? 'الاسم' }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $vendor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">{{ __('general.type') ?? 'النوع' }}</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="supplier" {{ old('type', $vendor->type) == 'supplier' ? 'selected' : '' }}>{{ __('general.supplier') ?? 'مورد' }}</option>
                                <option value="subcontractor" {{ old('type', $vendor->type) == 'subcontractor' ? 'selected' : '' }}>{{ __('general.subcontractor') ?? 'مقاول باطن' }}</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.tax_number') ?? 'الرقم الضريبي' }}</label>
                            <input type="text" name="tax_number" class="form-control" value="{{ old('tax_number', $vendor->tax_number) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.commercial_register') ?? 'السجل التجاري' }}</label>
                            <input type="text" name="commercial_register" class="form-control" value="{{ old('commercial_register', $vendor->commercial_register) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.status') ?? 'الحالة' }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $vendor->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ __('general.active') ?? 'نشط' }}</label>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-md-6">
                        <h5 class="mb-4 border-bottom pb-2">{{ __('general.contact_info') ?? 'معلومات الاتصال' }}</h5>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('general.phone') ?? 'الهاتف' }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $vendor->phone) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.email') ?? 'البريد الإلكتروني' }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $vendor->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.address') ?? 'العنوان' }}</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $vendor->address) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.contact_person') ?? 'جهة الاتصال' }}</label>
                            <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $vendor->contact_person) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('general.contact_phone') ?? 'هاتف جهة الاتصال' }}</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $vendor->contact_phone) }}">
                        </div>
                    </div>
                </div>

                <!-- Bank Info -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-4 border-bottom pb-2">{{ __('general.bank_info') ?? 'المعلومات البنكية' }}</h5>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('general.bank_name') ?? 'اسم البنك' }}</label>
                            <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $vendor->bank_name) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('general.bank_account') ?? 'رقم الحساب' }}</label>
                            <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account', $vendor->bank_account) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('general.iban') ?? 'IBAN' }}</label>
                            <input type="text" name="iban" class="form-control" value="{{ old('iban', $vendor->iban) }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-light me-3">{{ __('general.cancel') ?? 'إلغاء' }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('general.save') ?? 'حفظ' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
