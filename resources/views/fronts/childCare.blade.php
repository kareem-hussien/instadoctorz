@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.web.childCare') }}
@endsection

@section('front-content')
<div class="book-appointment-page">
    <!-- start hero section -->
    <section class="hero-content-section bg-white p-t-100 p-b-100">
        <div class="container p-t-30">
            <div class="col-12">
                <div class="hero-content text-center">
                    <h1 class="mb-3">
                        {{ __('messages.web.childCare') }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('medical') }}">  {{ __('messages.web.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">  {{ __('messages.web.childCare') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- end hero section -->

</div>
@endsection
