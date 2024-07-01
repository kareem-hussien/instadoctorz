@extends('layouts.auth')
@section('title')
    {{__('messages.register')}}
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center">
            <a href="{{ route('medical') }}" class="image mb-7 mb-sm-10">
                <img alt="Logo" src="{{ asset(getAppLogo()) }}" class="img-fluid" style="width:90px;" loading="lazy">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <h1 class="text-center mb-7">{{__('messages.web.patient_registration')}}</h1>
            <form method="POST" action="{{ route('doctor.register') }}"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-sm-7 mb-4">
                        <label for="formInputFirstName" class="form-label">
                            {{ __('messages.patient.first_name').':' }}<span class="required"></span>
                        </label>
                        <input name="first_name" type="text" class="form-control" id="name" aria-describedby="firstName" placeholder="{{ __('messages.patient.first_name') }}" value="{{ old('first_name') }}" required>
                    </div>
                    <div class="col-md-6 mb-sm-7 mb-4">
                        <label for="last_name" class="form-label">
                            {{ __('messages.patient.last_name') .':' }}<span class="required"></span>
                        </label>
                        <input name="last_name" type="text" class="form-control" id="last_name" aria-describedby="lastName" placeholder="{{ __('messages.patient.last_name') }}" required value="{{ old('last_name') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-sm-7 mb-4">
                        <label for="email" class="form-label">
                            {{ __('messages.patient.email').':' }}<span class="required"></span>
                        </label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="email" placeholder="{{ __('messages.patient.email') }}" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="mb-5 fv-row">
                    <div class="row">
                        <div class="col-md-6 mb-sm-7 mb-4">
                            <label for="password" class="form-label">
                                {{ __('messages.patient.password').':' }}<span class="required"></span>
                            </label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('messages.patient.password') }}" aria-describedby="password" required>
                        </div>
                        <div class="col-md-6 mb-sm-7 mb-4">
                            <label for="password_confirmation" class="form-label">
                                {{ __('messages.patient.confirm_password') .':' }}<span class="required"></span>
                            </label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('messages.patient.confirm_password') }}" id="password_confirmation" aria-describedby="confirmPassword" required>
                        </div>
                    </div>

					<div class="row">

						<div class="col-md-6">
							<div class="mb-5">
								<label class="form-label required">
									{{__('messages.doctor.select_gender')}}
									:
								</label>
								<span class="is-valid">
									<div class="mt-2">
										<input class="form-check-input" type="radio" checked name="gender" value="1">
										<label class="form-label mr-3">{{__('messages.doctor.male')}}</label>
										<input class="form-check-input ms-2" type="radio" name="gender" value="2">
										<label class="form-label mr-3">{{__('messages.doctor.female')}}</label>
									</div>
								</span>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<label class="form-label">{{ __('messages.patient.prefix').':' }}</label>
							{{ Form::select('prefix', $prefixdata , null, ['class' => 'io-select2 form-select', 'data-control'=>"select2",'placeholder' => __('messages.patient.prefix')]) }}
						</div>

						
					</div>

					<div class="row">
						<div class="col-md-6 mb-5">
							<label class="form-label">{{ __('messages.patient.education').':' }}</label>
							{{ Form::select('education', $educationdata , null, ['class' => 'io-select2 form-select', 'data-control'=>"select2",'placeholder' => __('messages.patient.education')]) }}
						</div>

						<div class="col-md-6 mb-5">
							<label class="form-label">{{ __('messages.patient.experience').':' }}</label>
							{{ Form::select('experience', $experiencedata , null, ['class' => 'io-select2 form-select', 'data-control'=>"select2",'placeholder' => __('messages.patient.experience')]) }}
						</div>
						
						
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="mb-5">
								{{ Form::label('Specialization',__('messages.doctor.specialization').':' ,['class' => 'form-label required']) }}
								{{ Form::select('specializations[]',$specializations, null,['class' => 'io-select2 form-select', 'data-control'=>"select2", 'multiple', 'data-placeholder' => __('messages.doctor.specialization')]) }}
							</div>
						</div>
					</div>

					<div class="row">
						
							<label class="form-label">{{ __('messages.patient.availability').':' }}</label>
							<div class="col-md-6 mb-5">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="availability[]" value="Online from our premises" id="availabilityOnline">
									<label class="form-check-label" for="availabilityOnline">
										{{ __('messages.patient.online_from_premises') }}
									</label>
								</div>
							</div>
							<div class="col-md-6 mb-5">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="availability[]" value="Remotely" id="availabilityRemotely">
									<label class="form-check-label" for="availabilityRemotely">
										{{ __('messages.patient.remotely') }}
									</label>
								</div>
							</div>
					</div>

					<div class="row">
						
							<label class="form-label">{{ __('messages.patient.can_start_immediately').':' }}</label>
							<div class="col-md-6 mb-5">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="can_start_immediately" value="Yes" id="startImmediatelyYes">
									<label class="form-check-label" for="startImmediatelyYes">
										{{ __('messages.patient.yes') }}
									</label>
								</div>
							</div>
							<div class="col-md-6 mb-5">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="can_start_immediately" value="No" id="startImmediatelyNo">
									<label class="form-check-label" for="startImmediatelyNo">
										{{ __('messages.patient.no') }}
									</label>
								</div>
							</div>
					</div>

					<div class="row" id="startDateContainer" style="display: none;">
						<div class="col-md-12 mb-5">
							<label class="form-label">{{ __('messages.patient.select_start_date').':' }}</label>
							<input type="date" name="start_date" class="form-control" id="startDate">
						</div>
					</div>


					<div class="row">
						
						<label class="form-label">{{ __('messages.patient.services_can_be_performed_online').':' }}</label>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="Online from our premises" id="urgent_care">
								<label class="form-check-label" for="urgent_care">
									{{ __('messages.patient.urgent_care') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="chronic_care" id="chronic_care">
								<label class="form-check-label" for="chronic_care">
									{{ __('messages.patient.chronic_care') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="child_care" id="child_care">
								<label class="form-check-label" for="child_care">
									{{ __('messages.patient.child_care') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="sexual_health" id="sexual_health">
								<label class="form-check-label" for="sexual_health">
									{{ __('messages.patient.sexual_health') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="skin_and_hair" id="skin_and_hair">
								<label class="form-check-label" for="skin_and_hair">
									{{ __('messages.patient.skin_and_hair') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="mental_health" id="mental_health">
								<label class="form-check-label" for="mental_health">
									{{ __('messages.patient.mental_health') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="services[]" value="preventive_health" id="preventive_health">
								<label class="form-check-label" for="preventive_health">
									{{ __('messages.patient.preventive_health') }}
								</label>
							</div>
						</div>
					</div>


					<div class="row mt-5" id="urgentCareSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.urgent_care').':' }}</label>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_urgent_care[]" value="Allergies" id="allergies">
								<label class="form-check-label" for="allergies">
									{{ __('messages.patient.allergies') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_urgent_care[]" value="Acne" id="acne">
								<label class="form-check-label" for="acne">
									{{ __('messages.patient.acne') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_urgent_care[]" value="Cold, Cough" id="cold_cough">
								<label class="form-check-label" for="cold_cough">
									{{ __('messages.patient.cold,cough') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_urgent_care[]" value="hair_loss" id="hair_loss">
								<label class="form-check-label" for="hair_loss">
									{{ __('messages.patient.hair_loss') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_urgent_care[]" value="erectile_dysfunction" id="erectile_dysfunction">
								<label class="form-check-label" for="erectile_dysfunction">
									{{ __('messages.patient.erectile_dysfunction') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_urgent_care[]" value="yeast_infections" id="yeast_infections">
								<label class="form-check-label" for="yeast_infections">
									{{ __('messages.patient.yeast_infections') }}
								</label>
							</div>
						</div>
					</div>

					<div class="row mt-5" id="ChronicCareSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.chronic_care').':' }}</label>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_chronic_care[]" value="asthma" id="asthma">
								<label class="form-check-label" for="asthma">
									{{ __('messages.patient.asthma') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_chronic_care[]" value="high_cholesterol" id="high_cholesterol">
								<label class="form-check-label" for="high_cholesterol">
									{{ __('messages.patient.high_cholesterol') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_chronic_care[]" value="high_blood_pressure" id="high_blood_pressure">
								<label class="form-check-label" for="high_blood_pressure">
									{{ __('messages.patient.high_blood_pressure') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_chronic_care[]" value="weight_management" id="weight_management">
								<label class="form-check-label" for="weight_management">
									{{ __('messages.patient.weight_management') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_chronic_care[]" value="diabetes" id="diabetes">
								<label class="form-check-label" for="diabetes">
									{{ __('messages.patient.diabetes') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_chronic_care[]" value="thyroid_issues" id="thyroid_issues">
								<label class="form-check-label" for="thyroid_issues">
									{{ __('messages.patient.thyroid_issues') }}
								</label>
							</div>
						</div>
					</div>

					<div class="row mt-5" id="ChildCareSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.services_can_be_performed_online').':' }}</label>
						<label class="form-label">{{ __('messages.patient.child_care').':' }}</label>

					</div>

					<div class="row mt-5" id="SexualHealthSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.sexual_health').':' }}</label>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_sexual_health[]" value="uti" id="uti">
								<label class="form-check-label" for="uti">
									{{ __('messages.patient.uti') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_sexual_health[]" value="erectile_dysfunction" id="erectile_dysfunction">
								<label class="form-check-label" for="erectile_dysfunction">
									{{ __('messages.patient.erectile_dysfunction') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_sexual_health[]" value="emergency_contraception" id="emergency_contraception">
								<label class="form-check-label" for="emergency_contraception">
									{{ __('messages.patient.emergency_contraception') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_sexual_health[]" value="weight_management" id="weight_management">
								<label class="form-check-label" for="weight_management">
									{{ __('messages.patient.weight_management') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_sexual_health[]" value="yeast_infections" id="yeast_infections">
								<label class="form-check-label" for="yeast_infections">
									{{ __('messages.patient.yeast_infections') }}
								</label>
							</div>
						</div>
						
					</div>

					<div class="row mt-5" id="SkinAndHairSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.skin_and_hair').':' }}</label>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]" value="hair_loss" id="hair_loss">
								<label class="form-check-label" for="hair_loss">
									{{ __('messages.patient.hair_loss') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]" value="acne" id="acne">
								<label class="form-check-label" for="acne">
									{{ __('messages.patient.acne') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]" value="eczema" id="eczema">
								<label class="form-check-label" for="eczema">
									{{ __('messages.patient.eczema') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]" value="athletes_foot" id="athletes_foot">
								<label class="form-check-label" for="athletes_foot">
									{{ __('messages.patient.athletes_foot') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]" value="cellulitis_sunburn" id="cellulitis_sunburn">
								<label class="form-check-label" for="cellulitis_sunburn">
									{{ __('messages.patient.cellulitis_sunburn') }}
								</label>
							</div>
						</div>
						
					</div>

					<div class="row mt-5" id="MentalHealthSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.mental_health').':' }}</label>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="anxiety" id="anxiety">
								<label class="form-check-label" for="anxiety">
									{{ __('messages.patient.anxiety') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="depression" id="depression">
								<label class="form-check-label" for="depression">
									{{ __('messages.patient.depression') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="stress" id="stress">
								<label class="form-check-label" for="stress">
									{{ __('messages.patient.stress') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="grief_loss" id="grief_loss">
								<label class="form-check-label" for="grief_loss">
									{{ __('messages.patient.grief_loss') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="postpartum" id="postpartum">
								<label class="form-check-label" for="postpartum">
									{{ __('messages.patient.postpartum') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="mood_disorders" id="mood_disorders">
								<label class="form-check-label" for="mood_disorders">
									{{ __('messages.patient.mood_disorders') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_mental_health[]" value="ptsd" id="ptsd">
								<label class="form-check-label" for="ptsd">
									{{ __('messages.patient.ptsd') }}
								</label>
							</div>
						</div>
						
					</div>

					<div class="row mt-5" id="PreventiveHealthSubservices" style="display: none;">
						<label class="form-label">{{ __('messages.patient.preventive_health').':' }}</label>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_preventive_health[]" value="wellness_visits" id="wellness_visits">
								<label class="form-check-label" for="wellness_visits">
									{{ __('messages.patient.wellness_visits') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_preventive_health[]" value="family_medicine" id="family_medicine">
								<label class="form-check-label" for="family_medicine">
									{{ __('messages.patient.family_medicine') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_preventive_health[]" value="womens_wellness" id="womens_wellness">
								<label class="form-check-label" for="womens_wellness">
									{{ __('messages.patient.womens_wellness') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_preventive_health[]" value="men_wellness" id="men_wellness">
								<label class="form-check-label" for="men_wellness">
									{{ __('messages.patient.men_wellness') }}
								</label>
							</div>
						</div>
						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_preventive_health[]" value="diet_nutrition" id="diet_nutrition">
								<label class="form-check-label" for="diet_nutrition">
									{{ __('messages.patient.diet_nutrition') }}
								</label>
							</div>
						</div>

						<div class="col-md-6 mb-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="sub_preventive_health[]" value="medication_management" id="medication_management">
								<label class="form-check-label" for="medication_management">
									{{ __('messages.patient.medication_management') }}
								</label>
							</div>
						</div>
						
					</div>


					<!-- File upload field -->
					<div class="col-md-6 mb-5">
						<label class="form-label">{{ __('messages.patient.upload_file').':' }}</label>
						<input type="file" name="uploaded_file" class="form-control" id="uploadedFile">
					</div>


					@include('components.images')


                    <div class="mb-sm-7 mb-4 form-check">
                        <input type="checkbox" class="form-check-input" name="toc" value="1" required/>
                        <span class="text-gray-700 me-2 ml-1">{{__('messages.web.i_agree')}}
									<a href="{{ route('terms.conditions') }}"
                                       class="ms-1 link-primary">{{__('messages.web.terms_and_conditions')}}</a>.
                        </span>
                    </div>

                    @if (getSettingValue('recaptcha'))
                        <div class="form-group mb-4 captcha-customize">
                            <div class="g-recaptcha" id="g-recaptcha"
                                data-sitekey="{{$captchakey}}"
                                data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback">
                            </div>
                        </div>
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">{{__('messages.common.submit')}}</button>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <span class="text-gray-700 me-2">{{__('messages.web.already_have_an_account').'?'}}</span>
                        <a href="{{ route('login') }}" class="link-info fs-6 text-decoration-none">
                            {{__('messages.web.sign_in_here')}}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
			var yesRadio = document.getElementById('startImmediatelyYes');
			var noRadio = document.getElementById('startImmediatelyNo');
			var startDateContainer = document.getElementById('startDateContainer');

			yesRadio.addEventListener('change', function () {
				if (this.checked) {
					startDateContainer.style.display = 'none';
				}
			});

			noRadio.addEventListener('change', function () {
				if (this.checked) {
					startDateContainer.style.display = 'block';
				}
			});

			// Ensure the correct state is set on page load
			if (noRadio.checked) {
				startDateContainer.style.display = 'block';
			} else {
				startDateContainer.style.display = 'none';
			}
	});
	$(document).ready(function() {
		$('#urgent_care').on('change', function() {
			if ($(this).is(':checked')) {
				$('#urgentCareSubservices').show();
			} else {
				$('#urgentCareSubservices').hide();
			}
		});

		$('#chronic_care').on('change', function() {
			if ($(this).is(':checked')) {
				$('#ChronicCareSubservices').show();
			} else {
				$('#ChronicCareSubservices').hide();
			}
		});

		$('#child_care').on('change', function() {
			if ($(this).is(':checked')) {
				$('#ChildCareSubservices').show();
			} else {
				$('#ChildCareSubservices').hide();
			}
		});

		$('#sexual_health').on('change', function() {
			if ($(this).is(':checked')) {
				$('#SexualHealthSubservices').show();
			} else {
				$('#SexualHealthSubservices').hide();
			}
		});

		$('#skin_and_hair').on('change', function() {
			if ($(this).is(':checked')) {
				$('#SkinAndHairSubservices').show();
			} else {
				$('#SkinAndHairSubservices').hide();
			}
		});

		$('#mental_health').on('change', function() {
			if ($(this).is(':checked')) {
				$('#MentalHealthSubservices').show();
			} else {
				$('#MentalHealthSubservices').hide();
			}
		});

		$('#preventive_health').on('change', function() {
			if ($(this).is(':checked')) {
				$('#PreventiveHealthSubservices').show();
			} else {
				$('#PreventiveHealthSubservices').hide();
			}
		});
		
	});
</script>
