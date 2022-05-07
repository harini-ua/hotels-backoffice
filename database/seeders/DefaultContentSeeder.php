<?php

namespace Database\Seeders;

use App\Enums\CarouselType;
use App\Enums\TeaserType;
use App\Models\CompanyCarousel;
use App\Models\CompanyCarouselItem;
use App\Models\CompanyTeaser;
use App\Models\CompanyTeaserItem;
use App\Models\DefaultContent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DefaultContentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        CompanyCarousel::insert([
            'default' => true,
            'created_at' => Carbon::now()
        ]);

        CompanyCarouselItem::insert([
            'carousel_id' => 1,
            'type' => CarouselType::Image,
            'image' => 'picture_1.jpg',
            'text' => '<p>&nbsp;</p><p style="color: #000000;">Welcome to 230 000 hotels worldwide</p>',
            'created_at' => Carbon::now()
        ]);

        CompanyCarouselItem::insert([
            'carousel_id' => 1,
            'type' => CarouselType::Image,
            'image' => 'picture_2.jpg',
            'text' => '<p><br />All with best price guarantee for the same conditions</p>',
            'created_at' => Carbon::now()
        ]);

        CompanyCarouselItem::insert([
            'carousel_id' => 1,
            'type' => CarouselType::Image,
            'image' => 'picture_3.jpg',
            'text' => '<p>Enjoy discount on car rental as well</p>',
            'created_at' => Carbon::now()
        ]);

        CompanyCarouselItem::insert([
            'carousel_id' => 1,
            'type' => CarouselType::Image,
            'image' => 'picture_4.jpg',
            'text' => '<p>We will continue to add on more hotels</p>',
            'created_at' => Carbon::now()
        ]);

        CompanyCarouselItem::insert([
            'carousel_id' => 1,
            'type' => CarouselType::Image,
            'image' => 'picture_5.jpg',
            'text' => '<p><br />Enjoy your travels<br />... and your savings!</p>',
            'created_at' => Carbon::now()
        ]);

        CompanyTeaser::insert([
            'default' => true,
            'created_at' => Carbon::now()
        ]);

        CompanyTeaserItem::insert([
            'teaser_id' => 1,
            'type' => TeaserType::Testimonial,
            'title' => 'Testimonial',
            'text' => '<p><em>Booked a room in a 5 star hotel in the city center of Budapest. Really great deal, breakfast included. Compared it with the deals on the well known booking sites and the deal couldn&rsquo;t be matched by far. This booking website really does give added value!</em></p><p><strong>Albert van den Broek, The Hague, Netherlands</strong></p>',
            'created_at' => Carbon::now()
        ]);

        CompanyTeaserItem::insert([
            'teaser_id' => 1,
            'type' => TeaserType::Default,
            'title' => 'Please compare our prices',
            'text' => '<p>Check that these prices:</p><ul><li>Include breakfast.</li><li>Can be cancelled without fee.</li></ul>',
            'created_at' => Carbon::now()
        ]);

        CompanyTeaserItem::insert([
            'teaser_id' => 1,
            'type' => TeaserType::Default,
            'title' => 'Hotel Express website',
            'text' => '<p>www.hotelexpressonline.com</p>',
            'created_at' => Carbon::now()
        ]);

        DefaultContent::insert([
            'logo' => 'logo.jpg',
            'carousel_id' => 1,
            'teaser_id' => 1,
            'created_at' => Carbon::now()
        ]);
    }
}
