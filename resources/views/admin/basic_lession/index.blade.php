@extends('layouts.admin',['page' => __('Basic lession'), 'pageSlug' => 'lession_plus'])

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-2">
				<!--begin::Page Title-->
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Basic Lesson</h5>
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
			@if(session()->has('message'))
			    <div class="alert alert-success">
			        {{ session()->get('message') }}
			    </div>
			@endif
			<!--begin::Dashboard-->
			<!--begin::Row-->
			<div class="row">
				<div class="col-lg-12">
					<!--begin::Advance Table Widget 4-->
					<div class="card card-custom card-stretch gutter-b">
						<!--begin::Header-->
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Basic Lesson</span>
							</h3>
							<a href="{{route('basic_lessions.create')}}" class="btn btn-primary font-weight-bolder">
								<span class="svg-icon svg-icon-md">
									<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<circle fill="#000000" cx="9" cy="15" r="6" />
											<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
										</g>
									</svg>
									<!--end::Svg Icon-->
								</span>Add new Basic Lesson</a>
						</div>
						<!--end::Header-->
						<!--begin::Body-->
						<div class="card-body pt-0 pb-3">
							<div class="tab-content">
								<!--begin: Search Form-->
								<!--begin::Search Form-->
								<div class="mb-7">
									<div class="row align-items-center">
										<div class="col-lg-9 col-xl-8">
											<div class="row align-items-center">
												<div class="col-md-4 my-2 my-md-0">
													<div class="input-icon">
														<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
														<span>
															<i class="flaticon2-search-1 text-muted"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
											<a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
										</div>
									</div>
								</div>
								<!--end::Search Form-->
								<!--end: Search Form-->
								<!--begin: Datatable-->
								<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
								<!--end: Datatable-->
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
</div>
					<!--end::Content-->
@endsection('content')
@section('page_script')
<script src="{{ asset('public/json/data-basic-lessons-json.js')}}"></script>
@endsection('page_script')