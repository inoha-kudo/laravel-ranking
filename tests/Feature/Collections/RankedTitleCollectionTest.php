<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Tests\Feature\Collections;

use Carbon\CarbonImmutable;
use Miraiportal\LaravelRanking\Collections\RankedTitleCollection;
use Miraiportal\LaravelRanking\Models\RankedTitle;
use Miraiportal\LaravelRanking\Tests\TestCase;
use Miraiportal\Ranking\Entities\Rank;
use Miraiportal\Ranking\Entities\RankingId;

final class RankedTitleCollectionTest extends TestCase
{
    private array $rankedTitles;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $rankingId = RankingId::MIN;
        $storedAt = CarbonImmutable::parse('1970-01-01T00:00:00+00:00');
        $rank = Rank::MIN;

        $this->rankedTitles = [
            [
                'id' => 1,
                'ranking_id' => $rankingId,
                'stored_at' => $storedAt,
                'rank' => $rank,
                'title' => 'title_'.$rank,
                'metadata' => [
                    'description' => 'description_'.$rank,
                    'thumbnail' => 'thumbnail_'.$rank,
                    'genre' => 'genre_'.$rank,
                    'link' => 'link_'.$rank,
                ],
            ],
            [
                'id' => 2,
                'ranking_id' => $rankingId,
                'stored_at' => $storedAt,
                'rank' => $rank + 1,
                'title' => 'title_'.($rank + 1),
                'metadata' => [
                    'description' => 'description_'.($rank + 1),
                    'thumbnail' => 'thumbnail_'.($rank + 1),
                    'genre' => 'genre_'.($rank + 1),
                    'link' => 'link_'.($rank + 1),
                ],
            ],
        ];
    }

    public function test_to_entity(): void
    {
        $this->assertSame([
            [
                'id' => $this->rankedTitles[0]['id'],
                'ranking_id' => $this->rankedTitles[0]['ranking_id'],
                'stored_at' => $this->rankedTitles[0]['stored_at']->toIso8601String(),
                'rank' => $this->rankedTitles[0]['rank'],
                'title' => $this->rankedTitles[0]['title'],
                'metadata' => $this->rankedTitles[0]['metadata'],
            ],
            [
                'id' => $this->rankedTitles[1]['id'],
                'ranking_id' => $this->rankedTitles[1]['ranking_id'],
                'stored_at' => $this->rankedTitles[1]['stored_at']->toIso8601String(),
                'rank' => $this->rankedTitles[1]['rank'],
                'title' => $this->rankedTitles[1]['title'],
                'metadata' => $this->rankedTitles[1]['metadata'],
            ],
        ], new RankedTitleCollection([
            new RankedTitle()->forceFill($this->rankedTitles[0]),
            new RankedTitle()->forceFill($this->rankedTitles[1]),
        ])->toEntity()->toArray());
    }
}
