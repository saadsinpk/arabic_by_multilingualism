@extends('layouts.admin',['page' => __('Units'), 'pageSlug' => 'units'])

@section('content')
	<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
	<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<!--begin::Info-->
		<div class="d-flex align-items-center flex-wrap mr-2">
			<!--begin::Page Title-->
			<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add new Unit</h5>
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
							<span class="card-label font-weight-bolder text-dark">Add new Unit</span>
						</h3>
					</div>
					<!--end::Header-->
					<!--begin::Body-->
					 <!--begin::Form-->
					 <form action="{{ route('units.update',$unit['unit_id']) }}" method="post">
					 	@csrf
						@method('PUT')
					  <div class="card-body">
					   <div class="form-group">
					    <label>Sort</label>
					      <input type="number" class="form-control"  placeholder="Enter Sort" name="unit_sort" value="{{old('unit_sort',$unit['unit_sort'])}}">
					   </div>
					   <div class="form-group">
					    <label>Unit</label>
					      <input type="text" class="form-control"  placeholder="Enter Unit" name="unit_name" value="{{old('unit_name',$unit['unit_name'])}}">
					   </div>
					   <div class="form-group">
					    <label>Level</label>
					    <select name="unit_level" id="unit_level" class="form-control">
					    	<option>Select Level</option>
							@foreach ($unit['level'] as $key => $value)
						    	<option value="{{ $value->level_id }}" @if($unit['unit_level'] == $value->level_id ){{'selected'}}@endif>{{ $value->level_name }}</option>
							@endforeach
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