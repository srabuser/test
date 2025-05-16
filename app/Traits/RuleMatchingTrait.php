<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use App\Models\Rule;
use OpenAI\Laravel\Facades\OpenAI;

trait RuleMatchingTrait
{
    public function generateEmbedding(string $text): Collection
    {
        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => $text,
        ]);

        return collect($response['data'][0]['embedding']);
    }

    public function calculateCosineSimilarity(Collection $a, Collection $b): float
    {
        $dot = $a->zip($b)->sum(fn($pair) => $pair[0] * $pair[1]);
        $normA = sqrt($a->sum(fn($v) => $v ** 2));
        $normB = sqrt($b->sum(fn($v) => $v ** 2));

        return ($normA && $normB) ? $dot / ($normA * $normB) : 0;
    }

    public function findBestMatchingRule(Collection $userEmbedding): ?Rule
    {
        $rules = Rule::all();
        $bestRule = null;
        $highestSimilarity = -1;

        foreach ($rules as $rule) {
            if (!$rule->embedding) continue;

            $storedEmbedding = collect($rule->embedding)->map(fn($v) => (float) $v);
            $similarity = $this->calculateCosineSimilarity($userEmbedding, $storedEmbedding);

            if ($similarity > $highestSimilarity) {
                $highestSimilarity = $similarity;
                $bestRule = $rule;
            }
        }

        return $highestSimilarity >= 0.85 ? $bestRule : null;
    }
}
