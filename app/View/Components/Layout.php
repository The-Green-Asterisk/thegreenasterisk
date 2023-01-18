<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $showNavbar;

    public $showFooter;

    public $mainContent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($showNavbar = true, $showFooter = true, $mainContent = true)
    {
        $this->showNavbar = $showNavbar;
        $this->showFooter = $showFooter;
        $this->mainContent = $mainContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $showNavbar = $this->showNavbar;
        $showFooter = $this->showFooter;
        $mainContent = $this->mainContent;

        return view('components.layout', compact('showNavbar', 'showFooter', 'mainContent'));
    }
}
