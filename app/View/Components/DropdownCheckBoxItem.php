<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class DropdownCheckBoxItem extends Component
{
    /**
     * Create a new component instance.
     */
    
    public string $helperMessage;
    public string $title;
    public string $type;

    public function __construct(string $title, string $helperMessage, string $type)
    {
        $this->helperMessage = $helperMessage;
        $this->title = $title;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown-check-box-item');
    }
}

