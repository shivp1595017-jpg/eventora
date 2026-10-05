<?php

namespace App\Http\Controllers;

class OrganizationAdminSettingsController extends Controller
{
    public function index()
    {
        return view('organization_admin.settings.index');
    }
}