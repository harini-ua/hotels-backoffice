<?php

use App\Models\Hotel;
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
        'primary_image_url'
    ];

    /**
     * Run the actions.
     *
     * @return void
     */
    public function up(): void
    {
        $hotels = Hotel::all();
        foreach ($hotels as $hotel) {
            foreach ($this->fields as $field) {
                if ($hotel->{$field}) {
                    $file = storage_path($hotel->{$field});
                    $extension = pathinfo(storage_path($hotel->{$field}), PATHINFO_EXTENSION);

                    $destination = storage_path('app/public/hotels/'.$hotel->id.'/');
                    $fileName = Uuid::uuid1().'.'.$extension;
                    Storage::copy($file, $destination.$fileName);

                    $hotel->{$field} = $fileName;
                    $hotel->save();
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
        Storage::deleteDirectory('app/public/hotels/');
        Storage::makeDirectory('app/public/hotels/');
    }
};
