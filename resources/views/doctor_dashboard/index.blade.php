@extends('layouts.app')
@section('title')
    {{__('messages.dashboard')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">

                    <div class="col-xl-4 ">
                     <div class="row ">
                        <div class="col-xl-12 col-md-6 dashbord-doctor-card widget mb-5">
                            <div class="dashbord-doctor-card-header">
                                <h3>{{__('messages.welcome_back')}}</h3>
                                <span>{{__('messages.dashboard')}}</span>
                            </div>
                            <div class="dashbord-doctor-card-body d-flex align-items-center justify-content-between">
                                <div class="align-items-center py-3 py-sm-1">
                                    <div class="image image-circle image-mini">
                                        @if(getLogInUser()->hasRole('patient'))
                                            <img class="img-fluid doctor-card-img" alt="img-fluid"
                                                 src="{{ getLogInUser()->patient->profile }}"/>
                                        @elseif(getLogInUser()->hasRole('doctor'))
                                            <img class="img-fluid doctor-card-img" alt="img-fluid"
                                                 src="{{ getLogInUser()->profile_image }}"/>
                                        @else
                                            <img class="img-fluid doctor-card-img" alt="img-fluid"
                                                 src="{{ getLogInUser()->profile_image }}"/>
                                        @endif
                                    </div>
                                    <div class="doctor-data">
                                        <h3 class="text-gray-900">{{ getLogInUser()->full_name }}</h3>
                                        <h4 class="mb-0 fw-400 fs-6">{{ getLogInUser()->email }}</h4>
                                    </div>
                                </div>
                                <div class="col-5 ">
                                    <div class="">
                                        <div class="float-end">
                                            <h4 class="fs-6 text-dark fw-bolder">{{__('messages.user.edit_profile')}}</h4>
                                            <a href="{{route('profile.setting')}}" class="btn btn-primary px-2 py-1">{{__('messages.doctor.profile')}} →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-6 doctor-dashbord-earning-card widget mb-5">
                            <div class="doctor-dashbord-earning-card-header">
                                <h3>{{__('messages.monthly_earning')}}</h3>
                                <span class="mt-4 fw-light">{{__('messages.datepicker.this_month')}}</span>
                            </div>
                            <div class="doctor-dashbord-earning-card-body d-flex align-items-center justify-content-between">
                                   <div class="doctor-month-total-amount fs-1 my-2">0</div>
                                    <div class="">
                                        <span class="me-3 dashbord-earning-card-body-amont"></span><div>{{__('messages.from_previous_month')}}</div>
                                    </div>
                            </div>
                        </div>
                     </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                                <a href="{{ url('doctors/appointments') }}"
                                   class="text-decoration-none">
                                    <div class="doctor-wiget-appointment-card1 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                        <div class="text-start text-dark">
                                            <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.doctor_dashboard.total_appointments')}}</h3>
                                            <h1 class="fs-2-xxl fw-bolder">{{$appointments['totalAppointmentCount']}}</h1>
                                        </div>
                                        <div class="bg-cyan-500 widget-icon doctor-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-file-medical card-icon display-6 text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                                <a href="{{ url('doctors/appointments') }}"
                                   class="text-decoration-none">
                                    <div
                                        class="doctor-wiget-appointment-card2 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                        <div class="text-start text-dark">
                                            <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.admin_dashboard.today_appointments')}}</h3>
                                            <h1 class="fs-2-xxl fw-bolder">{{$appointments['todayAppointmentCount']}}</h1>
                                        </div>
                                        <div
                                            class="bg-cyan-500 widget-icon doctor-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-calendar-alt card-icon display-6 text-white hospital-user-dark-mode"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                                <a href="{{ url('doctors/appointments') }}"
                                   class="text-decoration-none">
                                    <div
                                        class="doctor-wiget-appointment-card3 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                        <div class="text-start text-dark">
                                            <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.patient_dashboard.next_appointment')}}</h3>
                                            <h1 class="fs-2-xxl fw-bolder">{{$appointments['upcomingAppointmentCount']}}</h1>
                                        </div>
                                        <div
                                            class="bg-cyan-500 widget-icon doctor-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-book-medical card-icon display-6 text-white"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!--begin::Charts Widget 8-->
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <!--begin::Header-->
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column mb-3">
                                    <span
                                        class="card-label fw-bolder fs-3 mb-1">{{__('messages.monthly_appointments')}}
                                    </span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body appointmentDoctorChart">
                                {{Form::hidden('admin_chart_data',json_encode($doctorAllAppointment,true) ,['id' => 'doctorChartData'])}}
                                <!--begin::Chart-->
                                <div id="appointmentDoctorChartId" style="height: 350px" class="card-rounded-bottom"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Charts Widget 8-->
                    </div>


                <div class="col-xxl-12">
                    <div class="d-flex border-0 pt-5">
                        <h3 class="align-items-start flex-column">
                            <span class="fw-bolder fs-3 mb-1">{{__('messages.doctor_dashboard.recent_appointments')}}</span>
                        </h3>
                        <div class="ms-auto d-sm-block d-none">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-sm btn-color-muted btn-active text-primary btn-active-light-primary fw-bolder px-4 active"
                                       data-bs-toggle="tab"
                                       id="doctorDayData">{{__('messages.admin_dashboard.day')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1"
                                       data-bs-toggle="tab"
                                       id="doctorWeekData">{{__('messages.admin_dashboard.week')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1 "
                                       data-bs-toggle="tab"
                                       id="doctorMonthData">{{__('messages.admin_dashboard.month')}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="ms-auto d-flex d-sm-none d-block mt-2 mb-2 justify-content-end">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active text-primary btn-active-light-primary fw-bolder px-4 active"
                                   data-bs-toggle="tab"
                                   id="doctorDayData">{{__('messages.admin_dashboard.day')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1"
                                   data-bs-toggle="tab"
                                   id="doctorWeekData">{{__('messages.admin_dashboard.week')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1 "
                                   data-bs-toggle="tab"
                                   id="doctorMonthData">{{__('messages.admin_dashboard.month')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content mt-0">
                    <div class="tab-pane fade show active" id="month">
                        <div class="table-responsive livewire-table">
                            <table class="table table-striped">
                                <thead>
                                <tr class="text-uppercase">
                                    <th class="w-25px text-muted mt-1 fw-bold fs-7">{{__('messages.doctor_appointment.patient')}}</th>
                                    <th class="min-w-150px text-muted mt-1 fw-bold fs-7">{{__('messages.patient.patient_unique_id')}}</th>
                                    <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">{{__('messages.appointment.date')}}</th>
                                </tr>
                                </thead>
                                <tbody id="doctorMonthlyReport">
                                @forelse($appointments['records'] as $appointment)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="image image-circle image-mini me-3">
                                                    <img src="{{$appointment->patient->profile}}" alt="user" class="">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="{{route('doctors.patient.detail',$appointment->patient_id)}}"
                                                       class="text-primary-800 mb-1 fs-6 text-decoration-none">
                                                        {{$appointment->patient->user->fullname}}</a>
                                                    <span class="text-muted fw-bold d-block">{{$appointment->patient->user->email}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-start">
                                            <span class="badge bg-light-success">{{$appointment->patient->patient_unique_id}}</span>
                                        </td>
                                        <td class="mb-1 fs-6 text-muted fw-bold text-center">
                                            <div class="badge bg-light-info">
                                                <div class="mb-2">{{$appointment->from_time}} {{$appointment->from_time_type}}
                                                    - {{$appointment->to_time}} {{$appointment->to_time_type}}</div>
                                                <div class="">{{ \Carbon\Carbon::parse($appointment->date)->isoFormat('DD MMM YYYY')}} </div>
                                            </div>
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
                    <div class="tab-pane fade" id="week">
                        <div class="table-responsive livewire-table">
                            <table class="table table-striped">
                                <thead>
                                <tr class="text-uppercase">
                                    <th class="w-25px text-muted mt-1 fw-bold fs-7">{{__('messages.doctor_appointment.patient')}}</th>
                                    <th class="min-w-150px text-muted mt-1 fw-bold fs-7">{{__('messages.patient.patient_unique_id')}}</th>
                                    <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">{{__('messages.appointment.date')}}</th>
                                </tr>
                                </thead>
                                <tbody id="doctorWeeklyReport"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="day">
                        <div class="table-responsive livewire-table">
                            <table class="table table-striped">
                                <thead>
                                <tr class="text-uppercase">
                                    <th class="w-25px text-muted mt-1 fw-bold fs-7">{{__('messages.doctor_appointment.patient')}}</th>
                                    <th class="min-w-150px text-muted mt-1 fw-bold fs-7">{{__('messages.patient.patient_unique_id')}}</th>
                                    <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">{{__('messages.appointment.date')}}</th>
                                </tr>
                                </thead>
                                <tbody id="doctorDailyReport">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('doctor_dashboard.templates.templates')
@endsection
