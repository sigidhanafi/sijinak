<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

// enum Badge: string
// {
//     case SUCCESS = 'success';
//     case WARNING = 'warning';
//     case ERROR = 'error';
//     case INFO = 'info';
//     case PRIMARY = 'primary';
//     case SECONDARY = 'secondary';
//     case NONE = 'none';
// }

class DropdownCheckBoxChildren extends Component
{
    public string $label;
    public ?string $badge;
    public string $type;

    /**
     * Create a new component instance.
     */
    public function __construct(string $badge, string $label, string $type)
    {
        $this->type = $type;
        $this->badge = $badge;
        $this->label = $label;
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown-check-box-children');
    }
}
