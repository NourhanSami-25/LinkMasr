
@foreach (['success', 'warning', 'error', 'authError'] as $msgType)
    @if(session($msgType))
        <div class="alert alert-{{ $msgType === 'authError' || $msgType === 'error' ? 'danger' : $msgType }} alert-dismissible fade show d-flex justify-content-between align-items-center py-3 px-4 mb-0" role="alert">
            <span class="fw-bold">
                {{ session($msgType) }}
                @if($msgType === 'error' && session('detailed_error'))
                    — <a href="{{ route('error.index', session('detailed_error')) }}" target="_blank">More details</a>
                @endif
            </span>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach




