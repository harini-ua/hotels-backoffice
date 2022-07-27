<?php

use App\Models\Hotel;
use App\Models\PromoMessage;
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
        'image'
    ];

    /**
     * Run the actions.
     *
     * @return void
     */
    public function up(): void
    {
        $messages = PromoMessage::all();
        foreach ($messages as $message) {
            foreach ($this->fields as $field) {
                if ($message->{$field}) {
                    $file = storage_path($message->{$field});
                    if (Storage::exists($file)) {
                        $extension = pathinfo(storage_path($message->{$field}), PATHINFO_EXTENSION);

                        $destination = storage_path('app/public/promo/' . $message->id . '/');
                        $fileName = Uuid::uuid1() . '.' . $extension;
                        Storage::copy($file, $destination . $fileName);

                        $message->{$field} = $fileName;
                        $message->save();
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
        Storage::deleteDirectory('app/public/promo/');
        Storage::makeDirectory('app/public/promo/');
    }
};
