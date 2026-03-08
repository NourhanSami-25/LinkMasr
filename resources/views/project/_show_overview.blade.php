<div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">

    <!--begin::Earnings-->
	<div class="card mb-6 mb-xl-9">
		<div class="card-body pt-9 pb-0">						
	        <!--begin::Details-->
	        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
	        	{{-- <!--begin::Image-->
	        	<div
	        		class="d-flex flex-center flex-shrink-0 rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
	        		<img class="mw-50px mw-lg-150px"
	        			src="{{ asset('assets/media/icon/project.png') }}"
	        			alt="image" />
	        	</div>
	        	<!--end::Image--> --}}
                <!--begin::Wrapper-->
	        	<div class="flex-grow-1">
	        		<!--begin::Head-->
	        		<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
	        			<!--begin::Details-->
	        			<div class="d-flex flex-column">
	        				<!--begin::Status-->
	        				<div class="d-flex align-items-center mb-1">
	        					<a href="#"
	        						class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">{{$project->subject}}</a>
	        					<span class="badge 
								    {{ $project->status === 'in_progress' ? 'badge-light-primary' : '' }}
								    {{ $project->status === 'on_hold' ? 'badge-light-warning' : '' }}
								    {{ $project->status === 'completed' ? 'badge-light-success' : '' }}
								    {{ $project->status === 'not_started' ? 'badge-light-info' : '' }}
								    me-auto">{{ __('general.' . $project->status) }}
								</span>
	        				</div>
	        				<!--end::Status-->
	        				<!--begin::Description-->
	        				<div
	        					class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">
	        					{{$project->description}}</div>
	        				<!--end::Description-->
	        			</div>
	        			<!--end::Details-->
	        		</div>
	        		<!--end::Head-->
	        		<!--begin::Info-->
	        		<div class="d-flex flex-wrap justify-content-start">
	        			<!--begin::Stats-->
	        			<div class="d-flex flex-wrap">
	        				<!--begin::Stat-->
	        				<div
	        					class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
	        					<!--begin::Label-->
	        					<div class="fw-semibold fs-6 text-gray-500 mb-2">{{ __('general.start_date') }}</div>
	        					<!--end::Label-->
	        					<!--begin::Number-->
	        					<div class="d-flex align-items-center">
	        						<div class="fs-4 fw-bold">{{$project->date?? __('general.not_exists')}}</div>
	        					</div>
	        					<!--end::Number-->
	        				</div>
	        				<!--end::Stat-->
                            <!--begin::Stat-->
	        				<div
	        					class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
	        					<!--begin::Label-->
	        					<div class="fw-semibold fs-6 text-gray-500 mb-2">{{ __('general.dead_line') }}</div>
	        					<!--end::Label-->
	        					<!--begin::Number-->
	        					<div class="d-flex align-items-center">
	        						<div class="fs-4 fw-bold">{{$project->due_date?? __('general.not_exists')}}</div>
	        					</div>
	        					<!--end::Number-->
	        				</div>
	        				<!--end::Stat-->
							<!--begin::Stat-->
	        				<div
	        					class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
	        					<!--begin::Label-->
	        					<div class="fw-semibold fs-6 text-gray-500 mb-2">{{ __('general.created_by') }}</div>
	        					<!--end::Label-->
	        					<!--begin::Number-->
	        					<div class="d-flex align-items-center">
	        						<div class="fs-4 fw-bold">{{__getUserNameById($project->created_by)?? __('general.not_exists')}}</div>
	        					</div>
	        					<!--end::Number-->
	        				</div>
	        				<!--end::Stat-->
	        				<!--begin::Assignees-->
							@if($project->assignees)
	        				<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
	        					<!--begin::Label-->
	        					<div class="fw-semibold fs-6 text-gray-500 mb-2">{{ __('general.assignees') }}</div>
	        					<!--end::Label-->
	        					<div class="symbol-group symbol-hover">
    								@foreach(json_decode($project->assignees) as $assigneeId)
    								    @php
    								        $username = __getUserNameById($assigneeId)
    								    @endphp
    								    <!--begin::User-->
    								    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $username }}">
    								        <span class="symbol-label bg-primary text-inverse-warning fw-bold">
    								            {{ substr($username, 0, 2) }}
    								        </span>
    								    </div>
    								    <!--end::User-->
    								@endforeach
								</div>
	        				</div>
							@endif
	        				<!--end::Assignees-->
							<!--begin::Assignees-->
							@if($project->followers)
	        				<div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
	        					<!--begin::Label-->
	        					<div class="fw-semibold fs-6 text-gray-500 mb-2">{{ __('general.followers') }}</div>
	        					<!--end::Label-->
	        					<div class="symbol-group symbol-hover">
    								@foreach(json_decode($project->followers) as $followerId)
    								    @php
    								        $username = __getUserNameById($followerId)
    								    @endphp
    								    <!--begin::User-->
    								    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="{{ $username }}">
    								        <span class="symbol-label bg-primary text-inverse-warning fw-bold">
    								            {{ substr($username, 0, 2) }}
    								        </span>
    								    </div>
    								    <!--end::User-->
    								@endforeach
								</div>
	        				</div>
							@endif
	        				<!--end::Assignees-->
	        			</div>
	        			<!--end::Stats-->
	        			
						
	        		</div>
	        		<!--end::Info-->
	        	</div>
	        	<!--end::Wrapper-->
            </div>

            <!--begin::Project Main Details Card-->
            <div class="row g-5 g-xl-10 mb-xl-10">
                <div class="col-xl-12">
                    <!--begin::Project summary-->
            		<div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            			<!--begin::Project details-->
            			<div class="card card-flush py-4 flex-row-fluid">
            				<!--begin::Card header-->
            				<div class="card-header">
            					<div class="card-title">
            						<h2>{{ __('general.project_data') }}</h2>
            					</div>
            				</div>
            				<!--end::Card header-->
            				<!--begin::Card body-->
            				<div class="card-body pt-0">
            					<div class="table-responsive">
            						<!--begin::Table-->
            						<table
            							class="table align-middle table-row-bordered mb-0 fs-5 gy-5 min-w-300px">
            							<tbody class="fw-semibold text-gray-600">
	        								<tr>
											    <td class="text-muted">
											        {{__('general.client_name')}}
											    </td>
											    <td class="fw-bold text-end text-gray-800">{{$project->client->name ?? __('general.not_exists')}}</td>
											</tr>
											<tr>
											    <td class="text-muted">
											        {{__('general.client_name')}}
											    </td>
											    <td class="fw-bold text-end text-gray-800">{{$project->client->name ?? __('general.not_exists')}}</td>
											</tr>
            								<tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">
            											{{__('general.billing_type')}}
            										</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{$project->billing_type?? __('general.not_exists')}}</td>
            								</tr>	
											<tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">{{__('general.status')}}</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{__('general.' . $project->status) ?? __('general.not_exists')}}</td>
            								</tr>
                                            <tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">{{__('general.priority')}}</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{$project->priority ?? __('general.not_exists')}}</td>
            								</tr>
                                            <tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">
            											{{__('general.project_id')}}
            										</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{$project->id?? __('general.not_exists')}}</td>
            								</tr>
            							</tbody>
            						</table>
            						<!--end::Table-->
            					</div>
            				</div>
            				<!--end::Card body-->
            			</div>
            			<!--end:: details-->
            			<!--begin::Customer details-->
            			<div class="card card-flush py-4 flex-row-fluid">
            				<!--begin::Card header-->
            				<div class="card-header">
            					<div class="card-title">
            						<h2>{{ __('general.project_dates') }}</h2>
            					</div>
            				</div>
            				<!--end::Card header-->
            				<!--begin::Card body-->
            				<div class="card-body pt-0">
            					<div class="table-responsive">
            						<!--begin::Table-->
            						<table
            							class="table align-middle table-row-bordered mb-0 fs-5 gy-5 min-w-300px">
            							<tbody class="fw-semibold text-gray-600">
                                            <tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">{{__('general.start_date')}}</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{$project->start_date?? __('general.not_exists')}}</td>
            								</tr>
                                            <tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">{{__('general.dead_line')}}</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{$project->due_date?? __('general.not_exists')}}</td>
            								</tr>
                                            <tr>
            									<td class="text-muted">
            										<div class="d-flex align-items-center">{{__('general.created_at')}}</div>
            									</td>
            									<td class="fw-bold text-end text-gray-800">{{$project->created_at?? __('general.not_exists')}}</td>
            								</tr>
            							</tbody>
            						</table>
            						<!--end::Table-->
            					</div>
            				</div>
            				<!--end::Card body-->
            			</div>
            			<!--end::Customer details-->
            		</div>
    			    <!--end:: summary-->
                </div>
            </div>
            <!--end:: Main Details Card-->
        </div>
    </div>
    <!--end::Earnings-->

</div>
