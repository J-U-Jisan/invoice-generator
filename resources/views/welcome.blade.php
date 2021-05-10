@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/homePage.css') }}">
@endpush
@section('content')
        <div style="margin: 40px 110px;">
            <div class="cardh" style="float: left;">
                <img src="https://img.icons8.com/dusk/64/000000/payroll.png"/>
                <h2>Salary Management</h2>
                <p>One can manage monthly salary for all the employee depending on the category of employee. And it can be saved in cloud. One can be seen this after login in his/her dashboard.</p>
                @guest
                    <a href="{{ route('login') }}">Try It Now</a>
                @endguest
                @auth
                    <a href="">Try It Now</a>
                @endauth
            </div>

            <div class="cardh" style="float: right;">
                <img src="https://img.icons8.com/dusk/64/000000/invoice.png"/>
                <h2>Invoice Generator</h2>
                <p>Create professional looking PDF invoices online for your business. Automatically calculates taxes and totals amount. Even it can be saved in cloud and share through social media.</p>
                @guest
                    <a href="{{ route('login') }}">Try It Now</a>
                @endguest
                @auth
                    <a href="{{ route('invoice') }}">Try It Now</a>
                @endauth
            </div>
        </div>
@endsection
