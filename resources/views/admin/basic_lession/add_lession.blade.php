@extends('layouts.admin',['page' => __('Add Basic Level'), 'pageSlug' => 'lession_plus'])
@section('page_css')
<style type="text/css">
	.add_more_basic_lesson, .delete_this_basic_lesson { cursor: pointer;  }
</style>
@endsection('page_css')
@section('content')
	<!--begin::Subheader-->
<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
<!--begin::Info-->
<div class="d-flex align-items-center flex-wrap mr-2">
	<!--begin::Page Title-->
	<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add new Basic Lesson</h5>
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
					<span class="card-label font-weight-bolder text-dark">Add new Basic Lesson</span>
				</h3>
			</div>
			<!--end::Header-->
			<!--begin::Body-->
			 <!--begin::Form-->
			 <form action="{{ route('basic_lessions.store')}}" method="post" enctype="multipart/form-data">
			 	@csrf
			  <div class="card-body">
			   <div class="form-group">
			    <label>Sort </label>
			    <input type="number" class="form-control"  placeholder="Enter sort" name="lesson_sort" value="{{old('lesson_sort')}}">
			   </div>
			   <div class="form-group">
			    <label>Title </label>
			    <input type="text" class="form-control"  placeholder="Enter lesson title" name="lesson_title" value="{{old('lesson_title')}}">
			   </div>
			   <div class="form-group">
			   	<label>Level </label>
			   	<select name="lesson_level" id="lesson_level" class="form-control">
			   		<option>select level</option>
			   		@foreach ($level as $key => $value)
			   		<option value="{{ $value->level_id }}">{{ $value->level_name }}</option>
			   		@endforeach
			   	</select>
			   </div>
			   <div class="form-group">
			   	<label>Unit </label>
			   	<select name="lesson_unit" id="lesson_unit" class="form-control">
			   	</select>
			   </div>
			    <input type="hidden" class="form-control"  placeholder="Enter Tagline" name="lesson_sub_title" value="">
				<div class="form-group">
					<label>Bulk Audio</label>
					<div></div>
					<div class="custom-file">
						<input type="file" name="bulk_audio" class="custom-file-input" id="bulk_audio" />
						<label class="custom-file-label" for="bulk_audio">Choose file</label>
					</div>
				</div>
			   <div class="basic_lesson_addmore_div">
			   		<div class="basic_lesson_section">
				   		<h3><span class="add_more_basic_lesson">+</span> | <span class="delete_this_basic_lesson">-</span></h3>
					   <div class="form-group">
					    <label>Character</label>
					    <input type="text" class="form-control"  placeholder="Enter Character" name="character[]" />
					   </div>
					    <input type="hidden" class="form-control"  placeholder="Enter Arabic" name="arabic[]" value="" />
					    <input type="hidden" class="form-control"  placeholder="Enter English" name="english[]" value="" />

						<div class="form-group">
							<label>Upload Audio</label>
							<div></div>
							<div class="custom-file">
								<input type="file" class="custom-file-input"  name="lesson_audio[]"/>
								<label class="custom-file-label" for="upload_audio">Choose file</label>
							</div>
						</div>
					   </div>
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
				jQuery("body").on("click", ".add_more_basic_lesson", function(){
					var html = '<div class="basic_lesson_section"><h3><span class="add_more_basic_lesson">+</span> | <span class="delete_this_basic_lesson">-</span></h3><div class="form-group"><label>Character</label><input type="text" class="form-control"  placeholder="Enter Character" name="character[]" /></div><input type="hidden" class="form-control"  placeholder="Enter Arabic" name="arabic[]" /><input type="hidden" class="form-control"  placeholder="Enter English" name="english[]" /><div class="form-group"><label>Upload Audio</label><div></div><div class="custom-file"><input type="file" class="custom-file-input" name="lesson_audio[]"/><label class="custom-file-label" for="upload_audio">Choose file</label></div></div></div>';
					jQuery(this).closest(".basic_lesson_addmore_div").append(html);
				});
				jQuery("body").on("click", ".delete_this_basic_lesson", function(){
					jQuery(this).closest(".basic_lesson_section").remove();
				});
				jQuery('#lesson_level').on('change',function(e){
					var unit_id = jQuery(this).val();
					e.preventDefault();
				    $.ajaxSetup({
				        headers: {
				            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				        }
				    });
				    $.ajax({
				        url: APP_URL+'/get_unit/'+unit_id,
				        type: 'POST',
				        dataType: 'json',
				        data: {submit: true}
				    }).always(function (data) {
				    	console.log(data);
				    	$('#lesson_unit').html(data.data);
				        //location.reload();
				    });
				});

				 jQuery(document).on('change','.custom-file .custom-file-input',function(){
					       console.log(jQuery(this).val());
					jQuery(this).next('.custom-file-label').html(jQuery(this).val());

					 });
</script>
			</script>
@endsection('page_script')