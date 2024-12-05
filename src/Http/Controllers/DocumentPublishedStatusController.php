<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Models\Document;
use Illuminate\Http\Request;

class DocumentPublishedStatusController extends Controller
{
    public function __invoke(Request $request, Document $document)
    {
        $publishedStatus = $request->boolean('published');
        $document->update(['published' => $publishedStatus]);
        return redirect()->route('manage.document.index')->withMessage('Document ' . ($publishedStatus ? 'published' : 'unpublished'));
    }
}
