@extends('layouts.app')

@section('content')
    <div>
        @foreach($customers as $customer)

            <div class="d-inline-block px-4 py-2 m-3 bg-light rounded-3 fs-5">
                <a href="{{ route('invoice-gen',['cuid'=>$customer->id]) }}" class="text-dark text-decoration-none" target="_blank">
                    Invoice No: <p class="d-inline-block">{{ $customer->id }}</p><br>
                    Customer Name: <p class="d-inline-block">{{ $customer->customerName }}</p><br>
                    Subject: <p class="fst-italic d-inline-block"> {{ $customer->subject }} </p>
                </a>
                <br>
                <a class="btn btn-danger" href="#" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
            </div>

        @endforeach
    </div>
@endsection
