<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientsExport;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Class ViewController
 * @package App\Http\Controllers\Admin
 */
class ViewController extends Controller
{
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function index()
    {
        return view('admin.home.index');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function privacyPolicy()
    {
        return view('admin.home.privacy-policy');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function userTermsAndConditions()
    {
        return view('admin.home.user-terms-and-conditions');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function commerceTermsAndConditions()
    {
        return view('admin.home.commerce-terms-and-conditions');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function loginUser()
    {
        return view('vendor.brackets.admin-auth.admin.auth.login-user');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function recoverPassword()
    {
        return view('admin.users.recover-password');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function createAddress()
    {
        return view('admin.users.create-address');
    }
    
    /**
     * @return Factory|Application|RedirectResponse|View
     */
    public function successDeliveryDate()
    {
        return view('admin.orders.success-delivery-date');
    }
}