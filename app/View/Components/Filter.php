<?php

namespace App\View\Components;

use Illuminate\View\Component;
use function view;

class Filter extends Component
{
    /** @var string $title */
    public string $title;

    /** @var bool $collapse */
    public bool $collapse;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param bool $collapse
     */
    public function __construct(string $title = 'Filters', bool $collapse = true)
    {
        $this->title = $title ?? __($title);
        $this->collapse = $collapse;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filter');
    }
}
