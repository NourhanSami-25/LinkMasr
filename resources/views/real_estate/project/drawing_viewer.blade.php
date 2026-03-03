@extends('layout.app')

@section('title')
    {{ $drawing->title }} - {{ $project->subject }}
@endsection

@push('head')
<script src="//unpkg.com/alpinejs" defer></script>
<style>
    .hotspot {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(40, 167, 69, 0.8);
        border: 2px solid white;
        border-radius: 50%;
        cursor: pointer;
        transform: translate(-50%, -50%);
        transition: all 0.2s ease;
        z-index: 10;
        animation: pulse 2s infinite;
    }
    .hotspot:hover {
        transform: translate(-50%, -50%) scale(1.5);
        background: #28a745;
        z-index: 20;
    }
    .hotspot.sold {
        background: rgba(220, 53, 69, 0.8);
    }
    .hotspot.reserved {
        background: rgba(255, 193, 7, 0.8);
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }
</style>
@endpush

@section('content')
<div class="row" x-data="drawingViewer()">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ $drawing->title }} <small class="text-muted">({{ $drawing->type }})</small></h4>
                <div>
                   <button class="btn btn-outline-primary" @click="adminMode = !adminMode" x-text="adminMode ? 'Exit Edit Mode' : 'Edit Hotspots'"></button>
                   <a href="{{ route('projects.drawings', $project->id) }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </div>
            <div class="card-body p-0 position-relative bg-dark text-center" style="overflow: auto;">
                
                <!-- Main Drawing Container -->
                <div class="d-inline-block position-relative" style="min-width: 800px;">
                    <img src="{{ asset('storage/' . $drawing->file_path) }}" 
                         alt="{{ $drawing->title }}" 
                         class="img-fluid"
                         @click="handleMapClick($event)"
                         style="cursor: crosshair;">

                    <!-- Existing Hotspots (Units) -->
                    @foreach($drawing->units as $unit)
                        @if($unit->pos_x && $unit->pos_y)
                            <div class="hotspot {{ $unit->status }}"
                                 style="left: {{ $unit->pos_x }}%; top: {{ $unit->pos_y }}%;"
                                 title="{{ $unit->name }} - {{ $unit->status }}"
                                 data-bs-toggle="popover"
                                 data-bs-trigger="hover"
                                 data-bs-content="Area: {{ $unit->area }}m² | Price: {{ number_format($unit->price) }}">
                            </div>
                        @endif
                    @endforeach

                    <!-- Temporary Pin for Editing -->
                    <div x-show="tempPin.visible" 
                         class="hotspot bg-warning"
                         :style="`left: ${tempPin.x}%; top: ${tempPin.y}%;`">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Link Unit Modal -->
    <div class="modal fade" id="linkUnitModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Link Position to Unit</h5>
                    <button type="button" class="btn-close" @click="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <p>Coordinates: <span x-text="tempPin.x.toFixed(2)"></span>%, <span x-text="tempPin.y.toFixed(2)"></span>%</p>
                    <div class="form-group">
                        <label>Select Unit</label>
                        <select x-model="selectedUnitId" class="form-control">
                            <option value="">-- Choose Unit --</option>
                            @foreach($drawing->units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->status }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" @click="saveCoordinate()">Save Position</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function drawingViewer() {
    return {
        adminMode: false,
        tempPin: { visible: false, x: 0, y: 0 },
        selectedUnitId: null,
        modal: null,

        init() {
            this.modal = new bootstrap.Modal(document.getElementById('linkUnitModal'));
            // Initialize popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
              return new bootstrap.Popover(popoverTriggerEl)
            })
        },

        handleMapClick(event) {
            if (!this.adminMode) return;

            const rect = event.target.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            // Calculate percentage
            this.tempPin.x = (x / rect.width) * 100;
            this.tempPin.y = (y / rect.height) * 100;
            this.tempPin.visible = true;

            this.modal.show();
        },

        closeModal() {
            this.modal.hide();
            this.tempPin.visible = false;
        },

        saveCoordinate() {
            if (!this.selectedUnitId) return alert('Please select a unit');

            // Find unit name just for simpler feedback (optional)
            
            fetch(`{{ url('projects/' . $project->id . '/units') }}/${this.selectedUnitId}/coordinates`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    pos_x: this.tempPin.x,
                    pos_y: this.tempPin.y
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    location.reload(); 
                }
            });
        }
    }
}
</script>
@endsection
