@extends('layouts.admin',['page' => __('Users'), 'pageSlug' => 'users'])

@section('content')
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
	<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<!--begin::Info-->
		<div class="d-flex align-items-center flex-wrap mr-2">
			<!--begin::Page Title-->
			<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add new User</h5>
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
							<span class="card-label font-weight-bolder text-dark">Add new Users</span>
						</h3>
					</div>
					<!--end::Header-->
					<!--begin::Body-->
					 <!--begin::Form-->
					 <form action="{{ route('users.store')}}" method="post">
					 	@csrf
					  <div class="card-body">
					   <div class="form-group">
					    <label>Username </label>
					    <input type="text" class="form-control"  placeholder="Enter Username" name="username" value="{{old('username')}}">
					   </div>
					   <div class="form-group">
					    <label for="exampleInputPassword1">Password</label>
					    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" value="{{old('password')}}">
					   </div>
					   <div class="form-group">
					    <label>Group </label>
					    <select name="usergroup" class="form-control">
					    	<option value="1">Admin</option>
					    	<option value="2">User</option>
					    </select>
					   </div>
					   <div class="form-group">
					    <label>Email </label>
					    <input type="text" class="form-control"  placeholder="Enter Username" name="email" value="{{old('email')}}">
					   </div>
					   <div class="form-group">
					    <label>First Name </label>
					    <input type="text" class="form-control"  placeholder="Enter Username" name="firstname"  value="{{old('firstname')}}">
					   </div>
					   <div class="form-group">
					    <label>Last Name </label>
					    <input type="text" class="form-control"  placeholder="Enter Username" name="lastname" value="{{old('lastname')}}">
					   </div>
					   <input type="hidden" value="" name="user_level">
					   <div class="form-group">
					    <label>Language </label>
					    <select class="form-control" name="language">
					    	<option value="English">English</option>
					    	<option value="Arabic">Arabic</option>
					    </select>
					   </div>
					   <div class="form-group">
					    <label>Notification </label>
					    <select class="form-control" name="notification">
					    	<option value="1">Yes</option>
					    	<option value="2">No</option>
					    </select>
					   </div>
					   <div class="form-group">
					    <label>Membership </label>
					    <select class="form-control" name="user_membership">
					    	<option value="1">Free</option>
					    	<option value="2">Premium</option>
					    </select>
					   </div>
					   <div class="form-group">
					    <label>Ban </label>
					    <select class="form-control" name="user_ban">
					    	<option value="1">No</option>
					    	<option value="2">Yes</option>
					    </select>
					   </div>
					   </div>
					  <div class="card-footer">
					   <button type="submit" name="submitform" class="btn btn-primary mr-2">Submit</button>
					   <button type="reset" class="btn btn-secondary">Cancel</button>
					  </div>
					 </form>
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
@endsection('content')