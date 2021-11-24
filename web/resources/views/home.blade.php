@extends('layouts.admin',['page' => __('Dashboard'), 'pageSlug' => 'dashboard'])

@section('content')
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-2">
				<!--begin::Page Title-->
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>
				<!--end::Page Title-->
			</div>
			<!--end::Info-->
		</div>
	</div>
	<!--end::Subheader-->

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Dashboard-->
			<!--begin::Row-->
			<div class="row">
				<div class="col-lg-12">
					<!--begin::Advance Table Widget 4-->
					<div class="card card-custom card-stretch gutter-b">
						<!--begin::Header-->
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Recent Users</span>
							</h3>
						</div>
						<!--end::Header-->
						<!--begin::Body-->
						<div class="card-body pt-0 pb-3">
							<div class="tab-content">
								<!--begin::Table-->
								<div class="table-responsive">
									<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
										<thead>
											<tr class="text-left text-uppercase">
												<th style="min-width: 250px" class="pl-7">
													<span class="text-dark-75">User</span>
												</th>
												<th style="min-width: 210px">Name</th>
												<th style="min-width: 100px">Level</th>
												<th style="min-width: 100px">Status</th>
												<th style="min-width: 100px">Membership</th>
											</tr>
										</thead>
										<tbody>
											@if(!empty($users))

											@foreach($users as $user)

											<tr>
												<td class="pl-0 py-8">
													<div class="d-flex align-items-center">
														<div class="symbol symbol-50 symbol-light mr-4">
															<span class="symbol-label">
																<img src="{{ asset('public/media/svg/avatars/001-boy.svg')}}" class="h-75 align-self-end" alt="" />
															</span>
														</div>
														<div>
															<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$user['username'] ?? ''}}</a>
														</div>
													</div>
												</td>
												<td>
													<span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$user['firstname'] ?? ''}} {{$user['lastname'] ?? ''}}</span>
												</td>
												<td>
													<span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$user['levels']['level_name'] ?? ''}}</span>
												</td>
												<td>
													<span class="text-dark-75 font-weight-bolder d-block font-size-lg">@if($user['user_ban'] == 1){{_('Active')}}@endif
													@if($user['user_ban'] == 2){{_('Inactive')}}@endif
													</span>
												</td>
												<td>
													<span class="text-dark-75 font-weight-bolder d-block font-size-lg">@if($user['user_membership'] == 1){{_('Free')}}@elseif($user['user_membership'] == 2){{_('Premium')}}@endif</span>
												</td>
											</tr>
											@endforeach
											@endif
											
										
											</tbody>
										</table>
									</div>
									<!--end::Table-->
								</div>
							</div>
							<!--end::Body-->
						</div>
						<!--end::Advance Table Widget 4-->
					</div>
				</div>
				<!--end::Row-->
				<!--end::Dashboard-->
			</div>
			<!--end::Container-->
		</div>
						<!--end::Entry-->
@endsection