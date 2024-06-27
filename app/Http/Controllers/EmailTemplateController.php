<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\Placeholder;
use Illuminate\Http\Request;
use PharIo\Manifest\Email;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('templates.index', compact('templates'));
    }
    public function create()
    {
        $template = EmailTemplate::all();
        $placeholders = Placeholder::all();
        return view('templates.create', compact('placeholders', 'templates'));
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $template->name = $request->input('name');
        $template->subject = $request->input('subject');
        $template->content = $request->input('content');
        $template->save();

        return redirect()->route('admin.templates.index');
    }
    public function edit(EmailTemplate $template)
    {
        $placeholders = Placeholder::all();
        return view('templates.create', compact('template', 'placeholders'));
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
