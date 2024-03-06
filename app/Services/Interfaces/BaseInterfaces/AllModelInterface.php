<?php

namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Database\Eloquent\Collection;

interface AllModelInterface
{
    /**
     * @return Collection
     */
    public function getModels(): Collection;
}
