@extends('layouts.admin',['page' => __('Levels'), 'pageSlug' => 'levels'])

@section('content')
	<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
	<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
		<!--begin::Info-->
		<div class="d-flex align-items-center flex-wrap mr-2">
			<!--begin::Page Title-->
			<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add new Level</h5>
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
							<span class="card-label font-weight-bolder text-dark">Add new Level</span>
						</h3>
					</div>
					<!--end::Header-->
					<!--begin::Body-->
					 <!--begin::Form-->
					 <form action="{{ route('levels.update',$level['level_id']) }}" method="post">
					 	@csrf
						@method('PUT')
					  <div class="card-body">
					   <div class="form-group">
					    <label>Sort</label>
					      <input type="number" class="form-control"  placeholder="Enter Sort" name="level_sort" value="{{old('level_sort',$level['level_sort'])}}">
					   </div>
					   <div class="form-group">
					    <label>Level</label>
					      <input type="text" class="form-control"  placeholder="Enter Level" name="level_name" value="{{old('level_name',$level['level_name'])}}">
					   </div>
					   <div class="form-group">
					    <label>Min Marks</label>
					      <input type="text" class="form-control"  placeholder="Enter Minimum Marks" name="level_min_marks" value="{{old('level_min_marks',$level['level_min_marks'])}}">
					   </div>
					   <div class="form-group">
					    <label>Max Marks</label>
					      <input type="text" class="form-control"  placeholder="Enter Maximum Marks" name="level_max_marks" value="{{old('level_max_marks',$level['level_max_marks'])}}">
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
@section('page_script')
<script type="text/javascript">
	$('.select2-multiple').select2({
  placeholder: 'Select an option'
});
</script>
@endsection('page_script')