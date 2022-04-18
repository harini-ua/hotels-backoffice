<?php

namespace App\Http\Controllers;

use App\Enums\NewsletterUserType;
use App\Exports\DiscountVoucherCodesExport;
use App\Exports\NewsletterUsersExport;
use App\Http\Requests\DistributorStoreRequest;
use App\Http\Requests\NewsletterExportRequest;
use App\Http\Requests\NewsletterStoreRequest;
use App\Jobs\SendNewsletterEmail;
use App\Models\Company;
use App\Models\Distributor;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Newsletter')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Create Newsletter')]
        ];

        $newsletterTypes = NewsletterUserType::asSelectArray();
        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return view('admin.pages.newsletters.create', compact(
            'breadcrumbs', 'newsletterTypes', 'companies'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if ($request->get('action')) {
            return Excel::download(
                new NewsletterUsersExport($request->all()),
                'newsletters.xlsx'
            );
        }

        try {
            DB::beginTransaction();

            $newsletter = new Newsletter();
            $newsletter->fill($request->all());
            $newsletter->save();

            dispatch(new SendNewsletterEmail($newsletter));

            DB::commit();

            alert()->success(__('Success'), __('Emails send successful in the background...'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('newsletters.create');
    }
}
