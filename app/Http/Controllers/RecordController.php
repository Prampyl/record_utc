<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::with('category')->paginate(10);
        return view('records.index', compact('records'));
    }

    public function show(Record $record)
    {
        return view('records.show', compact('record'));
    }
}