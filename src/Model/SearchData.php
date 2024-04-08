<?php

namespace App\Model;

class SearchData
{
    /** @var string */
    public ?string $q = null;

    /** @var string|null */
    public ?string $category = null;

    /** @var string|null */
    public ?string $taille = null;

    /** @var string|null */
    public ?string $color = null;
}