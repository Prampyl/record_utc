<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Services\MediaService;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index()
    {
        $records = Record::with(['category', 'media'])->latest()->paginate(10);
        return view('records.index', compact('records'));
    }

    public function create()
    {
        return view('records.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'holder' => 'required|string|max:255',
            'value' => 'required|string',
            'record_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,mp4,pdf,doc,docx|max:10240'
        ]);

        \DB::beginTransaction();
        try {
            $record = Record::create($validated);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $this->mediaService->store($file, $record);
                }
            }

            \DB::commit();
            return redirect()->route('records.show', $record)
                           ->with('success', 'Record created successfully');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Error creating record: ' . $e->getMessage());
        }
    }

    public function show(Record $record)
    {
        return view('records.show', compact('record'));
    }
}