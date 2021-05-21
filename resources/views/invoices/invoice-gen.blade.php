<!DOCTYPE html>
<html>
<head>
    <title>{{ __('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="{{ asset('css/invoice.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <div style="background: #5cd08d; padding: 8px;"></div>
        <div class="top">
            <div class="first-section">
                <div>
                    <img src="{{ asset('images/default.png') }}" style="max-height: 100px; max-width: 100px;">
                </div>
                <div>
                    <h3>{{ __('Company Name') }}</h3>
                    <address>{{ __('House#27, Road#S11, Block#L Eastern Housing, Rupnagar Pallabi Dhaka-1216, 1216') }}</address>
                    <span class="d-block">jisan.cse16@gmail.com</span>
                    <span>+880 1521484347</span>
                </div>
            </div>


            <div class="last-section clearfix">
                <h3 class="text-secondary">INVOICE</h3>

                <div class="d-block text-center float-end">
                    <span class="fw-bolder m-0 text-uppercase">No: </span> <span class="p-1">{{ sprintf("INV-%06d", 1) }} </span>
                    <hr class="m-0 float-end">
                </div>
            </div>
        </div>
        <div class="customer-section clearfix">
            <div class="float-end">
                <p><strong>Date: </strong>{{ date('d-m-Y') }}</p>
            </div>
            <div class="float-end">
                <p><strong>Name: </strong> Jalal Uddin Jisan</p>
            </div>

            <div class="float-end">
                <p><strong>Phone: </strong>{{ __('+880 1521484347') }}</p>
            </div>
            <div class="float-end">
                <p><strong>Address: </strong> BSMRH, KUET, Khulna</p>
            </div>
        </div>
        <div class="product-section pb-5">
            <table class="table table-bordered table-striped w-75 m-auto">
                <thead>
                <tr style="background: #5cd08d;" class="text-center">
                    <th scope="col" class="col-md-1">SL. No</th>
                    <th scope="col" class="col-md-5">Description</th>
                    <th scope="col" class="col-md-2">Unit Price</th>
                    <th scope="col" class="col-md-2">Quantity</th>
                    <th scope="col" class="col-md-2">Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Product 1</td>
                    <td>100</td>
                    <td>2kg</td>
                    <td>200</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Product 2</td>
                    <td>150</td>
                    <td>2kg</td>
                    <td>300</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Product 3</td>
                    <td>200</td>
                    <td>2kg</td>
                    <td>400</td>
                </tr>
                </tbody>
            </table>
            <div>
                <p><strong>Delivery Date: </strong>{{ date('d-m-Y') }}</p>
                <p><strong>Delivery Time: </strong>{{ date('H:m:s') }}</p>
            </div>
            <div>
                <table class="table">
                    <tr>
                        <th>Total Amount:</th>
                        <td>{{ __('900 Tk') }}</td>
                    </tr>
                    <tr>
                        <th>Discount: </th>
                        <td>{{ __('100 Tk') }}</td>
                    </tr>
                    <tr>
                        <th>Amount After Discount: </th>
                        <td>{{ __('800 Tk') }}</td>
                    </tr>
                    <tr>
                        <th>Tax Rate: </th>
                        <td>{{ __('10%') }}</td>
                    </tr>
                    <tr>
                        <th>Amount Including Tax: </th>
                        <td>{{ __('880 Tk') }}</td>
                    </tr>
                    <tr>
                        <th>Advance Payment: </th>
                        <td>{{ __('500 Tk') }}</td>
                    </tr>
                    <tr class="table-active">
                        <th>Due: </th>
                        <td>{{ __('380 Tk') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="background: #5cd08d; padding: 8px;"></div>
    </div>
</body>
</html>
