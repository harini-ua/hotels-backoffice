<?php

namespace App\Services;

use App\Enums\AccessCodeType;
use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Models\AccessCode;
use App\Models\Company;
use App\Models\CompanyCarousel;
use App\Models\CompanyMainOption;
use App\Models\CompanyTeaser;
use App\Models\CompanyTemplate;
use App\Models\CompanyTheme;
use App\Models\Country;
use App\Models\DefaultContent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
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

        // Replicate company extra night
        if ($this->company->extraNight) {
            $extraNight = $this->company->extraNight->replicate();
            $newCompany->extraNight()->create($extraNight->toArray());
        } else {
            $this->defaultExtraNight();
        }

        // Replicate company homepage options
        if ($this->company->homepageOptions) {
            // Homepage Options
            $homepageOptions = $this->company->homepageOptions->replicate();

            // Copy company default logo
            if ($this->company->homepageOptions->logo) {
                $fileName = Uuid::uuid1().'.'.\File::extension($this->company->homepageOptions->logo);
                $logo = $this->company->homepageOptions->logo;
                if (Storage::exists('public/companies/'.$this->company->id.'/'.$logo)) {
                    Storage::copy(
                        'public/companies/'.$this->company->id.'/'.$logo,
                        'public/companies/'.$newCompany->id.'/'.$fileName
                    );
                }
                $homepageOptions->logo = $fileName;
            }

            // Replicate company homepage options
            if ($this->company->homepageOptions->carousel) {
                $newCarousel = $this->company->homepageOptions->carousel->replicate();
                $newCarousel->default = false;
                $newCarousel->push();

                foreach ($this->company->homepageOptions->carousel->items as $item) {
                    $newItem = $item->replicate();
                    $newItem->carousel_id = $newCarousel->id;

                    $fileName = Uuid::uuid1().'.'.\File::extension($newItem->image);

                    if (Storage::exists('public/companies/'.$this->company->id.'/'.$newItem->image)) {
                        Storage::copy(
                            'public/companies/'.$this->company->id.'/'.$newItem->image,
                            'public/companies/'.$newCompany->id.'/'.$fileName
                        );
                    }

                    $newItem->image = $fileName;
                    $newItem->push();
                }

                $homepageOptions->carousel_id = $newCarousel->id;
            }

            $newTeaser = $this->company->homepageOptions->teaser->replicate();
            $newTeaser->default = false;
            $newTeaser->push();

            foreach ($this->company->homepageOptions->teaser->items as $item) {
                $newItem = $item->replicate();
                $newItem->teaser_id = $newTeaser->id;
                $newItem->push();
            }

            $homepageOptions->teaser_id = $newTeaser->id;

            $newCompany->homepageOptions()->create($homepageOptions->toArray());
        } else {
            $this->defaultHomepageOptions();
        }

        // Replicate company main options
        if ($this->company->mainOptions) {
            $mainOptions = $this->company->mainOptions->replicate();
            $newCompany->mainOptions()->create($mainOptions->toArray());
        } else {
            $this->defaultMainOptions();
        }

        // Replicate company prefilled option
        if ($this->company->prefilledOption) {
            $prefilledOptions = $this->company->prefilledOption->replicate();
            $newCompany->prefilledOption()->create($prefilledOptions->toArray());
        } else {
            $this->defaultPrefilledOption();
        }

        // TODO: Implement duplicate all relationship

        return $newCompany;
    }

    /**
     * Set Default Main Options
     *
     * @return void
     */
    public function defaultMainOptions()
    {
        $mainOption = new CompanyMainOption();
        $mainOption->company_id = $this->company->id;
        $mainOption->hotel_distances_filter = setDefaultHotelDistancesFilters();
        $mainOption->save();
    }

    /**
     * Set Default Homepage Options
     *
     * @return void
     */
    public function defaultHomepageOptions()
    {
        // Create default carousel
        $carousel = CompanyCarousel::whereDefault(true)
            ->with('items')->first();

        $newCarousel = $carousel->replicate();
        $newCarousel->default = false;
        $newCarousel->push();

        foreach ($carousel->items as $item) {
            $newItem = $item->replicate();
            $newItem->carousel_id = $newCarousel->id;

            $fileName = Uuid::uuid1().'.'.\File::extension($newItem->image);
            Storage::copy(
                'public/default/'.$newItem->image,
                'public/companies/'.$this->company->id.'/'.$fileName
            );

            $newItem->image = $fileName;
            $newItem->push();
        }

        // Create default teaser
        $teaser = CompanyTeaser::whereDefault(true)
            ->with('items')->first();

        $newTeaser = $teaser->replicate();
        $newTeaser->default = false;
        $newTeaser->push();

        foreach ($teaser->items as $item) {
            $newItem = $item->replicate();
            $newItem->teaser_id = $newTeaser->id;
            $newItem->push();
        }

        // Copy default logo
        $logo = DefaultContent::first()->logo;
        $fileName = Uuid::uuid1().'.'.\File::extension($logo);
        Storage::copy(
            'public/default/'.$logo,
            'public/companies/'.$this->company->id.'/'.$fileName
        );

        // Create default homepage options
        $this->company->homepageOptions()->create([
            'theme_id' => CompanyTheme::whereDefault(true)->first()->id,
            'logo' => $fileName,
            'carousel_id' => $newCarousel->id,
            'teaser_id' => $newTeaser->id,
        ]);
    }

    /**
     * Set Default Prefilled Option
     *
     * @return void
     */
    public function defaultPrefilledOption()
    {
        $this->company->prefilledOption()->create([]);
    }

    /**
     * Set Default Extra Night
     *
     * @return void
     */
    public function defaultExtraNight()
    {
        $this->company->extraNight()->create([]);
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
            ->map(static function ($theme) {
                return [
                    'id' => $theme->id,
                    'theme_name' => !$theme->default
                        ? $theme->theme_name
                        : $theme->theme_name.' ('.__('Default').')',
                ];
            })
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
            ->map(static function ($theme) {
                return [
                    'id' => $theme->id,
                    'theme_name' => !$theme->default
                        ? $theme->theme_name
                        : $theme->theme_name.' ('.__('Default').')',
                ];
            })
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
