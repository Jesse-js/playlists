<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteConfirm extends Component
{
    public string $context = '';
    /**
     * Create a new component instance.
     */
    public function __construct(string $context = '')
    {
        $this->context = $context;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-confirm');
    }
}
