<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $questions = Questions::all();

        // return response()->json([
        //     ''
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, $slug)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required',
    //         'choice_type' => 'required|in:short answer,paragraph,date,multiple choice,dropdown,checkboxes',
    //         'choices' => 'required_if:choice_type,multiple choice,dropdown,checkboxes|array',
    //     ], [
    //         'name.required' => 'The name field is required.',
    //         'choice_type.required' => 'The choice type field is required.',
    //         'choices.required_if' => 'The choices field is required when choice type is not short answer.',
    //         'choices.array' => 'The choices must be an array.',
    //     ]);
    //     $form = Form::where('slug', $slug)->firstOrFail();
    //     $question = new Question($validated);
    //     $question->choices = json_encode($validated['choices']);
    //     $question->form_id = $form->id;

    //     if(isset($request->is_required)){
    //         $question->is_required = $request->is_required;
    //     }else {
    //         $question->is_required = false;
    //     }
    //     $question->save();

    //     return response()->json([
    //         'message' => 'Add question success',
    //         'question' => $question,
    //     ]);

    // }

    public function store(Request $request, $slug)
    {
        $validated = $request->validate([
            'name' => 'required',
            'choice_type' => 'required|in:short answer,paragraph,date,multiple choice,dropdown,checkboxes',
            'choices' => 'required_if:choice_type,multiple choice,dropdown,checkboxes|array',
        ], [
            'name.required' => 'The name field is required.',
            'choice_type.required' => 'The choice type field is required.',
            'choices.required_if' => 'The choices field is required when choice type is not short answer.',
            'choices.array' => 'The choices must be an array.',
        ]);

        $form = Form::where('slug', $slug)->firstOrFail();
        $question = new Question($validated);
        $question->form_id = $form->id;
        $question->is_required = $request->filled('is_required') ? $request->is_required : false;

        if ($request->has('choices')) {
            $question->choices = json_encode($validated['choices']);
        } else {
            $question->choices = json_encode([]); // Set choices to an empty array
        }

        $question->save();

        return response()->json([
            'message' => 'Add question success',
            'question' => $question,
        ]);
    }

    public function destroy(Question $question, $slug)
    {
        $form = Form::where('slug', $slug)->firstOrFail();

        $question->delete();
        return response()->json([
            "message" => "Remove question success"
        ]);
    }
}
