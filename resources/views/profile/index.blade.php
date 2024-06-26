@extends('layouts.app')
@section('title')
    {{ __('messages.user.profile_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1>{{ __('messages.user.edit_profile') }}</h1>
        </div>

        <div class="col-12">
            @include('layouts.errors')
            @include('flash::message')
        </div>
        <div class="card">
            <div class="card-body">
                @if (auth()->user()->role_name != 'Doctor')
                    <form id="profileForm" method="POST" action="{{ route('update.profile.setting') }}"
                        enctype="multipart/form-data">
                        {{ Form::hidden('is_edit', true, ['id' => 'staffProfileIsEdit']) }}
                        {{ Form::hidden('is_edit', true, ['id' => 'patientProfileIsEdit']) }}
                        {{ Form::hidden(
                            'edit_patient_country_id',
                            isset($patient->address->country_id) ? $patient->address->country_id : null,
                            ['id' => 'editPatientProfileCountryId'],
                        ) }}
                        {{ Form::hidden(
                            'edit_patient_state_id',
                            isset($patient->address->state_id) ? $patient->address->state_id : null,
                            ['id' => 'editPatientProfileStateId'],
                        ) }}
                        {{ Form::hidden('edit_patient_city_id', isset($patient->address->city_id) ? $patient->address->city_id : null, [
                            'id' => 'editPatientProfileCityId',
                        ]) }}
                        @csrf
                        @method('PUT')
                        <div class="row mb-5">
                            <div class="col-lg-4">
                                <label for="exampleInputImage"
                                    class="form-label">{{ __('messages.doctor.profile') }}:</label>
                            </div>
                            <div class="col-lg-8">
                                @php $styleCss = 'style' @endphp
                                <div class="mb-3" io-image-input="true">
                                    <div class="d-block">
                                        <div class="image-picker">
                                            <div class="image previewImage" id="exampleInputImage"
                                                {{ $styleCss }}="background-image: url('{{ getLogInUser()->hasRole('patient') ? getLogInUser()->patient->profile : $user->profile_image }}')
                                ">
                                            </div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="{{ __('messages.user.edit_profile') }}">
                                                <label>
                                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file" id="profilePicture" name="image"
                                                        class="image-upload d-none profile-validation" accept="image/*" />
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="col-lg-4 form-label required">{{ __('messages.user.full_name') . ':' }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6 mb-5">
                                        {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => __('messages.doctor.first_name'), 'required']) }}
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => __('messages.doctor.last_name'), 'required']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="col-lg-4 form-label required">{{ __('messages.user.email') . ':' }}</label>
                            <div class="col-lg-8">
                                {{ Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => __('messages.user.email'), 'required']) }}
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 form-label required">{{ __('messages.user.time_zone') . ':' }}
                            </label>
                            <div class="col-lg-8">
                                {{ Form::select('time_zone', App\Models\User::TIME_ZONE_ARRAY, $user->time_zone, ['class' => 'form-control io-select2', 'placeholder' => __('messages.user.select_time_zone'), 'required', 'data-control' => 'select2']) }}
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-4">
                                <label
                                    class="col-lg-4 form-label required">{{ __('messages.user.contact_number') . ':' }}</label>
                            </div>
                            <div class="col-lg-8">
                                {{ Form::tel('contact', $user->contact ? '+' . $user->region_code . $user->contact : null, ['id' => 'phoneNumber', 'class' => 'form-control', 'placeholder' => __('messages.user.contact_number'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                                {{ Form::hidden('region_code', !empty($user->user) ? $user->region_code : null, ['id' => 'prefix_code']) }}
                                <span id="valid-msg"
                                    class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.valid_number') }}</span>
                                <span id="error-msg"
                                    class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.invalid_number') }}</span>
                            </div>
                        </div>

                        <div class="row mb-5">
                            {{ Form::label('gender', __('messages.staff.gender') . ':', ['class' => 'col-lg-4 form-label required']) }}
                            <div class="col-lg-8">
                                <span class="is-valid">
                                    <input class="form-check-input" type="radio" name="gender" value="1" checked
                                        {{ !empty($user) && $user->gender === 1 ? 'checked' : '' }}>
                                    <label class="form-label">{{ __('messages.staff.male') }}</label>&nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="gender" value="2"
                                        {{ !empty($user) && $user->gender === 2 ? 'checked' : '' }}>
                                    <label class="form-label">{{ __('messages.staff.female') }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="row pt-5">

                            <div class="col-md-6 mb-5">
                                {{ Form::label('dob', __('messages.patient.dob') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('dob', !empty($user) ? $user->dob : null, ['class' => 'form-control patient-dob', 'id' => __('messages.patient.dob'), 'placeholder' => __('messages.doctor.dob')]) }}
                            </div>
                            <div class="col-md-6 mb-5">
                                <label class="form-label">{{ __('messages.patient.blood_group') . ':' }}</label>
                                {{ Form::select('blood_group', $data['bloodGroupList'], !empty($patient->user) ? $patient->user->blood_group : null, ['placeholder' => __('messages.patient.blood_group'), 'class' => 'form-select io-select2', 'aria-label' => 'Select a Blood Group', 'data-control' => 'select2']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-7">
                                {{ Form::label('address1', __('messages.patient.address1') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('address1', !empty($patient->address) ? $patient->address->address1 : null, ['class' => 'form-control', 'placeholder' => __('messages.patient.address1')]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('address2', __('messages.patient.address2') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('address2', !empty($patient->address) ? $patient->address->address2 : null, ['class' => 'form-control', 'placeholder' => __('messages.patient.address2')]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('country_id', __('messages.country.country') . ':', ['class' => 'form-label']) }}
                                {{ Form::select('country_id', $data['countries'], null, [
                                    'id' => 'patientProfileCountryId',
                                    'data-placeholder' => __('messages.country.country'),
                                    'class' => 'form-select io-select2',
                                    'aria-label' => 'Select a Country',
                                    'data-control' => 'select2',
                                ]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('state_id', __('messages.state.state') . ':', ['class' => 'form-label']) }}
                                {{ Form::select('state_id', [], null, [
                                    'id' => 'patientProfileStateId',
                                    'class' => 'form-select io-select2',
                                    'data-placeholder' => __('messages.common.select_state'),
                                    'aria-label' => 'Select State',
                                    'data-control' => 'select2',
                                ]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('city_id', __('messages.city.city') . ':', ['class' => 'form-label']) }}
                                {{ Form::select('city_id', [], null, ['id' => 'patientProfileCityId', 'class' => 'form-select io-select2', 'data-placeholder' => __('messages.common.select_city'), 'aria-label' => 'Select City', 'data-control' => 'select2']) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('postalCode', __('messages.patient.postal_code') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('postal_code', !empty($patient->address) ? $patient->address->postal_code : null, ['class' => 'form-control', 'placeholder' => __('messages.patient.postal_code')]) }}
                            </div>
                            <div class="d-flex py-6">
                                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
                            </div>
                        </div>
                    </form>
                @elseif(auth()->user()->role_name == 'Doctor')
                    <form id="profileForm" method="POST" action="{{ route('update.profile.setting') }}"
                        enctype="multipart/form-data">
                        {{ Form::hidden('is_edit', true, ['id' => 'staffProfileIsEdit']) }}
                        {{ Form::hidden('is_edit', true, ['id' => 'patientProfileIsEdit']) }}
                        {{ Form::hidden(
                            'edit_doctor_country_id',
                            isset($patient->address->country_id) ? $patient->address->country_id : null,
                            ['id' => 'editPatientProfileCountryId'],
                        ) }}
                        {{ Form::hidden(
                            'edit_doctor_state_id',
                            isset($patient->address->state_id) ? $patient->address->state_id : null,
                            ['id' => 'editPatientProfileStateId'],
                        ) }}
                        {{ Form::hidden('edit_doctor_city_id', isset($patient->address->city_id) ? $patient->address->city_id : null, [
                            'id' => 'editPatientProfileCityId',
                        ]) }}
                        @csrf
                        @method('PUT')
                        <div class="row mb-5">
                            <div class="col-lg-4">
                                <label for="exampleInputImage"
                                    class="form-label">{{ __('messages.doctor.profile') }}:</label>
                            </div>
                            <div class="col-lg-8">
                                @php $styleCss = 'style' @endphp
                                <div class="mb-3" io-image-input="true">
                                    <div class="d-block">
                                        <div class="image-picker">
                                            <div class="image previewImage" id="exampleInputImage"
                                                {{ $styleCss }}="background-image: url('{{ getLogInUser()->hasRole('patient') ? getLogInUser()->patient->profile : $user->profile_image }}')
                                    ">
                                            </div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="{{ __('messages.user.edit_profile') }}">
                                                <label>
                                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file" id="profilePicture" name="image"
                                                        class="image-upload d-none profile-validation" accept="image/*" />
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="col-lg-4 form-label required">{{ __('messages.user.full_name') . ':' }}</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6 mb-5">
                                        {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => __('messages.doctor.first_name'), 'required']) }}
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        {{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => __('messages.doctor.last_name'), 'required']) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label class="col-lg-4 form-label required">{{ __('messages.user.email') . ':' }}</label>
                            <div class="col-lg-8">
                                {{ Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' => __('messages.user.email'), 'required']) }}
                            </div>
                        </div>

                        <div class="row mb-6">
                            <label class="col-lg-4 form-label required">{{ __('messages.user.time_zone') . ':' }}
                            </label>
                            <div class="col-lg-8">
                                {{ Form::select('time_zone', App\Models\User::TIME_ZONE_ARRAY, $user->time_zone, ['class' => 'form-control io-select2', 'placeholder' => __('messages.user.select_time_zone'), 'required', 'data-control' => 'select2']) }}
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-lg-4">
                                <label
                                    class="col-lg-4 form-label required">{{ __('messages.user.contact_number') . ':' }}</label>
                            </div>
                            <div class="col-lg-8">
                                {{ Form::tel('contact', $user->contact ? '+' . $user->region_code . $user->contact : null, ['id' => 'phoneNumber', 'class' => 'form-control', 'placeholder' => __('messages.user.contact_number'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                                {{ Form::hidden('region_code', !empty($user->user) ? $user->region_code : null, ['id' => 'prefix_code']) }}
                                <span id="valid-msg"
                                    class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.valid_number') }}</span>
                                <span id="error-msg"
                                    class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.invalid_number') }}</span>
                            </div>
                        </div>

                        <div class="row mb-5">
                            {{ Form::label('gender', __('messages.staff.gender') . ':', ['class' => 'col-lg-4 form-label required']) }}
                            <div class="col-lg-8">
                                <span class="is-valid">
                                    <input class="form-check-input" type="radio" name="gender" value="1" checked
                                        {{ !empty($user) && $user->gender === 1 ? 'checked' : '' }}>
                                    <label class="form-label">{{ __('messages.staff.male') }}</label>&nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="gender" value="2"
                                        {{ !empty($user) && $user->gender === 2 ? 'checked' : '' }}>
                                    <label class="form-label">{{ __('messages.staff.female') }}</label>
                                </span>
                            </div>
                        </div>

                        <div class="row pt-5">

                            <div class="col-md-6 mb-5">
                                {{ Form::label('dob', __('messages.patient.dob') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('dob', !empty($user) ? $user->dob : null, ['class' => 'form-control patient-dob', 'id' => __('messages.patient.dob'), 'placeholder' => __('messages.doctor.dob')]) }}
                            </div>
                            <div class="col-md-6 mb-5">
                                <label class="form-label">{{ __('messages.patient.blood_group') . ':' }}</label>
                                {{ Form::select('blood_group', $data['bloodGroupList'], !empty($patient->user) ? $patient->user->blood_group : null, ['placeholder' => __('messages.patient.blood_group'), 'class' => 'form-select io-select2', 'aria-label' => 'Select a Blood Group', 'data-control' => 'select2']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <label class="form-label">{{ __('messages.patient.education') . ':' }}</label>
                                {{ Form::select('education', $educationdata, null, ['class' => 'io-select2 form-select', 'data-control' => 'select2', 'placeholder' => __('messages.patient.education')]) }}
                            </div>


                            <div class="col-md-6">
                                <div class="mb-5">
                                    {{ Form::label('Experience', __('messages.doctor.experience') . ':', ['class' => 'form-label']) }}
                                    {{ Form::text('experience', null, ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'placeholder' => __('messages.doctor.experience'), 'step' => 'any']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-5">
                                    <label class="form-label required">
                                        {{ __('messages.doctor.select_gender') }}
                                        :
                                    </label>
                                    <span class="is-valid">
                                        <div class="mt-2">
                                            <input class="form-check-input" type="radio" checked name="gender"
                                                value="1">
                                            <label class="form-label mr-3">{{ __('messages.doctor.male') }}</label>
                                            <input class="form-check-input ms-2" type="radio" name="gender"
                                                value="2">
                                            <label class="form-label mr-3">{{ __('messages.doctor.female') }}</label>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <label class="form-label">{{ __('messages.patient.blood_group') . ':' }}</label>
                                {{ Form::select('blood_group', $bloodGroup, null, ['class' => 'io-select2 form-select', 'data-control' => 'select2', 'placeholder' => __('messages.patient.blood_group')]) }}
                            </div>
                            <div class="col-md-6 mb-5">
                                {{ Form::label('twitter', __('messages.doctor.twitter') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('twitter_url', null, ['class' => 'form-control', 'placeholder' => __('messages.common.twitter_url'), 'id' => 'twitterUrl']) }}
                            </div>
                            <div class="col-md-6 mb-5">
                                {{ Form::label('linkedin', __('messages.doctor.linkedin') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('linkedin_url', null, ['class' => 'form-control', 'placeholder' => __('messages.common.linkedin_url'), 'id' => 'linkedinUrl']) }}
                            </div>
                            <div class="col-md-6 mb-5">
                                {{ Form::label('instagram', __('messages.doctor.instagram') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('instagram_url', null, ['class' => 'form-control', 'placeholder' => __('messages.common.instagram_url'), 'id' => 'instagramUrl']) }}
                            </div>
                        </div>
                        <div class="row">

                            <label class="form-label">{{ __('messages.patient.availability') . ':' }}</label>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="availability[]"
                                        value="Online from our premises" id="availabilityOnline">
                                    <label class="form-check-label" for="availabilityOnline">
                                        {{ __('messages.patient.online_from_premises') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="availability[]"
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
                                    <input class="form-check-input" type="radio" name="can_start_immediately"
                                        value="Yes" id="startImmediatelyYes">
                                    <label class="form-check-label" for="startImmediatelyYes">
                                        {{ __('messages.patient.yes') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="can_start_immediately"
                                        value="No" id="startImmediatelyNo">
                                    <label class="form-check-label" for="startImmediatelyNo">
                                        {{ __('messages.patient.no') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="startDateContainer" style="display: none;">
                            <div class="col-md-12 mb-5">
                                <label class="form-label">{{ __('messages.patient.select_start_date') . ':' }}</label>
                                <input type="date" name="start_date" class="form-control" id="startDate">
                            </div>
                        </div>


                        <div class="row">

                            <label
                                class="form-label">{{ __('messages.patient.services_can_be_performed_online') . ':' }}</label>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="Online from our premises" id="urgent_care">
                                    <label class="form-check-label" for="urgent_care">
                                        {{ __('messages.patient.urgent_care') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="chronic_care" id="chronic_care">
                                    <label class="form-check-label" for="chronic_care">
                                        {{ __('messages.patient.chronic_care') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]" value="child_care"
                                        id="child_care">
                                    <label class="form-check-label" for="child_care">
                                        {{ __('messages.patient.child_care') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="sexual_health" id="sexual_health">
                                    <label class="form-check-label" for="sexual_health">
                                        {{ __('messages.patient.sexual_health') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="skin_and_hair" id="skin_and_hair">
                                    <label class="form-check-label" for="skin_and_hair">
                                        {{ __('messages.patient.skin_and_hair') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="mental_health" id="mental_health">
                                    <label class="form-check-label" for="mental_health">
                                        {{ __('messages.patient.mental_health') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]"
                                        value="preventive_health" id="preventive_health">
                                    <label class="form-check-label" for="preventive_health">
                                        {{ __('messages.patient.preventive_health') }}
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-5" id="urgentCareSubservices" style="display: none;">
                            <label class="form-label">{{ __('messages.patient.urgent_care') . ':' }}</label>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_urgent_care[]"
                                        value="Allergies" id="allergies">
                                    <label class="form-check-label" for="allergies">
                                        {{ __('messages.patient.allergies') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_urgent_care[]"
                                        value="Acne" id="acne">
                                    <label class="form-check-label" for="acne">
                                        {{ __('messages.patient.acne') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_urgent_care[]"
                                        value="Cold, Cough" id="cold_cough">
                                    <label class="form-check-label" for="cold_cough">
                                        {{ __('messages.patient.cold,cough') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_urgent_care[]"
                                        value="hair_loss" id="hair_loss">
                                    <label class="form-check-label" for="hair_loss">
                                        {{ __('messages.patient.hair_loss') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_urgent_care[]"
                                        value="erectile_dysfunction" id="erectile_dysfunction">
                                    <label class="form-check-label" for="erectile_dysfunction">
                                        {{ __('messages.patient.erectile_dysfunction') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_urgent_care[]"
                                        value="yeast_infections" id="yeast_infections">
                                    <label class="form-check-label" for="yeast_infections">
                                        {{ __('messages.patient.yeast_infections') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5" id="ChronicCareSubservices" style="display: none;">
                            <label class="form-label">{{ __('messages.patient.chronic_care') . ':' }}</label>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_chronic_care[]"
                                        value="asthma" id="asthma">
                                    <label class="form-check-label" for="asthma">
                                        {{ __('messages.patient.asthma') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_chronic_care[]"
                                        value="high_cholesterol" id="high_cholesterol">
                                    <label class="form-check-label" for="high_cholesterol">
                                        {{ __('messages.patient.high_cholesterol') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_chronic_care[]"
                                        value="high_blood_pressure" id="high_blood_pressure">
                                    <label class="form-check-label" for="high_blood_pressure">
                                        {{ __('messages.patient.high_blood_pressure') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_chronic_care[]"
                                        value="weight_management" id="weight_management">
                                    <label class="form-check-label" for="weight_management">
                                        {{ __('messages.patient.weight_management') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_chronic_care[]"
                                        value="diabetes" id="diabetes">
                                    <label class="form-check-label" for="diabetes">
                                        {{ __('messages.patient.diabetes') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_chronic_care[]"
                                        value="thyroid_issues" id="thyroid_issues">
                                    <label class="form-check-label" for="thyroid_issues">
                                        {{ __('messages.patient.thyroid_issues') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5" id="ChildCareSubservices" style="display: none;">
                            <label
                                class="form-label">{{ __('messages.patient.services_can_be_performed_online') . ':' }}</label>
                            <label class="form-label">{{ __('messages.patient.child_care') . ':' }}</label>

                        </div>

                        <div class="row mt-5" id="SexualHealthSubservices" style="display: none;">
                            <label class="form-label">{{ __('messages.patient.sexual_health') . ':' }}</label>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_sexual_health[]"
                                        value="uti" id="uti">
                                    <label class="form-check-label" for="uti">
                                        {{ __('messages.patient.uti') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_sexual_health[]"
                                        value="erectile_dysfunction" id="erectile_dysfunction">
                                    <label class="form-check-label" for="erectile_dysfunction">
                                        {{ __('messages.patient.erectile_dysfunction') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_sexual_health[]"
                                        value="emergency_contraception" id="emergency_contraception">
                                    <label class="form-check-label" for="emergency_contraception">
                                        {{ __('messages.patient.emergency_contraception') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_sexual_health[]"
                                        value="weight_management" id="weight_management">
                                    <label class="form-check-label" for="weight_management">
                                        {{ __('messages.patient.weight_management') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_sexual_health[]"
                                        value="yeast_infections" id="yeast_infections">
                                    <label class="form-check-label" for="yeast_infections">
                                        {{ __('messages.patient.yeast_infections') }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-5" id="SkinAndHairSubservices" style="display: none;">
                            <label class="form-label">{{ __('messages.patient.skin_and_hair') . ':' }}</label>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]"
                                        value="hair_loss" id="hair_loss">
                                    <label class="form-check-label" for="hair_loss">
                                        {{ __('messages.patient.hair_loss') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]"
                                        value="acne" id="acne">
                                    <label class="form-check-label" for="acne">
                                        {{ __('messages.patient.acne') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]"
                                        value="eczema" id="eczema">
                                    <label class="form-check-label" for="eczema">
                                        {{ __('messages.patient.eczema') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]"
                                        value="athletes_foot" id="athletes_foot">
                                    <label class="form-check-label" for="athletes_foot">
                                        {{ __('messages.patient.athletes_foot') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_skin_and_hair[]"
                                        value="cellulitis_sunburn" id="cellulitis_sunburn">
                                    <label class="form-check-label" for="cellulitis_sunburn">
                                        {{ __('messages.patient.cellulitis_sunburn') }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-5" id="MentalHealthSubservices" style="display: none;">
                            <label class="form-label">{{ __('messages.patient.mental_health') . ':' }}</label>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="anxiety" id="anxiety">
                                    <label class="form-check-label" for="anxiety">
                                        {{ __('messages.patient.anxiety') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="depression" id="depression">
                                    <label class="form-check-label" for="depression">
                                        {{ __('messages.patient.depression') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="stress" id="stress">
                                    <label class="form-check-label" for="stress">
                                        {{ __('messages.patient.stress') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="grief_loss" id="grief_loss">
                                    <label class="form-check-label" for="grief_loss">
                                        {{ __('messages.patient.grief_loss') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="postpartum" id="postpartum">
                                    <label class="form-check-label" for="postpartum">
                                        {{ __('messages.patient.postpartum') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="mood_disorders" id="mood_disorders">
                                    <label class="form-check-label" for="mood_disorders">
                                        {{ __('messages.patient.mood_disorders') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_mental_health[]"
                                        value="ptsd" id="ptsd">
                                    <label class="form-check-label" for="ptsd">
                                        {{ __('messages.patient.ptsd') }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-5" id="PreventiveHealthSubservices" style="display: none;">
                            <label class="form-label">{{ __('messages.patient.preventive_health') . ':' }}</label>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_preventive_health[]"
                                        value="wellness_visits" id="wellness_visits">
                                    <label class="form-check-label" for="wellness_visits">
                                        {{ __('messages.patient.wellness_visits') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_preventive_health[]"
                                        value="family_medicine" id="family_medicine">
                                    <label class="form-check-label" for="family_medicine">
                                        {{ __('messages.patient.family_medicine') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_preventive_health[]"
                                        value="womens_wellness" id="womens_wellness">
                                    <label class="form-check-label" for="womens_wellness">
                                        {{ __('messages.patient.womens_wellness') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_preventive_health[]"
                                        value="men_wellness" id="men_wellness">
                                    <label class="form-check-label" for="men_wellness">
                                        {{ __('messages.patient.men_wellness') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_preventive_health[]"
                                        value="diet_nutrition" id="diet_nutrition">
                                    <label class="form-check-label" for="diet_nutrition">
                                        {{ __('messages.patient.diet_nutrition') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_preventive_health[]"
                                        value="medication_management" id="medication_management">
                                    <label class="form-check-label" for="medication_management">
                                        {{ __('messages.patient.medication_management') }}
                                    </label>
                                </div>
                            </div>

                        </div>

                        <!-- File upload field -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label">{{ __('messages.patient.upload_file') . ':' }}</label>
                            <input type="file" name="uploaded_file" class="form-control" id="uploadedFile">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-7">
                                {{ Form::label('address1', __('messages.patient.address1') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('address1', !empty($patient->address) ? $patient->address->address1 : null, ['class' => 'form-control', 'placeholder' => __('messages.patient.address1')]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('address2', __('messages.patient.address2') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('address2', !empty($patient->address) ? $patient->address->address2 : null, ['class' => 'form-control', 'placeholder' => __('messages.patient.address2')]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('country_id', __('messages.country.country') . ':', ['class' => 'form-label']) }}
                                {{ Form::select('country_id', $data['countries'], null, [
                                    'id' => 'patientProfileCountryId',
                                    'data-placeholder' => __('messages.country.country'),
                                    'class' => 'form-select io-select2',
                                    'aria-label' => 'Select a Country',
                                    'data-control' => 'select2',
                                ]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('state_id', __('messages.state.state') . ':', ['class' => 'form-label']) }}
                                {{ Form::select('state_id', [], null, [
                                    'id' => 'patientProfileStateId',
                                    'class' => 'form-select io-select2',
                                    'data-placeholder' => __('messages.common.select_state'),
                                    'aria-label' => 'Select State',
                                    'data-control' => 'select2',
                                ]) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('city_id', __('messages.city.city') . ':', ['class' => 'form-label']) }}
                                {{ Form::select('city_id', [], null, ['id' => 'patientProfileCityId', 'class' => 'form-select io-select2', 'data-placeholder' => __('messages.common.select_city'), 'aria-label' => 'Select City', 'data-control' => 'select2']) }}
                            </div>
                            <div class="col-md-6 mb-7">
                                {{ Form::label('postalCode', __('messages.patient.postal_code') . ':', ['class' => 'form-label']) }}
                                {{ Form::text('postal_code', !empty($patient->address) ? $patient->address->postal_code : null, ['class' => 'form-control', 'placeholder' => __('messages.patient.postal_code')]) }}
                            </div>
                            <div class="d-flex py-6">
                                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-2']) }}
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
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
