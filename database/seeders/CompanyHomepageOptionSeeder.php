<?php

namespace Database\Seeders;

use App\Enums\TeaserType;
use App\Models\CompanyCarousel;
use App\Models\CompanyCarouselItem;
use App\Models\CompanyHomepageOption;
use App\Models\CompanyTeaser;
use App\Models\CompanyTeaserItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class CompanyHomepageOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_homepage_options = [];

        if (($open = fopen(storage_path('app/seed') . "/company_homepage_options.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $carousel_data = [];
                $teaser_data = [];
                if ($data[4] !== '' || $data[5] !== '') {
                    $carousel_data[0] = ['picture' => $data[4], 'text' => $data[5]];
                }
                if ($data[6] !== '' || $data[7] !== '') {
                    $carousel_data[1] = ['picture' => $data[6], 'text' => $data[7]];
                }
                if ($data[8] !== '' || $data[9] !== '') {
                    $carousel_data[2] = ['picture' => $data[8], 'text' => $data[9]];
                }
                if ($data[10] !== '' || $data[11] !== '') {
                    $carousel_data[3] = ['picture' => $data[10], 'text' => $data[11]];
                }
                if ($data[12] !== '' || $data[13] !== '') {
                    $carousel_data[4] = ['picture' => $data[12], 'text' => $data[13]];
                }

                if ($data[14] !== '' || $data[15] !== '') {
                    $teaser_data[0] = ['title' => $data[14], 'text' => $data[15], 'type' => TeaserType::Default()];
                }
                if ($data[16] !== '' || $data[17] !== '') {
                    $teaser_data[1] = ['title' => $data[16], 'text' => $data[17], 'type' => TeaserType::Default()];
                }
                if ($data[19] !== '' || $data[20] !== '') {
                    $teaser_data[2] = ['title' => $data[18], 'text' => $data[19] . $data[20], 'type' => TeaserType::Testimonial()];
                }

                if (!empty($carousel_data)) {
                    $carousel = new CompanyCarousel();
                    $carousel->default = 0;
                    $carousel->save();
                    foreach ($carousel_data as $carousels) {
                        $carousel_item = new CompanyCarouselItem();
                        $carousel_item->carousel_id = $carousel->id;
                        $carousel_item->image = $carousels['picture'];
                        $carousel_item->text = $carousels['text'];
                        $carousel_item->save();
                    }
                }
                if (!empty($teaser_data)) {
                    $teaser = new CompanyTeaser();
                    $teaser->default = 0;
                    $teaser->save();
                    foreach ($teaser_data as $teasers) {
                        $teaser_item = new CompanyTeaserItem();
                        $teaser_item->teaser_id = $teaser->id;
                        $teaser_item->type = $teasers['type'];
                        $teaser_item->title = $teasers['title'];
                        $teaser_item->text = $teasers['text'];
                        $teaser_item->save();
                    }
                }

                $company_homepage_options[] = [
                    'company_id' => (int)$data[0],
                    'theme_id' => (int)$data[1],
                    'logo' => $data[2] == '' ? null : $data[2],
                    'mobile_background_image' => $data[3] == '' ? null : $data[3],
                    'carousel_id' => isset($carousel) ? $carousel->id : null,
                    'teaser_id' => isset($teaser) ? $teaser->id : null,
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($company_homepage_options, 1000) as $company) {
            DB::table(CompanyHomepageOption::TABLE_NAME)->insertTs($company);
        }
    }
}
