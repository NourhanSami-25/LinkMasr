<div class="tab-pane fade show active" id="kt_customer_view_overview_tab"
role="tabpanel">

<!--begin::Earnings-->
<div class="card mb-6 mb-xl-9">
    <!--begin::Header-->
    <div class="card-header border-0">
        <div class="card-title">
            <h2>{{__('general.user_data')}}</h2>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
    	<div class="table-responsive">
    		<!--begin::Table-->
    		<table
    			class="table align-middle table-row-bordered mb-0 fs-5 gy-5 min-w-300px">
    			<tbody class="fw-semibold text-gray-600">
					<tr>
    					<td class="text-muted">
    						{{__('general.name')}}
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->name?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    						{{__('general.job_title')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->job_title?? __('general.not_exists')}}
    					</td>
    				</tr>
    				<tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.phone')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->phone?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.department')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->department->name ?? __('general.not_exists')}}</td>
    				</tr>
                    <tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.email')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->email ?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.address')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->address?? __('general.not_exists')}}</td>
    				</tr>
                    <tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.linkedin')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->linkedin?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.facebook')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->facebook?? __('general.not_exists')}}</td>
    				</tr>
                     <tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.signature')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->signature?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.hourly_rate')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->hourly_rate?? __('general.not_exists')}}</td>
    				</tr>
                    <tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.accountant_record')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->accountant_record?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.status')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->status?? __('general.not_exists')}}</td>
    				</tr>
                    <tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.language')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->language?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.remaining_balance')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{ $balance ? max(0, $balance->total_days - $balance->used_days) : 0 }} {{__('general.day')}}</td>
    				</tr>
					<tr>
    					<td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.bio')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->bio?? __('general.not_exists')}}</td>
                        <td class="text-muted">
    						<div class="d-flex align-items-center">
    							{{__('general.created_at')}}
    						</div>
    					</td>
    					<td class="fw-bold text-end text-gray-800">{{$user->created_at?? __('general.not_exists')}}</td>
    				</tr>
    			</tbody>
    		</table>
    		<!--end::Table-->
    	</div>
    </div>
    <!--end::Card body-->
    <!--end::Body-->
</div>
<!--end::Earnings-->

</div>
