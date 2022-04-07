<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Request;

class NavItem extends Component
{
    public ?string $path;

    public ?string $groupPath;

    public bool $tree;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $path = null,
        string $groupPath = null,
        bool $tree = false
    ) {
        $this->path = $path;
        $this->groupPath = $groupPath;
        $this->tree = $tree;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if (is_null($this->groupPath)) {
            return Request::url() == $this->path;
        }

        return Request::routeIs($this->groupPath . '.*');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-item');
    }
}
