@extends('layouts.app')

@section('title', 'Profile | ')

@push('styles')
    <style>
        #companyLogoLabel img{
            width: 40%;
        }
    </style>
@endpush

@section('content')
<div class="container" style="color: #f7fcfa;">
    <div class="p-4 rounded-2 col-12 col-md-8  m-auto" style="background-color: #075E54;">
        <h3>Update Profile</h3>

        @if(session('companyInformation'))
            <div class="alert alert-primary">
                {{ session('companyInformation') }}
                <div class="float-end text-end" style="cursor: pointer;" onclick="this.parentElement.style.display='none';"><span class="btn-close" >&times;</span></div>
            </div>
        @endif

        @isset($updateSuccess)
        <div class="alert alert-success">
            <span>Profile Updated Successfully</span>
            <div class="float-end text-end" style="cursor: pointer;" onclick="this.parentElement.style.display='none';"><span class="btn-close" >&times;</span></div>
        </div>
        @endisset
        @isset($updateFail)
        <div class="alert alert-danger">
            <span>Profile update failed. Try again after a few moments.</span>
            <div class="float-end text-end" style="cursor: pointer;" onclick="this.parentElement.style.display='none';"><span class="btn-close" >&times;</span></div>
        </div>
        @endisset
        <form action="{{ route('profile') }}" method="post" class="row" enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-6 mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="col-12 col-md-6 mt-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="col-12 col-md-6 mt-3">
                <label for="companyName" class="form-label">Company Name<sup class="text-danger">*</sup></label>
                <input type="text" name="companyName" class="form-control" id="companyName" value="{{ $company->companyName ?? '' }}" placeholder="Enter Company Name" required>
            </div>
            <div class="col-12 col-md-6 mt-3">
                <label for="companyLogo" id="companyLogoLabel" class="form-label">Upload Logo <img src="{{ asset($company->companyLogo?? '') }}" id="logo" class="{{ isset($company->companyLogo)?'d-block':'d-none' }}" /></label>
                <input type="file" name="companyLogo" class="form-control" accept="image/*" id="companyLogo"  onchange="loadFile(event)">
            </div>
            <div class="col-12 mt-3">
                <label for="companyAddress" class="form-label">Company Address</label>
                <input type="text" id="companyAddress" class="form-control" name="companyAddress" value="{{ $company->companyAddress??'' }}" placeholder="Enter Address">
            </div>
            <div class="col-12 col-md-6 mt-3">
                <label for="companyEmail" class="form-label">Company Email</label>
                <input type="email" id="companyEmail" class="form-control" name="companyEmail" value="{{ $company->companyEmail??'' }}" placeholder="Enter email">
            </div>
            <div class="col-12 col-md-6 mt-3">
                <label for="comapnyPhone" class="form-label">Company Phone</label>
                <input type="text" id="companyPhone" class="form-control" name="companyPhone" value="{{ $company->companyPhone??'' }}" placeholder="Enter Company Phone Number">
            </div>
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-info col-12" name="submit">UPDATE</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script>
        //Logo
        var loadFile = function(event) {
            var image = document.getElementById('logo');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.classList.remove('d-none');
            image.classList.add('d-block');
            document.getElementById('companyLogo').style.display = "none";
        };
    </script>
@endpush
