<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\CollectedBy;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Miraiportal\LaravelRanking\Collections\RankedTitleCollection;
use Miraiportal\Ranking\Entities\RankedTitle as RankedTitleEntity;

/**
 * @property int $id
 * @property int $ranking_id
 * @property CarbonImmutable $stored_at
 * @property int $rank
 * @property string $title
 * @property ?array<string, mixed> $metadata
 */
#[Guarded(['id', 'created_at', 'updated_at'])]
#[CollectedBy(RankedTitleCollection::class)]
final class RankedTitle extends Model
{
    public function toEntity(): RankedTitleEntity
    {
        return RankedTitleEntity::create(
            rankingId: $this->ranking_id,
            storedAt: $this->stored_at,
            rank: $this->rank,
            title: $this->title,
            id: $this->id,
            metadata: $this->metadata,
        );
    }

    #[\Override]
    protected function casts(): array
    {
        return [
            'stored_at' => 'immutable_datetime',
            'metadata' => 'array',
        ];
    }
}
