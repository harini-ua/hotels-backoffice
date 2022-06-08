<?php

namespace Database\Seeders;

use App\Enums\TeaserType;
use App\Models\CompanyCarousel;
use App\Models\CompanyCarouselItem;
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

        //for company_homepage_options.csv
//        SELECT c.whiteid as company_id, p.theme_id, c.logo, c.mobile_slide_pic as mobile_background_image,
//        c.s_pic1, c.s_text1, c.s_pic2, c.s_text2, c.s_pic3, c.s_text3,
//        c.s_pic4, c.s_text4, c.s_pic5, c.s_text5, c.rgt_head1, c.rgt_msg1,
//        c.rgt_head2, c.rgt_msg2, c.testi_title, c.testi_t1, c.testi_t2
//        FROM white_label_content c
//        INNER JOIN white_profile_details p ON p.whtid = c.whiteid
//        WHERE c.whiteid IN(761,804,805,806,807,808,809,810,840,841,842,843,844,845,846,847,848,849,1184,1395,1396,1397,1398,1399,1400,1401,1402,
//        1403,1404,1418,1419,1420,1421,1422,1423,1556,1594,1706,1707,1708,1709,1710,1711,1712,1713,754,602,886,425,431,443,462,
//        494,496,497,501,503,516,518,524,568,570,571,587,604,605,616,640,645,682,693,712,719,723,724,732,746,748,750,790,962,
//        1374,1526,1554,1595,1623,1626,1629,1727,1743)

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

                $this->downloadImages($data);
            }

            fclose($open);
        }

        foreach (array_chunk($company_homepage_options, 1000) as $company) {
            DB::table('company_homepage_options')->insertTs($company);
        }
    }

    /**
     * Download company images
     * @param array $data
     * @return void
     */
    protected function downloadImages(array $data): void
    {
        if (App::environment('local'))
        {
            $company_dir = storage_path('app/public/companies') . '/' . (int)$data[0];
            if (!file_exists($company_dir)) {
                mkdir($company_dir, 0777);
            }

            $contextOptions = [
                "ssl" => [
                    "verify_peer"      => false,
                    "verify_peer_name" => false,
                ]
            ];

            //  for downloading images, execute only on local (long process)
            if (!file_exists(storage_path('app/public/company_logos'))) {
                mkdir(storage_path('app/public/company_logos'), 0777);
            }
            $logo = 'https://ho.hotel-express.com/admin/white_image/mainpagelogo/' . $data[2];
            if (($data[2] !== '') && @fopen($logo, 'r')) {
                $store_path = storage_path('app/public/company_logos') . '/' . $data[2];
                copy($logo, $store_path, stream_context_create($contextOptions));
            }

            if (!file_exists(storage_path('app/public/company_images'))) {
                mkdir(storage_path('app/public/company_images'), 0777);
            }
            $images_path = 'https://ho.hotel-express.com/admin/white_image/';
            if (($data[3] !== '') && @fopen($images_path . $data[3], 'r')) {
                $store_path = storage_path('app/public/company_images') . '/' . $data[3];
                copy($images_path . $data[3], $store_path, stream_context_create($contextOptions));
            }
            if (($data[4] !== '') && @fopen($images_path . $data[4], 'r')) {
                $store_path = storage_path('app/public/company_images') . '/' . $data[4];
                copy($images_path . $data[4], $store_path, stream_context_create($contextOptions));
            }
            if (($data[6] !== '') && @fopen($images_path . $data[6], 'r')) {
                $store_path = storage_path('app/public/company_images') . '/' . $data[6];
                copy($images_path . $data[6], $store_path, stream_context_create($contextOptions));
            }
            if (($data[8] !== '') && @fopen($images_path . $data[8], 'r')) {
                $store_path = storage_path('app/public/company_images') . '/' . $data[8];
                copy($images_path . $data[8], $store_path, stream_context_create($contextOptions));
            }
            if (($data[10] !== '') && @fopen($images_path . $data[10], 'r')) {
                $store_path = storage_path('app/public/company_images') . '/' . $data[10];
                copy($images_path . $data[10], $store_path, stream_context_create($contextOptions));
            }
            if (($data[12] !== '') && @fopen($images_path . $data[12], 'r')) {
                $store_path = storage_path('app/public/company_images') . '/' . $data[12];
                copy($images_path . $data[12], $store_path, stream_context_create($contextOptions));
            }
        }
    }
}
