<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Tests\Feature\Repositories;

use Carbon\CarbonImmutable;
use Miraiportal\LaravelRanking\Repositories\RankingEloquentWriteRepository;
use Miraiportal\LaravelRanking\Tests\TestCase;
use Miraiportal\Ranking\Entities\Rank;
use Miraiportal\Ranking\Entities\RankedTitle;
use Miraiportal\Ranking\Entities\RankedTitleList;
use Miraiportal\Ranking\Entities\RankingId;

final class RankingEloquentWriteRepositoryTest extends TestCase
{
    private RankedTitleList $rankedTitleList;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $rankingId = RankingId::MIN;
        $storedAt = CarbonImmutable::parse('1970-01-01T00:00:00+00:00');
        $rank = Rank::MIN;

        $this->rankedTitleList = RankedTitleList::from(
            RankedTitle::create($rankingId, $storedAt, $rank, 'title_'.$rank),
            RankedTitle::create($rankingId, $storedAt, $rank + 1, 'title_'.($rank + 1)),
        );
    }

    public function test_add(): void
    {
        new RankingEloquentWriteRepository()->add($this->rankedTitleList);

        $this->assertDatabaseCount(
            'ranked_titles',
            $this->rankedTitleList->count(),
        );
    }
}
