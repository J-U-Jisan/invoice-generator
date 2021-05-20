@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
@endpush
@section('content')
    <div class="mx-5 my-2 px-2 text-white">
        <form action="{{ route('invoice-gen') }}" method="POST" class="row g-3" id="invoice_form">
            @csrf
            <div class="col-md-8">
                <label for="companyName" class="form-label">Company Name<sup style="color: #f7c6c6;">*</sup></label>
                <input type="text" name="companyName" class="form-control" id="companyName" placeholder="Enter Company name" required>
            </div>
            <div class="col-md-4">
                <label for="companyLogo" id="companyLogoLevel" class="form-label">Upload Logo <img src="" id="logo" class="d-block" /></label>
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
                <label for="comapnyPhone" class="form-label">Company Phone</label>
                <input type="text" id="companyPhone" class="form-control" name="companyPhone" placeholder="Enter Company Phone Number">
            </div>
            <div class="col-md-8">
                <label for="customerName" class="form-label">Customer Name</label>
                <input type="text" name="customerName" class="form-control" id="customerName" placeholder="Enter Customer Name">
            </div>
            <div class="col-6 col-md-2">
                <label for="date" class="form-label">Date<sup style="color: #f7c6c6;">*</sup></label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>
            <div class="col-6 col-md-2">
                <label for="currencyInput" class="form-label">Select Currency<sup style="color: #f7c6c6;">*</sup></label>
                <input name="currency" class="form-control" list="currencyOptions" id="currencyInput" placeholder="Type to search..." required>
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

            <div class="col-12 mt-5">
                <div class="mb-2 clearfix">
                    <button type="button" name="add-product" class="btn btn-secondary add-product float-end"  data-bs-toggle="modal" data-bs-target="#product_dialog">Add Product</button>
                </div>
                <table class="table table-responsive table-bordered table-striped table-success mt-3 text-center" id="productTable">
                    <thead>
                        <tr>
                            <th scope="col" class="col-4">Description</th>
                            <th scope="col" class="col-2">Quantity</th>
                            <th scope="col" class="col-2">Unit Price</th>
                            <th scope="col" class="col-2">Amount</th>
                            <th scope="col" class="col-1">Details</th>
                            <th scope="col" class="col-1">Remove</th>
                        </tr>
                    </thead>
                    <tbody id="product_data">

                    </tbody>
                </table>
            </div>

            <div class="col-6 col-md-3">
                <label for="deliveryTime" class="form-label">Delivery Time</label>
                <input type="datetime-local" name="deliveryTime" class="form-control" id="deliveryTime">
            </div>

            <div class="col-6 col-md-3">
                <label for="tax" class="form-label">Tax (In Percentage)</label>
                <input type="number" name="tax" class="form-control" id="tax" min="0" max="100" placeholder="Enter tax in percentage">
            </div>
            <div class="col-6 col-md-3">
                <label for="discount" class="form-label">Total Discount</label>
                <input type="number" name="discount" class="form-control" id="discount" min="0" placeholder="Enter total discount">
                <span id="error_discount" style="color: #f7c6c6;"></span>
            </div>
            <div class="col-6 col-md-3">
                <label for="advancePayment" class="form-label">Advance Payment</label>
                <input type="number" name="advancePayment" class="form-control" id="advancePayment" min="0" placeholder="Enter advance payment">
                <span id="error_advance_payment" style="color: #f7c6c6;"></span>
            </div>

            <div class="col-12 clearfix" id="totalAmount">
                <span class="bg-secondary col-md-4 p-2 rounded-1 float-end">Total Amount = 0.0</span>
            </div>
            <div class="col-12 mt-1 clearfix" id="amountWithTax">
                <span class="bg-secondary col-md-4 p-2 rounded-1 float-end">Total Amount = 0.0 (Including Tax)</span>
            </div>
            <div class="col-12 mt-1 clearfix" id="amountAfterDiscount">
                <span class="bg-secondary col-md-4 p-2 rounded-1 float-end">Total Amount = 0.0 (After Discount)</span>
            </div>
            <div class="col-12 mt-1 clearfix" id="dueAmount">
                <span class="bg-secondary col-md-4 p-2 rounded-1 float-end">Due Amount = 0.0</span>
            </div>

            <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary">Generate Invoice</button>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="product_dialog" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content bg-green text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-12">
                            <label for="productTitle">Product Title<sup style="color: #f7c6c6;">*</sup></label>
                            <input type="text" name="productTitle" id="productTitle" class="form-control" placeholder="Enter Product Title" required>
                            <span id="error_product_title" style="color: #f7c6c6;"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="productQuantity">Quantity</label>
                            <input type="text" name="productQuantity" id="productQuantity" class="form-control" placeholder="Enter Quantity">
                        </div>
                        <div class="col-md-4">
                            <label for="productUnitPrice">Unit Price</label>
                            <input type="text" name="productUnitPrice" id="productUnitPrice" class="form-control" placeholder="Enter Unit Price">
                        </div>
                        <div class="col-md-4">
                            <label for="productAmount">Amount<sup style="color: #f7c6c6;">*</sup></label>
                            <input type="number" min="0" name="productAmount" id="productAmount" class="form-control" placeholder="Enter Amount" required>
                            <span id="error_product_amount" style="color: #f7c6c6;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="row_id" id="hidden_row_id" />
                        <button type="button" name="save" id="save" class="btn btn-light align-content-between" >Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

    <script>
        //Logo
        var loadFile = function(event) {
            var image = document.getElementById('logo');
            image.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('companyLogo').style.display = "none";
        };
        //Product add-delete
        $(document).ready(function (){
            var count = 0;
            var amount = 0;
            var amount_with_tax = 0;
            var discount = 0;
            var error_discount = '';
            var amount_after_discount = 0;
            var tax = 0;
            var advancePayment = 0;
            var due = 0;
            var error_advance_payment = '';

            $('input[name=tax]').on('change', function(){
                tax = $('#tax').val();

                amount_with_tax = +amount + +(amount*(tax/100.00));
                $('#amountWithTax span').text('Total Amount = ' + amount_with_tax + ' (Including Tax)');

                amount_after_discount = amount_with_tax - discount;
                $('#amountAfterDiscount span').text('Total Amount = ' + amount_after_discount + ' (After Discount)');

                due = amount_after_discount - advancePayment;
                $('#dueAmount span').text('Due Amount = ' + due);
            });

            $('input[name=discount]').on('change', function(){
                discount = $('#discount').val();

                $('#error_discount').text('');
                $('#discount').css('border-color', '');


                amount_with_tax = +amount + +(amount*(tax/100.00));
                $('#amountWithTax span').text('Total Amount = ' + amount_with_tax + ' (Including Tax)');

                if(discount>amount_with_tax){
                    error_discount = 'Must be less than final amount';
                    $('#error_discount').text(error_discount);
                    $('#discount').css('border-color', '#ff0000');
                    discount = 0;
                    return false;
                }
                else{
                    error_discount = '';
                    $('#error_discount').text(error_discount);
                    $('#discount').css('border-color', '');
                }

                amount_after_discount = amount_with_tax - discount;
                $('#amountAfterDiscount span').text('Total Amount = ' + amount_after_discount + ' (After Discount)');

                due = amount_after_discount - advancePayment;
                $('#dueAmount span').text('Due Amount = ' + due);
            });

            $('input[name=advancePayment]').on('change', function(){
                advancePayment = $('#advancePayment').val();

                $('#error_advance_payment').text('');
                $('#advancePayment').css('border-color', '');


                amount_with_tax = +amount + +(amount*(tax/100.00));
                $('#amountWithTax span').text('Total Amount = ' + amount_with_tax + ' (Including Tax)');

                amount_after_discount = amount_with_tax - discount;
                $('#amountAfterDiscount span').text('Total Amount = ' + amount_after_discount + ' (After Discount)');

                if(advancePayment > amount_after_discount){
                    error_advance_payment = 'Must be less than final amount';
                    $('#error_advance_payment').text(error_advance_payment);
                    $('#advancePayment').css('border-color', '#ff0000');

                    advancePayment = 0;
                    return false;
                }
                else{
                    error_advance_payment = '';
                    $('#error_advance_payment').text(error_advance_payment);
                    $('#advancePayment').css('border-color', '');
                }

                due = amount_after_discount - advancePayment;
                $('#dueAmount span').text('Due Amount = ' + due);
            });

            $('#totalAmount').hide();
            $('#amountWithTax').hide();
            $('#amountAfterDiscount').hide();
            $('#dueAmount').hide();

            $('.add-product').click(function (){
               $('#totalAmount').show();
               $('#amountWithTax').show();
               $('#amountAfterDiscount').show();
               $('#dueAmount').show();

               console.log('Add Product');
               $('#productTitle').val('');
               $('#error_product_title').text('');
               $('#productQuantity').val('');
               $('#productUnitPrice').val('');
               $('#productAmount').val('');
               $('#error_product_amount').text('');
               $('#productTitle').css('border-color', '');
               $('#productAmount').css('border-color', '');

               $('#save').text('Save');
            });

            $('#save').click(function (){
               var error_product_title = '';
               var error_product_amount = '';
               var productTitle = '';
               var productQuantity = '';
               var productUnitPrice = '';
               var productAmount = '';

               productQuantity = $('#productQuantity').val();

               productUnitPrice = $('#productUnitPrice').val();

                if($('#productTitle').val() == '')
                {
                    error_product_title = 'Product title is required';
                    $('#error_product_title').text(error_product_title);
                    $('#productTitle').css('border-color', '#ff0000');
                    productTitle = '';
                }
                else
                {
                    error_product_title = '';
                    $('#error_product_title').text(error_product_title);
                    $('#productTitle').css('border-color', '');
                    productTitle = $('#productTitle').val();
                }

                if($('#productAmount').val() == '')
                {
                    error_product_amount = 'Amount is required';
                    $('#error_product_amount').text(error_product_amount);
                    $('#productAmount').css('border-color', '#ff0000');
                    productAmount = '';
                }
                else
                {
                    error_product_amount = '';
                    $('#error_product_amount').text(error_product_amount);
                    $('#productAmount').css('border-color', '');
                    productAmount = $('#productAmount').val();
                    amount= +amount + +productAmount;
                }

                if(error_product_title != '' || error_product_amount != '')
                {
                    return false;
                }
                else{

                    if($('#save').text() == 'Save'){
                        count = count + 1;
                        console.log('Add = ',count);
                        output = '<tr id="row_'+count+'">';
                        output += '<td>' + productTitle + '<input type="hidden" name="hidden_product_title[]" id="productTitle'+count+'" class="productTitle" value="'+productTitle+'" required /></td>';
                        output += '<td>' + productQuantity + '<input type="hidden" name="hidden_product_quantity[]" id="productQuantity'+count+'" value="'+productQuantity+'"/></td>';
                        output += '<td>' + productUnitPrice + '<input type="hidden" name="hidden_product_unit_price[]" id="productUnitPrice'+count+'" value="'+productUnitPrice+'"/></td>';
                        output += '<td>' + productAmount + '<input type="hidden" name="hidden_product_amount[]" id="productAmount'+count+'" value="'+productAmount+'" required /></td>';
                        output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+count+'" data-bs-toggle="modal" data-bs-target="#product_dialog">View</button></td>';
                        output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
                        output += '</tr>';
                        $('#product_data').append(output);
                    }
                    else{
                        var row_id = $('#hidden_row_id').val();
                        output = '<td>' + productTitle + '<input type="hidden" name="hidden_product_title[]" id="productTitle'+row_id+'" class="productTitle" value="'+productTitle+'"/></td>';
                        output += '<td>' + productQuantity + '<input type="hidden" name="hidden_product_quantity[]" id="productQuantity'+row_id+'" value="'+productQuantity+'"/></td>';
                        output += '<td>' + productUnitPrice + '<input type="hidden" name="hidden_product_unit_price[]" id="productUnitPrice'+row_id+'" value="'+productUnitPrice+'"/></td>';
                        output += '<td>' + productAmount + '<input type="hidden" name="hidden_product_amount[]" id="productAmount'+row_id+'" value="'+productAmount+'"/></td>';
                        output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+row_id+'" data-bs-toggle="modal" data-bs-target="#product_dialog">View</button></td>';
                        output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+row_id+'">Remove</button></td>';
                        $('#row_'+row_id+'').html(output);
                        console.log('Update = ',row_id);
                    }
                    $('.modal').modal('hide');

                    $('#totalAmount span').text('Total Amount = ' + amount);

                    amount_with_tax = +amount + +(amount*(tax/100.00));
                    $('#amountWithTax span').text('Total Amount = ' + amount_with_tax + ' (Including Tax)');

                    amount_after_discount = amount_with_tax - discount;
                    $('#amountAfterDiscount span').text('Total Amount = ' + amount_after_discount + ' (After Discount)');

                    due = amount_after_discount - advancePayment;
                    $('#dueAmount span').text('Due Amount = ' + due);
                }
            });

            $(document).on('click', '.view_details', function(){
                $('#modalTitle').text('Edit Product');

                console.log('Edit Product')
                var row_id = $(this).attr("id");
                var productTitle = $('#productTitle'+row_id+'').val();
                var productQuantity = $('#productQuantity'+row_id+'').val();
                var productUnitPrice = $('#productUnitPrice'+row_id+'').val();
                var productAmount = $('#productAmount'+row_id+'').val();

                $('#productTitle').val(productTitle);
                $('#productQuantity').val(productQuantity);
                $('#productUnitPrice').val(productUnitPrice);
                $('#productAmount').val(productAmount);

                $('#save').text('Edit');
                $('#hidden_row_id').val(row_id);
            });

            $(document).on('click', '.remove_details', function(){
                console.log('Remove Product')
                var row_id = $(this).attr("id");
                if(confirm("Are you sure you want to remove this row data?"))
                {
                    $('#row_'+row_id+'').remove();
                }
                else
                {
                    return false;
                }
            });

            $('#product_form').on('submit', function(event){
                event.preventDefault();
                var count_data = 0;
                $('.productTitle').each(function(){
                    count_data = count_data + 1;
                });
                if(count_data > 0)
                {
                    var form_data = $(this).serialize();
                    $.ajax({
                        url:"/",
                        method:"POST",
                        data:form_data,
                        success:function(data)
                        {
                            $('#user_data').find("tr:gt(0)").remove();
                            $('#action_alert').html('<p>Data Inserted Successfully</p>');
                            $('#action_alert').dialog('open');
                        }
                    })
                }
                else
                {
                    $('#action_alert').html('<p>Please Add atleast one data</p>');
                    $('#action_alert').dialog('open');
                }
            });
        });
    </script>
@endpush
