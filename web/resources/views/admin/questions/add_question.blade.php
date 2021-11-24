@extends('layouts.admin',['page' => __('Questions'), 'pageSlug' => 'questions'])

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Info-->
			<div class="d-flex align-items-center flex-wrap mr-2">
				<!--begin::Page Title-->
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add new Question</h5>
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
			@if ($errors->any())
				
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)

			                <li>{{ $error ?? '' }}</li>
			            @endforeach
			        </ul>
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
								<span class="card-label font-weight-bolder text-dark">Add new Question</span>
							</h3>
						</div>
						<!--end::Header-->
						<!--begin::Body-->
						 <!--begin::Form-->
						 <form action="{{ route('questions.store')}}" method="post" enctype="multipart/form-data">
						 	@csrf
						  <div class="card-body">
						   <div class="form-group">
						    <label>Question </label>
						    <input type="text" class="form-control"  placeholder="Enter question" name="question" value="{{old('question')}}">
						   </div>
						   <div class="form-group">
						    <label>Question Tag Line </label>
						    <input type="text" class="form-control"  placeholder="Enter Tagline" name="question_tagline" value="{{old('question_tagline')}}">
						   </div>
						   <div class="form-group">
						    <label>Question Marks </label>
						    <input type="text" class="form-control"  placeholder="Enter Marks" name="question_marks" value="{{old('question_marks')}}">
						   </div>
						   <div class="form-group">
						    <label>Question Type</label>
						    <select name="question_type" class="form-control">
						    	<option value="Single Answer">Single Answer</option>
						    	<option value="Drag drop">Drag drop</option>
						    </select>
						   </div>

							<div class="form-group">
								<label>Upload Image</label>
								<div></div>
								<div class="custom-file">
									<input type="file" name="image" class="custom-file-input" id="upload_image" />
									<label class="custom-file-label" for="upload_image">Choose file</label>
								</div>
							</div>

							<div class="form-group">
								<label>Upload Audio</label>
								<div></div>
								<div class="custom-file">
									<input type="file" name="audio" class="custom-file-input" id="upload_audio" />
									<label class="custom-file-label" for="upload_audio">Choose file</label>
								</div>
							</div>

						   <div class="answersgroup">
						   		<div class="answer_class">
								   <div class="form-group">
										<label>Answer 1 <span class="addmoreanswer">+</span> | <span class="removethisanswer">-</span></label>
										<div class="input-group input-group-sm">
											<input type="text" class="form-control"  placeholder="Enter Answer" name="question_answer[]" value=""><input type="text" class="form-control" placeholder="Enter order number" name="order_number[]" value="">
											<div class="input-group-append">
												<span class="input-group-text">
													<input type="hidden"  name="question_corren_radio[0]"  value="0" class="radio radio-single radio-primary">
													<input type="checkbox"  name="question_corren_radio[0]" value="{{old('question_radio')}}" class="radio radio-single radio-primary">
												</span>
											</div>
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
</div>
<!--end::Content-->
							   	
@endsection('content')
