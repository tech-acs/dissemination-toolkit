<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Enums\VisualizationTypeEnum;
use Uneca\DisseminationToolkit\Models\Story;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Models\Visualization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoryBuilderController extends Controller
{
    public function edit(Story $story)
    {
        $baseUrl = config('app.url');
        $visualizations = Visualization::orderBy('livewire_component')
            ->published()
            ->get()
            ->map(function (Visualization $visualization) {
                return [
                    'id' => $visualization->id,
                    'name' => $visualization->title,
                    'type' => $visualization->type,
                ];
            })->all();
        return view('manage.story.builder', compact('story', 'visualizations', 'baseUrl'));
    }

    public function update(Request $request, $id)
    {
        $story = Story::find($id);
        $succeeded = $story->update(['html' => html_entity_decode($request->get('storyHtml'))]);
        abort_unless($succeeded, 400);
        return response('Success', 200);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $allowedFileTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!in_array($image->getMimeType(), $allowedFileTypes)) {
                return response()->json(['message' => 'File type not allowed']);
            }
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('stories\images', $imageName, 'public');
            $imagePath =  asset('storage/' . $imagePath);
            return response()->json(['image_path' => $imagePath]);
        }
        return response()->json(['message' => 'No image available to upload']);
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            if (!$this->isFileTypeAllowed($request->file('file'))) {
                return response()->json(['message' => 'File type not allowed']);
            }
            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('stories/files', $fileName, 'public');
            $filePath =  asset('storage/' . $filePath);
            return response()->json(['file_path' => $filePath]);
        }
        return response()->json(['message' => 'No file available to upload']);
    }

    public function getArtifacts(int $topic_id)
    {
        return Visualization::published()->whereHas('topic',function ($query) use ($topic_id) {
            $query->where('topic_id',$topic_id);
        }
        )->get() ->map(function ($viz) {
            return [
                'id' => $viz->id,
                'title' => $viz->title,
                'description' => $viz->description,
                'type' => $viz->type,
                'icon' => VisualizationTypeEnum::getIcon($viz->type),
                'code' => '<livewire:visualizer vizId="' . $viz->id . '"/>',
            ];
        });
    }

    public function getTopics() {
        return Topic::all()->map (function ($topic) {
            return [
                'id' =>$topic->id,
                'name' =>$topic->name,
            ];
        });
}

    private function isFileTypeAllowed($file)
    {
        $fileExtension = $file->getClientOriginalExtension();
        $allowedFileTypes = ['pdf', 'xls', 'xlsx', 'csv','doc','docx','ppt','pptx'];
        return in_array($fileExtension, $allowedFileTypes);
    }
}
