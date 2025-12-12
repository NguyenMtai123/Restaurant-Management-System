@extends('customer.layouts.app')

@section('title', 'Take Away Express - Đồ Ăn Mang Về Chất Lượng Cao')

@section('content')
    @include('customer.home.hero')
    @include('customer.home.features')
    @include('customer.home.about')
    @include('customer.home.deals')
    @include('customer.home.menu')
    @include('customer.home.testimonials')
    @include('customer.home.order')
    @include('customer.home.contact')
@endsection
