<?php

namespace App\Classes;

class Hotel
{
    /** @var Room[] array */
    public $rooms = [];

    public function __construct()
    {
        // TODO: Implement __construct class.
    }

    /**
     * Get rooms
     * @return Room[]
     */
    public function getRooms(): array
    {
        return $this->rooms;
    }

    /**
     * Set rooms
     * @param Room[] $rooms
     * @return void
     */
    public function setRooms(array $rooms): void
    {
        $this->rooms = $rooms;
    }

    /**
     * Add rooms
     *
     * @param Room[]|Room $rooms
     * @return void
     */
    public function addRooms($rooms): void
    {
        $rooms = is_array($rooms) ? $rooms : [$rooms];
        $this->rooms = array_merge($this->rooms, $rooms);
    }

    // TODO: Implement Hotel class.
}
