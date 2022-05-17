<?php

namespace App\Http\Controllers;

use App\DataTables\PromoMessagesDataTable;
use App\Http\Requests\PromoMessageStoreRequest;
use App\Http\Requests\PromoMessageUpdateRequest;
use App\Models\Company;
use App\Models\Language;
use App\Models\PromoMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create Promo Message')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('promo-messages.index'), 'name' => __('All Promo Message')],
            ['name' => __('Create')]
        ];

        $languages = Language::all()->sortBy('name')->pluck('name', 'id');

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return view('admin.pages.promo-messages.create', compact(
            'breadcrumbs',
            'languages',
            'companies'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PromoMessageStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(PromoMessageStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $promoMessage = new PromoMessage();
            $promoMessage->fill($request->except(PromoMessage::IMAGE_FIELDS));
            $promoMessage->creator_id = \Auth::user()->id;
            $promoMessage->save();

            foreach (PromoMessage::IMAGE_FIELDS as $field) {
                $path = storage_path('app/public/promo/');

                $imageUpload = $request->file($field);
                $fileName = Uuid::uuid1().'.'.$imageUpload->extension();

                $imageUpload->move($path, $fileName);
                $promoMessage->update([ $field => $fileName ]);
            }

            DB::commit();

            alert()->success(__('Success!'), __('Promo Message created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('promo-messages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PromoMessage $promoMessage
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(PromoMessage $promoMessage)
    {
        $breadcrumbs = [
            ['title' => __('Update Promo Messages')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('promo-messages.index'), 'name' => __('All Promo Messages')],
            ['name' => __('Edit Promo Messages')]
        ];

        $actions = [
            ['href' => route('promo-messages.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $languages = Language::all()->sortBy('name')->pluck('name', 'id');

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        return view('admin.pages.promo-messages.update', compact(
            'breadcrumbs',
            'actions',
            'promoMessage',
            'languages',
            'companies',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PromoMessageUpdateRequest $request
     * @param PromoMessage $promoMessage
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(PromoMessageUpdateRequest $request, PromoMessage $promoMessage)
    {
        try {
            DB::beginTransaction();

            $promoMessage->fill($request->except(PromoMessage::IMAGE_FIELDS));
            $promoMessage->save();

            foreach (PromoMessage::IMAGE_FIELDS as $field) {
                if ($request->file($field)) {
                    if ($promoMessage->{$field}) {
                        if (Storage::exists('public/promo/'.$promoMessage->{$field})) {
                            Storage::delete('public/promo/'.$promoMessage->{$field});
                        }
                    }

                    $path = storage_path('app/public/promo/');

                    $imageUpload = $request->file($field);
                    $fileName = Uuid::uuid1().'.'.$imageUpload->extension();

                    $imageUpload->move($path, $fileName);
                    $promoMessage->update([ $field => $fileName ]);
                }
            }

            DB::commit();

            alert()->success(__('Success!'), __('Promo Messages updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('promo-messages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PromoMessage $promoMessage
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(PromoMessage $promoMessage)
    {
        foreach (PromoMessage::IMAGE_FIELDS as $field) {
            if ($promoMessage->{$field}) {
                if (Storage::exists('public/promo/'.$promoMessage->{$field})) {
                    Storage::delete('public/promo/'.$promoMessage->{$field});
                }
            }
        }

        if ($promoMessage->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
