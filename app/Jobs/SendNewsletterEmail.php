<?php

namespace App\Jobs;

use App\Enums\NewsletterUserType;
use App\Mail\NewsletterEmail;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Newsletter */
    protected $newsletter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($newsletter)
    {
        /** @var Newsletter $newsletter */
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query = (new User)->newQuery();

        switch ($this->newsletter->type) {
            case NewsletterUserType::All:
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['employee', 'booking']);
                });
                break;
            case NewsletterUserType::CompanySiteClient:
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['employee']);
                });
                break;
            case NewsletterUserType::BookingUsers:
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['booking']);
                });
                break;
        }

        if ($this->newsletter->company_id) {
            $query->whereHas('companies', function ($q) {
                $q->where('id', $this->newsletter->company_id);
            });
        }

        if ($this->newsletter->registered_date_from) {
            $query->whereDate('created_at', '>=', $this->newsletter->registered_date_from);
        }

        /** @var User[] $users */
        $users = $query->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NewsletterEmail($this->newsletter));
        }
    }
}
