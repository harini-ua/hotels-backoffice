<?php

namespace App\Services;

use App\Enums\AccessCodeType;
use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Enums\SystemType;
use App\Models\AccessCode;
use App\Models\Company;
use App\Models\CompanyTemplate;
use App\Models\CompanyTheme;
use App\Models\Country;
use App\Models\PartnerProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
     * @param $companyName
     * @return Company
     */
    public function duplicate($companyName = null)
    {
        if (!$this->company) {
            throw (new BadRequestException(__('Unknown company site')));
        }

        $newCompany = $this->company->replicate();
        $newCompany->company_name = $companyName ?? $this->company->company_name.' (Copy)';
        $newCompany->holder_name = $newCompany->company_name; // TODO: Need to be clarified
        $newCompany->created_at = Carbon::now();
        $newCompany->save();

        $extraNight = $this->company->extraNight->replicate();
        $newCompany->extraNight()->create($extraNight->toArray());

        $homepageOptions = $this->company->homepageOptions->replicate();
        $newCompany->homepageOptions()->create($homepageOptions->toArray());

        $mainOptions = $this->company->mainOptions->replicate();
        $newCompany->mainOptions()->create($mainOptions->toArray());

        $prefilledOptions = $this->company->prefilledOption->replicate();
        $newCompany->prefilledOption()->create($prefilledOptions->toArray());

        // TODO: Implement duplicate all relationship

        return $newCompany;
    }

    /**
     * Generate access codes for company site
     *
     * @param $code
     * @param int $type
     * @return void
     */
    public function genegateAccesCodes($code, int $type = AccessCodeType::FIXED)
    {
        if (!$this->company) {
            throw (new BadRequestException(__('Unknown company site')));
        }

        $accessCodes = [];
        if ($type === AccessCodeType::FIXED) {
            $accessCode = new AccessCode();
            $accessCode->fill([
                'type' => $type,
                'code' => $code,
            ]);
            $accessCodes[] = $accessCode;

            $this->company->accessCodes()->delete();
        } else {
            for ($i = 0; $i < $code; $i++) {

                $accessCode = new AccessCode();
                $accessCode->fill([
                    'type' => $type,
                    'code' => Str::uuid(),
                ]);
                $accessCodes[] = $accessCode;
            }
        }

        $this->company->accessCodes()->saveMany($accessCodes);
    }

    /**
     * Get last access code for company site
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getLastAccessCode()
    {
        if (!$this->company) {
            throw (new BadRequestException(__('Unknown company site')));
        }

        return $this->company->accessCodes()->latest();
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
            $name[] = $template->name;
            $name[] = $template->language->name; // TODO: Need clarification
            $name[] = $template->show_all_booking_non_refund ? 'refundables' : 'non-refundables';
            if ($template->secure_payment) {
                $name[] = '3ds';
            }

            $template->name = implode(' | ', $name);
        });

        $templates = $templates->pluck('name', 'id');

//        $products = PartnerProduct::with('currency')
//            ->wherePartnerId(SystemType::GoDreamSystem)
//            ->get()->sortBy('name');
//
//        $products->map(function ($product) {
//            $product->name = implode(' | ', [
//                trim($product->code),
//                trim(preg_replace('~[\r\n]+~', '', $product->name)),
//                Formatter::currency($product->price),
//                $product->currency->code,
//            ]);
//        });
//
//        $goDreamProducts = $products->pluck('name', 'id');
//
//        $products = PartnerProduct::with('currency')
//            ->wherePartnerId(SystemType::WonderBoxSystem)
//            ->get()->sortBy('code');
//
//        $products->map(function ($product) {
//            $product->name = implode(' | ', [
//                trim($product->code),
//                trim(preg_replace('~[\r\n]+~', '', $product->name)),
//                Formatter::currency($product->price),
//                $product->currency->code,
//            ]);
//        });
//
//        $wonderBoxProducts = $products->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function ($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $loginTypes = AccessCodeType::asSelectArray();

        return [
            $themes,
            $templates,
            $status,
            $categories,
            $admins,
            $countries,
//            $goDreamProducts,
//            $wonderBoxProducts,
            $loginTypes,
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
            $name[] = $template->name;
            $name[] = $template->language->name; // TODO: Need clarification
            $name[] = $template->show_all_booking_non_refund ? 'refundables' : 'non-refundables';
            if ($template->secure_payment) {
                $name[] = '3ds';
            }

            $template->name = implode(' | ', $name);
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
