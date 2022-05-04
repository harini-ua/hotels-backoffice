<?php

namespace Database\Seeders;

use App\Models\DefaultContent;
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
        DefaultContent::insert([
            'logo' => 'logo.jpg',
            'testimonial_heading_1' => '<p><em>Booked a room in a 5 star hotel in the city center of Budapest. Really great deal, breakfast included. Compared it with the deals on the well known booking sites and the deal couldn&rsquo;t be matched by far. This booking website really does give added value!</em></p>',
            'testimonial_heading_2' => '<p><strong>Albert van den Broek, The Hague, Netherlands</strong></p>',
            'main_page_picture' => 'main_page_picture.jpg',
            'main_page_heading_1' => '<p><span style="font-family: verdana,geneva; color: #000000; font-size: large;">Main Picture heading 1</span></p>',
            'main_page_heading_2' => '<p><span style="font-family: verdana,geneva; color: #000000; font-size: medium;">Main Picture heading 2</span></p>',
            'main_page_heading_3' => '<p><span style="font-family: verdana,geneva;">Main Picture heading 3</span></p>',
            'picture_1' => 'picture_1.jpg',
            'text_picture_1' => '<p>&nbsp;</p><p style="color: #000000;">Welcome to 230 000 hotels worldwide</p>',
            'picture_2' => 'picture_2.jpg',
            'text_picture_2' => '<p><br />All with best price guarantee for the same conditions</p>',
            'picture_3' => 'picture_3.jpg',
            'text_picture_3' => '<p>Enjoy discount on car rental as well</p>',
            'picture_4' => 'picture_4.jpg',
            'text_picture_4' => '<p>We will continue to add on more hotels</p>',
            'picture_5' => 'picture_5.jpg',
            'text_picture_5' => '<p><br />Enjoy your travels<br />... and your savings!</p>',
            'right_heading_1' => 'Please compare our prices',
            'right_heading_message_1' => '<p>Check that these prices:</p><ul><li>Include breakfast.</li><li>Can be cancelled without fee.</li></ul>',
            'right_heading_2' => 'Hotel Express website',
            'right_heading_message_2' => '<p>www.hotelexpressonline.com</p>',
        ]);
    }
}
