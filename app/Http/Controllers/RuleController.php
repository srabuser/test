<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class RuleController extends Controller
{
    public function updateEmbedding($id)
    {
        $rule = Rule::findOrFail($id);

        $response = OpenAI::embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => $rule->question,
        ]);

        $rule->update(['embedding' => $response['data'][0]['embedding']]);

        return response()->json(['message' => 'تم تحديث الـ embedding بنجاح']);
    }


    public function refreshEmbeddings()
    {
        $rules = Rule::all();
        $errors = [];

        foreach ($rules as $rule) {
            try {
                $response = OpenAI::embeddings()->create([
                    'model' => 'text-embedding-ada-002',
                    'input' => $rule->question,
                ]);
                $rule->update(['embedding' => $response['data'][0]['embedding']]);
            } catch (\Exception $e) {

                $errors[] = $e->getMessage();
            }
        }

        return response()->json([
            'message' => 'تم تحديث الـ embedding بنجاح',
            'errors' => $errors,
        ]);
    }
}
