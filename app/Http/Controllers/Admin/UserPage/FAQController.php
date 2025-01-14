<?php

namespace App\Http\Controllers\Admin\UserPage;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\Setting;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $title = Setting::where('name', 'title')->where('category', 'faq')->first()->value;
        $faqs = FAQ::all();
        return view('pages.admin.user-page.faq.index', compact('title', 'faqs'));
    }

    public function changeTitle()
    {
        $title = Setting::where('name', 'title')->where('category', 'faq')->first()->value;
        return view('pages.admin.user-page.faq.change-title', compact('title'));
    }

    public function changeTitleUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul tidak boleh lebih dari :max karakter.',
        ]);

        $title = Setting::where('name', 'title')->where('category', 'faq')->first();

        $title->update([
            'value' => $validatedData['title'],
        ]);

    return redirect()->route('dashboard.faq.index')->with('success', 'Berhasil mengubah judul');
    }

    public function addList()
    {
        return view('pages.admin.user-page.faq.add-qna');
    }

    public function addNewList(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ], [
            'question.required' => 'Pertanyaan harus diisi.',
            'question.string' => 'Pertanyaan harus berupa teks.',
            'question.max' => 'Pertanyaan tidak boleh lebih dari :max karakter.',

            'answer.required' => 'answer harus diisi.',
            'answer.string' => 'answer harus berupa teks.',
        ]);

        $list = new FAQ();
        $list->create([
            'question' => $validatedData['question'],
            'answer' => $validatedData['answer'],
        ]);

        return redirect()->route('dashboard.faq.index')->with('success', 'Berhasil manambah qna');
    }

    public function changeList($id)
    {
        $list = FAQ::find($id);
        return view('pages.admin.user-page.faq.change-qna', compact('list'));
    }

    public function changeListUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ], [
            'question.required' => 'Pertanyaan harus diisi.',
            'question.string' => 'Pertanyaan harus berupa teks.',
            'question.max' => 'Pertanyaan tidak boleh lebih dari :max karakter.',

            'answer.required' => 'answer harus diisi.',
            'answer.string' => 'answer harus berupa teks.',
        ]);

        $list = FAQ::find($id);

        $list->update([
            'question' => $validatedData['question'],
            'answer' => $validatedData['answer'],
        ]);

    return redirect()->route('dashboard.faq.index')->with('success', 'Berhasil mengubah qna');
    }

    public function deleteList($id)
    {
        $lists = FAQ::all();
        if($lists->count() <= 1) {
            return redirect()->route('dashboard.faq.index')->with('error', 'Pertanyaan tidak boleh kurang dari 1');
        }

        $list = FAQ::find($id);
        $list->delete();

        return redirect()->route('dashboard.faq.index')->with('success', 'Berhasil menghapus pertanyaan');
    }


}
