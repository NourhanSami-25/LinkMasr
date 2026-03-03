    <!--begin::Todo drawer-->
	<div id="kt_drawer_chat" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="chat"
		data-kt-drawer-activate="true" data-kt-drawer-overlay="false"
		data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end"
		data-kt-drawer-toggle="#kt_drawer_chat_toggle" data-kt-drawer-close="#kt_drawer_chat_close">
		<!--begin::List-->
		<div class="card w-100 border-0 rounded-0" id="kt_drawer_chat_messenger">
			<!--begin::Card header-->
			<div class="card-header pe-5" id="kt_drawer_chat_messenger_header">
				<!--begin::Title-->
				<div class="card-title">
					<!--begin::User-->
					<div class="d-flex justify-content-center flex-column me-3">
						<a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{__('general.todo_lists')}}</a>
						<!--begin::Info-->
						<div class="mb-0 lh-1">
							<span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
							<span class="fs-7 fw-semibold text-muted">{{__getUserNameById(Auth()->id())}}</span>
						</div>
						<!--end::Info-->
					</div>
					<!--end::User-->
				</div>
				<!--end::Title-->
				<!--begin::Card toolbar-->
				<div class="card-toolbar">
					<!--begin::Close-->
					<div class="btn btn-sm btn-icon btn-active-color-primary" id="kt_drawer_chat_close">
						<i class="ki-outline ki-cross-square fs-2"></i>
					</div>
					<!--end::Close-->
				</div>
				<!--end::Card toolbar-->
			</div>
			<!--end::Card header-->
			<!--begin::Card body-->
			<div class="card-body" id="kt_drawer_chat_messenger_body">
			    <!--begin::Todo List-->
			    <div class="scroll-y me-n5 pe-5" data-kt-element="messages" data-kt-scroll="true"
			        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
			        data-kt-scroll-dependencies="#kt_drawer_chat_messenger_header, #kt_drawer_chat_messenger_footer"
			        data-kt-scroll-wrappers="#kt_drawer_chat_messenger_body" data-kt-scroll-offset="0px">
			    </div>
			    <!--end::Todo List-->
			</div>
			<!--end::Card body-->

			<!--begin::Card footer-->
			<div class="card-footer pt-4" id="kt_drawer_chat_messenger_footer">
				<!--begin:Toolbar-->
				<div class="d-flex flex-stack justify-content-center">
					<!--begin::Create-->
					<a href="{{route('todos.create')}}" class="btn btn-primary me-2" type="button" data-kt-element="send" target="_blank">{{__('general.create_new')}}</a>
					<a href="{{route('todos.index')}}" class="btn btn-warning me-2" type="button" data-kt-element="send">{{__('general.view_all')}}</a>
					<!--end::Create-->
				</div>
				<!--end::Toolbar-->
			</div>
			<!--end::Card footer-->
		</div>
		<!--end::List-->
	</div>
	<!--end::Todo drawer-->