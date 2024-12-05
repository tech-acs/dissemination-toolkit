<?php

namespace Uneca\DisseminationToolkit\Http\Controllers;

use Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum;
use App\Http\Controllers\Controller;
use Uneca\DisseminationToolkit\Http\Requests\CensusTableRequest;
use Uneca\DisseminationToolkit\Models\Document;
use Uneca\DisseminationToolkit\Models\Indicator;
use Uneca\DisseminationToolkit\Models\Tag;
use Uneca\DisseminationToolkit\Models\Topic;
use Uneca\DisseminationToolkit\Services\SmartTableColumn;
use Uneca\DisseminationToolkit\Services\SmartTableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentManagementController extends Controller
{
    public function uploadCensusFile($request, string $disk, string $directory): array
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($request->has('file_path')) {
                Storage::disk($disk)->delete($request->get('file_path'));
            }
        }
        $file_path = $request->file('file')->store($directory, $disk);

        return [
            'file_path' => $file_path,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'file_size' => $request->file('file')->getSize(),
            'file_type' => $request->file('file')->getClientOriginalExtension(),
        ];
    }

    public function index(Request $request)
    {
        return (new SmartTableData(auth()->user()->documents(), $request))
            ->columns([
                SmartTableColumn::make('title')->sortable()->tdClasses('w-1/3'),
                SmartTableColumn::make('type')->sortable()
                    ->setBladeTemplate('<x-dissemination::dataset-type-badge :text="$row->dataset_type" class="{{\Uneca\DisseminationToolkit\Enums\CensusTableTypeEnum::getTypeClass($row->dataset_type)}}"/>'),
                SmartTableColumn::make('publisher')->sortable(),
                SmartTableColumn::make('author')->sortable()
                    ->setBladeTemplate('{{ $row->user->name }}'),
                SmartTableColumn::make('published')
                    ->setBladeTemplate('<x-dissemination::yes-no value="{{$row->published}}"/>'),
                SmartTableColumn::make('updated')
                    ->setBladeTemplate('{{ $row->updated_at->diffForHumans() }}'),
            ])
            ->showable('document.show')
            ->editable('manage.document.edit')
            ->deletable('manage.document.destroy')
            ->searchable(['title', 'type'])
            ->sortBy('title')
            ->downloadable()
            ->view('dissemination::manage.document.index');
    }

    public function create()
    {
        $topics = Topic::pluck('name', 'id');
        $indicators = Indicator::all();
        $types = CensusTableTypeEnum::getTypes();
        $document = (new Document());
        return view('dissemination::manage.document.create', compact('topics', 'indicators', 'types', 'document'));
    }

    public function store(CensusTableRequest $request)
    {
        if (!($request->hasFile('file') && $request->file('file')->isValid())) {
            return redirect()->back()->withErrors(['file' => 'File is required']);
        }
        $fileInfo = $this->uploadCensusFile($request, 'public', 'documents');

        $request->merge($fileInfo);
        $request->merge(['user_id' => Auth::id()]);

        $document = Document::create($request->all());
        $document->topics()->sync($request->get('topics'));

        $updatedTags = Tag::prepareForSync($request->get('tags', ''));
        $document->tags()->sync($updatedTags->pluck('id'));
        return redirect()->route('manage.document.index')->withMessage('Document created');
    }

    public function edit(Document $document)
    {
        $topics = Topic::pluck('name', 'id');
        $indicators = Indicator::all();
        $types = CensusTableTypeEnum::getTypes();
        $document->load(['topics', 'tags']);
        $selectedTopics = $document->topics->pluck('id')->toArray();
        return view('dissemination::manage.document.edit', compact('document', 'topics', 'indicators', 'selectedTopics', 'types'));
    }

    public function update(CensusTableRequest $request, Document $document)
    {
        $requestUpdate = $request->only(['title', 'description', 'producer', 'publisher', 'data_source', 'comment', 'dataset_type']);
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $fileInfo = $this->uploadCensusFile($request, 'public', 'documents');
            $requestUpdate = array_merge($requestUpdate, $fileInfo);
        }
        $document->update($requestUpdate);
        $document->topics()->sync($request->get('topics'));
        $updatedTags = Tag::prepareForSync($request->get('tags', ''));
        $document->tags()->sync($updatedTags->pluck('id'));

        return redirect()->route('manage.document.index')->withMessage('Document updated');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        Storage::disk('public')->move($document->file_path, 'archive/' . $document->file_name);
        return redirect()->route('manage.document.index')->withMessage('Document deleted');
    }
}
