<?php

namespace App\Http\Controllers;

use App\DataTables\PromoMessagesDataTable;

class PromoMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PromoMessagesDataTable $dataTable
     * @return mixed
     */
    public function index(PromoMessagesDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('Promo Messages')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Promo Messages')]
        ];

        $actions = [
            ['href' => route('promo-messages.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.promo-messages.index', compact(
            'breadcrumbs',
            'actions',
        ));
    }
}
