@extends('layouts.admin',['page' => __('Questions'), 'pageSlug' => 'lesson_questions'])

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
								<span class="card-label font-weight-bolder text-dark">Add new Question</span>
							</h3>
						</div>
						<!--end::Header-->
						<!--begin::Body-->
						 <!--begin::Form-->
						 <form action="{{ route('lesson_questions.update', $question['questionid']) }}" method="post" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						  <div class="card-body">
						   <div class="form-group">
						    <label>Question </label>
						    <input type="text" class="form-control"  placeholder="Enter question" name="question" value="{{$question['question'] ?? ''}}">
						   </div>
						   <div class="form-group">
						    <label>Question Tag Line </label>
						    <input type="text" class="form-control"  placeholder="Enter Username" name="question_tagline" value="{{ $question['question_tagline'] ?? ''}}">
						   </div>
						   <div class="form-group">
						    <label>Lesson</label>
						    <select name="question_lesson" class="form-control" required="">
						    	<option ></option> 
						    	@foreach($lessions as $key => $lesson)
						    	<option value="{{$lesson->lesson_id}}" @if($lesson->lesson_id == $question['question_lesson']){{'selected'}}@endif>{{$lesson->lesson_title}}</option>
						    	@endforeach
						    </select>
						   </div>
						    <div class="form-group">
						    <label>Question Marks </label>
						    <input type="text" class="form-control"  placeholder="Enter Marks" name="question_marks" value="{{old('question_marks',$question['question_marks'])}}">
						   </div>
						   <div class="form-group">
						    <label>Question Type</label>
						    <select name="question_type" class="form-control">
						    	@if($question['question_type'] == "Single Answer")
						    	<option value="Single Answer" selected="selected">Single Answer</option>
						    	@elseif($question['question_type'] == "Drag drop")
						    	<option value="Drag drop" selected="selected">Drag drop</option>
						    	@endif
						    	
						    	
						    </select>
						   </div>
							<div class="form-group">
								@if(!empty($question['image']))
									<label>Upload Image : <b>{{ url('/') }}/storage/app/questions/{{ $question['image'] ?? ''}}</b></label>
								@else
									<label>Upload Image</label>
								@endif
								<div></div>
								<div class="custom-file">
									<input type="file" name="image" class="custom-file-input" id="upload_image" />
									<label class="custom-file-label" for="upload_image">Choose file</label>
								</div>
							</div>											   

							<div class="form-group">
								@if(!empty($question['audio']))
									<label>Upload Audio : <b>{{ url('/') }}/storage/app/questions/{{ $question['audio'] ?? ''}}</b></label>
								@else
									<label>Upload Audio</label>
								@endif
								<div></div>
								<div class="custom-file">
									<input type="file" name="audio" class="custom-file-input" id="upload_audio" />
									<label class="custom-file-label" for="upload_audio">Choose file</label>
								</div>
							</div>
							@php

						   	$question_answer = json_decode($question['question_answer'],true);
						   	$checked = '';
						   	@endphp
							@if(!empty($question_answer))
							@foreach($question_answer as $key=> $val)
							<div class="answersgroup">
						   		<div class="answer_class">
								  <div class="form-group">
										<label>Answer 1 <span class="addmoreanswer">+</span> | <span class="removethisanswer">-</span></label>
										<div class="input-group input-group-sm">
											<input type="text" class="form-control"  placeholder="Enter Answer" name="question_answer[]" value="{{old('question_answer',$val['question_answer'] ?? '')}}">
											<div class="input-group-append">
												<input type="text" class="form-control" placeholder="Enter order number" name="order_number[]" value="{{$val['order_number']}}">
												<span class="input-group-text">
													<input type="hidden"  name="question_corren_radio[{{$key}}]"  value="0" class="radio radio-single radio-primary">
													@if(isset($val['question_corren_radio']))
														@if( $val['question_corren_radio']== 1)
															<input type="checkbox"  name="question_corren_radio[{{$key}}]" checked="true" value="1" class="radio radio-single radio-primary">
														@else
															<input type="checkbox"  name="question_corren_radio[{{$key}}]"  value="1" class="radio radio-single radio-primary">
														@endif
													@else
														<input type="checkbox"  name="question_corren_radio[{{$key}}]"  value="1" class="radio radio-single radio-primary">
													@endif
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
							@else
							<div class="answersgroup">
						   		<div class="answer_class">
								   <div class="form-group">
										<label>Answer 1 <span class="addmoreanswer">+</span> | <span class="removethisanswer">-</span></label>
										<div class="input-group input-group-sm">
											<input type="text" class="form-control"  placeholder="Enter Answer" name="question_answer[]" value="{{old('question_answer')}}">
											<div class="input-group-append">
												<span class="input-group-text">
													<input type="radio"  name="question_corren_radio[]" value="{{old('question_radio')}}" class="radio radio-single radio-primary">
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label>Upload Answer Audio</label>
										<div></div>
										<div class="custom-file">
											<input type="file" name="answer_audio[]" class="custom-file-input" id="upload_audio" />
											<label class="custom-file-label" for="upload_audio">Choose file</label>
										</div>
									</div>
									<div class="form-group">
										<label>Upload Answer Image</label>
										<div></div>
										<div class="custom-file">
											<input type="file" name="answer_image[]" class="custom-file-input" id="upload_image" />
											<label class="custom-file-label" for="upload_image">Choose file</label>
										</div>
									</div>
								</div>
							</div>
							@endif
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
