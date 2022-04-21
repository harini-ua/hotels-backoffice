<?php

namespace App\Models;

use App\Traits\ImageUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDefault extends Model
{
    use ImageUpload, HasFactory;

    public const IMAGE_DIRECTORY = 'public/company/default/';
    public const IMAGE_EXTENSIONS = [ 'png', 'jpg', 'jpeg' ];
    public const IMAGE_KILOBYTES_SIZE = 4096;

    public const IMAGE_FIELDS = [
        'logo',
        'main_page_picture',
        'picture_1',
        'picture_2',
        'picture_3',
        'picture_4',
        'picture_5',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_default';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo', 'testimonial_heading_1', 'testimonial_heading_2', 'main_page_picture', 'main_page_heading_1',
        'main_page_heading_2', 'main_page_heading_3', 'picture_1', 'text_picture_1', 'picture_2', 'text_picture_2',
        'picture_3', 'text_picture_3', 'picture_4', 'text_picture_4', 'picture_5', 'text_picture_5', 'right_heading_1',
        'right_heading_message_1', 'right_heading_2', 'right_heading_message_2'
    ];
}
