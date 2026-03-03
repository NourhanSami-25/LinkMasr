@extends('layout.app')

@section('title')
    {{ __('general.cost_estimates') ?? 'تقديرات التكلفة' }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item text-muted">{{ __('general.cost_estimates') ?? 'تقديرات التكلفة' }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">{{ __('general.cost_estimates') ?? 'تقديرات التكلفة' }}</h4>
                <div>
                    @include('components.print-export-buttons', ['tableId' => 'estimatesTable', 'title' => __('general.cost_estimates') ?? 'تقديرات التكلفة', 'filename' => 'estimates'])
                    <a href="{{ route('estimates.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus me-1"></i> {{ __('general.new_estimate') ?? 'تقدير جديد' }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($estimates->count() > 0)
                <div class="table-responsive">
                    <table id="estimatesTable" class="table table-hover table-row-dashed align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('general.title') ?? 'العنوان' }}</th>
                                <th>{{ __('general.type') ?? 'النوع' }}</th>
                                <th>{{ __('general.project') ?? 'المشروع' }}</th>
                                <th>{{ __('general.unit') ?? 'الوحدة' }}</th>
                                <th>{{ __('general.materials_total') ?? 'إجمالي المواد' }}</th>
                                <th>{{ __('general.total_cost') ?? 'الإجمالي' }}</th>
                                <th>{{ __('general.date') ?? 'التاريخ' }}</th>
                                <th>{{ __('general.actions') ?? 'الإجراءات' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estimates as $estimate)
                            <tr>
                                <td>{{ $estimate->id }}</td>
                                <td>
                                    <a href="{{ route('estimates.show', $estimate->id) }}" class="text-dark fw-bold text-hover-primary">
                                        {{ $estimate->title }}
                                    </a>
                                </td>
                                <td>
                                    @if($estimate->type == 'finishing')
                                        <span class="badge badge-light-info fs-7 fw-bold">{{ __('general.finishing') ?? 'تشطيبات' }}</span>
                                    @else
                                        <span class="badge badge-light-warning fs-7 fw-bold">{{ __('general.land_construction') ?? 'بناء أرض' }}</span>
                                    @endif
                                </td>
                                <td>{{ $estimate->project->subject ?? '-' }}</td>
                                <td>{{ $estimate->unit->name ?? '-' }}</td>
                                <td>{{ number_format($estimate->materials_total, 2) }}</td>
                                <td class="fw-bold text-success">{{ number_format($estimate->total_cost, 2) }}</td>
                                <td>{{ $estimate->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('estimates.show', $estimate->id) }}" class="btn btn-sm btn-light-primary" title="{{ __('general.view') ?? 'عرض' }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form action="{{ route('estimates.delete', $estimate->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('general.confirm_delete') ?? 'هل أنت متأكد من الحذف؟' }}')">
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
                
                <div class="mt-4">
                    {{ $estimates->links() }}
                </div>
                @else
                <div class="text-center py-10">
                    <i class="fa fa-calculator fs-3x text-muted mb-3"></i>
                    <p class="text-muted">{{ __('general.no_estimates') ?? 'لا توجد تقديرات بعد' }}</p>
                    <a href="{{ route('estimates.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> {{ __('general.create_first_estimate') ?? 'إنشاء أول تقدير' }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
