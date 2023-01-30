<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounteragentGroup;
use Illuminate\Http\Request;

class CounteragentGroupController extends Controller
{
    public function index()
    {
        $counteragentGroups = CounteragentGroup::all();

        return view('admin.counteragent-group.index', compact('counteragentGroups'));
    }

    public function create()
    {

        return view('admin.counteragent-group.create');
    }

    public function store(Request $request)
    {
        $counteragentGroup = new CounteragentGroup();
        $counteragentGroup->name = $request->get('name');
        $counteragentGroup->save();

        return redirect()->route('admin.counteragent-group.index');
    }

    public function edit(CounteragentGroup $counteragentGroup)
    {

        return view('admin.counteragent-group.edit', compact('counteragentGroup'));
    }

    public function update(Request $request, CounteragentGroup $counteragentGroup)
    {
        $counteragentGroup->name = $request->get('name');
        $counteragentGroup->save();
        return redirect()->route('admin.counteragent-group.index');
    }

    public function delete(CounteragentGroup $counteragentGroup)
    {
        $counteragentGroup->delete();

        return redirect()->route('admin.counteragent-group.index');
    }


}
