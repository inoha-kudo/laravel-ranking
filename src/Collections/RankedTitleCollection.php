<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Collections;

use Illuminate\Database\Eloquent\Collection;
use Miraiportal\LaravelRanking\Models\RankedTitle;
use Miraiportal\Ranking\Entities\RankedTitleList;

/** @extends Collection<int, RankedTitle> */
final class RankedTitleCollection extends Collection
{
    public function toEntity(): RankedTitleList
    {
        return RankedTitleList::from(...$this->map->toEntity()->values());
    }
}
