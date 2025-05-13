<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public string $name;
    public string $class;
    /**
     * Create a new component instance.
     */
    public function __construct(string $name, string $class = 'w-5 h-5')
    {
        $this->name = $name;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partials.icon');
    }
}
