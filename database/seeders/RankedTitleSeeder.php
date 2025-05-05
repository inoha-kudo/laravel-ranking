<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Database\Seeders;

use Illuminate\Container\Attributes\Give;
use Illuminate\Database\Seeder;
use Miraiportal\LaravelRanking\Repositories\RankingEloquentWriteRepository;
use Miraiportal\Ranking\Entities\RankedTitle;
use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;
use Miraiportal\Ranking\Services\RankingService;

final class RankedTitleSeeder extends Seeder
{
    public function __construct(
        #[Give(RankingService::class, [
            'writeRepository' => new RankingEloquentWriteRepository,
        ])]
        private readonly RankingService $rankingService,
    ) {}

    public function run(): void
    {
        $now = now()->roundHour()->toImmutable();

        $rankedTitles = collect([RankingId::MIN])
            ->crossJoin(range(1, 10))
            ->map(fn (array $params) => RankedTitle::create(
                rankingId: $params[0],
                storedAt: $now,
                rank: $params[1],
                title: "title_$params[1]",
                metadata: [
                    'description' => "description_$params[1]",
                    'thumbnail' => "thumbnail_$params[1]",
                    'genre' => "genre_$params[1]",
                    'link' => "link_$params[1]",
                ],
            ));

        $this->rankingService->add(RankedTitleList::from(...$rankedTitles));
    }
}
