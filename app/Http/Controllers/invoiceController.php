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
        $company = Company::where('user_id',Auth::id())->first();

        if(!isset($company))
            return redirect(route('profile'))->with('companyInformation', 'Please first add information about your company');

        return view('invoices.invoice');
    }
    public function store(Request $request)
    {
        $signature = Null;

        if($request->hasFile('signature')){
            $customer = Customer::where('user_id',Auth::id())->latest()->first();

            if(isset($customer)){
                $id = $customer->id;
            }
            $id = ($id ?? 0) + 1;

            $signature = 'signature' . $id . '.' . $request->signature->getClientOriginalExtension();
            $request->signature->storeAs('/public/signature', $signature);
            $signature = '/storage/signature/' . $signature;
        }

        $customer = new Customer();
        $customer->customerName = $request->customerName;
        $customer->user_id = Auth::id();
        $customer->date  = $request->date ?? now()->toDate();
        $customer->currencyPosition = $request->currencyPosition;
        $customer->currency = $request->currency;
        $customer->customerAddress = $request->customerAddress;
        $customer->customerPhone = $request->customerPhone;
        $customer->deliveryDate = $request->deliveryDate;
        $customer->deliveryTime = $request->deliveryTime;
        $customer->tax = $request->tax;
        $customer->discount = $request->discount;
        $customer->advancePayment = $request->advancePayment;
        $customer->subject = $request->subject;
        $customer->termsAndConditions = $request->termsAndConditions;
        $customer->lastMessage = $request->lastMessage;
        $customer->signature = $signature;
        $customer->regardsName = $request->regardsName;
        $customer->regardsTitle = $request->regardsTitle;

        $customer->save();

        $customer_id = $customer->id;

        $no = count($request->hidden_product_title);
        for($idx = 0; $idx<$no; $idx++){
            $product = new Product();
            $product->customer_id = $customer_id;
            $product->productTitle = $request->hidden_product_title[$idx];
            $product->productQuantity = $request->hidden_product_quantity[$idx];
            $product->productUnit = $request->hidden_product_unit[$idx];
            $product->productUnitPrice = $request->hidden_product_unit_price[$idx];
            $product->productAmount = $request->hidden_product_amount[$idx];

            $product->save();
        }

        return redirect(route('invoice-gen',['cuid'=>$customer_id]));
    }
    public function show($cuid)
    {
        $company = Company::where('user_id',Auth::id())->first();
        $customer = Customer::where('id',$cuid)->first();
        $products = Product::where('customer_id', $customer->id)->get();

        $len = strlen($customer->currency)-1;
        $currency = ['', ''];

        $flag = false;
        for($i=0 ; $i<$len ; $i++){
            if($flag)
                $currency[1] .= $customer->currency[$i];

            if($customer->currency[$i]=='('){
                $flag =true;
            }
            else if(!$flag){
                $currency[0] .= $customer->currency[$i];
            }
        }
        $header = \view('invoices.invoice-header',  compact('company','customer'))->render();
        $footer = \view('invoices.invoice-footer')->render();

        $pdf = PDF::loadView('invoices.invoice-gen', compact('company', 'customer', 'products', 'currency'));
        $pdf->setOption('header-html', $header);
        $pdf->setOption('footer-html', $footer);
        $pdf->setOption('margin-bottom', 18);
        return $pdf->setPaper('a4')->inline("'invoice' . $customer->id . '.pdf'");

        //return view('invoices/invoice-gen', compact('company', 'customer', 'products', 'currency'));
    }
}
