<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted font-weight-bold mr-2">2020©</span>
								<a href="#" target="_blank" class="text-dark-75 text-hover-primary">Arabic</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Nav-->
							<div class="nav nav-dark">
							</div>
							<!--end::Nav-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop">
			<span class="svg-icon">
				<!--begin::Svg Icon | path/media/svg/icons/Navigation/Up-2.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
						<path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
					</g>
				</svg>
				<!--end::Svg Icon-->
			</span>
		</div>
		<script>var HOST_URL = "{{ URL::to('/')}}";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
			<script src="{{ asset('public/plugins/global/plugins.bundle.js')}}"></script>
			<script src="{{ asset('public/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
			<script src="{{ asset('public/js/scripts.bundle.js')}}"></script>
			<!--end::Global Theme Bundle-->
			<!--begin::Page Vendors(used by this page)-->
			<script src="{{ asset('public/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
			<!--end::Page Vendors-->
			<!--begin::Page Scripts(used by this page)-->
			<script type="text/javascript">
				$("body").on("click", ".addmoreanswer", function(){
					var total_answers  = parseInt($(".answer_class").length) + 1;
					var total_answers_key  = parseInt($(".answer_class").length);
					var html = '<div class="answer_class"><div class="form-group"><label>Answer '+total_answers+' <span class="addmoreanswer">+</span> | <span class="removethisanswer">-</span></label><div class="input-group input-group-sm"><input type="text" class="form-control"  placeholder="Enter Answer" name="question_answer[]" value=""><input type="text" class="form-control" placeholder="Enter order number" name="order_number[]" value=""><div class="input-group-append"><span class="input-group-text"><input type="hidden"  name="question_corren_radio['+total_answers_key+']"  value="0" class="radio radio-single radio-primary"><input type="checkbox"  name="question_corren_radio['+total_answers_key+']" value="" class="radio radio-single radio-primary"></span></div></div></div></div>';
					$(".answersgroup").append(html);
				});
				$("body").on("click", ".removethisanswer", function(){
					$(this).closest(".answer_class").remove();
				});
			</script>

			<script type="text/javascript">
				$("body").on("click", ".add_duplicate_unit", function(){
					var html = $(".duplicaterow").html();
					$(".addduplicaterow").append("<div class='input-group'>"+html+"</div>")
				});
				$("body").on("click", ".remove_duplicate_unit", function(){
					if (!$(this).closest(".input-group").hasClass("duplicaterow")) {
						$(this).closest(".input-group").remove();
					}
					
				});
				$(document).ready(function() {
				    $('input[type=checkbox]').click(function() {
				      $(this).val(1);
				    });

				});
			</script>

			<script src="{{ asset('public/js/pages/widgets.js')}}"></script>
			<!--end::Page Scripts-->
			@yield('page_script')
	</body>
	<!--end::Body-->
</html>