<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Heading extends Component
{
    public bool $sortable;
    public ?string $direction;

    public function __construct(bool $sortable = false, ?string $direction = null)
    {
        $this->sortable = $sortable;
        $this->direction = $direction;
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('components.table.heading');
    }
}
