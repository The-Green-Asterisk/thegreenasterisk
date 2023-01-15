<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $content;
    public $showSubmitButton = true;
    public $showCloseButton = true;
    public $submitButtonText = 'Submit';
    public $closeButtonText = 'Close';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $title = null,
        $content = null,
        $showCloseButton = true,
        $showSubmitButton = true,
        $submitButtonText = 'Submit',
        $closeButtonText = 'Close'
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->showCloseButton = $showCloseButton;
        $this->showSubmitButton = $showSubmitButton;
        $this->submitButtonText = $submitButtonText;
        $this->closeButtonText = $closeButtonText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $title = $this->title ?? 'Modal';
        $content = $this->content ?? 'There is no content to this modal.';
        $showCloseButton = $this->showCloseButton;
        $showSubmitButton = $this->showSubmitButton;
        $submitButtonText = $this->submitButtonText;
        $closeButtonText = $this->closeButtonText;

        return view('components.modal.modal', compact(
            'title',
            'content',
            'showCloseButton',
            'showSubmitButton',
            'submitButtonText',
            'closeButtonText'
        ));
    }
}
