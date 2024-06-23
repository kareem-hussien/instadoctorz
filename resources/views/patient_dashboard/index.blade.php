@extends('layouts.app')
@section('title')
    {{ __('messages.dashboard') }}
@endsection
@section('content')
    <div class="container-fluid">
        {{-- <div class="d-flex flex-column"> --}}
            <div class="row ">
                <div class="col-xl-4">
                 <div class="row">
                    <div class="col-xl-12 col-md-6">
                        <div class="dashbord-patient-card  widget mb-5">
                            <div class="dashbord-patient-card-header">
                                <h3>{{ __('messages.welcome_back') }}</h3>
                                <span>{{ __('messages.dashboard') }}</span>
                                <img src="" alt="">
                            </div>
                            <div class="dashbord-patient-card-body d-flex align-items-center justify-content-between">
                                <div class="align-items-center py-3 py-sm-1">
                                    <div class="image image-circle image-mini">
                                        @if(getLogInUser()->hasRole('patient'))
                                            <img class="img-fluid patient-card-img" alt="img-fluid"
                                                 src="{{ getLogInUser()->patient->profile }}"/>
                                        @elseif(getLogInUser()->hasRole('doctor'))
                                            <img class="img-fluid patient-card-img" alt="img-fluid"
                                                 src="{{ getLogInUser()->profile_image }}"/>
                                        @else
                                            <img class="img-fluid patient-card-img" alt="img-fluid"
                                                 src="{{ getLogInUser()->profile_image }}"/>
                                        @endif
                                    </div>
                                    <div class="patient-data">
                                        <h3 class="text-gray-900">{{ getLogInUser()->full_name }}</h3>
                                        <h4 class="mb-0 fw-400 fs-6">{{ getLogInUser()->email }}</h4>
                                    </div>
                                </div>
                                <div class="col-5 pe-5">
                                    <div class="">
                                        <div class="float-end">
                                            <h4 class="fs-6 text-dark fw-bolder">{{__('messages.user.edit_profile')}}</h4>
                                            <a href="{{route('profile.setting')}}" class="btn btn-primary px-2 py-1">{{__('messages.doctor.profile')}} →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12 col-md-6">
                        <div class="patient-dashbord-earning-card  widget mb-5">
                            <div class="patient-dashbord-earning-card-header">
                                <h3>{{ __('messages.monthly_expense') }}</h3>
                                <span class="mt-4 fw-light">{{ __('messages.datepicker.this_month') }}</span>
                            </div>
                            <div class="patient-dashbord-earning-card-body d-flex align-items-center justify-content-between">
                                 <div class="d-flex">
                                    <div class="fs-1 patient-month-total-amount my-2">0</div>
                                    </div>
                                    <div class="mb-4">
                                        <span class="text-success me-3 dashbord-earning-card-body-amont">100.00% ^</span><div> {{ __('messages.from_previous_month') }}</div>
                                    </div>
                            </div>
                        </div>
                    </div>
                 </div>
                </div>
                <div class="col-xl-8">
                    <div class="">
                        <div class="row">
                            <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                                <a href="{{ route('patients.patient-appointments-index') }}"
                                   class="text-decoration-none">
                                    <div class="patient-wiget-appointment-card1 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                        <div class="text-start text-dark">
                                            <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.doctor_dashboard.total_appointments')}}</h3>
                                            <h1 class="fs-2-xxl fw-bolder">{{$data['todayAppointmentCount']}}</h1>
                                        </div>
                                        <div class="bg-cyan-500 widget-icon patient-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-file-medical card-icon display-6 text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                                <a href="{{ route('patients.patient-appointments-index') }}"
                                   class="text-decoration-none">
                                    <div class="patient-wiget-appointment-card1 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                        <div class="text-start text-dark">
                                            <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.doctor_dashboard.total_appointments')}}</h3>
                                            <h1 class="fs-2-xxl fw-bolder">{{$data['upcomingAppointmentCount']}}</h1>
                                        </div>
                                        <div class="bg-cyan-500 widget-icon patient-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-book-medical card-icon display-6 text-white hospital-user-dark-mode"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                                <a href="{{ route('patients.patient-appointments-index') }}"
                                   class="text-decoration-none">
                                    <div class="patient-wiget-appointment-card1 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                        <div class="text-start text-dark">
                                            <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.patient_dashboard.completed_appointments')}}</h3>
                                            <h1 class="fs-2-xxl fw-bolder">{{$data['completedAppointmentCount']}}</h1>
                                        </div>
                                        <div class="bg-cyan-500 widget-icon patient-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-calendar-check card-icon display-6 text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                        <div class="col-12 mb-7 mb-xxl-0 me-2">
                            <div class="d-flex border-0 pt-5 mb-2">
                                <h3 class="align-items-start flex-column">
                                    <span
                                        class="fw-bolder fs-3 mb-1">{{ __('messages.patient_dashboard.today_appointments') }}</span>
                                </h3>
                            </div>

                            <div class="table-responsive livewire-table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th class="text-muted mt-1 fw-bold fs-7">{{ __('messages.doctor.doctor') }}</th>
                                            <th class="text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.appointment.time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="monthlyReport">
                                        @forelse($data['todayAppointment'] as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="image image-circle image-mini me-3">
                                                            <img src="{{ $appointment->doctor->user->profile_image }}"
                                                                alt="user" class="">
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <a href="{{ route('patients.doctor.detail', $appointment->doctor_id) }}"
                                                                class="text-primary-800 mb-1 fs-6 text-decoration-none">
                                                                {{ $appointment->doctor->user->fullname }}</a>
                                                            <span
                                                                class="text-muted fw-bold d-block">{{ $appointment->doctor->user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="mb-1 fs-6 text-muted fw-bold text-center">
                                                    <span class="badge bg-light-info">
                                                        {{ $appointment->from_time }} {{ $appointment->from_time_type }}
                                                        - {{ $appointment->to_time }} {{ $appointment->to_time_type }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted fw-bold">
                                                    {{ __('messages.common.no_data_available') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 ms-2">
                            <div class="d-flex border-0 pt-5 mb-2">
                                <h3 class="align-items-start flex-column">
                                    <span
                                        class="fw-bolder fs-3 mb-1">{{ __('messages.patient_dashboard.upcoming_appointments') }}</span>
                                </h3>
                            </div>

                            <div class="table-responsive livewire-table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th class="text-muted mt-1 fw-bold fs-7">{{ __('messages.doctor.doctor') }}</th>
                                            <th class="text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.appointment.date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="monthlyReport">
                                        @forelse($data['upcomingAppointment'] as $appointment)
                                            <tr>
                                                <td class="w-50px">
                                                    <div class="d-flex align-items-center">
                                                        <div class="image image-circle image-mini me-3">
                                                            <img src="{{ $appointment->doctor->user->profile_image }}"
                                                                alt="user" class="user-img">
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <a href="{{ route('patients.doctor.detail', $appointment->doctor_id) }}"
                                                                class="text-primary-800 mb-1 fs-6 text-decoration-none">
                                                                {{ $appointment->doctor->user->fullname }}</a>
                                                            <span
                                                                class="text-muted fw-bold d-block">{{ $appointment->doctor->user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="mb-1 fs-6 text-muted fw-bold text-center">
                                                    <span class="badge bg-light-info">
                                                        {{ \Carbon\Carbon::parse($appointment->date)->isoFormat('DD MMM YYYY') }}
                                                        {{ $appointment->from_time }} {{ $appointment->from_time_type }}
                                                        - {{ $appointment->to_time }} {{ $appointment->to_time_type }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted fw-bold">
                                                    {{ __('messages.common.no_data_available') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::hidden('patient_chart_data', json_encode($patientAllAppointment, true), ['id' => 'patientChartData']) }}
                </div>
            </div>
        {{-- </div> --}}
    </div>
    @include('generate_patient_smart_cards/components/show_card')
@endsection
