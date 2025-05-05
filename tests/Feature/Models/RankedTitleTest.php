<?php

declare(strict_types=1);

namespace Miraiportal\LaravelRanking\Tests\Feature\Models;

use Carbon\CarbonImmutable;
use Miraiportal\LaravelRanking\Models\RankedTitle;
use Miraiportal\LaravelRanking\Tests\TestCase;
use Miraiportal\Ranking\Entities\Rank;
use Miraiportal\Ranking\Entities\RankingId;

final class RankedTitleTest extends TestCase
{
    private array $rankedTitle;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->rankedTitle = [
            'id' => 1,
            'ranking_id' => RankingId::MIN,
            'stored_at' => CarbonImmutable::parse('1970-01-01T00:00:00+00:00'),
            'rank' => Rank::MIN,
            'title' => 'title',
            'metadata' => [
                'description' => 'description',
                'thumbnail' => 'thumbnail',
                'genre' => 'genre',
                'link' => 'link',
            ],
        ];
    }

    public function test_to_entity(): void
    {
        $this->assertSame([
            'id' => $this->rankedTitle['id'],
            'ranking_id' => $this->rankedTitle['ranking_id'],
            'stored_at' => $this->rankedTitle['stored_at']->toIso8601String(),
            'rank' => $this->rankedTitle['rank'],
            'title' => $this->rankedTitle['title'],
            'metadata' => $this->rankedTitle['metadata'],
        ], new RankedTitle()->forceFill($this->rankedTitle)->toEntity()->toArray());
    }
}
