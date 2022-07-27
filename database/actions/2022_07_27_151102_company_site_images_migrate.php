<?php

use DragonCode\LaravelActions\Support\Actionable;

return new class extends Actionable
{
    /** @var array */
    protected $environment = ['local', 'staging'];

    /** @var array */
    protected $except_environment = ['production'];

    /**
     * Run the actions.
     *
     * @return void
     */
    public function up(): void
    {
        // TODO: Implement images migration
    }

    /**
     * Reverse the actions.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
