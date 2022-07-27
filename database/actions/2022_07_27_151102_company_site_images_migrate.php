<?php

use App\Models\Company;
use App\Models\CompanyCarouselItem;
use App\Models\CompanyHomepageOption;
use DragonCode\LaravelActions\Support\Actionable;
use Ramsey\Uuid\Uuid;

return new class extends Actionable
{
    /** @var array */
    protected $environment = ['local', 'staging'];

    /** @var array */
    protected $except_environment = ['production'];

    /** @var array */
    protected $fields = [
        CompanyHomepageOption::TABLE_NAME => [
            'logo',
            'mobile_background_image',
        ],
        CompanyCarouselItem::TABLE_NAME => [
            'image'
        ]
    ];

    /**
     * Run the actions.
     *
     * @return void
     */
    public function up(): void
    {
        $companies = Company::all()-with('homepageOptions.carousel.items');

        foreach ($companies as $company) {
            foreach ($this->fields as $table => $fields) {
                foreach ($fields as $field) {
                    switch ($table) {
                        case CompanyHomepageOption::TABLE_NAME:
                            if ($company->homepageOptions->{$field}) {
                                $file = storage_path($company->homepageOptions->{$field});
                                $extension = pathinfo(storage_path($company->homepageOptions->{$field}), PATHINFO_EXTENSION);

                                $destination = storage_path('app/public/companies/'.$company->id.'/');
                                $fileName = Uuid::uuid1().'.'.$extension;
                                Storage::copy($file, $destination.$fileName);

                                $company->homepageOptions->{$field} = $fileName;
                                $company->homepageOptions->save();
                            }
                            break;
                        case CompanyCarouselItem::TABLE_NAME:
                            $carouselItems = $company->homepageOptions->carousel->items;
                            foreach ($carouselItems as $carouselItem) {
                                if ($carouselItem->{$field}) {
                                    $file = storage_path($carouselItem->{$field});
                                    $extension = pathinfo(storage_path($carouselItem->{$field}), PATHINFO_EXTENSION);

                                    $destination = storage_path('app/public/companies/'.$company->id.'/');
                                    $fileName = Uuid::uuid1().'.'.$extension;
                                    Storage::copy($file, $destination.$fileName);

                                    $carouselItem->{$field} = $fileName;
                                    $carouselItem->save();
                                }
                            }
                            break;
                    }
                }
            }
        }
    }

    /**
     * Reverse the actions.
     *
     * @return void
     */
    public function down(): void
    {
        Storage::deleteDirectory('app/public/companies/');
        Storage::makeDirectory('app/public/companies/');
    }
};
