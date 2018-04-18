<?php

namespace JeroenNoten\LaravelAdminLte\Menu\Filters;

use Illuminate\Contracts\Auth\Access\Gate;
use JeroenNoten\LaravelAdminLte\Menu\Builder;

class GateFilter implements FilterInterface
{
    protected $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function transform($item, Builder $builder)
    {
        if (!empty($item['module_code'])) {
            if (!checkAccess($item['module_code'])) {
                return false;
            }
        }

        if (isset($item['hidden']) && $item['hidden']) {
            return false;
        }

        return $item;
        
        if (! $this->isVisible($item)) {
            return false;
        }

        return $item;
    }

    protected function isVisible($item)
    {
        if (! isset($item['can'])) {
            return true;
        }

        if (isset($item['model'])) {
            return $this->gate->allows($item['can'], $item['model']);
        }

        return $this->gate->allows($item['can']);
    }
}
