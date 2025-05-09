@extends('layouts.admin',['page' => __('Users'), 'pageSlug' => 'users'])

@section('content')
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
	<!--begin::Info-->
	<div class="d-flex align-items-center flex-wrap mr-2">
		<!--begin::Page Title-->
		<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">User</h5>
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
	@if(Session::has('flash_message'))
		    <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
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
						<span class="card-label font-weight-bolder text-dark">Users</span>
					</h3>
					<a href="{{ route('users.create')}}" class="btn btn-primary font-weight-bolder">
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
						</span>Add new user</a>
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
@endsection('content')
@section('page_script')
<!-- <script src="{{ asset('public/json/data-user-json.js')}}"></script> -->
<script type="text/javascript">
	"use strict";
// Class definition

var KTDatatableJsonRemoteDemo = function() {
    // Private functions

    // basic demo
    var demo = function() {
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: HOST_URL + '/api/?data=user',
                pageSize: 10,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [{
                field: 'id',
                title: 'User ID',
            }, {
                field: 'name',
                title: 'Name',
                template: function(row) {
                    return row.firstname + ' ' + row.lastname;
                },
            }, {
                field: 'group',
                title: 'Group',
                template: function(row) {
                    if(row.usergroup == '1') {
                        return 'Admin';
                    } else {
                        return 'User';
                    }
                },
            }, {
                field: 'username',
                title: 'Username'
            }, {
                field: 'user_ban',
                title: 'Status',
                // callback function support for column rendering
                template: function(row) {
                    if(row.user_ban == 1) {
                    	
                        return '<span class="label font-weight-bold label-lg label-light-success label-inline">Active</span>';
                    } else {
                        return '<span class="label font-weight-bold label-lg label-light-danger label-inline">Ban</span>';
                    }
                },
            }, {
                field: 'user_membership',
                title: 'Type',
                template: function(row) {
                    if(row.user_membership == 1) {
                        return '<span class="label label-primary label-dot mr-2"></span><span class="font-weight-bold text-primary">Free</span>';
                    } else {
                        return '<span class="label label-primary label-dot mr-2"></span><span class="font-weight-bold text-Premium">Premium</span>';
                    }
                },
            },
            {
                field: 'View',
                title: 'View',
                template: function(row) {
                    return '<a href="'+APP_URL+'/login_status/'+row.id+'">Login</a> | <a href="'+APP_URL+'/question_status/'+row.id+'">Questions</a> | <a href="'+APP_URL+'/lesson_status/'+row.id+'">Lessons</a> | <a href="'+APP_URL+'/revision_status/'+row.id+'">Revision</a> | <a href="'+APP_URL+'/remind_status/'+row.id+'">Remind</a>'; },
            }, {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 125,
                autoHide: false,
                overflow: 'visible',
                template: function(row) {
                    return '\
                        <a href="'+APP_URL+'/messages/'+row.id+'/edit" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">\
                            <span class="svg-icon svg-icon-md">\
                                <?xml version="1.0" encoding="iso-8859-1"?>\
                                    <!-- Generator: Adobe Illustrator 18.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->\
                                    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\
                                         viewBox="0 0 216 216" style="enable-background:new 0 0 216 216;" xml:space="preserve">\
                                    <path d="M108,0C48.353,0,0,48.353,0,108s48.353,108,108,108s108-48.353,108-108S167.647,0,108,0z M156.657,60L107.96,98.498\
                                        L57.679,60H156.657z M161.667,156h-109V76.259l50.244,38.11c1.347,1.03,3.34,1.545,4.947,1.545c1.645,0,3.073-0.54,4.435-1.616\
                                        l49.374-39.276V156z"/>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                    <g>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                        <a href="'+APP_URL+'/user_transaction/'+row.id+'" class="btn btn-sm btn-clean btn-icon" title="Transaction">\
                            <span class="svg-icon svg-icon-md">\
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">\
                                <path style="fill:#0E9347;" d="M488.727,325.818H23.273C10.473,325.818,0,315.345,0,302.545v-256\
                                    c0-12.8,10.473-23.273,23.273-23.273h465.455c12.8,0,23.273,10.473,23.273,23.273v256C512,315.345,501.527,325.818,488.727,325.818z\
                                    "/>\
                                <path style="fill:#0D8944;" d="M430.545,232.727c-26.764,0-51.2,12.8-65.164,33.745C353.745,260.655,340.945,256,325.818,256\
                                    c-40.727,0-74.473,30.255-80.291,69.818h243.2c11.636,0,20.945-8.145,23.273-19.782\
                                    C507.345,265.309,472.436,232.727,430.545,232.727z"/>\
                                <path style="fill:#3BB54A;" d="M442.182,302.545H69.818c0-25.6-20.945-46.545-46.545-46.545V93.091\
                                    c25.6,0,46.545-20.945,46.545-46.545h372.364c0,25.6,20.945,46.545,46.545,46.545V256C463.127,256,442.182,276.945,442.182,302.545z\
                                    "/>\
                                <g>\
                                    <path style="fill:#0E9347;" d="M430.545,232.727c-26.764,0-51.2,12.8-65.164,33.745C353.745,260.655,340.945,256,325.818,256\
                                        c-32.582,0-60.509,18.618-73.309,46.545h189.673c0-25.6,19.782-45.382,45.382-46.545\
                                        C472.436,242.036,452.655,232.727,430.545,232.727z"/>\
                                    <ellipse style="fill:#0E9347;" cx="256" cy="174.545" rx="93.091" ry="104.727"/>\
                                    <circle style="fill:#0E9347;" cx="116.364" cy="174.545" r="23.273"/>\
                                    <circle style="fill:#0E9347;" cx="395.636" cy="174.545" r="23.273"/>\
                                </g>\
                                <path style="fill:#89C763;" d="M267.636,162.909h-23.273c-6.982,0-11.636-4.655-11.636-11.636c0-6.982,4.655-11.636,11.636-11.636\
                                    h34.909c6.982,0,11.636-4.655,11.636-11.636c0-6.982-4.655-11.636-11.636-11.636h-11.636c0-6.982-4.655-11.636-11.636-11.636\
                                    c-6.982,0-11.636,4.655-11.636,11.636c-19.782,0-34.909,15.127-34.909,34.909s15.127,34.909,34.909,34.909h23.273\
                                    c6.982,0,11.636,4.655,11.636,11.636c0,6.982-4.655,11.636-11.636,11.636h-34.909c-6.982,0-11.636,4.655-11.636,11.636\
                                    c0,6.982,4.655,11.636,11.636,11.636h11.636c0,6.982,4.655,11.636,11.636,11.636c6.982,0,11.636-4.655,11.636-11.636\
                                    c19.782,0,34.909-15.127,34.909-34.909S287.418,162.909,267.636,162.909z"/>\
                                <circle style="fill:#FFCA5D;" cx="302.545" cy="337.455" r="81.455"/>\
                                <circle style="fill:#F6B545;" cx="407.273" cy="314.182" r="81.455"/>\
                                <path style="fill:#FFCB5B;" d="M407.273,232.727c-45.382,0-81.455,36.073-81.455,81.455s36.073,81.455,81.455,81.455\
                                    s81.455-36.073,81.455-81.455S452.655,232.727,407.273,232.727z M407.273,372.364c-32.582,0-58.182-25.6-58.182-58.182\
                                    S374.691,256,407.273,256s58.182,25.6,58.182,58.182S439.855,372.364,407.273,372.364z"/>\
                                <path style="fill:#F6B545;" d="M407.273,394.473L407.273,394.473c45.382,1.164,81.455-36.073,81.455-80.291h-1.164\
                                    c-5.818,0-10.473,4.655-11.636,10.473c-2.327,16.291-10.473,31.418-22.109,41.891c-9.309,9.309-22.109,15.127-36.073,17.454\
                                    C411.927,384,407.273,388.655,407.273,394.473z"/>\
                                <path style="fill:#FFE27A;" d="M407.273,233.891L407.273,233.891c-45.382-1.164-81.455,36.073-81.455,80.291h1.164\
                                    c5.818,0,10.473-4.655,11.636-10.473c2.327-16.291,10.473-31.418,22.109-41.891c9.309-9.309,22.109-15.127,36.073-17.455\
                                    C402.618,244.364,407.273,239.709,407.273,233.891z"/>\
                                <path style="fill:#F19920;" d="M357.236,322.327c0-32.582,25.6-58.182,58.182-58.182c13.964,0,26.764,4.655,37.236,13.964\
                                    C441.018,264.145,425.891,256,407.273,256c-32.582,0-58.182,25.6-58.182,58.182c0,18.618,8.145,33.745,20.945,44.218\
                                    C361.891,349.091,357.236,336.291,357.236,322.327z"/>\
                                <path style="fill:#FFCB5B;" d="M442.182,350.255c-1.164,0-2.327,0-3.491-1.164c-2.327-2.327-2.327-5.818,0-8.145\
                                    c6.982-6.982,10.473-17.455,10.473-26.764c0-3.491,2.327-5.818,5.818-5.818c3.491,0,5.818,2.327,5.818,5.818\
                                    c0,12.8-4.655,25.6-12.8,34.909C445.673,350.255,443.345,350.255,442.182,350.255z"/>\
                                <g>\
                                    <path style="fill:#F19920;" d="M407.273,349.091c-6.982,0-11.636-4.655-11.636-11.636v-46.545c0-6.982,4.655-11.636,11.636-11.636\
                                        s11.636,4.655,11.636,11.636v46.545C418.909,344.436,414.255,349.091,407.273,349.091z"/>\
                                    <path style="fill:#F19920;" d="M450.327,382.836c-8.145-29.091-29.091-52.364-55.855-62.836c-4.655-26.764-22.109-50.036-44.218-64\
                                        c-13.964,15.127-23.273,34.909-23.273,57.018c0,45.382,36.073,81.455,81.455,81.455\
                                        C423.564,395.636,437.527,390.982,450.327,382.836z"/>\
                                </g>\
                                <g>\
                                    <path style="fill:#E78825;" d="M370.036,358.4c-8.145-10.473-13.964-23.273-13.964-37.236c0-16.291,6.982-31.418,18.618-41.891\
                                        c-2.327-3.491-4.655-5.818-6.982-8.145c-11.636,10.473-18.618,25.6-18.618,43.055C349.091,332.8,357.236,347.927,370.036,358.4z"/>\
                                    <path style="fill:#E78825;" d="M395.636,321.164v16.291c0,6.982,4.655,11.636,11.636,11.636s11.636-4.655,11.636-11.636v-2.327\
                                        C411.927,329.309,403.782,324.655,395.636,321.164z"/>\
                                </g>\
                                <path style="fill:#F6B545;" d="M450.327,382.836c-2.327-8.145-4.655-15.127-9.309-22.109c-9.309,6.982-20.945,11.636-33.745,11.636\
                                    c-32.582,0-58.182-25.6-58.182-58.182c0-17.455,6.982-32.582,18.618-43.055c-5.818-5.818-11.636-10.473-18.618-13.964\
                                    c-13.964,15.127-23.273,34.909-23.273,57.018c0,45.382,36.073,81.455,81.455,81.455\
                                    C423.564,395.636,437.527,390.982,450.327,382.836z"/>\
                                <path style="fill:#F19920;" d="M446.836,372.364c-8.145,5.818-18.618,9.309-29.091,11.636c-5.818,1.164-10.473,5.818-10.473,11.636\
                                    l0,0c16.291,0,30.255-4.655,43.055-12.8C449.164,379.345,448,375.855,446.836,372.364z"/>\
                                <path style="fill:#FFCB5B;" d="M349.091,257.164c-13.964,15.127-23.273,34.909-23.273,57.018h1.164\
                                    c5.818,0,10.473-4.655,11.636-10.473c2.327-16.291,10.473-30.255,20.945-40.727C356.073,261.818,352.582,259.491,349.091,257.164z"\
                                    />\
                                <circle style="fill:#F6B545;" cx="302.545" cy="337.455" r="81.455"/>\
                                <path style="fill:#F19920;" d="M290.909,395.636c0,8.145,1.164,15.127,3.491,23.273c2.327,0,5.818,0,8.145,0\
                                    c45.382,0,81.455-36.073,81.455-81.455c0-8.145-1.164-15.127-3.491-23.273c-2.327,0-5.818,0-8.145,0\
                                    C326.982,314.182,290.909,350.255,290.909,395.636z"/>\
                                <path style="fill:#FFCB5B;" d="M302.545,256c-45.382,0-81.455,36.073-81.455,81.455s36.073,81.455,81.455,81.455\
                                    S384,382.836,384,337.455S347.927,256,302.545,256z M302.545,395.636c-32.582,0-58.182-25.6-58.182-58.182\
                                    s25.6-58.182,58.182-58.182s58.182,25.6,58.182,58.182S335.127,395.636,302.545,395.636z"/>\
                                <path style="fill:#F6B545;" d="M302.545,417.745L302.545,417.745C347.927,418.909,384,381.673,384,337.455h-1.164\
                                    c-5.818,0-10.473,4.655-11.636,10.473c-2.327,16.291-10.473,31.418-22.109,41.891c-9.309,9.309-22.109,15.127-36.073,17.455\
                                    C307.2,407.273,302.545,411.927,302.545,417.745z"/>\
                                <path style="fill:#FFE27A;" d="M302.545,257.164L302.545,257.164c-45.382-1.164-81.455,36.073-81.455,80.291h1.164\
                                    c5.818,0,10.473-4.655,11.636-10.473c2.327-16.291,10.473-31.418,22.109-41.891c9.309-9.309,22.109-15.127,36.073-17.455\
                                    C297.891,267.636,302.545,262.982,302.545,257.164z"/>\
                                <path style="fill:#F19920;" d="M252.509,345.6c0-32.582,25.6-58.182,58.182-58.182c13.964,0,26.764,4.655,37.236,13.964\
                                    c-11.636-13.964-26.764-22.109-45.382-22.109c-32.582,0-58.182,25.6-58.182,58.182c0,18.618,8.145,33.745,20.945,44.218\
                                    C257.164,372.364,252.509,359.564,252.509,345.6z"/>\
                                <path style="fill:#FFCB5B;" d="M337.455,373.527c-1.164,0-2.327,0-3.491-1.164c-2.327-2.327-2.327-5.818,0-8.145\
                                    c6.982-6.982,10.473-17.455,10.473-26.764c0-3.491,2.327-5.818,5.818-5.818c3.491,0,5.818,2.327,5.818,5.818\
                                    c0,12.8-4.655,25.6-12.8,34.909C340.945,373.527,338.618,373.527,337.455,373.527z"/>\
                                <path style="fill:#F19920;" d="M302.545,372.364c-6.982,0-11.636-4.655-11.636-11.636v-46.545c0-6.982,4.655-11.636,11.636-11.636\
                                    c6.982,0,11.636,4.655,11.636,11.636v46.545C314.182,367.709,309.527,372.364,302.545,372.364z"/>\
                                <g>\
                                    <path style="fill:#F6B545;" d="M356.073,315.345c2.327,6.982,4.655,13.964,4.655,22.109c0,32.582-25.6,58.182-58.182,58.182\
                                        c-3.491,0-8.145,0-11.636-1.164v1.164c0,8.145,1.164,15.127,3.491,23.273c2.327,0,5.818,0,8.145,0\
                                        c45.382,0,81.455-36.073,81.455-81.455c0-8.145-1.164-15.127-3.491-23.273c-2.327,0-5.818,0-8.145,0\
                                        C366.545,314.182,361.891,314.182,356.073,315.345z"/>\
                                    <circle style="fill:#F6B545;" cx="360.727" cy="407.273" r="81.455"/>\
                                </g>\
                                <path style="fill:#FFCB5B;" d="M360.727,325.818c-45.382,0-81.455,36.073-81.455,81.455s36.073,81.455,81.455,81.455\
                                    s81.455-36.073,81.455-81.455S406.109,325.818,360.727,325.818z M360.727,465.455c-32.582,0-58.182-25.6-58.182-58.182\
                                    s25.6-58.182,58.182-58.182s58.182,25.6,58.182,58.182S393.309,465.455,360.727,465.455z"/>\
                                <path style="fill:#F6B545;" d="M360.727,487.564L360.727,487.564c45.382,1.164,81.455-36.073,81.455-80.291h-1.164\
                                    c-5.818,0-10.473,4.655-11.636,10.473c-2.327,16.291-10.473,31.418-22.109,41.891c-9.309,9.309-22.109,15.127-36.073,17.455\
                                    C365.382,477.091,360.727,481.745,360.727,487.564z"/>\
                                <path style="fill:#FFE27A;" d="M360.727,326.982L360.727,326.982c-45.382-1.164-81.455,36.073-81.455,80.291h1.164\
                                    c5.818,0,10.473-4.655,11.636-10.473c2.327-16.291,10.473-31.418,22.109-41.891c9.309-9.309,22.109-15.127,36.073-17.455\
                                    C356.073,337.455,360.727,332.8,360.727,326.982z"/>\
                                <path style="fill:#F19920;" d="M310.691,415.418c0-32.582,25.6-58.182,58.182-58.182c13.964,0,26.764,4.655,37.236,13.964\
                                    c-11.636-13.964-26.764-22.109-45.382-22.109c-32.582,0-58.182,25.6-58.182,58.182c0,18.618,8.145,33.745,20.945,44.218\
                                    C315.345,442.182,310.691,429.382,310.691,415.418z"/>\
                                <path style="fill:#FFCB5B;" d="M395.636,443.345c-1.164,0-2.327,0-3.491-1.164c-2.327-2.327-2.327-5.818,0-8.145\
                                    c6.982-6.982,10.473-17.455,10.473-26.764c0-3.491,2.327-5.818,5.818-5.818s5.818,2.327,5.818,5.818c0,12.8-4.655,25.6-12.8,34.909\
                                    C399.127,443.345,396.8,443.345,395.636,443.345z"/>\
                                <path style="fill:#F19920;" d="M360.727,442.182c-6.982,0-11.636-4.655-11.636-11.636V384c0-6.982,4.655-11.636,11.636-11.636\
                                    c6.982,0,11.636,4.655,11.636,11.636v46.545C372.364,437.527,367.709,442.182,360.727,442.182z"/>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                <g>\
                                </g>\
                                </svg>\
                            </span>\
                        </a>\
                        <a href="'+APP_URL+'/users/'+row.id+'/edit" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">\
                            <span class="svg-icon svg-icon-md">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                        <a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon delete" data-remote="user/delete/'+row.id+'" title="Delete">\
                            <span class="svg-icon svg-icon-md">\
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                        <rect x="0" y="0" width="24" height="24"/>\
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                                    </g>\
                                </svg>\
                            </span>\
                        </a>\
                    ';
                },
            }],

        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_datatable_search_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        // public functions
        init: function() {
            demo();
        }
    };
}();

jQuery(document).ready(function() {
    KTDatatableJsonRemoteDemo.init();
      $('#kt_datatable').on('click', '.delete[data-remote]', function (e) { 

    e.preventDefault();

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

    var url = $(this).data('remote');

    // confirm then

    $.ajax({

        url: APP_URL+'/'+url,

        type: 'DELETE',

        dataType: 'json',

        data: {method: '_DELETE', submit: true}

    }).always(function (data) {
        location.reload();

    });

});
});

</script>
@endsection('page_script')