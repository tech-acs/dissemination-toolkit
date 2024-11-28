<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DatasetPublishStatusController extends Controller
{
    public function __invoke(Request $request, Dataset $dataset)
    {
        $validator = Validator::make(
            ['observations' => (int) $dataset->observationsCount()],
            ['observations' => 'required|numeric|min:1'],
            ['observations' => 'The dataset must contain some observations.']
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $publishStatus = $request->boolean('published');
        $dataset->update(['published' => $publishStatus]);
        return redirect()->route('manage.dataset.index')->withMessage('Dataset ' . ($publishStatus ? 'published' : 'unpublished'));
    }
}
