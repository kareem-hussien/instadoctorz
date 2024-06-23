@extends('layouts.app')
@section('title')
    {{ __('messages.dashboard') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12 col-md-6">
                            <div class="admin-dashbord-user-card  widget mb-5">
                                <div class="admin-dashbord-user-card-header">
                                    <h3>{{ __('messages.welcome_back') }}</h3>
                                    <span>{{$clinic_name}} {{ __('messages.dashboard') }}</span>
                                    <img src="" alt="">
                                </div>
                                <div class="admin-dashbord-user-card-body d-flex flex-xl-nowrap flex-wrap justify-content-between">
                                    <div class="d-flex  flex-xl-column flex-row align-items-left p-4 py-3 py-sm-1">
                                        <div class="image image-circle image-mini">
                                            @if(getLogInUser()->hasRole('patient'))
                                                <img class="img-fluid admin-user-card-img" alt="img-fluid"
                                                     src="{{ getLogInUser()->patient->profile }}"/>
                                            @elseif(getLogInUser()->hasRole('doctor'))
                                                <img class="img-fluid admin-user-card-img" alt="img-fluid"
                                                     src="{{ getLogInUser()->profile_image }}"/>
                                            @else
                                                <img class="img-fluid admin-user-card-img" alt="img-fluid"
                                                     src="{{ getLogInUser()->profile_image }}"/>
                                            @endif
                                        </div>
                                        <div class="admin-user-data pt-xl-0 pt-3">
                                            <h3 class="text-gray-900">{{ getLogInUser()->full_name }}</h3>
                                            <h4 class="mb-0 fw-400 fs-6">{{ getLogInUser()->email }}</h4>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-start ms-4 mb-4">
                                                    <h2 class="fs-6 fw-bolder">{{ $data['totalDoctorCount'] }}</h2>
                                                    <h3 class="mb-0 fw-light text-dark fs-6">
                                                        {{ __('messages.purchase_medicine.total') . ' ' . __('messages.common.active') . ' ' . __('messages.doctors') }}
                                                    </h3>
                                                </div>
                                                <div class="text-start ms-4 mb-4">
                                                    <h2 class="fs-6 fw-bolder">{{ $data['totalPatientCount'] }}</h2>
                                                    <h3 class="mb-0 fw-light text-dark fs-6">{{ __('messages.admin_dashboard.total_patients') }}
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-start ms-4 mb-5">
                                                    <h2 class="fs-6 fw-bolder">{{ $data['todayAppointmentCount'] }}</h2>
                                                    <h3 class="mb-0 fw-light text-dark fs-6">
                                                        {{ __('messages.admin_dashboard.today_appointments') }}
                                                    </h3>
                                                </div>
                                                <div class="text-start ms-4">
                                                    <h2 class="fs-6 fw-bolder">{{ $data['totalRegisteredPatientCount'] }}</h2>
                                                    <h3 class="mb-0 fw-light text-dark fs-6">
                                                        {{ __('messages.admin_dashboard.today_registered_patients') }}</h3>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-6">
                            <div class="admin-dashbord-earning-card widget mb-5">
                                <div class="admin-dashbord-earning-card-header">
                                    <h3>{{ __('messages.monthly_earning') }}</h3>
                                    <span class="mt-4 fw-light">{{ __('messages.datepicker.this_month') }}</span>
                                </div>
                                <div class="admin-dashbord-earning-card-body d-flex align-items-center justify-content-between">
                               <div class="total-amount fs-1 my-2">0</div>
                                  <div class="">
                                         <span class="text-success admin-dashbord-earning-card-body-amont me-3">100.00% ^</span>
                                         <div> {{ __('messages.from_previous_month') }}</div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="col-xxl-8 col-xl-8">
                    <!--begin::Charts Widget 8-->
                    <div class="row">
                        <div class="col-xxl-6 col-xl-4 col-md-6 widget">
                            <a href="{{ route('doctors.index') }}" class=" text-decoration-none">
                                <div class="admin-wiget-appointment-card1 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                    <div class="text-start text-dark">
                                        <h3 class="mb-0 fs-6 mb-3 fw-light">{{__('messages.patient_dashboard.upcoming_appointments')}}</h3>
                                        <h1 class="fs-2-xxl fw-bolder">{{ $data['upcomingAppointmentCount'] }}</h1>
                                    </div>
                                    <div class="bg-cyan-500 widget-icon admin-patient-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user-md display-6 admin-card-icon text-white"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="col-xxl-4 col-xl-4 col-md-6 widget">
                            <a href="{{ route('patients.index') }}" class="text-decoration-none">
                                <div class="admin-wiget-appointment-card2 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                    <div class="text-start text-dark">
                                        <h3 class="mb-0 fs-6 mb-3 fw-light">{{ __('messages.admin_dashboard.total_patients') }}</h3>
                                        <h1 class="fs-2-xxl fw-bolder">{{ $data['totalPatientCount'] }}</h1>
                                    </div>
                                    <div class="bg-cyan-500 widget-icon admin-patient-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-hospital-user display-6 admin-card-icon text-white hospital-user-dark-mode"></i>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                        <div class="col-xxl-6 col-xl-4 col-md-6 widget">
                            <a href="{{ route('appointments.index') }}" class="text-decoration-none">
                                <div class="admin-wiget-appointment-card3 rounded-10 p-xxl-8 px-7 py-10 d-flex align-items-center justify-content-between mb-5">
                                    <div class="text-start text-dark">
                                        <h3 class="mb-0 fs-6 mb-3 fw-light">{{ __('messages.doctor_dashboard.total_appointments') }}</h3>
                                        <h1 class="fs-2-xxl fw-bolder">{{ $data['totalAppointmentCount'] }}</h1>
                                    </div>
                                    <div class="bg-cyan-500 widget-icon admin-patient-widget-icon rounded-50 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-calendar-alt display-6 admin-card-icon text-white"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header card-header-dashbord border-0 p-3 ps-5">

                            <h3 class="card-title align-items-start flex-column mb-3">
                                <span
                                    class="card-label fw-bolder fs-3 mb-1">{{ __('messages.admin_dashboard.earnings_from_appointments') }}
                                    ({{ getCurrencyIcon() }} <span
                                        class="card-label fw-bolder fs-3 mb-1 me-0 totalEarning"></span>)
                                </span>
                            </h3>

                            <!--begin::Toolbar-->
                            <div class="ms-0 ms-md-2 mb-3">
                                <div class="dropdown d-flex align-items-center me-4 me-md-5">
                                    <button
                                        class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0"
                                        type="button" id="dashboardFilterBtn" data-bs-auto-close="outside"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class='fas fa-filter'></i>
                                    </button>
                                    <div class="dropdown-menu py-0" aria-labelledby="dashboardFilterBtn">
                                        <div class="text-start border-bottom py-4 px-7">
                                            <h3 class="text-gray-900 mb-0">
                                                {{ __('messages.admin_dashboard.filter_options') }}</h3>
                                        </div>
                                        <div class="p-5">
                                            <div class="mb-5">
                                                <label for="exampleInputSelect2"
                                                    class="form-label">{{ __('messages.services') }}</label>
                                                {{ Form::select('service', $data['servicesArr'], null, ['class' => 'form-select io-select2 dashboardFilter', 'placeholder' => __('messages.common.select_service'), 'id' => 'serviceId', 'data-control' => 'select2']) }}
                                            </div>
                                            <div class="mb-5">
                                                <label for="exampleInputSelect2"
                                                    class="form-label">{{ __('messages.service_categories') }}</label>

                                                {{ Form::select('service', $data['serviceCategoriesArr'], null, ['class' => 'form-select io-select2 dashboardFilter', 'placeholder' => __('messages.common.select_category'), 'id' => 'serviceCategoryId', 'data-control' => 'select2']) }}
                                            </div>
                                            <div class="mb-5">
                                                <label for="exampleInputSelect2"
                                                    class="form-label">{{ __('messages.doctors') }}</label>
                                                {{ Form::select('doctor_id', $data['doctorArr'], null, ['class' => 'form-select io-select2 dashboardFilter', 'placeholder' => __('messages.common.select_doctor'), 'id' => 'dashboardDoctorId', 'data-control' => 'select2']) }}
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                {{--                                                <button type="submit" class="btn btn-primary me-5">{{__('messages.common.apply')}}</button> --}}
                                                <button type="reset" class="btn btn-secondary"
                                                    id="dashboardResetBtn">{{ __('messages.common.reset') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body appointmentChart">
                            {{ Form::hidden('admin_chart_data', json_encode($appointmentChartData, true), ['id' => 'adminChartData']) }}
                            <!--begin::Chart-->
                            <div id="appointmentChartId" style="height: 350px" class="card-rounded-bottom"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Charts Widget 8-->
                </div>


                <div class="col-xxl-12">
                    <div class="d-flex border-0 pt-5">
                        <h3 class="align-items-start flex-column">
                            <span
                                class="fw-bolder fs-3 mb-1">{{ __('messages.admin_dashboard.recent_patients_registration') }}</span>
                        </h3>
                        <div class="ms-auto d-sm-block d-none">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link btn btn-sm btn-color-muted btn-active text-primary btn-active-light-primary fw-bolder px-4 active dayData"
                                        data-bs-toggle="tab" href=""
                                        id="dayData">{{ __('messages.admin_dashboard.day') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1 weekData"
                                        data-bs-toggle="tab" href=""
                                        id="weekData">{{ __('messages.admin_dashboard.week') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1 monthData"
                                        data-bs-toggle="tab" href=""
                                        id="monthData">{{ __('messages.admin_dashboard.month') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex ms-auto d-sm-none d-block mt-2 mb-2 justify-content-end">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active text-primary btn-active-light-primary fw-bolder px-4 active dayData"
                                    data-bs-toggle="tab" href=""
                                    id="dayData">{{ __('messages.admin_dashboard.day') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1 weekData"
                                    data-bs-toggle="tab" href=""
                                    id="weekData">{{ __('messages.admin_dashboard.week') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1 monthData"
                                    data-bs-toggle="tab" href=""
                                    id="monthData">{{ __('messages.admin_dashboard.month') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="month">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="w-25px text-muted mt-1 fw-bold fs-7">
                                                {{ __('messages.admin_dashboard.name') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7">
                                                {{ __('messages.admin_dashboard.patient_id') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.doctor_dashboard.total_appointments') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.patient.registered_on') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="monthlyReport" class="text-gray-600 fw-bold">
                                        @forelse($data['patients'] as $patient)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="image image-circle image-mini me-3">
                                                            <img src="{{ $patient->profile }}" alt="user"
                                                                class="">
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <a href="{{ route('patients.show', $patient->id) }}"
                                                                class="text-primary-800 mb-1 fs-6 text-decoration-none
">{{ $patient->user->fullname }}</a>
                                                            <span
                                                                class="text-muted fw-bold d-block">{{ $patient->user->email }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-start">
                                                    <span
                                                        class="badge bg-light-success">{{ $patient->patient_unique_id }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge bg-light-danger">{{ $patient->appointments_count }}</span>
                                                </td>
                                                <td class="text-center text-muted fw-bold">
                                                    <span class="badge bg-light-info">
                                                        {{ \Carbon\Carbon::parse($patient->user->created_at)->isoFormat('DD MMM YYYY hh:mm A') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="5" class="text-center text-muted fw-bold">
                                                    {{ __('messages.common.no_data_available') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="week">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="w-25px text-muted mt-1 fw-bold fs-7">
                                                {{ __('messages.admin_dashboard.name') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7">
                                                {{ __('messages.admin_dashboard.patient_id') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.doctor_dashboard.total_appointments') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.patient.registered_on') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weeklyReport" class="text-gray-600 fw-bold">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="day">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="w-25px text-muted mt-1 fw-bold fs-7">
                                                {{ __('messages.admin_dashboard.name') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7">
                                                {{ __('messages.admin_dashboard.patient_id') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.doctor_dashboard.total_appointments') }}</th>
                                            <th class="min-w-150px text-muted mt-1 fw-bold fs-7 text-center">
                                                {{ __('messages.patient.registered_on') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dailyReport" class="text-gray-600 fw-bold">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.templates.templates')
@endsection
