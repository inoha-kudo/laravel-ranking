<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Miraiportal\LaravelRanking\Models\RankedTitle;
use Miraiportal\Ranking\Contracts\RankingWriteRepository;
use Miraiportal\Ranking\Entities\RankedTitle as RankedTitleEntity;
use Miraiportal\Ranking\Entities\RankedTitleList;

final class RankingEloquentWriteRepository implements RankingWriteRepository
{
    private const int CHUNK_SIZE = 1000;

    private const int JSON_OPTIONS = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR;

    #[\Override]
    public function add(RankedTitleList $rankedTitleList): void
    {
        $now = now();

        $chunks = array_chunk($rankedTitleList->map(
            fn (RankedTitleEntity $rankedTitle) => Arr::except([
                ...$rankedTitle->toArray(),
                'stored_at' => $rankedTitle->storedAt(),
                'metadata' => $rankedTitle->metadata() !== null
                    ? json_encode($rankedTitle->metadata(), self::JSON_OPTIONS)
                    : null,
                'created_at' => $now,
                'updated_at' => $now,
            ], 'id'),
        ), self::CHUNK_SIZE);

        DB::transaction(function () use ($chunks) {
            foreach ($chunks as $chunk) {
                RankedTitle::query()->insert($chunk);
            }
        });
    }
}
