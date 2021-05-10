@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
@endpush
@section('content')
    <div class="mx-5 my-2 px-2 text-white">
        <form action="{{ route('invoice-gen') }}" method="POST" class="row g-3">
            <div class="col-md-8">
                <label for="companyName" class="form-label">Company Name</label>
                <input type="text" name="companyName" class="form-control" id="companyName" placeholder="Enter Company name">
            </div>
            <div class="col-md-4">
                <label for="companyLogo" id="companyLogoLevel" class="form-label">Upload Logo <img id="logo" class="d-block" /></label>
                <input type="file" name="companyLogo" class="form-control" accept="image/*" id="companyLogo"  onchange="loadFile(event)">
            </div>
            <div class="col-md-4">
                <label for="companyAddress" class="form-label">Company Address</label>
                <input type="text" id="companyAddress" class="form-control" name="companyAddress" placeholder="Enter Address">
            </div>
            <div class="col-md-4">
                <label for="companyEmail" class="form-label">Company Email</label>
                <input type="email" id="companyEmail" class="form-control" name="companyEmail" placeholder="Enter email">
            </div>
            <div class="col-md-4">
                <label for="comapnyPhone">Company Phone</label>
                <input type="text" id="companyPhone" class="form-control" name="companyPhone" placeholder="Enter Company Phone Number">
            </div>
            <div class="col-md-8">
                <label for="customerName" class="form-label">Customer Name</label>
                <input type="text" name="customerName" class="form-control" id="customerName" placeholder="Enter Customer Name">
            </div>
            <div class="col-6 col-md-2">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="date" >
            </div>
            <div class="col-6 col-md-2">
                <label for="currencyInput" class="form-label">Select Currency</label>
                <input name="currency" class="form-control" list="currencyOptions" id="currencyInput" placeholder="Type to search...">
                <datalist id="currencyOptions">
                    <option value="USD (US$)">
                    <option value="EUR (€)">
                    <option value="JPY (¥)">
                    <option value="BDT (৳)">
                    <option value="GBP (£)">
                    <option value="AUD (A$)">
                    <option value="CAD (C$)">
                    <option value="CHF (CHF)">
                    <option value="CNY (元 / ¥)">
                    <option value="HKD (HK$)">
                    <option value="NZD (NZ$)">
                    <option value="SEK (kr)">
                    <option value="KRW (₩)">
                    <option value="SGD (S$)">
                    <option value="NOK (kr)">
                    <option value="MXN ($)">
                    <option value="INR (₹)">
                    <option value="RUB (₽)">
                    <option value="ZAR (R)">
                    <option value="TRY (₺)">
                    <option value="BRL (R$)">
                    <option value="TWD (NT$)">
                    <option value="DKK (kr)">
                    <option value="PLN (zł)">
                    <option value="THB (฿)">
                    <option value="HUF (Ft)">
                    <option value="CZK (Kč)">
                    <option value="ILS (₪)">
                    <option value="CLP (CLP$)">
                    <option value="PHP (₱)">
                    <option value="AED (د.إ)">
                    <option value="COP (COL$)">
                    <option value="SAR (﷼)">
                    <option value="MYR (RM)">
                    <option value="RON (L)">
                </datalist>
            </div>
            <div class="col-md-8">
                <label for="customerAddress" class="form-label">Customer Address</label>
                <input type="text" name="customerAddress" class="form-control" id="customerAddress" placeholder="Enter Customer Address">
            </div>
            <div class="col-md-4">
                <label for="customerPhone" class="form-label">Customer Phone</label>
                <input type="number" name="customerPhone" class="form-control" min="0" id="customerPhone" placeholder="Enter Customer Phone Number">
            </div>

            <div class="col-12">
                <table class="table table-bordered table-success mt-3 text-center" id="productTable">
                    <thead>
                        <tr>
                            <th scope="col" class="col-1">Select</th>
                            <th scope="col" class="col-5">Description</th>
                            <th scope="col" class="col-2">Quantity</th>
                            <th scope="col" class="col-2">Unit Price</th>
                            <th scope="col" class="col-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><input type="text" name="productTitle" id="productTitle" class="form-control" placeholder="Product Title" required></td>
                            <td><input type="text" name="productQuantity" id="productQuantity" class="form-control" placeholder="Quantity"></td>
                            <td><input type="text" name="productUnitPrice" id="productUnitPrice" class="form-control" placeholder="Unit Price"></td>
                            <td><input type="text" name="productAmount" id="productAmount" class="form-control" placeholder="Amount"></td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <input type="button" name="add-product" class="btn btn-secondary add-product float-end" value="Add Product">
                    <input type="button" name="del-product" class="btn btn-danger del-product float-start" value="Delete Selected Product">
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary">Generate Invoice</button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        //Logo
        var loadFile = function(event) {
            var image = document.getElementById('logo');
            image.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('companyLogo').style.display = "none";
        };

        //Product add & delete
        $(document).ready(function(){

            //Product addition
            $(".add-product").click(function(){
                var title = $("#productTitle").val();
                var quantity = $("#productQuantity").val();
                var unitPrice = $("#productUnitPrice").val();
                var amount = $("#productAmount").val();
                //var markup = "<tr><td><input type='checkbox' class='form-check-input' name='record'></td><td>" + title + "</td><td>" + quantity + "</td><td>" + unitPrice + "</td><td>" + amount + "</td></tr>";

                var table = document.getElementById("productTable");
                var lastRowIndex = table.rows.length-1;
               // console.log(lastRowIndex);
                var row = table.insertRow(lastRowIndex);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                cell1.innerHTML = "<input type='checkbox' class='form-check-input' name='record'>";
                cell2.innerHTML = title;
                cell3.innerHTML = quantity;
                cell4.innerHTML = unitPrice;
                cell5.innerHTML = amount;
            });

            // Find and remove selected table rows
            $(".del-product").click(function(){
                $("table tbody").find('input[name="record"]').each(function(){
                    if($(this).is(":checked")){
                        $(this).parents("tr").remove();
                    }
                });
            });
        });
    </script>
@endpush
