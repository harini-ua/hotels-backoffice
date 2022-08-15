<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\HotelImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class ImagesMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:migrate {chunk=1000}
                            {--H|--hotels : Run migration for hotel images}
                            {--C|--company : Run migration for company images}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('hotels')) {
            $this->migrate_hotel_images((int)$this->argument('chunk'));
        }

        if ($this->option('company')) {
            $this->migrate_company_images((int)$this->argument('chunk'));
        }

        return 0;
    }

    /**
     * Migrate hotel images
     *
     * @param int $chunk
     * @return void
     */
    protected function migrate_hotel_images($chunk)
    {
        HotelImage::chunk($chunk, function ($items) {
            /** @var HotelImage $item */
            foreach ($items as $item) {
                if (! filter_var($item->image, FILTER_VALIDATE_URL)) {
                    $exploded = explode('/', $item->image);
                    $oldFileName = end($exploded);

                    if (Storage::exists('public/old/primaryimage/'.$oldFileName)) {
                        $newFileName = Uuid::uuid1().'.'.strtolower(\File::extension($item->image));

                        Storage::copy(
                            'public/old/primaryimage/'.$oldFileName,
                            'public/hotels/'.$item->hotel_id.'/'.$newFileName
                        );

                        $item->update(['image' => $newFileName]);
                    } else {
                        $item->delete();
                    }
                }
            }
        });
    }

    /**
     * Migrate company images
     *
     * @param int $chunk
     * @return void
     */
    protected function migrate_company_images($chunk)
    {
        Company::with(['homepageOptions.carousel.items'])
            ->chunk($chunk, function ($items) {
                /** @var Company $item */
                foreach ($items as $company) {
                    if ($item->homepageOptions) {
                        $homepage = $item->homepageOptions;
                        if ($homepage->logo && ! filter_var($homepage->logo, FILTER_VALIDATE_URL)) {
                            $exploded = explode('/', $homepage->logo);
                            $oldFileName = end($exploded);

                            if (Storage::exists('public/old/companies/mainpagelogo/'.$oldFileName)) {
                                $newFileName = Uuid::uuid1().'.'.strtolower(\File::extension($homepage->logo));

                                Storage::copy(
                                    'public/old/companies/mainpagelogo/'.$oldFileName,
                                    'public/companies/'.$company->id.'/'.$newFileName
                                );

                                $homepage->update(['image' => $newFileName]);
                            }
                        }

                        if ($homepage->mobile_background_image &&
                            ! filter_var($homepage->mobile_background_image, FILTER_VALIDATE_URL))
                        {
                            $exploded = explode('/', $homepage->mobile_background_image);
                            $oldFileName = end($exploded);

                            if (Storage::exists('public/old/companies/'.$oldFileName)) {
                                $newFileName = Uuid::uuid1().'.'.strtolower(\File::extension($homepage->mobile_background_image));

                                Storage::copy(
                                    'public/old/companies/'.$oldFileName,
                                    'public/companies/'.$company->id.'/'.$newFileName
                                );

                                $homepage->update(['image' => $newFileName]);
                            }
                        }

                        if ($homepage->carousel) {
                            $carousel = $homepage->carousel;
                            foreach ($carousel->items as $item) {
                                if ($item->image) {
                                    if (! filter_var($item->image, FILTER_VALIDATE_URL)) {
                                        $exploded = explode('/', $item->image);
                                        $oldFileName = end($exploded);

                                        if (Storage::exists('public/old/companies/'.$oldFileName)) {
                                            $newFileName = Uuid::uuid1().'.'.strtolower(\File::extension($item->image));

                                            Storage::copy(
                                                'public/old/companies/'.$oldFileName,
                                                'public/companies/'.$company->id.'/'.$newFileName
                                            );

                                            $item->update(['image' => $newFileName]);
                                        }
                                    }
                                } else {
                                    $item->delete();
                                }
                            }
                        }
                    }
                }
            });
    }
}
