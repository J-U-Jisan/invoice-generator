<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class invoiceController extends Controller
{
    public function index()
    {
        return view('invoices.invoice');
    }
    public function store(Request $request)
    {
        $companyLogo = '';

        if($request->hasFile('companyLogo')){
            $companies = Company::where('user_id',Auth::id())->latest()->first();

            if(isset($companies)){
                $id = $companies->id;
            }
            $id = ($id ?? 0) + 1;

            $companyLogo = 'companylogo' . $id . '.' . $request->companyLogo->getClientOriginalExtension();
            $request->companyLogo->storeAs('/public/companylogo', $companyLogo);
        }

        $company = new Company();
        $company->companyName = $request->companyName;
        $company->user_id = Auth::id();
        $company->companyLogo = '/storage/companylogo/' . $companyLogo;
        $company->companyAddress = $request->companyAddress;
        $company->companyEmail = $request->companyEmail;
        $company->companyPhone = $request->companyPhone;

        $company->save();

        $customer = new Customer();
        $customer->customerName = $request->customerName;
        $customer->company_id = $company->id;
        $customer->date  = $request->date;
        $customer->currency = $request->currency;
        $customer->customerAddress = $request->customerAddress;
        $customer->customerPhone = $request->customerPhone;
        $customer->deliveryTime = $request->deliveryTime;
        $customer->tax = $request->tax;
        $customer->discount = $request->discount;
        $customer->advancePayment = $request->advancePayment;

        $customer->save();

        $customer_id = $customer->id;

        $no = count($request->hidden_product_title);
        for($idx = 0; $idx<$no; $idx++){
            $product = new Product();
            $product->customer_id = $customer_id;
            $product->productTitle = $request->hidden_product_title[$idx];
            $product->productQuantity = $request->hidden_product_quantity[$idx];
            $product->productUnitPrice = $request->hidden_product_unit_price[$idx];
            $product->productAmount = $request->hidden_product_amount[$idx];

            $product->save();
        }

        return redirect(route('invoice-gen'))->with(['company' => $company, 'customer' => $customer]);
    }
    public function show()
    {
//        $company = session()->get('company');
//        $customer = session()->get('customer');
//        return view('invoices/invoice-gen', compact('company', 'customer'));

        $pdf = PDF::loadView('invoices.invoice-gen');
        return $pdf->stream('invoice.pdf', array('Attachment' => 0));

        //return view('invoices/invoice-gen');
    }
}
