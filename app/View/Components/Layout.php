<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    public $showNavbar;

    public $showFooter;

    public $mainContent;

    public $bg;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($showNavbar = true, $showFooter = true, $mainContent = true, $bg = null)
    {
        $this->showNavbar = $showNavbar;
        $this->showFooter = $showFooter;
        $this->mainContent = $mainContent;
        $this->bg = $bg;
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
        $bg = $this->bg;

        return view('components.layout', compact('showNavbar', 'showFooter', 'mainContent', 'bg'));
    }
}
