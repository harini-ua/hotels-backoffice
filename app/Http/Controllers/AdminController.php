<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UsersDataTable $dataTable
     * @return mixed
     */
    public function index(AdminsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Admins')]
        ];

        return $dataTable->render('admin.pages.users.index', compact(
            'breadcrumbs'
        ));
    }
}
