@extends('layout.app')

@section('title')
    {{ __('general.new_cost_estimate') ?? 'New Cost Estimate' }}
@endsection

@section('styles')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
<div class="row" x-data="costCalculator()">
    <div class="col-12">
        <form action="{{ route('estimates.store') }}" method="POST">
            @csrf
            
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('general.create_cost_estimate') ?? 'Create Cost Estimate' }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('general.estimate_title') ?? 'Estimate Title' }}</label>
                                <input type="text" name="title" class="form-control" required placeholder="{{ __('general.estimate_title_placeholder') ?? 'e.g. Building A Finishing' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('general.type') ?? 'Type' }}</label>
                                <select name="type" class="form-control">
                                    <option value="finishing">{{ __('general.finishing') ?? 'Finishing' }}</option>
                                    <option value="construction">{{ __('general.land_construction') ?? 'Land Construction' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ __('general.link_to_unit') ?? 'Link to Unit (Optional)' }}</label>
                                <select name="unit_id" class="form-control">
                                    <option value="">{{ __('general.none') ?? 'None' }}</option>
                                    @foreach($projects as $project)
                                        <optgroup label="{{ $project->subject }}">
                                            @foreach($project->units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-primary mt-4">{{ __('general.materials') ?? 'Materials' }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="40%">{{ __('general.material') ?? 'Material' }}</th>
                                    <th width="20%">{{ __('general.quantity') ?? 'Quantity' }}</th>
                                    <th width="20%">{{ __('general.unit_price') ?? 'Unit Price' }}</th>
                                    <th width="20%">{{ __('general.subtotal') ?? 'Subtotal' }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in items" :key="index">
                                    <tr>
                                        <td>
                                            <select :name="`items[${index}][material_id]`" class="form-control" x-model="item.material_id" @change="updatePrice(index)">
                                                <option value="">{{ __('general.select_material') ?? 'Select Material' }}</option>
                                                @foreach($materials as $m)
                                                    <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->unit }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" :name="`items[${index}][quantity]`" class="form-control" x-model="item.quantity">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" :value="item.price" readonly>
                                        </td>
                                        <td class="fw-bold">
                                            <span x-text="(item.quantity * item.price).toFixed(2)"></span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)">X</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-secondary btn-sm" @click="addItem()">+ {{ __('general.add_item') ?? 'Add Item' }}</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td>{{ __('general.materials_total') ?? 'Materials Total' }}</td>
                                    <td class="text-end fw-bold" x-text="calculateTotalMaterials()"></td>
                                </tr>
                                <tr>
                                    <td>{{ __('general.licensing_fees') ?? 'Licensing Fees' }}</td>
                                    <td>
                                        <input type="number" name="licensing_fees" class="form-control text-end" x-model="licensing_fees">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('general.other_fees') ?? 'Other Fees' }}</td>
                                    <td>
                                        <input type="number" name="other_fees" class="form-control text-end" x-model="other_fees">
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td><h5>{{ __('general.grand_total') ?? 'Grand Total' }}</h5></td>
                                    <td class="text-end text-success">
                                        <h4 x-text="calculateGrandTotal()"></h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">{{ __('general.save_estimate') ?? 'Save Estimate' }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function costCalculator() {
    return {
        items: [
            { material_id: '', quantity: 1, price: 0 }
        ],
        licensing_fees: 0,
        other_fees: 0,
        
        addItem() {
            this.items.push({ material_id: '', quantity: 1, price: 0 });
        },
        
        removeItem(index) {
            this.items.splice(index, 1);
        },
        
        updatePrice(index) {
            let materialId = this.items[index].material_id;
            if(!materialId) {
                this.items[index].price = 0;
                return;
            }
            
            fetch(`/api/materials/${materialId}/price`)
                .then(res => {
                    if(!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    this.items[index].price = parseFloat(data.price) || 0;
                })
                .catch(err => {
                    console.error('Error fetching price:', err);
                    this.items[index].price = 0;
                });
        },
        
        calculateTotalMaterials() {
            let total = 0;
            this.items.forEach(item => {
                total += (parseFloat(item.quantity) || 0) * (parseFloat(item.price) || 0);
            });
            return total.toFixed(2);
        },
        
        calculateGrandTotal() {
            let matTotal = parseFloat(this.calculateTotalMaterials());
            let fees1 = parseFloat(this.licensing_fees) || 0;
            let fees2 = parseFloat(this.other_fees) || 0;
            return (matTotal + fees1 + fees2).toFixed(2);
        }
    }
}
</script>
@endsection
