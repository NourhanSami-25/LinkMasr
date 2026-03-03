@extends('layout.app')

@section('title', __('general.vendors') ?? 'الموردين')

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">{{ __('general.vendors') ?? 'الموردين' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{{ __('general.vendors') ?? 'الموردين والمقاولين' }}</h4>
            <a href="{{ route('vendors.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ __('general.add_vendor') ?? 'إضافة مورد' }}
            </a>
        </div>
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row mb-4">
                <div class="col-md-3">
                    <select name="type" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('general.all_types') ?? 'كل الأنواع' }}</option>
                        <option value="supplier" {{ request('type') == 'supplier' ? 'selected' : '' }}>{{ __('general.supplier') ?? 'مورد' }}</option>
                        <option value="subcontractor" {{ request('type') == 'subcontractor' ? 'selected' : '' }}>{{ __('general.subcontractor') ?? 'مقاول باطن' }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('general.search') ?? 'بحث...' }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

            @if($vendors->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('general.name') ?? 'الاسم' }}</th>
                            <th>{{ __('general.type') ?? 'النوع' }}</th>
                            <th>{{ __('general.phone') ?? 'الهاتف' }}</th>
                            <th>{{ __('general.email') ?? 'البريد' }}</th>
                            <th>{{ __('general.status') ?? 'الحالة' }}</th>
                            <th>{{ __('general.actions') ?? 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendors as $vendor)
                        <tr>
                            <td>
                                <a href="{{ route('vendors.show', $vendor->id) }}" class="text-dark fw-bold">
                                    {{ $vendor->name }}
                                </a>
                            </td>
                            <td>
                                @if($vendor->type == 'supplier')
                                    <span class="badge badge-light-primary fs-7 fw-bold">{{ __('general.supplier') ?? 'مورد' }}</span>
                                @else
                                    <span class="badge badge-light-warning fs-7 fw-bold">{{ __('general.subcontractor') ?? 'مقاول باطن' }}</span>
                                @endif
                            </td>
                            <td>{{ $vendor->phone ?? '-' }}</td>
                            <td>{{ $vendor->email ?? '-' }}</td>
                            <td>
                                @if($vendor->is_active)
                                    <span class="badge badge-light-success fs-7 fw-bold">{{ __('general.active') ?? 'نشط' }}</span>
                                @else
                                    <span class="badge badge-light-danger fs-7 fw-bold">{{ __('general.inactive') ?? 'غير نشط' }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-sm btn-light-info" title="{{ __('general.view') ?? 'عرض' }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-sm btn-light-warning" title="{{ __('general.edit') ?? 'تعديل' }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('vendors.toggle-status', $vendor->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light-secondary" title="{{ $vendor->is_active ? 'تعطيل' : 'تفعيل' }}">
                                        <i class="fa fa-{{ $vendor->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('{{ __('general.confirm_delete') ?? 'هل أنت متأكد من الحذف؟' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light-danger" title="{{ __('general.delete') ?? 'حذف' }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $vendors->links() }}
            @else
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle fs-1 mb-3 d-block"></i>
                {{ __('general.no_vendors') ?? 'لا توجد موردين حتى الآن' }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
