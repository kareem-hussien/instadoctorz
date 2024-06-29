@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.web.medical_services') }}
@endsection

@section('front-content')
    <div class="services-page">
        <!-- start hero section -->
        <section class="hero-content-section bg-white p-t-100 p-b-100">
            <div class="container p-t-30">
                <div class="col-12">
                    <div class="hero-content text-center">
                        <h1 class="mb-3">
                            {{ __('messages.web.services') }}
                        </h1>
                        <p>{{ __('messages.web.service_page_subtitle') }}</p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('medical') }}"> {{ __('messages.web.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.web.services') }}</li>
                            </ol>
                            
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- end our-team section -->
        <section class="services-section bg-secondary p-t-100">
            <div class="container">

        <section class="services-section bg-secondary p-t-100">
        <div class="container">
                <div class="row justify-content-center">
                    @foreach($services as $service)
                    <div class="col-xl-4 col-md-6 services-block d-flex align-items-stretch">
                        <div class="card mx-lg-2 flex-fill">
                            <div class="card-body text-center d-flex flex-column">
                                <div class="services-icon-box mx-auto d-flex align-items-center justify-content-center">
                                    <img src="{{ $service->icon }}" alt="Emergency" class="img-fluid object-image-cover" loading="lazy">
                                </div>
                                <h4 class="text-primary"> {{ $service->name }}</h4>
                                <p class="paragraph pb-3">
                                    {{ $service->short_description }}
                                </p>
                                <a href="{{ route('serviceBookAppointment',$service->id) }}"
                                   class="btn btn-primary mt-auto align-self-center">
                                    <span>{{ __('messages.web.book_an_appointment') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- end our-team section -->

        <section class="about-section p-b-50">
            <div class="container">
                <div class="row align-items-center flex-column-reverse flex-xl-row">
                    <div class="col-xxl-6 col-xl-5 after-rectangle-shape position-relative about-left-content left-shape">
                        <div class="row position-relative z-index-1">
                            <div class="col-xl-6 col-md-3 about-block">
                                <div class="about-image-box rounded-20 bg-white">
                                    <img src="{{ getSettingValue('about_image_2') }}" alt="About" class="rounded-20" loading="lazy" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-7">
                        <div class="about-right-content mb-md-5 mb-4 mb-xl-0 text-center text-xl-start">
                            <h5 class="text-primary top-heading fs-6 mb-3">{{ __('messages.web.instadoctorz') }}</h5>
                            <h2 class="pb-2">{{ __('messages.web.child_care') }}</h2>
                            <p class="paragraph pb-1 ">{{ __('messages.web.child_care_details_0') }}</p>
                            <p class="paragraph pb-1">{{ __('messages.web.child_care_details_1') }}</p>
                            <p class="paragraph pb-1">{{ __('messages.web.child_care_details_2') }}</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    
















    

        <!-- start services counter section -->
        <section class="services-counter-section p-t-50 p-b-50">
            <div class="container">
                <div class="bg-white rounded-20 box-shadow py-3 py-sm-0">
                    <div class="row">
                        <div class="col-xl-3 col-6 services-counter-block">
                            <div class="text-center my-4 my-sm-5 pipe">
                                <h4 class="text-primary fs-1 fw-bolder mb-3">{{ $data['specializationsCount'] }}</h4>
                                <h5 class="mb-0">{{ __('messages.specializations') }}</h5>
                            </div>
                        </div>
                        <div class="col-xl-3 col-6 services-counter-block">
                            <div class="text-center my-4 my-sm-5 pipe">
                                <h4 class="text-primary fs-1 fw-bolder mb-3">{{ $data['servicesCount'] }}</h4>
                                <h5 class="mb-0">{{ __('messages.web.services') }}</h5>
                            </div>
                        </div>
                        <div class="col-xl-3 col-6 services-counter-block">
                            <div class="text-center my-4 my-sm-5 pipe">
                                <h4 class="text-primary fs-1 fw-bolder mb-3">{{ $data['doctorsCount'] }}</h4>
                                <h5 class="mb-0">{{ __('messages.doctors') }}</h5>
                            </div>
                        </div>
                        <div class="col-xl-3 col-6 services-counter-block">
                            <div class="text-center my-4 my-sm-5 pipe">
                                <h4 class="text-primary fs-1 fw-bolder mb-3">{{ $data['patientsCount'] }}</h4>
                                <h5 class="mb-0">{{ __('messages.web.satisfied_patient') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end services counter section -->
    </div>
@endsection
