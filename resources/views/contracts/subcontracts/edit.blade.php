@extends('layout.app')

@section('title', __('general.edit_subcontract') ?? 'تعديل العقد')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('subcontracts.index') }}" class="text-muted text-hover-primary">{{ __('general.subcontracts') ?? 'عقود مقاولي الباطن' }}</a>
    </li>
    <li class="breadcrumb-item text-muted">
        <a href="{{ route('subcontracts.show', $subcontract->id) }}" class="text-muted text-hover-primary">{{ $subcontract->contract_no }}</a>
    </li>
    <li class="breadcrumb-item text-muted">{{ __('general.edit') ?? 'تعديل' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <form action="{{ route('subcontracts.update', $subcontract->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Basic Info Card -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.contract_info') ?? 'معلومات العقد' }} - {{ $subcontract->contract_no }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('general.project') ?? 'المشروع' }}</label>
                        <input type="text" class="form-control" value="{{ $subcontract->project->subject }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ __('general.vendor') ?? 'المقاول' }}</label>
                        <input type="text" class="form-control" value="{{ $subcontract->vendor->name }}" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label required">{{ __('general.contract_title') ?? 'عنوان العقد' }}</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title', $subcontract->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.start_date') ?? 'تاريخ البدء' }}</label>
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                               value="{{ old('start_date', $subcontract->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">{{ __('general.end_date') ?? 'تاريخ الانتهاء' }}</label>
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                               value="{{ old('end_date', $subcontract->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label required">{{ __('general.retention_percentage') ?? 'نسبة المحجوز (%)' }}</label>
                        <input type="number" name="retention_percentage" class="form-control @error('retention_percentage') is-invalid @enderror" 
                               value="{{ old('retention_percentage', $subcontract->retention_percentage) }}" step="0.01" min="0" max="100" required>
                        @error('retention_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.advance_percentage') ?? 'نسبة الدفعة المقدمة (%)' }}</label>
                        <input type="number" name="advance_percentage" class="form-control" 
                               value="{{ old('advance_percentage', $subcontract->advance_percentage) }}" step="0.01" min="0" max="100">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ __('general.insurance_percentage') ?? 'نسبة التأمين (%)' }}</label>
                        <input type="number" name="insurance_percentage" class="form-control" 
                               value="{{ old('insurance_percentage', $subcontract->insurance_percentage) }}" step="0.01" min="0" max="100">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('general.scope') ?? 'نطاق العمل' }}</label>
                    <textarea name="scope" class="form-control" rows="3">{{ old('scope', $subcontract->scope) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('general.terms') ?? 'شروط العقد' }}</label>
                    <textarea name="terms" class="form-control" rows="3">{{ old('terms', $subcontract->terms) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Current Items -->
        <div class="card mb-5">
            <div class="card-header">
                <h5 class="mb-0">{{ __('general.contract_items') ?? 'بنود العقد' }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('general.description') ?? 'الوصف' }}</th>
                                <th>{{ __('general.quantity') ?? 'الكمية' }}</th>
                                <th>{{ __('general.unit_price') ?? 'سعر الوحدة' }}</th>
                                <th>{{ __('general.total') ?? 'الإجمالي' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subcontract->items as $item)
                            <tr>
                                <td>
                                    @if($item->boq)
                                        <strong>{{ $item->boq->code }}</strong><br>
                                    @endif
                                    {{ $item->description }}
                                </td>
                                <td>{{ number_format($item->quantity, 2) }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="3" class="text-end">{{ __('general.contract_total') ?? 'إجمالي العقد' }}</td>
                                <td>{{ number_format($subcontract->contract_value, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('subcontracts.show', $subcontract->id) }}" class="btn btn-light me-3">{{ __('general.cancel') ?? 'إلغاء' }}</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> {{ __('general.save') ?? 'حفظ' }}
            </button>
        </div>
    </form>
</div>
@endsection
