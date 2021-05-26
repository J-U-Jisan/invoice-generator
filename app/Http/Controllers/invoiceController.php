<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;

class invoiceController extends Controller
{
    public function index()
    {
        return view('invoices.invoice');
    }
    public function store(Request $request)
    {
        $companyLogo = Null;

        if($request->hasFile('companyLogo')){
            $companies = Company::where('user_id',Auth::id())->latest()->first();

            if(isset($companies)){
                $id = $companies->id;
            }
            $id = ($id ?? 0) + 1;

            $companyLogo = 'companylogo' . $id . '.' . $request->companyLogo->getClientOriginalExtension();
            $request->companyLogo->storeAs('/public/companylogo', $companyLogo);
            $companyLogo = '/storage/companylogo/' . $companyLogo;
        }

        $company = new Company();
        $company->companyName = $request->companyName;
        $company->user_id = Auth::id();
        $company->companyLogo =  $companyLogo;
        $company->companyAddress = $request->companyAddress;
        $company->companyEmail = $request->companyEmail;
        $company->companyPhone = $request->companyPhone;

        $company->save();

        $customer = new Customer();
        $customer->customerName = $request->customerName;
        $customer->company_id = $company->id;
        $customer->date  = $request->date;
        $customer->currencyPosition = $request->currencyPosition;
        $customer->currency = $request->currency;
        $customer->customerAddress = $request->customerAddress;
        $customer->customerPhone = $request->customerPhone;
        $customer->deliveryDate = $request->deliveryDate;
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

        return redirect(route('invoice-gen',['cid'=>$company->id, 'cuid'=>$customer_id]));
    }
    public function show($cid, $cuid)
    {
        $company = Company::where('id',$cid)->first();
        $customer = Customer::where('id',$cuid)->first();
        $products = Product::where('customer_id', $customer->id)->get();

        $len = strlen($customer->currency)-1;
        $currency = '';
        $flag = false;
        for($i=0 ; $i<$len ; $i++){
            if($flag)
                $currency .= $customer->currency[$i];

            if($customer->currency[$i]=='('){
                $flag =true;
            }
        }

        $pdf = PDF::loadView('invoices.invoice-gen', compact('company', 'customer', 'products', 'currency'));
        return $pdf->stream('invoice' . $customer->id . '.pdf');


        //return view('invoices/invoice-gen', compact('company', 'customer', 'products'));
    }
}
