<!DOCTYPE html>
<html>
<head>
    <title>{{ __('INVOICE') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html{
            height: auto;
            background-color: #f3f8f3 !important;
        }
        body{
            font-family: "Nunito", sans-serif;
            background-color: #f3f8f3 !important;
        }
        main{
            margin-top: 250px;
        }
        .customer-section{
            background-color: #f3f8f3;
            width: 100%;
        }
        .customer-section div:nth-child(1){
            width: 25%;
            display: inline-block;
            margin-right: 10%;
        }
        .customer-section div:nth-child(2){
            width: 50%;
            display: inline-block;
        }
        .customer-section div:nth-child(3){
            width: 25%;
            display: inline-block;
            margin-right: 10%;
        }
        .customer-section div:nth-child(4){
            width: 50%;
            display: inline-block;
        }
        .product-section{
            background-color: #f3f8f3;
            width: 100%;
        }
        .product-section div:nth-child(2){
            margin-left: 11%;
            margin-top: 5px;
            width: 25%;
            display: inline-block;
            vertical-align: 30px;
        }
        .product-section div:nth-child(3){
            width: 50%;
            display: inline-block;
            text-align: right;
        }

    </style>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"  crossorigin="anonymous">
</head>
<body class="container">


    <main>
    <div class="customer-section clearfix pt-3">
        <div class="float-end">
            <p><strong>Date: </strong>{{ date('d-m-Y', strtotime($customer->date)) }}</p>
        </div>
        <div class="float-end">
            <p><strong>Name: </strong>{{ $customer->customerName ?? '' }}</p>
        </div>

        <div class="float-end">
            <p><strong>Phone: </strong>{{ $customer->customerPhone ?? '' }}</p>
        </div>
        <div class="float-end">
            <p><strong>Address: </strong> {{ $customer->customerAddress ?? '' }}</p>
        </div>
    </div>
    @isset($customer->subject)
    <div class="text-center py-2">
        <h3 class="fst-italic" >Subject: {{ $customer->subject }}</h3>
    </div>
    @endisset
    <div class="product-section clearfix">
        <table class="table table-bordered table-striped" style="width: 85%; margin: 0 auto;">
            <thead>
            <tr style="background: #5cd08d;" class="text-center">
                <th scope="col" class="col-xs-1">SL. No</th>
                <th scope="col" class="col-xs-5">Description</th>
                <th scope="col" class="col-xs-1">Quantity</th>
                <th scope="col" class="col-xs-1">Unit</th>
                <th scope="col" class="col-xs-2">Unit Price</th>
                <th scope="col" class="col-xs-2">Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $cnt=1;
                $sum=0;
            ?>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $cnt++ }}</th>
                    <td>{{ $product->productTitle }}</td>
                    <td>{{ $product->productQuantity ?? '' }}</td>
                    <td>{{ $product->productUnit ?? '' }}</td>
                    <td>{{ $product->productUnitPrice ?? '' }}</td>
                    <td>{{ $product->productAmount }}</td>
                    <?php
                        $sum += $product->productAmount;
                    ?>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            <p><strong>Delivery Date: </strong>
                @isset($customer->deliveryTime)
                    {{ date('d-m-Y', strtotime($customer->deliveryDate)) }}</p>
                @endisset
            <p><strong>Delivery Time: </strong>
                @isset($customer->deliveryTime)
                    {{ date('h:i a', strtotime($customer->deliveryTime)) }}</p>
                @endisset
        </div>
        <div>
            <?php
                $discount = $customer->discount ?? 0;
                $amount_after_discount = $sum - $discount;
                $tax = $customer->tax ?? 0;
                $amount_including_tax = $amount_after_discount + ($amount_after_discount * ($tax/100.00));
                $advancePayment = $customer->advancePayment ?? 0;
                $due = $amount_including_tax - $advancePayment;
                $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                $dueInWord = $digit->format($due);
                ?>
            <table class="table">
                <tr>
                    <th class="text-right">Total Amount:</th>
                    <td>{{ ($customer->currencyPosition=='left')?($currency[1] . $sum):($sum . $currency[1]) }}</td>
                </tr>
                <tr>
                    <th class="text-right">Discount: </th>
                    <td>{{ ($customer->currencyPosition=='left')?($currency[1] . $discount):($discount . $currency[1]) }}</td>
                </tr>
                <tr>
                    <th class="text-right">Amount After Discount: </th>
                    <td>{{ ($customer->currencyPosition=='left')?($currency[1] . $amount_after_discount):($amount_after_discount . $currency[1]) }}</td>
                </tr>
                <tr>
                    <th class="text-right">Tax Rate: </th>
                    <td>{{ $tax . '%' }}</td>
                </tr>
                <tr>
                    <th class="text-right">Amount Including Tax: </th>
                    <td>{{ ($customer->currencyPosition=='left')?($currency[1] . $amount_including_tax):($amount_including_tax . $currency[1]) }}</td>
                </tr>
                <tr>
                    <th class="text-right">Advance Payment: </th>
                    <td>{{ ($customer->currencyPosition=='left')?($currency[1] . $advancePayment):($advancePayment . $currency[1]) }}</td>
                </tr>
                <tr class="danger">
                    <th class="text-right">Due: </th>
                    <td>{{ ($customer->currencyPosition=='left')?($currency[1] . $due):($due . $currency[1]) }}</td>
                </tr>
                <tr class="danger">
                    <td colspan="2"><b>Amount in word:</b> <span class="text-capitalize">{{ $dueInWord }}</span></td>
                </tr>
            </table>
        </div>

        @isset($customer->termsAndConditions)
            <div class="my-3 mx-5 ps-4 pe-5">
                <h3>Terms and conditions</h3>
                <p>{!! $customer->termsAndConditions !!}</p>
            </div>
        @endisset

        @isset($customer->lastMessage)
            <div class="my-3 mx-5 ps-4">
                {!! $customer->lastMessage !!}
            </div>
        @endisset
        <div class="w-25 my-3 mx-5 ps-4">
            <p>With best regards,</p>
            @isset($customer->signature)
                <img src="{{ asset($customer->signature) }}" class="w-50" />
            @endisset

            <p>............................</p>

            @isset($customer->regardsName)
                <p>{{ $customer->regardsName }}</p>
            @endisset

            @isset($customer->regardsTitle)
                <p>{{ $customer->regardsTitle }},</p>
            @endisset
            <p>{{ $company->companyName }}</p>
        </div>
    </div>
    </main>
</body>
</html>
