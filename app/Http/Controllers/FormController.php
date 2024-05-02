<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormDetailResource;
use App\Http\Resources\FormResource;
use App\Models\AllowedDomain;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::where('user_id', auth()->id())->get();

        return response()->json([
            'message' => 'Get all forms success',
            'forms' => FormResource::collection($forms),
            // 'forms' => $forms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => [
                'required',
                'unique:forms,slug',
                'regex:/^[a-zA-Z0-9.-]+$/'
            ],
            'allowed_domains' => 'array',
        ]);

        $form = new Form($validated);
        $form->slug = Str::of($validated['slug']);
        $form->user_id = auth()->id();
        $form->save();

        if (isset($validated['allowed_domains'])) {
            $allowedDomain = new AllowedDomain();
            $allowedDomain->domain = json_encode($validated['allowed_domains']);
            $allowedDomain->form_id = $form->id;
            $allowedDomain->save();
        }



        return response()->json([
            'message' => 'success',
            'form' => new FormResource($form),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function detail($slug)
    {
        $form = Form::where('slug', $slug)->with('questions')->firstOrFail();
        return new FormDetailResource($form);

    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Form $form)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Form $form)
    // {
    //     //
    // }
}
