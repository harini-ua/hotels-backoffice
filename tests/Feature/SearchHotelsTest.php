<?php

namespace Tests\Feature;

use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Scout\Searchable;
use Tests\TestCase;

class SearchHotelsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function class_uses_scout()
    {
        $this->assertContains(Searchable::class, class_uses(Hotel::class));
    }
}
