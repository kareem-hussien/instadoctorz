<div class="row">
    <div class="col-md-6 mb-5">
        {{ Form::label('First Name', __('messages.doctor.first_name') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => __('messages.doctor.first_name'), 'required']) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Last Name', __('messages.doctor.last_name') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => __('messages.doctor.last_name'), 'required']) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Email', __('messages.user.email') . ':', ['class' => 'form-label required']) }}
        {{ Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => __('messages.web.email')]) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Contact', __('messages.user.contact_number') . ':', ['class' => 'form-label']) }}
        {{ Form::tel('contact', '+' . $user->region_code . $user->contact, ['class' => 'form-control', 'placeholder' => __('messages.patient.contact_no'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'phoneNumber']) }}
        {{ Form::hidden('region_code', !empty($user->user) ? $user->user->region_code : null, ['id' => 'prefix_code']) }}
        <span id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.valid_number') }}</span>
        <span id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.invalid_number') }}</span>
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('DOB', __('messages.doctor.dob') . ':', ['class' => 'form-label']) }}
        {{ Form::text('dob', $user->dob, ['class' => 'form-control doctor-dob', 'placeholder' => __('messages.doctor.dob'), 'id' => 'dob']) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Specialization', __('messages.doctor.specialization') . ':', ['class' => 'form-label required']) }}
        {{ Form::select('specializations[]', $data['specializations'], $data['doctorSpecializations'], ['class' => 'io-select2 form-select', 'data-control' => 'select2', 'multiple']) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Experience', __('messages.doctor.experience') . ':', ['class' => 'form-label']) }}
        {{ Form::text('experience', $doctor->experience, ['class' => 'form-control', 'placeholder' => __('messages.doctor.experience'), 'step' => 'any']) }}
    </div>
    <div class="col-md-6 mb-5">
        <label class="form-label required">
            {{ __('messages.doctor.select_gender') }}
            :
        </label>
        <span class="is-valid">
            <div class="mt-2">
                <input class="form-check-input" type="radio" name="gender" value="1"
                    {{ !empty($user->gender) && $user->gender === 1 ? 'checked' : '' }}>
                <label class="form-label mr-3">{{ __('messages.doctor.male') }}</label>
                <input class="form-check-input ms-2" type="radio" name="gender" value="2"
                    {{ !empty($user->gender) && $user->gender === 2 ? 'checked' : '' }}>
                <label class="form-label mr-3">{{ __('messages.doctor.female') }}</label>
            </div>
        </span>
    </div>
    <div class="col-md-6 mb-5">
        <label class="form-label">{{ __('messages.patient.blood_group') . ':' }}</label>
        {{ Form::select('blood_group', $bloodGroup, $user->blood_group, ['class' => 'io-select2 form-select', 'data-control' => 'select2', 'placeholder' => __('messages.doctor.select_blood_group')]) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('twitter', __('messages.doctor.twitter') . ':', ['class' => 'form-label']) }}
        {{ Form::text('twitter_url', !empty($doctor->twitter_url) ? $doctor->twitter_url : null, ['class' => 'form-control', 'placeholder' => __('messages.common.twitter_url'), 'id' => 'twitterUrl']) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('linkedin', __('messages.doctor.linkedin') . ':', ['class' => 'form-label']) }}
        {{ Form::text('linkedin_url', !empty($doctor->linkedin_url) ? $doctor->linkedin_url : null, ['class' => 'form-control', 'placeholder' => __('messages.common.linkedin_url'), 'id' => 'linkedinUrl']) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('instagram', __('messages.doctor.instagram') . ':', ['class' => 'form-label']) }}
        {{ Form::text('instagram_url', !empty($doctor->instagram_url) ? $doctor->instagram_url : null, ['class' => 'form-control', 'placeholder' => __('messages.common.instagram_url'), 'id' => 'instagramUrl']) }}
    </div>
    <div class="row">

        <label class="form-label">{{ __('messages.patient.availability') . ':' }}</label>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="availability[]" value="Online from our premises"
                    @checked(string_in_array(json_decode($doctor->availability), 'Online from our premises')) id="availabilityOnline">
                <label class="form-check-label" for="availabilityOnline">
                    {{ __('messages.patient.online_from_premises') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" @checked(string_in_array(json_decode($doctor->availability), 'Remotely')) type="checkbox" name="availability[]"
                    value="Remotely" id="availabilityRemotely">
                <label class="form-check-label" for="availabilityRemotely">
                    {{ __('messages.patient.remotely') }}
                </label>
            </div>
        </div>
    </div>

    <div class="row">

        <label class="form-label">{{ __('messages.patient.can_start_immediately') . ':' }}</label>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="can_start_immediately" value="Yes"
                    @checked($doctor->can_start_immediately == 1) id="startImmediatelyYes">
                <label class="form-check-label" for="startImmediatelyYes">
                    {{ __('messages.patient.yes') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="can_start_immediately" value="No"
                    id="startImmediatelyNo" @checked($doctor->can_start_immediately == 0)>
                <label class="form-check-label" for="startImmediatelyNo">
                    {{ __('messages.patient.no') }}
                </label>
            </div>
        </div>
    </div>

    <div class="row" id="startDateContainer" style="display: none;">
        <div class="col-md-12 mb-5">
            <label class="form-label">{{ __('messages.patient.select_start_date') . ':' }}</label>
            <input type="date" name="start_date" value="{{ $doctor->start_date }}" class="form-control"
                id="startDate">
        </div>
    </div>


    <div class="row">

        <label class="form-label">{{ __('messages.patient.services_can_be_performed_online') . ':' }}</label>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'Online from our premises')) name="services[]"
                    value="Online from our premises" id="urgent_care">
                <label class="form-check-label" for="urgent_care">
                    {{ __('messages.patient.urgent_care') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'chronic_care')) name="services[]"
                    value="chronic_care" id="chronic_care">
                <label class="form-check-label" for="chronic_care">
                    {{ __('messages.patient.chronic_care') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'child_care')) name="services[]"
                    value="child_care" id="child_care">
                <label class="form-check-label" for="child_care">
                    {{ __('messages.patient.child_care') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'sexual_health')) name="services[]"
                    value="sexual_health" id="sexual_health">
                <label class="form-check-label" for="sexual_health">
                    {{ __('messages.patient.sexual_health') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'skin_and_hair')) name="services[]"
                    value="skin_and_hair" id="skin_and_hair">
                <label class="form-check-label" for="skin_and_hair">
                    {{ __('messages.patient.skin_and_hair') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'mental_health')) name="services[]"
                    value="mental_health" id="mental_health">
                <label class="form-check-label" for="mental_health">
                    {{ __('messages.patient.mental_health') }}
                </label>
            </div>
        </div>
        <div class="col-md-6 mb-5">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->services), 'preventive_health')) name="services[]"
                    value="preventive_health" id="preventive_health">
                <label class="form-check-label" for="preventive_health">
                    {{ __('messages.patient.preventive_health') }}
                </label>
            </div>
        </div>
    </div>


    <div class="row mt-5 toggle-div" id="urgentCareSubservices" >
        <label class="form-label">{{ __('messages.patient.urgent_care') . ':' }}</label>
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_urgent_care), 'Allergies'))
                        name="sub_urgent_care[]" value="Allergies" id="allergies">
                    <label class="form-check-label" for="allergies">
                        {{ __('messages.patient.allergies') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_urgent_care), 'Acne'))
                        name="sub_urgent_care[]" value="Acne" id="acne">
                    <label class="form-check-label" for="acne">
                        {{ __('messages.patient.acne') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_urgent_care), 'Cold'))
                        name="sub_urgent_care[]" value="Cold, Cough" id="cold_cough">
                    <label class="form-check-label" for="cold_cough">
                        {{ __('messages.patient.cold,cough') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_urgent_care), 'hair_loss'))
                        name="sub_urgent_care[]" value="hair_loss" id="hair_loss">
                    <label class="form-check-label" for="hair_loss">
                        {{ __('messages.patient.hair_loss') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_urgent_care), 'erectile_dysfunction'))
                        name="sub_urgent_care[]" value="erectile_dysfunction" id="erectile_dysfunction">
                    <label class="form-check-label" for="erectile_dysfunction">
                        {{ __('messages.patient.erectile_dysfunction') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_urgent_care), 'yeast_infections'))
                        name="sub_urgent_care[]" value="yeast_infections" id="yeast_infections">
                    <label class="form-check-label" for="yeast_infections">
                        {{ __('messages.patient.yeast_infections') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 toggle-div" id="ChronicCareSubservices" >
        <label class="form-label">{{ __('messages.patient.chronic_care') . ':' }}</label>
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_chronic_care), 'asthma'))
                        name="sub_chronic_care[]" value="asthma" id="asthma">
                    <label class="form-check-label" for="asthma">
                        {{ __('messages.patient.asthma') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_chronic_care), 'high_cholesterol'))
                        name="sub_chronic_care[]" value="high_cholesterol" id="high_cholesterol">
                    <label class="form-check-label" for="high_cholesterol">
                        {{ __('messages.patient.high_cholesterol') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_chronic_care), 'high_blood_pressure'))
                        name="sub_chronic_care[]" value="high_blood_pressure" id="high_blood_pressure">
                    <label class="form-check-label" for="high_blood_pressure">
                        {{ __('messages.patient.high_blood_pressure') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_chronic_care), 'weight_management'))
                        name="sub_chronic_care[]" value="weight_management" id="weight_management">
                    <label class="form-check-label" for="weight_management">
                        {{ __('messages.patient.weight_management') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_chronic_care), 'diabetes'))
                        name="sub_chronic_care[]" value="diabetes" id="diabetes">
                    <label class="form-check-label" for="diabetes">
                        {{ __('messages.patient.diabetes') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_chronic_care), 'thyroid_issues'))
                        name="sub_chronic_care[]" value="thyroid_issues" id="thyroid_issues">
                    <label class="form-check-label" for="thyroid_issues">
                        {{ __('messages.patient.thyroid_issues') }}
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 toggle-div" id="ChildCareSubservices" >
        <div class="row">
            <label class="form-label">{{ __('messages.patient.services_can_be_performed_online') . ':' }}</label>
            <label class="form-label">{{ __('messages.patient.child_care') . ':' }}</label>
        </div>
    </div>

    <div class="row mt-5 toggle-div" id="SexualHealthSubservices" >
        <label class="form-label">{{ __('messages.patient.sexual_health') . ':' }}</label>
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_sexual_health), 'uti'))
                        name="sub_sexual_health[]" value="uti" id="uti">
                    <label class="form-check-label" for="uti">
                        {{ __('messages.patient.uti') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_sexual_health), 'erectile_dysfunction'))
                        name="sub_sexual_health[]" value="erectile_dysfunction" id="erectile_dysfunction">
                    <label class="form-check-label" for="erectile_dysfunction">
                        {{ __('messages.patient.erectile_dysfunction') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_sexual_health), 'emergency_contraception'))
                        name="sub_sexual_health[]" value="emergency_contraception" id="emergency_contraception">
                    <label class="form-check-label" for="emergency_contraception">
                        {{ __('messages.patient.emergency_contraception') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_sexual_health), 'weight_management'))
                        name="sub_sexual_health[]" value="weight_management" id="weight_management">
                    <label class="form-check-label" for="weight_management">
                        {{ __('messages.patient.weight_management') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_sexual_health), 'yeast_infections'))
                        name="sub_sexual_health[]" value="yeast_infections" id="yeast_infections">
                    <label class="form-check-label" for="yeast_infections">
                        {{ __('messages.patient.yeast_infections') }}
                    </label>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5 toggle-div" id="SkinAndHairSubservices" >
        <label class="form-label">{{ __('messages.patient.skin_and_hair') . ':' }}</label>
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_skin_and_hair), 'hair_loss'))
                        name="sub_skin_and_hair[]" value="hair_loss" id="hair_loss">
                    <label class="form-check-label" for="hair_loss">
                        {{ __('messages.patient.hair_loss') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_skin_and_hair), 'acne'))
                        name="sub_skin_and_hair[]" value="acne" id="acne">
                    <label class="form-check-label" for="acne">
                        {{ __('messages.patient.acne') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_skin_and_hair), 'eczema'))
                        name="sub_skin_and_hair[]" value="eczema" id="eczema">
                    <label class="form-check-label" for="eczema">
                        {{ __('messages.patient.eczema') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_skin_and_hair), 'athletes_foot'))
                        name="sub_skin_and_hair[]" value="athletes_foot" id="athletes_foot">
                    <label class="form-check-label" for="athletes_foot">
                        {{ __('messages.patient.athletes_foot') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_skin_and_hair), 'cellulitis_sunburn'))
                        name="sub_skin_and_hair[]" value="cellulitis_sunburn" id="cellulitis_sunburn">
                    <label class="form-check-label" for="cellulitis_sunburn">
                        {{ __('messages.patient.cellulitis_sunburn') }}
                    </label>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5 toggle-div" id="MentalHealthSubservices" >
        <label class="form-label">{{ __('messages.patient.mental_health') . ':' }}</label>
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'anxiety'))
                        name="sub_mental_health[]" value="anxiety" id="anxiety">
                    <label class="form-check-label" for="anxiety">
                        {{ __('messages.patient.anxiety') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'depression'))
                        name="sub_mental_health[]" value="depression" id="depression">
                    <label class="form-check-label" for="depression">
                        {{ __('messages.patient.depression') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'stress'))
                        name="sub_mental_health[]" value="stress" id="stress">
                    <label class="form-check-label" for="stress">
                        {{ __('messages.patient.stress') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'grief_loss'))
                        name="sub_mental_health[]" value="grief_loss" id="grief_loss">
                    <label class="form-check-label" for="grief_loss">
                        {{ __('messages.patient.grief_loss') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'postpartum'))
                        name="sub_mental_health[]" value="postpartum" id="postpartum">
                    <label class="form-check-label" for="postpartum">
                        {{ __('messages.patient.postpartum') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'mood_disorders'))
                        name="sub_mental_health[]" value="mood_disorders" id="mood_disorders">
                    <label class="form-check-label" for="mood_disorders">
                        {{ __('messages.patient.mood_disorders') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_mental_health), 'ptsd'))
                        name="sub_mental_health[]" value="ptsd" id="ptsd">
                    <label class="form-check-label" for="ptsd">
                        {{ __('messages.patient.ptsd') }}
                    </label>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5 toggle-div" id="PreventiveHealthSubservices" >
        <label class="form-label">{{ __('messages.patient.preventive_health') . ':' }}</label>
        <div class="row">
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_preventive_health), 'wellness_visits'))
                        name="sub_preventive_health[]" value="wellness_visits" id="wellness_visits">
                    <label class="form-check-label" for="wellness_visits">
                        {{ __('messages.patient.wellness_visits') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_preventive_health), 'family_medicine'))
                        name="sub_preventive_health[]" value="family_medicine" id="family_medicine">
                    <label class="form-check-label" for="family_medicine">
                        {{ __('messages.patient.family_medicine') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_preventive_health), 'womens_wellness'))
                        name="sub_preventive_health[]" value="womens_wellness" id="womens_wellness">
                    <label class="form-check-label" for="womens_wellness">
                        {{ __('messages.patient.womens_wellness') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_preventive_health), 'men_wellness'))
                        name="sub_preventive_health[]" value="men_wellness" id="men_wellness">
                    <label class="form-check-label" for="men_wellness">
                        {{ __('messages.patient.men_wellness') }}
                    </label>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_preventive_health), 'diet_nutrition'))
                        name="sub_preventive_health[]" value="diet_nutrition" id="diet_nutrition">
                    <label class="form-check-label" for="diet_nutrition">
                        {{ __('messages.patient.diet_nutrition') }}
                    </label>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" @checked(string_in_array(json_decode($doctor->sub_preventive_health), 'medication_management'))
                        name="sub_preventive_health[]" value="medication_management" id="medication_management">
                    <label class="form-check-label" for="medication_management">
                        {{ __('messages.patient.medication_management') }}
                    </label>
                </div>
            </div>
        </div>

    </div>

    <!-- File upload field -->
    <div class="col-md-6 mb-5">
        <label class="form-label">{{ __('messages.patient.upload_file') . ':' }}</label>
        <input type="file" name="uploaded_file" class="form-control" id="uploadedFile">
    </div>

    @include('components.images')
    <div class="col-md-6 mb-5">
        <div class="mb-3" io-image-input="true">
            <label for="exampleInputImage" class="form-label">{{ __('messages.doctor.profile') }}:</label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="exampleInputImage"
                        style="background-image: url({{ !empty($user->profile_image) ? $user->profile_image : asset('web/media/avatars/male.png') }})">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                        data-placement="top" data-bs-original-title="{{ __('messages.user.edit_profile') }}">
                        <label>
                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            <input type="file" id="profilePicture" name="profile"
                                class="image-upload d-none profile-validation" accept="image/*" />
                        </label>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 mb-5">
    <label class="form-label">{{ __('messages.doctor.status') }}:</label>
    <div class="col-lg-8">
        <div class="form-check form-check-solid form-switch">
            <input name="status" class="form-check-input checkBoxClass" type="checkbox"
                {{ $user->status == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="allowmarketing"></label>
        </div>
    </div>
</div>
<div class="row gx-10 mb-5">
    <div class="col-md-6 mb-5">
        {{ Form::label('Address 1', __('messages.doctor.address1') . ':', ['class' => 'form-label']) }}
        {{ Form::text('address1', isset($user->address->address1) ? $user->address->address1 : '', ['class' => 'form-control', 'placeholder' => __('messages.doctor.address1')]) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Address 2', __('messages.doctor.address2') . ':', ['class' => 'form-label']) }}
        {{ Form::text('address2', isset($user->address->address2) ? $user->address->address2 : '', ['class' => 'form-control', 'placeholder' => __('messages.doctor.address2')]) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('Country', __('messages.doctor.country') . ':', ['class' => 'form-label']) }}
        {{ Form::select(
            'country_id',
            $countries,
            isset($user->address->country_id) ? $user->address->country_id : null,
            [
                'class' => 'io-select2 form-select',
                'data-control' => 'select2',
                'id' => 'editDoctorCountryId',
                'placeholder' => __('messages.common.select_country'),
            ],
        ) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('State', __('messages.doctor.state') . ':', ['class' => 'form-label']) }}
        {{ Form::select('state_id', isset($state) && $state != null ? $state : [], isset($user->address->state_id) ? $user->address->state_id : null, ['class' => 'io-select2 form-select', 'data-control' => 'select2', 'id' => 'editDoctorStateId', 'placeholder' => __('messages.common.select_state')]) }}
    </div>
    <div class="col-md-6 mb-5">
        {{ Form::label('City', __('messages.doctor.city') . ':', ['class' => 'form-label']) }}
        {{ Form::select('city_id', isset($cities) && $cities != null ? $cities : [], isset($user->address->city_id) ? $user->address->city_id : null, ['class' => 'io-select2 form-select', 'data-control' => 'select2', 'id' => 'editDoctorCityId', 'placeholder' => __('messages.common.select_city')]) }}
    </div>
    <div class="col-md-6">
        {{ Form::label('Postal Code', __('messages.doctor.postal_code') . ':', ['class' => 'form-label']) }}
        {{ Form::text('postal_code', isset($user->address->postal_code) ? $user->address->postal_code : '', ['class' => 'form-control', 'placeholder' => __('messages.doctor.postal_code')]) }}
    </div>
</div>
<div>
    <div class="fw-bolder fs-3 rotate collapsible mb-4">{{ __('messages.doctor.qualification_information') }}
    </div>
    <a class="btn btn-primary float-end mb-4"
        id="addQualification">{{ __('messages.doctor.add_qualification') }}</a>
</div>
<input type="hidden" name="deletedQualifications" value="" id="deletedQualifications">
<div class="row showQualification w-100">
    <div class="col-md-4 mb-5">
        {{ Form::label('Degree', __('messages.doctor.degree') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('degree', null, ['class' => 'form-control degree', 'placeholder' => __('messages.doctor.degree'), 'id' => 'degree']) }}
    </div>
    <div class="col-md-4 mb-5">
        {{ Form::label('university', __('messages.doctor.university') . ':', ['class' => 'form-label required']) }}
        {{ Form::text('university', null, ['class' => 'form-control university', 'placeholder' => __('messages.doctor.university'), 'id' => 'university']) }}
    </div>
    <div class="col-md-4 mb-5">
        <label class="form-label required">{{ __('messages.doctor.year') }}:</label>
        {{ Form::select('year', $years, !empty($qualifications->year) ? $qualifications->year : null, ['class' => 'io-select2 form-select year', 'data-control' => 'select2', 'id' => 'year', 'placeholder' => __('messages.doctor.select_year')]) }}
    </div>
    <div class="mb-5 col-md-4">
        <button type="button" class="btn btn-primary me-3"
            id="saveQualification">{{ __('messages.common.save') }}</button>
        <button type="button" class="btn btn-secondary"
            id="cancelQualification">{{ __('messages.common.discard') }}</button>
    </div>

 
</div><br>
<div class="table-responsive-sm w-100 mt-4">
    <table class="table table-row-dashed table-row-gray-300 gy-7 align-middle" id="doctorQualificationTbl">
        <thead>
            <tr class="fw-bolder fs-6 text-gray-800">
                <th>{{ Str::upper(__('messages.doctor.sr_no')) }}</th>
                <th>{{ Str::upper(__('messages.doctor.degree')) }}</th>
                <th>{{ Str::upper(__('messages.doctor.collage_university')) }}</th>
                <th>{{ Str::upper(__('messages.doctor.year')) }}</th>
                <th class="text-center">{{ Str::upper(__('messages.common.action')) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($qualifications as $index => $qualification)
                <tr>
                    <td id="qualificationId" data-value="{{ $index + 1 }}">{{ $index + 1 }}</td>
                    <td id="degreeTd">{{ $qualification->degree }}</td>
                    <td id="universityTd">{{ $qualification->university }}</td>
                    <td id="yearTd">{{ $qualification->year }}</td>
                    <td class="text-center whitespace-nowrap">
                        <div class="d-flex justify-content-center">
                            <a data-id="{{ $index + 1 }}" data-primary-id="{{ $qualification->id }}"
                                title="{{ __('messages.common.edit') }}"
                                class="btn edit-btn-qualification btn-icon px-1 fs-3 text-primary"
                                data-bs-toggle="tooltip" data-bs-original-title="{{ __('messages.common.edit') }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a data-id="{{ $qualification->id }}" title="{{ __('messages.common.delete') }}"
                                class="delete-btn-qualification btn btn-icon px-1 fs-3 text-danger"
                                data-bs-toggle="tooltip"
                                data-bs-original-title="{{ __('messages.common.delete') }}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex mt-4">
    <button type="submit" class="btn btn-primary">{{ __('messages.common.save') }}</button>&nbsp;&nbsp;&nbsp;
    <a href="{{ route('doctors.index') }}" type="reset" id="ResetForm"
        class="btn btn-secondary">{{ __('messages.common.discard') }}</a>
</div>


<script>

$(document).ready(function(){
       $("#urgentCareSubservices").hide();
        $("#ChronicCareSubservices").hide();
        $("#ChildCareSubservices").hide();
        $("#SexualHealthSubservices").hide();
        $("#SkinAndHairSubservices").hide();
        $("#MentalHealthSubservices").hide();
        $("#PreventiveHealthSubservices").hide();

        function toggleDiv(checkboxId, divId) {
            if ($('#' + checkboxId).is(":checked")) {
                $('#' + divId).show();
            }
        }

              // Check and set visibility for all required checkboxes
        toggleDiv("urgent_care", "urgentCareSubservices");
        toggleDiv("chronic_care", "ChronicCareSubservices");
        toggleDiv("child_care", "ChildCareSubservices");
        toggleDiv("sexual_health", "SexualHealthSubservices");
        toggleDiv("skin_and_hair", "SkinAndHairSubservices");
        toggleDiv("mental_health", "MentalHealthSubservices");
        toggleDiv("preventive_health", "PreventiveHealthSubservices");
});



    document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll("input[type='checkbox']");
            
            function toggleDiv(checkboxId, divId) {
                const checkbox = document.getElementById(checkboxId);
                const relatedDiv = document.getElementById(divId);
                if (checkbox.checked) {
                    relatedDiv.style.display = "block";
                } else {
                    relatedDiv.style.display = "none";
                }
                checkbox.addEventListener("change", function() {
                    relatedDiv.style.display = this.checked ? "block" : "none";
                });
            }

            // Check and set visibility for all required checkboxes
            toggleDiv("urgent_care", "urgentCareSubservices");
            toggleDiv("chronic_care", "ChronicCareSubservices");
            toggleDiv("child_care", "ChildCareSubservices");
            toggleDiv("sexual_health", "SexualHealthSubservices");
            toggleDiv("skin_and_hair", "SkinAndHairSubservices");
            toggleDiv("mental_health", "MentalHealthSubservices");
            toggleDiv("preventive_health", "PreventiveHealthSubservices");
            // Add more calls to toggleDiv for other checkbox-div pairs as needed
        });



    document.addEventListener('DOMContentLoaded', function() {
        var yesRadio = document.getElementById('startImmediatelyYes');
        var noRadio = document.getElementById('startImmediatelyNo');
        var startDateContainer = document.getElementById('startDateContainer');

        yesRadio.addEventListener('change', function() {
            if (this.checked) {
                startDateContainer.style.display = 'none';
            }
        });

        noRadio.addEventListener('change', function() {
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

</script>
