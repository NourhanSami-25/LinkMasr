

					<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
					data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
					data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
					data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
					<!--begin::Wrapper-->

					<div class="app-sidebar-wrapper">
						<div id="kt_app_sidebar_wrapper" class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true"
							data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
							data-kt-scroll-dependencies="#kt_app_header"
							data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
							
							<!--begin::Sidebar menu-->
							<div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
								class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">
								
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{ route('home') }}">
								        <span class="menu-icon">
								            <i class="fa-solid fa-house fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.dashboard') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->

							

								@hasAccess('project', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('projects.index')}}">
								        <span class="menu-icon">
								            <i class="fa-solid fa-suitcase fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.projects') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('task', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('tasks.index')}}">
								        <span class="menu-icon">
								           <i class="fa-solid fa-list-check fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.tasks') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('client', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('clients.index')}}">
								        <span class="menu-icon">
								           <i class="fa-solid fa-user-tie fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.clients') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('expense', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('expenses.index')}}">
								        <span class="menu-icon">
								           <i class="fa-solid fa-cart-plus fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.expenses') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess


								@hasAccess('finance', 'view')
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
								    <!--begin:Menu link-->
								    <span class="menu-link">
								        <span class="menu-icon">
								            <i class="fa-solid fa-dollar-sign fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.finance') }}</span>
								        <span class="menu-arrow"></span>
								    </span>
								    <!--end:Menu link-->
								    <!--begin:Menu sub-->
								    <div class="menu-sub menu-sub-accordion">
								        <!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('invoices.index')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.invoices') }}</span>
								            </a>
								        </div>
								        <!--end:Menu item-->
										<!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('paymentRequests.index')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.payment_requests') }}</span>
								            </a>
								        </div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('creditNotes.index')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.creditNotes') }}</span>
								            </a>
								        </div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('pyments.index')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.payments') }}</span>
								            </a>
								        </div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('finance.report')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.finance_report') }}</span>
								            </a>
								        </div>
										<!--end:Menu item-->
								    </div>
								    <!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								@endhasAccess
								
								@hasAccess('contract', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('contracts.index')}}">
								        <span class="menu-icon">
								           <i class="fa-solid fa-file-signature fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.contracts') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

                                @hasAccess('real_estate', 'view')
                                <!--begin:Menu item - Real Estate-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-building fs-2"></i>
                                        </span>
                                        <span class="menu-title">{{ __('general.real_estate') ?? 'Real Estate' }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('materials.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.materials') ?? 'Materials' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('estimates.create')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.cost_estimation') ?? 'Cost Estimation' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                                @endhasAccess

                                @hasAccess('construction', 'view')
                                <!--begin:Menu item - Construction (BOQ & EVM)-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-helmet-safety fs-2"></i>
                                        </span>
                                        <span class="menu-title">{{ __('general.construction') ?? 'Construction' }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('construction.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.project_boq') ?? 'المشاريع و BOQ' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('schedules.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.execution_schedule') ?? 'مخطط التنفيذ' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('subcontracts.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.subcontracts') ?? 'عقود مقاولي الباطن' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('subcontractor-invoices.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.subcontractor_invoices') ?? 'مستخلصات المقاولين' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('client-invoices.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.client_invoices') ?? 'مستخلصات العملاء' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                                @endhasAccess

                                <!--begin:Menu item - Procurement-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-cart-shopping fs-2"></i>
                                        </span>
                                        <span class="menu-title">{{ __('general.procurement') ?? 'المشتريات' }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <div class="menu-sub menu-sub-accordion">
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('vendors.index')}}">
                                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                                <span class="menu-title">{{ __('general.vendors') ?? 'الموردين' }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--end:Menu item-->

                                @hasAccess('partners', 'view')
                                <!--begin:Menu item - Partners-->
                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-icon">
                                            <i class="fa-solid fa-handshake fs-2"></i>
                                        </span>
                                        <span class="menu-title">{{ __('general.partners') ?? 'Partners' }}</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        @if(auth()->user()->isAdmin())
                                        <!--begin:Menu item - Admin Only-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('partners.index')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.partners_management') ?? 'Partners Management' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        @endif
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('partners.dashboard', ['partner' => auth()->id()])}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.my_portfolio') ?? 'My Portfolio' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        @if(auth()->user()->isAdmin())
                                        <!--begin:Menu item - Admin Only-->
                                        <div class="menu-item">
                                            <a class="menu-link" href="{{route('partners.management.fees')}}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ __('general.management_fees') ?? 'Management Fees' }}</span>
                                            </a>
                                        </div>
                                        <!--end:Menu item-->
                                        @endif
                                    </div>
                                    <!--end:Menu sub-->
                                </div>
                                <!--end:Menu item-->
                                @endhasAccess

								@hasAccess('proposal', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('proposals.index')}}">
								        <span class="menu-icon">
								          <i class="fa-solid fa-hands-praying fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.proposals') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('lead', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('leads.index')}}">
								        <span class="menu-icon">
								          <i class="fa-solid fa-globe fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.leads') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('request', 'view')
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-hospital-user fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.requests') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										{{-- <!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('requests.staff_requests')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.staff_requests') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item--> --}}
										
										@hasAccess('approve', 'full')
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('requests.managed_requests' , parameters: auth()->user()->id)}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.managed_requests') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										@endhasAccess
										
										{{-- <!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('requests.department_requests' , parameters: auth()->user()->department_id)}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.department_requests') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item--> --}}
										
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('vacation-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.vacations') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('permission-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.permissions') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('mission-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.outside_missions') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('money-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.money_requests') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('support-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.support_requests') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('workhome-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.work_from_home') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
        								    <a class="menu-link" href="{{route('overtime-requests.index')}}">
        								        <span class="menu-bullet">
        								            <span class="bullet bullet-dot"></span>
        								        </span>
        								        <span class="menu-title">{{ __('general.overtime_work_hours') }}</span>
        								    </a>
        								</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('hr', 'view')
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-users fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.hr') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('sectors.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.sectors') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('departments.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.departments') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('positions.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.positions') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('balances.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.balances') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('report.requests')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.requests_report') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('calendar.index')}}">
								        <span class="menu-icon">
								          <i class="fa-solid fa-calendar-days fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.calendar') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->

								@hasAccess('reminder', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('reminders.index')}}">
								        <span class="menu-icon">
								          <i class="fa-solid fa-stopwatch fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.reminders') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('announcement', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('announcements.index')}}">
								        <span class="menu-icon">
								          <i class="fa-solid fa-bullhorn fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.announcements') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								{{-- <!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-file-waveform fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.reports') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('home')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">report1</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('home')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">report2</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item--> --}}

								@hasAccess('setting', 'view')
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-clock-rotate-left fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.logs') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('indexRequests')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.requests_logs') }}</span>
											</a>
											<!--end:Menu link-->
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('indexErrors')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.errors_logs') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								{{-- <!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-headset fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.support') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('home')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.tickets') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('home')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.create_support_ticket') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item--> --}}

								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-square-poll-horizontal fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.utilities') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('todos.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.todo_lists') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->

								@hasAccess('user', 'view')
								<!--begin:Menu item-->
								<div class="menu-item">
								    <!--begin:Menu link-->
								    <a class="menu-link" href="{{route('users.index')}}">
								        <span class="menu-icon">
								         <i class="fa-solid fa-user fs-2"></i>
								        </span>
								        <span class="menu-title">{{ __('general.users') }}</span>
								    </a>
								    <!--end:Menu link-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								@hasAccess('setting', 'view')
								<!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-gear fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.settings') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('currencies.index')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.currencies') }}</span>
								            </a>
								        </div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
								        <div class="menu-item">
								            <a class="menu-link" href="{{route('exchangeRates.index')}}">
								                <span class="menu-bullet">
								                    <span class="bullet bullet-dot"></span>
								                </span>
								                <span class="menu-title">{{ __('general.exchange_rates') }}</span>
								            </a>
								        </div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('users_roles_index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.users_roles') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('companyProfiles.index')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.company_profile') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('contact.admin')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">رسائل اتصل بنا</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item-->
								@endhasAccess

								{{-- <!--begin:Menu item-->
								<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
									<!--begin:Menu link-->
									<span class="menu-link">
										<span class="menu-icon">
											<i class="fa-solid fa-address-card fs-2"></i>
										</span>
										<span class="menu-title">{{ __('general.about') }}</span>
										<span class="menu-arrow"></span>
									</span>
									<!--end:Menu link-->
									<!--begin:Menu sub-->
									<div class="menu-sub menu-sub-accordion">
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('home')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.about') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
										<!--begin:Menu item-->
										<div class="menu-item">
											<!--begin:Menu link-->
											<a class="menu-link" href="{{route('home')}}">
												<span class="menu-bullet">
													<span class="bullet bullet-dot"></span>
												</span>
												<span class="menu-title">{{ __('general.contact') }}</span>
											</a>
											<!--end:Menu link-->
										</div>
										<!--end:Menu item-->
									</div>
									<!--end:Menu sub-->
								</div>
								<!--end:Menu item--> --}}

								
							</div>
							<!--end::Sidebar menu-->
						</div>
					</div>
					<!--end::Wrapper-->
				</div>

				<script>
					document.addEventListener('DOMContentLoaded', function () {
						const sidebar = document.querySelector('#kt_app_sidebar');
						const links = sidebar.querySelectorAll('.menu-link[href]');
					
						const currentUrl = window.location.href.split(/[?#]/)[0]; // Ignore query params and hash
					
						// Match current URL to sidebar links
						const activeLink = Array.from(links).find(link => link.href.split(/[?#]/)[0] === currentUrl);
						if (activeLink) {
							setActiveSidebarLink(activeLink);
							localStorage.setItem('activeSidebarLink', activeLink.href); // Optional: update localStorage
						}
					
						// Still save future clicks
						links.forEach(link => {
							link.addEventListener('click', function () {
								localStorage.setItem('activeSidebarLink', link.href);
							});
						});
					
						function setActiveSidebarLink(link) {
							// Remove current active states
							sidebar.querySelectorAll('.menu-link.active').forEach(el => el.classList.remove('active'));
							sidebar.querySelectorAll('.menu-item.here, .menu-item.show').forEach(el => {
								el.classList.remove('here');
								el.classList.remove('show');
							});
					
							// Activate current
							link.classList.add('active');
					
							// Traverse up and mark parents
							let parent = link.closest('.menu-item');
							while (parent) {
								parent.classList.add('here');
								if (parent.classList.contains('menu-accordion')) {
									parent.classList.add('show');
								}
								parent = parent.parentElement.closest('.menu-item');
							}
						}
					});
					</script>
					