<!--begin::Modals-->
								<!--begin::Modal - Add Payment-->
								<div class="modal fade" id="kt_modal_add_payment" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Modal header-->
											<div class="modal-header">
												<!--begin::Modal title-->
												<h2 class="fw-bold">Add a Payment Record</h2>
												<!--end::Modal title-->
												<!--begin::Close-->
												<div id="kt_modal_add_payment_close"
													class="btn btn-icon btn-sm btn-active-icon-primary">
													<i class="ki-outline ki-cross fs-1"></i>
												</div>
												<!--end::Close-->
											</div>
											<!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
												<!--begin::Form-->
												<form id="kt_modal_add_payment_form" class="form" action="#">
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold form-label mb-2">
															<span class="required">Invoice Number</span>
															<span class="ms-2" data-bs-toggle="tooltip"
																title="The invoice number must be unique.">
																<i class="ki-outline ki-information fs-7"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid"
															name="invoice" value="" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label
															class="required fs-6 fw-semibold form-label mb-2">Status</label>
														<!--end::Label-->
														<!--begin::Input-->
														<select class="form-select form-select-solid fw-bold"
															name="status" data-control="select2"
															data-placeholder="Select an option" data-hide-search="true">
															<option></option>
															<option value="0">Approved</option>
															<option value="1">Pending</option>
															<option value="2">Rejected</option>
															<option value="3">In progress</option>
															<option value="4">Completed</option>
														</select>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="required fs-6 fw-semibold form-label mb-2">Invoice
															Amount</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input type="text" class="form-control form-control-solid"
															name="amount" value="" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-15">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold form-label mb-2">
															<span class="required">Additional Information</span>
															<span class="ms-2" data-bs-toggle="tooltip"
																title="Information such as description of invoice or product purchased.">
																<i class="ki-outline ki-information fs-7"></i>
															</span>
														</label>
														<!--end::Label-->
														<!--begin::Input-->
														<textarea class="form-control form-control-solid rounded-3"
															name="additional_info"></textarea>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="text-center">
														<button type="reset" id="kt_modal_add_payment_cancel"
															class="btn btn-light me-3">Discard</button>
														<button type="submit" id="kt_modal_add_payment_submit"
															class="btn btn-primary">
															<span class="indicator-label">Submit</span>
															<span class="indicator-progress">Please wait...
																<span
																	class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Modal body-->
										</div>
										<!--end::Modal content-->
									</div>
									<!--end::Modal dialog-->
								</div>
								<!--end::Modal - New Card-->
								<!--begin::Modal - Adjust Balance-->
								<div class="modal fade" id="kt_modal_adjust_balance" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Modal header-->
											<div class="modal-header">
												<!--begin::Modal title-->
												<h2 class="fw-bold">Adjust Balance</h2>
												<!--end::Modal title-->
												<!--begin::Close-->
												<div id="kt_modal_adjust_balance_close"
													class="btn btn-icon btn-sm btn-active-icon-primary">
													<i class="ki-outline ki-cross fs-1"></i>
												</div>
												<!--end::Close-->
											</div>
											<!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
												<!--begin::Balance preview-->
												<div class="d-flex text-center mb-9">
													<div
														class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
														<div class="fs-6 fw-semibold mb-2 text-muted">Current Balance
														</div>
														<div class="fs-2 fw-bold"
															kt-modal-adjust-balance="current_balance">US$ 32,487.57
														</div>
													</div>
													<div
														class="w-50 border border-dashed border-gray-300 rounded mx-2 p-4">
														<div class="fs-6 fw-semibold mb-2 text-muted">New Balance
															<span class="ms-2" data-bs-toggle="tooltip"
																title="Enter an amount to preview the new balance.">
																<i class="ki-outline ki-information fs-7"></i>
															</span>
														</div>
														<div class="fs-2 fw-bold" kt-modal-adjust-balance="new_balance">
															--</div>
													</div>
												</div>
												<!--end::Balance preview-->
												<!--begin::Form-->
												<form id="kt_modal_adjust_balance_form" class="form" action="#">
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label
															class="required fs-6 fw-semibold form-label mb-2">Adjustment
															type</label>
														<!--end::Label-->
														<!--begin::Dropdown-->
														<select class="form-select form-select-solid fw-bold"
															name="adjustment" aria-label="Select an option"
															data-control="select2"
															data-dropdown-parent="#kt_modal_adjust_balance"
															data-placeholder="Select an option" data-hide-search="true">
															<option></option>
															<option value="1">Credit</option>
															<option value="2">Debit</option>
														</select>
														<!--end::Dropdown-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label
															class="required fs-6 fw-semibold form-label mb-2">Amount</label>
														<!--end::Label-->
														<!--begin::Input-->
														<input id="kt_modal_inputmask" type="text"
															class="form-control form-control-solid" name="amount"
															value="" />
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="fv-row mb-7">
														<!--begin::Label-->
														<label class="fs-6 fw-semibold form-label mb-2">Add adjustment
															note</label>
														<!--end::Label-->
														<!--begin::Input-->
														<textarea
															class="form-control form-control-solid rounded-3 mb-5"></textarea>
														<!--end::Input-->
													</div>
													<!--end::Input group-->
													<!--begin::Disclaimer-->
													<div class="fs-7 text-muted mb-15">Please be aware that all manual
														balance changes will be audited by the financial team every
														fortnight. Please maintain your invoices and receipts until
														then. Thank you.</div>
													<!--end::Disclaimer-->
													<!--begin::Actions-->
													<div class="text-center">
														<button type="reset" id="kt_modal_adjust_balance_cancel"
															class="btn btn-light me-3">Discard</button>
														<button type="submit" id="kt_modal_adjust_balance_submit"
															class="btn btn-primary">
															<span class="indicator-label">Submit</span>
															<span class="indicator-progress">Please wait...
																<span
																	class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Modal body-->
										</div>
										<!--end::Modal content-->
									</div>
									<!--end::Modal dialog-->
								</div>
								<!--end::Modal - New Card-->
								<!--begin::Modal - New Address-->
								<div class="modal fade" id="kt_modal_update_customer" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Form-->
											<form class="form" action="#" id="kt_modal_update_customer_form">
												<!--begin::Modal header-->
												<div class="modal-header" id="kt_modal_update_customer_header">
													<!--begin::Modal title-->
													<h2 class="fw-bold">Update Customer</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div id="kt_modal_update_customer_close"
														class="btn btn-icon btn-sm btn-active-icon-primary">
														<i class="ki-outline ki-cross fs-1"></i>
													</div>
													<!--end::Close-->
												</div>
												<!--end::Modal header-->
												<!--begin::Modal body-->
												<div class="modal-body py-10 px-lg-17">
													<!--begin::Scroll-->
													<div class="d-flex flex-column scroll-y me-n7 pe-7"
														id="kt_modal_update_customer_scroll" data-kt-scroll="true"
														data-kt-scroll-activate="{default: false, lg: true}"
														data-kt-scroll-max-height="auto"
														data-kt-scroll-dependencies="#kt_modal_update_customer_header"
														data-kt-scroll-wrappers="#kt_modal_update_customer_scroll"
														data-kt-scroll-offset="300px">
														<!--begin::Notice-->
														<!--begin::Notice-->
														<div
															class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
															<!--begin::Icon-->
															<i
																class="ki-outline ki-information fs-2tx text-primary me-4"></i>
															<!--end::Icon-->
															<!--begin::Wrapper-->
															<div class="d-flex flex-stack flex-grow-1">
																<!--begin::Content-->
																<div class="fw-semibold">
																	<div class="fs-6 text-gray-700">Updating customer
																		details will receive a privacy audit. For more
																		info, please read our
																		<a href="#">Privacy Policy</a>
																	</div>
																</div>
																<!--end::Content-->
															</div>
															<!--end::Wrapper-->
														</div>
														<!--end::Notice-->
														<!--end::Notice-->
														<!--begin::User toggle-->
														<div class="fw-bold fs-3 rotate collapsible mb-7"
															data-bs-toggle="collapse"
															href="#kt_modal_update_customer_user_info" role="button"
															aria-expanded="false"
															aria-controls="kt_modal_update_customer_user_info">User
															Information
															<span class="ms-2 rotate-180">
																<i class="ki-outline ki-down fs-3"></i>
															</span>
														</div>
														<!--end::User toggle-->
														<!--begin::User form-->
														<div id="kt_modal_update_customer_user_info"
															class="collapse show">
															<!--begin::Input group-->
															<div class="mb-7">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">
																	<span>Update Avatar</span>
																	<span class="ms-1" data-bs-toggle="tooltip"
																		title="Allowed file types: png, jpg, jpeg.">
																		<i class="ki-outline ki-information fs-7"></i>
																	</span>
																</label>
																<!--end::Label-->
																<!--begin::Image input wrapper-->
																<div class="mt-1">
																	<!--begin::Image input-->
																	<div class="image-input image-input-outline"
																		data-kt-image-input="true"
																		style="background-image: url('assets/media/svg/avatars/blank.svg')">
																		<!--begin::Preview existing avatar-->
																		<div class="image-input-wrapper w-125px h-125px"
																			style="background-image: url(assets/media/avatars/300-1.jpg)">
																		</div>
																		<!--end::Preview existing avatar-->
																		<!--begin::Edit-->
																		<label
																			class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
																			data-kt-image-input-action="change"
																			data-bs-toggle="tooltip"
																			title="{{ __('general.change_picture') }}">
																			<i class="ki-outline ki-pencil fs-7"></i>
																			<!--begin::Inputs-->
																			<input type="file" name="avatar"
																				accept=".png, .jpg, .jpeg') }}" />
																			<input type="hidden" name="avatar_remove" />
																			<!--end::Inputs-->
																		</label>
																		<!--end::Edit-->
																		<!--begin::Cancel-->
																		<span
																			class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
																			data-kt-image-input-action="cancel"
																			data-bs-toggle="tooltip"
																			title="Cancel avatar">
																			<i class="ki-outline ki-cross fs-2"></i>
																		</span>
																		<!--end::Cancel-->
																		<!--begin::Remove-->
																		<span
																			class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
																			data-kt-image-input-action="remove"
																			data-bs-toggle="tooltip"
																			title="Remove avatar">
																			<i class="ki-outline ki-cross fs-2"></i>
																		</span>
																		<!--end::Remove-->
																	</div>
																	<!--end::Image input-->
																</div>
																<!--end::Image input wrapper-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="fv-row mb-7">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">Name</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input type="text"
																	class="form-control form-control-solid"
																	placeholder="" name="name" value="Sean Bean" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="fv-row mb-7">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">
																	<span>Email</span>
																	<span class="ms-1" data-bs-toggle="tooltip"
																		title="Email address must be active">
																		<i class="ki-outline ki-information fs-7"></i>
																	</span>
																</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input type="email"
																	class="form-control form-control-solid"
																	placeholder="" name="email"
																	value="sean@dellito.com" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="fv-row mb-15">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">Description</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input type="text"
																	class="form-control form-control-solid"
																	placeholder="" name="description" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
														</div>
														<!--end::User form-->
														<!--begin::Billing toggle-->
														<div class="fw-bold fs-3 rotate collapsible collapsed mb-7"
															data-bs-toggle="collapse"
															href="#kt_modal_update_customer_billing_info" role="button"
															aria-expanded="false"
															aria-controls="kt_modal_update_customer_billing_info">
															Shipping Information
															<span class="ms-2 rotate-180">
																<i class="ki-outline ki-down fs-3"></i>
															</span>
														</div>
														<!--end::Billing toggle-->
														<!--begin::Billing form-->
														<div id="kt_modal_update_customer_billing_info"
															class="collapse">
															<!--begin::Input group-->
															<div class="d-flex flex-column mb-7 fv-row">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">Address Line
																	1</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	placeholder="" name="address1"
																	value="101, Collins Street" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="d-flex flex-column mb-7 fv-row">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">Address Line
																	2</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	placeholder="" name="address2" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="d-flex flex-column mb-7 fv-row">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">Town</label>
																<!--end::Label-->
																<!--begin::Input-->
																<input class="form-control form-control-solid"
																	placeholder="" name="city" value="Melbourne" />
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="row g-9 mb-7">
																<!--begin::Col-->
																<div class="col-md-6 fv-row">
																	<!--begin::Label-->
																	<label class="fs-6 fw-semibold mb-2">State /
																		Province</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input class="form-control form-control-solid"
																		placeholder="" name="state" value="Victoria" />
																	<!--end::Input-->
																</div>
																<!--end::Col-->
																<!--begin::Col-->
																<div class="col-md-6 fv-row">
																	<!--begin::Label-->
																	<label class="fs-6 fw-semibold mb-2">Post
																		Code</label>
																	<!--end::Label-->
																	<!--begin::Input-->
																	<input class="form-control form-control-solid"
																		placeholder="" name="postcode" value="3000" />
																	<!--end::Input-->
																</div>
																<!--end::Col-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="d-flex flex-column mb-7 fv-row">
																<!--begin::Label-->
																<label class="fs-6 fw-semibold mb-2">
																	<span>Country</span>
																	<span class="ms-1" data-bs-toggle="tooltip"
																		title="Country of origination">
																		<i class="ki-outline ki-information fs-7"></i>
																	</span>
																</label>
																<!--end::Label-->
																<!--begin::Input-->
																<select name="country" aria-label="Select a Country"
																	data-control="select2"
																	data-placeholder="Select a Country..."
																	data-dropdown-parent="#kt_modal_update_customer"
																	class="form-select form-select-solid fw-bold">
																	<option value="">Select a Country...</option>
																	<option value="AF">Afghanistan</option>
																	<option value="AX">Aland Islands</option>
																	<option value="AL">Albania</option>
																	<option value="DZ">Algeria</option>
																	<option value="AS">American Samoa</option>
																	<option value="AD">Andorra</option>
																	<option value="AO">Angola</option>
																	<option value="AI">Anguilla</option>
																	<option value="AG">Antigua and Barbuda</option>
																	<option value="AR">Argentina</option>
																	<option value="AM">Armenia</option>
																	<option value="AW">Aruba</option>
																	<option value="AU">Australia</option>
																	<option value="AT">Austria</option>
																	<option value="AZ">Azerbaijan</option>
																	<option value="BS">Bahamas</option>
																	<option value="BH">Bahrain</option>
																	<option value="BD">Bangladesh</option>
																	<option value="BB">Barbados</option>
																	<option value="BY">Belarus</option>
																	<option value="BE">Belgium</option>
																	<option value="BZ">Belize</option>
																	<option value="BJ">Benin</option>
																	<option value="BM">Bermuda</option>
																	<option value="BT">Bhutan</option>
																	<option value="BO">Bolivia, Plurinational State of
																	</option>
																	<option value="BQ">Bonaire, Sint Eustatius and Saba
																	</option>
																	<option value="BA">Bosnia and Herzegovina</option>
																	<option value="BW">Botswana</option>
																	<option value="BR">Brazil</option>
																	<option value="IO">British Indian Ocean Territory
																	</option>
																	<option value="BN">Brunei Darussalam</option>
																	<option value="BG">Bulgaria</option>
																	<option value="BF">Burkina Faso</option>
																	<option value="BI">Burundi</option>
																	<option value="KH">Cambodia</option>
																	<option value="CM">Cameroon</option>
																	<option value="CA">Canada</option>
																	<option value="CV">Cape Verde</option>
																	<option value="KY">Cayman Islands</option>
																	<option value="CF">Central African Republic</option>
																	<option value="TD">Chad</option>
																	<option value="CL">Chile</option>
																	<option value="CN">China</option>
																	<option value="CX">Christmas Island</option>
																	<option value="CC">Cocos (Keeling) Islands</option>
																	<option value="CO">Colombia</option>
																	<option value="KM">Comoros</option>
																	<option value="CK">Cook Islands</option>
																	<option value="CR">Costa Rica</option>
																	<option value="CI">Côte d'Ivoire</option>
																	<option value="HR">Croatia</option>
																	<option value="CU">Cuba</option>
																	<option value="CW">Curaçao</option>
																	<option value="CZ">Czech Republic</option>
																	<option value="DK">Denmark</option>
																	<option value="DJ">Djibouti</option>
																	<option value="DM">Dominica</option>
																	<option value="DO">Dominican Republic</option>
																	<option value="EC">Ecuador</option>
																	<option value="EG">Egypt</option>
																	<option value="SV">El Salvador</option>
																	<option value="GQ">Equatorial Guinea</option>
																	<option value="ER">Eritrea</option>
																	<option value="EE">Estonia</option>
																	<option value="ET">Ethiopia</option>
																	<option value="FK">Falkland Islands (Malvinas)
																	</option>
																	<option value="FJ">Fiji</option>
																	<option value="FI">Finland</option>
																	<option value="FR">France</option>
																	<option value="PF">French Polynesia</option>
																	<option value="GA">Gabon</option>
																	<option value="GM">Gambia</option>
																	<option value="GE">Georgia</option>
																	<option value="DE">Germany</option>
																	<option value="GH">Ghana</option>
																	<option value="GI">Gibraltar</option>
																	<option value="GR">Greece</option>
																	<option value="GL">Greenland</option>
																	<option value="GD">Grenada</option>
																	<option value="GU">Guam</option>
																	<option value="GT">Guatemala</option>
																	<option value="GG">Guernsey</option>
																	<option value="GN">Guinea</option>
																	<option value="GW">Guinea-Bissau</option>
																	<option value="HT">Haiti</option>
																	<option value="VA">Holy See (Vatican City State)
																	</option>
																	<option value="HN">Honduras</option>
																	<option value="HK">Hong Kong</option>
																	<option value="HU">Hungary</option>
																	<option value="IS">Iceland</option>
																	<option value="IN">India</option>
																	<option value="ID">Indonesia</option>
																	<option value="IR">Iran, Islamic Republic of
																	</option>
																	<option value="IQ">Iraq</option>
																	<option value="IE">Ireland</option>
																	<option value="IM">Isle of Man</option>
																	<option value="IL">Israel</option>
																	<option value="IT">Italy</option>
																	<option value="JM">Jamaica</option>
																	<option value="JP">Japan</option>
																	<option value="JE">Jersey</option>
																	<option value="JO">Jordan</option>
																	<option value="KZ">Kazakhstan</option>
																	<option value="KE">Kenya</option>
																	<option value="KI">Kiribati</option>
																	<option value="KP">Korea, Democratic People's
																		Republic of</option>
																	<option value="KW">Kuwait</option>
																	<option value="KG">Kyrgyzstan</option>
																	<option value="LA">Lao People's Democratic Republic
																	</option>
																	<option value="LV">Latvia</option>
																	<option value="LB">Lebanon</option>
																	<option value="LS">Lesotho</option>
																	<option value="LR">Liberia</option>
																	<option value="LY">Libya</option>
																	<option value="LI">Liechtenstein</option>
																	<option value="LT">Lithuania</option>
																	<option value="LU">Luxembourg</option>
																	<option value="MO">Macao</option>
																	<option value="MG">Madagascar</option>
																	<option value="MW">Malawi</option>
																	<option value="MY">Malaysia</option>
																	<option value="MV">Maldives</option>
																	<option value="ML">Mali</option>
																	<option value="MT">Malta</option>
																	<option value="MH">Marshall Islands</option>
																	<option value="MQ">Martinique</option>
																	<option value="MR">Mauritania</option>
																	<option value="MU">Mauritius</option>
																	<option value="MX">Mexico</option>
																	<option value="FM">Micronesia, Federated States of
																	</option>
																	<option value="MD">Moldova, Republic of</option>
																	<option value="MC">Monaco</option>
																	<option value="MN">Mongolia</option>
																	<option value="ME">Montenegro</option>
																	<option value="MS">Montserrat</option>
																	<option value="MA">Morocco</option>
																	<option value="MZ">Mozambique</option>
																	<option value="MM">Myanmar</option>
																	<option value="NA">Namibia</option>
																	<option value="NR">Nauru</option>
																	<option value="NP">Nepal</option>
																	<option value="NL">Netherlands</option>
																	<option value="NZ">New Zealand</option>
																	<option value="NI">Nicaragua</option>
																	<option value="NE">Niger</option>
																	<option value="NG">Nigeria</option>
																	<option value="NU">Niue</option>
																	<option value="NF">Norfolk Island</option>
																	<option value="MP">Northern Mariana Islands</option>
																	<option value="NO">Norway</option>
																	<option value="OM">Oman</option>
																	<option value="PK">Pakistan</option>
																	<option value="PW">Palau</option>
																	<option value="PS">Palestinian Territory, Occupied
																	</option>
																	<option value="PA">Panama</option>
																	<option value="PG">Papua New Guinea</option>
																	<option value="PY">Paraguay</option>
																	<option value="PE">Peru</option>
																	<option value="PH">Philippines</option>
																	<option value="PL">Poland</option>
																	<option value="PT">Portugal</option>
																	<option value="PR">Puerto Rico</option>
																	<option value="QA">Qatar</option>
																	<option value="RO">Romania</option>
																	<option value="RU">Russian Federation</option>
																	<option value="RW">Rwanda</option>
																	<option value="BL">Saint Barthélemy</option>
																	<option value="KN">Saint Kitts and Nevis</option>
																	<option value="LC">Saint Lucia</option>
																	<option value="MF">Saint Martin (French part)
																	</option>
																	<option value="VC">Saint Vincent and the Grenadines
																	</option>
																	<option value="WS">Samoa</option>
																	<option value="SM">San Marino</option>
																	<option value="ST">Sao Tome and Principe</option>
																	<option value="SA">Saudi Arabia</option>
																	<option value="SN">Senegal</option>
																	<option value="RS">Serbia</option>
																	<option value="SC">Seychelles</option>
																	<option value="SL">Sierra Leone</option>
																	<option value="SG">Singapore</option>
																	<option value="SX">Sint Maarten (Dutch part)
																	</option>
																	<option value="SK">Slovakia</option>
																	<option value="SI">Slovenia</option>
																	<option value="SB">Solomon Islands</option>
																	<option value="SO">Somalia</option>
																	<option value="ZA">South Africa</option>
																	<option value="KR">South Korea</option>
																	<option value="SS">South Sudan</option>
																	<option value="ES">Spain</option>
																	<option value="LK">Sri Lanka</option>
																	<option value="SD">Sudan</option>
																	<option value="SR">Suriname</option>
																	<option value="SZ">Swaziland</option>
																	<option value="SE">Sweden</option>
																	<option value="CH">Switzerland</option>
																	<option value="SY">Syrian Arab Republic</option>
																	<option value="TW">Taiwan, Province of China
																	</option>
																	<option value="TJ">Tajikistan</option>
																	<option value="TZ">Tanzania, United Republic of
																	</option>
																	<option value="TH">Thailand</option>
																	<option value="TG">Togo</option>
																	<option value="TK">Tokelau</option>
																	<option value="TO">Tonga</option>
																	<option value="TT">Trinidad and Tobago</option>
																	<option value="TN">Tunisia</option>
																	<option value="TR">Turkey</option>
																	<option value="TM">Turkmenistan</option>
																	<option value="TC">Turks and Caicos Islands</option>
																	<option value="TV">Tuvalu</option>
																	<option value="UG">Uganda</option>
																	<option value="UA">Ukraine</option>
																	<option value="AE">United Arab Emirates</option>
																	<option value="GB">United Kingdom</option>
																	<option value="US">United States</option>
																	<option value="UY">Uruguay</option>
																	<option value="UZ">Uzbekistan</option>
																	<option value="VU">Vanuatu</option>
																	<option value="VE">Venezuela, Bolivarian Republic of
																	</option>
																	<option value="VN">Vietnam</option>
																	<option value="VI">Virgin Islands</option>
																	<option value="YE">Yemen</option>
																	<option value="ZM">Zambia</option>
																	<option value="ZW">Zimbabwe</option>
																</select>
																<!--end::Input-->
															</div>
															<!--end::Input group-->
															<!--begin::Input group-->
															<div class="fv-row mb-7">
																<!--begin::Wrapper-->
																<div class="d-flex flex-stack">
																	<!--begin::Label-->
																	<div class="me-5">
																		<!--begin::Label-->
																		<label class="fs-6 fw-semibold">Use as a billing
																			adderess?</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<div class="fs-7 fw-semibold text-muted">If you
																			need more info, please check budget planning
																		</div>
																		<!--end::Input-->
																	</div>
																	<!--end::Label-->
																	<!--begin::Switch-->
																	<label
																		class="form-check form-switch form-check-custom form-check-solid">
																		<!--begin::Input-->
																		<input class="form-check-input" name="billing"
																			type="checkbox" value="1"
																			id="kt_modal_update_customer_billing"
																			checked="checked" />
																		<!--end::Input-->
																		<!--begin::Label-->
																		<span
																			class="form-check-label fw-semibold text-muted"
																			for="kt_modal_update_customer_billing">Yes</span>
																		<!--end::Label-->
																	</label>
																	<!--end::Switch-->
																</div>
																<!--begin::Wrapper-->
															</div>
															<!--end::Input group-->
														</div>
														<!--end::Billing form-->
													</div>
													<!--end::Scroll-->
												</div>
												<!--end::Modal body-->
												<!--begin::Modal footer-->
												<div class="modal-footer flex-center">
													<!--begin::Button-->
													<button type="reset" id="kt_modal_update_customer_cancel"
														class="btn btn-light me-3">Discard</button>
													<!--end::Button-->
													<!--begin::Button-->
													<button type="submit" id="kt_modal_update_customer_submit"
														class="btn btn-primary">
														<span class="indicator-label">Submit</span>
														<span class="indicator-progress">Please wait...
															<span
																class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
													</button>
													<!--end::Button-->
												</div>
												<!--end::Modal footer-->
											</form>
											<!--end::Form-->
										</div>
									</div>
								</div>
								<!--end::Modal - New Address-->
								<!--begin::Modal - New Card-->
								<div class="modal fade" id="kt_modal_new_card" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											<!--begin::Modal header-->
											<div class="modal-header">
												<!--begin::Modal title-->
												<h2>Add New Card</h2>
												<!--end::Modal title-->
												<!--begin::Close-->
												<div class="btn btn-sm btn-icon btn-active-color-primary"
													data-bs-dismiss="modal">
													<i class="ki-outline ki-cross fs-1"></i>
												</div>
												<!--end::Close-->
											</div>
											<!--end::Modal header-->
											<!--begin::Modal body-->
											<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
												<!--begin::Form-->
												<form id="kt_modal_new_card_form" class="form" action="#">
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-7 fv-row">
														<!--begin::Label-->
														<label
															class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
															<span class="required">Name On Card</span>
															<span class="ms-1" data-bs-toggle="tooltip"
																title="Specify a card holder's name">
																<i
																	class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span>
														</label>
														<!--end::Label-->
														<input type="text" class="form-control form-control-solid"
															placeholder="" name="card_name" value="Max Doe" />
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-column mb-7 fv-row">
														<!--begin::Label-->
														<label class="required fs-6 fw-semibold form-label mb-2">Card
															Number</label>
														<!--end::Label-->
														<!--begin::Input wrapper-->
														<div class="position-relative">
															<!--begin::Input-->
															<input type="text" class="form-control form-control-solid"
																placeholder="Enter card number" name="card_number"
																value="4111 1111 1111 1111" />
															<!--end::Input-->
															<!--begin::Card logos-->
															<div
																class="position-absolute translate-middle-y top-50 end-0 me-5">
																<img src="{{ asset('assets/media/svg/card-logos/visa.svg') }}"
																	alt="" class="h-25px" />
																<img src="{{ asset('assets/media/svg/card-logos/mastercard.svg') }}"
																	alt="" class="h-25px" />
																<img src="{{ asset('assets/media/svg/card-logos/american-express.svg') }}"
																	alt="" class="h-25px" />
															</div>
															<!--end::Card logos-->
														</div>
														<!--end::Input wrapper-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="row mb-10">
														<!--begin::Col-->
														<div class="col-md-8 fv-row">
															<!--begin::Label-->
															<label
																class="required fs-6 fw-semibold form-label mb-2">Expiration
																Date</label>
															<!--end::Label-->
															<!--begin::Row-->
															<div class="row fv-row">
																<!--begin::Col-->
																<div class="col-6">
																	<select name="card_expiry_month"
																		class="form-select form-select-solid"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="Month">
																		<option></option>
																		<option value="1">1</option>
																		<option value="2">2</option>
																		<option value="3">3</option>
																		<option value="4">4</option>
																		<option value="5">5</option>
																		<option value="6">6</option>
																		<option value="7">7</option>
																		<option value="8">8</option>
																		<option value="9">9</option>
																		<option value="10">10</option>
																		<option value="11">11</option>
																		<option value="12">12</option>
																	</select>
																</div>
																<!--end::Col-->
																<!--begin::Col-->
																<div class="col-6">
																	<select name="card_expiry_year"
																		class="form-select form-select-solid"
																		data-control="select2" data-hide-search="true"
																		data-placeholder="Year">
																		<option></option>
																		<option value="2024">2024</option>
																		<option value="2025">2025</option>
																		<option value="2026">2026</option>
																		<option value="2027">2027</option>
																		<option value="2028">2028</option>
																		<option value="2029">2029</option>
																		<option value="2030">2030</option>
																		<option value="2031">2031</option>
																		<option value="2032">2032</option>
																		<option value="2033">2033</option>
																		<option value="2034">2034</option>
																	</select>
																</div>
																<!--end::Col-->
															</div>
															<!--end::Row-->
														</div>
														<!--end::Col-->
														<!--begin::Col-->
														<div class="col-md-4 fv-row">
															<!--begin::Label-->
															<label
																class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
																<span class="required">CVV</span>
																<span class="ms-1" data-bs-toggle="tooltip"
																	title="Enter a card CVV code">
																	<i
																		class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
																</span>
															</label>
															<!--end::Label-->
															<!--begin::Input wrapper-->
															<div class="position-relative">
																<!--begin::Input-->
																<input type="text"
																	class="form-control form-control-solid"
																	minlength="3" maxlength="4" placeholder="CVV"
																	name="card_cvv" />
																<!--end::Input-->
																<!--begin::CVV icon-->
																<div
																	class="position-absolute translate-middle-y top-50 end-0 me-3">
																	<i class="ki-outline ki-credit-cart fs-2hx"></i>
																</div>
																<!--end::CVV icon-->
															</div>
															<!--end::Input wrapper-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
													<!--begin::Input group-->
													<div class="d-flex flex-stack">
														<!--begin::Label-->
														<div class="me-5">
															<label class="fs-6 fw-semibold form-label">Save Card for
																further billing?</label>
															<div class="fs-7 fw-semibold text-muted">If you need more
																info, please check budget planning</div>
														</div>
														<!--end::Label-->
														<!--begin::Switch-->
														<label
															class="form-check form-switch form-check-custom form-check-solid">
															<input class="form-check-input" type="checkbox" value="1"
																checked="checked" />
															<span class="form-check-label fw-semibold text-muted">Save
																Card</span>
														</label>
														<!--end::Switch-->
													</div>
													<!--end::Input group-->
													<!--begin::Actions-->
													<div class="text-center pt-15">
														<button type="reset" id="kt_modal_new_card_cancel"
															class="btn btn-light me-3">Discard</button>
														<button type="submit" id="kt_modal_new_card_submit"
															class="btn btn-primary">
															<span class="indicator-label">Submit</span>
															<span class="indicator-progress">Please wait...
																<span
																	class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
													</div>
													<!--end::Actions-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Modal body-->
										</div>
										<!--end::Modal content-->
									</div>
									<!--end::Modal dialog-->
								</div>
								<!--end::Modal - New Card-->
								