<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $faqs = FAQ::when($search, function ($query, $search) {
            $query->where('question', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('Backend.faqs.lists', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Backend.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'faq_publish_status' => 'nullable|boolean',
        ]);

        try {
            FAQ::create([
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'faq_publish_status' => $request->input('faq_publish_status', false),
            ]);

            return redirect()->route('faqs.index')->with('success', 'FAQ created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(FAQ $fAQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq)
    {
        return view('Backend.faqs.create', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQ $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'faq_publish_status' => 'nullable|boolean',
        ]);

        try {
            $faq->update([
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'faq_publish_status' => $request->input('faq_publish_status', false),
            ]);

            return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $faq = FAQ::onlyTrashed()->findOrFail($id);
            $faq->forceDelete();

            return redirect()->back()->with('success', 'FAQ deleted permanently.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
        /**
     * Publish the FAQ.
     */
    public function publish(Request $request, $id)
    {
        try {
            // Manually validating the incoming request
            $validatedData = $request->validate([
                'faq_publish_status' => 'required|in:1,0',
            ]);

            // Find faq or fail
            $faq = FAQ::findOrFail($id);

            // Update the publish status
            $faq->faq_publish_status = $request->faq_publish_status;
            $faq->save();



            return redirect()->route('faqs.index')->with('success', 'faq published successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle the validation failure case
            $errors = implode(', ', array_map(function ($error) {
                return implode(', ', $error);
            }, $e->errors())); // Convert errors array to a string


            // Redirect back with the error notification and input
            return redirect()->back()->with('error', $errors)->withInput();

        } catch (\Exception $e) {
            // General exception handling
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Unpublish the FAQ.
     */
    public function unpublish(Request $request, $id)
    {
        $request->validate([
            'faq_publish_status' => 'required|in:1,0',
        ]);

        try {
            $faq = FAQ::findOrFail($id);
            $faq->faq_publish_status = $request->faq_publish_status;
            $faq->save();

            return redirect()->route('faqs.index', $faq->id)->with('success', 'FAQ unpublished successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function trashDelete(Request $request,$id)
    {
        try {
            $faq = FAQ::findOrFail($id);
            $faq->delete();

            return redirect()->route('faqs.index')->with('success', 'FAQ moved to trash successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Display trashed FAQs.
     */
    public function trashView(Request $request)
    {
        $search = $request->input('search');

        $faqs_trash = FAQ::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where('question', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('Backend.faqs.trash_view', compact('faqs_trash'));
    }
/**
     * Restore a trashed FAQ.
     */
    public function restore(Request $request, $id)
    {
        try {
            $faq = FAQ::onlyTrashed()->findOrFail($id);
            $faq->restore();

            return redirect()->route('faqs.index')->with('success', 'FAQ restored successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
