<?php

namespace App\Services;

use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Enums\SystemType;
use App\Models\Company;
use App\Models\CompanyTemplate;
use App\Models\CompanyTheme;
use App\Models\Country;
use App\Models\PartnerProduct;
use App\Models\User;
use Carbon\Carbon;

class CompanyService
{
    /** @var Company */
    protected $company;

    /**
     * Set company resource
     *
     * @param Company $company
     * @return CompanyService
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get payload data
     *
     * @return array|void
     */
    public function payload($action = 'create')
    {
        if (method_exists(self::class, 'get'.ucfirst($action).'Payload')) {
            /** @uses getCreatePayload() */
            return $this->{'get'.ucfirst($action).'Payload'}();
        }
    }

    /**
     * Replicate a company
     *
     * @param $newName
     * @return Company
     */
    public function duplicate($newName = null)
    {
        $newCompany = $this->company->replicate();
        $newCompany->company_name = $newName ?? $this->company->company_name.' (Copy)';
        $newCompany->holder_name = $newCompany->company_name; // TODO: Need to be clarified
        $newCompany->created_at = Carbon::now();
        $newCompany->save();

        // TODO: Implement duplicate all relationship

        return $newCompany;
    }

    /**
     * Get payload data for create company
     *
     * @return array
     */
    protected function getCreatePayload()
    {
        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        $templates = CompanyTemplate::with('language')->get()
            ->sortBy('name');

        $templates->map(function ($template) {
            $template->name = implode(' | ', [
                $template->name,
                $template->language->name,
                $template->restal_non_refundable ? 'refundables' : 'non-refundables',
                '3ds', // TODO: Need clarification
            ]);
        });

        $templates = $templates->pluck('name', 'id');

        $products = PartnerProduct::with('currency')
            ->wherePartnerId(SystemType::GoDreamSystem)
            ->get()->sortBy('name');

        $products->map(function ($product) {
            $product->name = implode(' | ', [
                trim($product->code),
                trim(preg_replace('~[\r\n]+~', '', $product->name)),
                Formatter::currency($product->price),
                $product->currency->code,
            ]);
        });

        $goDreamProducts = $products->pluck('name', 'id');

        $products = PartnerProduct::with('currency')
            ->wherePartnerId(SystemType::WonderBoxSystem)
            ->get()->sortBy('code');

        $products->map(function ($product) {
            $product->name = implode(' | ', [
                trim($product->code),
                trim(preg_replace('~[\r\n]+~', '', $product->name)),
                Formatter::currency($product->price),
                $product->currency->code,
            ]);
        });

        $wonderBoxProducts = $products->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function ($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return [
            $themes,
            $templates,
            $status,
            $categories,
            $admins,
            $countries,
            $goDreamProducts,
            $wonderBoxProducts,
        ];
    }

    /**
     * Get payload data for edit company
     *
     * @return array
     */
    protected function getEditPayload()
    {
        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        $templates = CompanyTemplate::with('language')->get()
            ->sortBy('name');

        $templates->map(function ($template) {
            $template->name = implode(' | ', [
                $template->name,
                $template->language->name,
                $template->restal_non_refundable ? 'refundables' : 'non-refundables',
                '3ds', // TODO: Need clarification
            ]);
        });

        $templates = $templates->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function ($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return [
            $themes,
            $templates,
            $status,
            $categories,
            $admins,
            $countries
        ];
    }
}
