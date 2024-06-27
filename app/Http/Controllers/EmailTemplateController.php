<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Placeholder;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function create()
    {
        $placeholders = Placeholder::all();
        return view('templates.create', compact('placeholders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required'
        ]);

        $template = new EmailTemplate();
        $template->name = $request->name;
        $template->content = $request->content;
        $template->save();

        return redirect()->back()->with('success', 'Email template created successfully.');
    }

    public function addPlaceholder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $placeholder = new Placeholder();
        $placeholder->name = $request->name;
        $placeholder->save();

        return response()->json($placeholder);
    }
}
