<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $company = Company::where('user_id', Auth::id())->first();
        return view('profile/profile', compact('company'));
    }
    public function update(Request $request)
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

        $company = Company::where('user_id',Auth::id())->first();
        if(isset($company))
            $flag = $company->update($request->all());
        else{
            $company = new Company();
            $company->companyName = $request->companyName;
            $company->user_id = Auth::id();
            $company->companyLogo =  $companyLogo;
            $company->companyAddress = $request->companyAddress;
            $company->companyEmail = $request->companyEmail;
            $company->companyPhone = $request->companyPhone;

            $flag = $company->save();
        }

        $updateSuccess = null;
        $updateFail = null;
        if($flag)
            $updateSuccess = true;
        else
            $updateFail = true;

        return view('profile/profile', compact('company', 'updateSuccess', 'updateFail'));
    }
}
