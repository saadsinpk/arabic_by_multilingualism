@extends('layouts.admin',['page' => __('Messages'), 'pageSlug' => 'messages'])

@section('content')
<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Subheader-->
		<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
			<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
				<!--begin::Info-->
				<div class="d-flex align-items-center flex-wrap mr-2">
					<!--begin::Page Title-->
					<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Message Box : <b>Username</b></h5>
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
				@include('includes.alert')
				<!--begin::Dashboard-->
				<!--begin::Row-->
				<div class="row">
					<div class="col-lg-12">
						<!--begin::Advance Table Widget 4-->
						<div class="card card-custom card-stretch gutter-b">
							<!--begin::Header-->
							<div class="card-header border-0 py-5">
								<h3 class="card-title align-items-start flex-column">
									<span class="card-label font-weight-bolder text-dark">Message Box</span>
								</h3>
							</div>
							<!--end::Header-->
							<!--begin::Body-->
							 <!--begin::Form-->
							<div class="card-body px-0">
								<div class="container">
									<form class="form" action="{{ route('messages.update',$messages['user_id'])}}" method="POST">
										@csrf
										@method('PUT')
										<div class="form-group">
											<textarea class="form-control form-control-lg form-control-solid" id="exampleTextarea" name="message" rows="3" placeholder="Type Message"></textarea>
										</div>
										<div class="row">
											<div class="col">
												<button type="submit" name="submitform" class="btn btn-primary mr-2">Submit</button>
						  						 <button type="reset" class="btn btn-secondary">Cancel</button>
											</div>
										</div>
									</form>
									<div class="separator separator-dashed my-10"></div>
									<!--begin::Timeline-->
									<div class="timeline timeline-3">
										<div class="timeline-items">
											@foreach($messages_all as $message)
											<div class="timeline-item">
												<div class="timeline-content">
													<div class="d-flex align-items-center justify-content-between mb-3">
														<div class="mr-2">
															<a href="#" class="text-dark-75 text-hover-primary font-weight-bold">@if($message->sendbyuser == $message->user_id) User @else Admin @endif has sent a message.</a>
															<span class="text-muted ml-2">{{date_create($message->created_at)->format('h:iA d M')}} </span>
														</div>
													</div>
													<p class="p-0">{{ $message->message ?? ''}}</p>
												</div>
											</div>
											@endforeach
											
											
										</div>
									</div>
									<!--end::Timeline-->
								</div>
							</div>
							 <!--end::Form-->
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
	</div>
	<!--end::Content-->
	@endsection('content')