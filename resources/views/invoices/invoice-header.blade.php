<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        header{
            top: 0;
            left: 117px;
            right: 116px;
        }
        .top{
            background-color: #e6f5e3;
            width: 100%;
            padding: 10px;
            letter-spacing: 1px;
        }

        .first-section{
            width: 68%;
            display: inline-block;
        }

        .first-section div:first-child{
            width: 20%;
            text-align: right;
            margin-right: 20px;
            display: inline-block;
        }
        .first-section div:first-child img{
            vertical-align: 40px;
        }
        .first-section div:last-child{
            width: 60%;
            display: inline-block;
        }
        .last-section{
            width: 30%;
            display: inline-block;
            vertical-align: 60px;
        }
        .last-section hr{
            width: 70%;
            padding: 10px;
        }
        .last-section h3{
            margin-right: 10px;
            text-align: right;
            margin-bottom: 30px;
        }
    </style>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
</head>
<body>
<header>
    <div style="background: #5cd08d; padding: 8px;"></div>
    <div class="top">
        <div class="first-section">
            <div>
                @isset($company->companyLogo)
                    <img src="{{ asset($company->companyLogo) }}" style="max-height: 100px; max-width: 100px;" />
                @endisset
            </div>
            <div>
                <h2>{{ $company->companyName }}</h2>
                @isset($company->companyAddress)
                    <address>{{ $company->companyAddress }}</address>
                @endisset
                @isset($company->companyEmail)
                    <span class="show">{{ $company->companyEmail }}</span>
                @endisset
                @isset($company->companyPhone)
                    <span class="ps-2">{{ $company->companyPhone }}</span>
                @endisset
            </div>
        </div>

        <div class="last-section">
            <h3 class="text-secondary">INVOICE</h3>

            <div class="d-block text-center float-end clearfix">
                <span class="fw-bolder m-0 text-uppercase">No: </span> <span class="p-1">{{ sprintf("INV-%06d", $customer->id) }} </span>
                <hr class="m-0 float-end">
            </div>
        </div>
    </div>
</header>
</body>
</html>
