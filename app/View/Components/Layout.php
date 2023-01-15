<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $showNavbar = true;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($showNavbar = true)
    {
        $this->showNavbar = $showNavbar;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $showNavbar = $this->showNavbar;

        return view('components.layout', compact('showNavbar'));
    }
}
