<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Список материалов
     */
    public function index()
    {
        $materials = Material::with('uploader')
            ->latest()
            ->paginate(15);

        return view('materials.index', compact('materials'));
    }

    /**
     * Форма загрузки материала
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Сохранение материала
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:10240', // до 10MB
            'is_published' => 'boolean',
        ]);

        // Загрузка файла
        $filePath = $request->file('file')->store('materials', 'public');

        Material::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
            'file_size' => $request->file('file')->getSize(),
            'uploaded_by' => auth()->id(),
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return redirect()->route('materials.index')
            ->with('success', '✅ Материал успешно загружен!');
    }

    /**
     * Скачивание материала
     */
    public function download(Material $material)
    {
        return Storage::disk('public')->download($material->file_path);
    }

    /**
     * Удаление материала
     */
    public function destroy(Material $material)
    {
        Storage::disk('public')->delete($material->file_path);
        $material->delete();

        return back()->with('success', '🗑️ Материал удалён');
    }
}
