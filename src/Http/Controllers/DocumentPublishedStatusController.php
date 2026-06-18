<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Uneca\DisseminationToolkit\Models\Document;

class DocumentPublishedStatusController extends Controller
{
    public function __invoke(Request $request, Document $document)
    {
        $publishedStatus = $request->boolean('published');
        $document->update(['published' => $publishedStatus]);

        return redirect()->route('manage.document.index')->withMessage('Document '.($publishedStatus ? 'published' : 'unpublished'));
    }
}
