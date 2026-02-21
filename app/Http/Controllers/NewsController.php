<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Метод для списка новостей
    public function index()
    {
        // Берём только опубликованные новости, сортируем по дате
        $news = \App\Models\News::published()
            ->latest('published_at')
            ->paginate(9); // По 9 штук на страницу

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Показать форму создания новости (только для организатора)
    public function create()
    {
        // Проверка прав
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Доступ запрещён');
        }

        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Сохранить новую новость
    public function store(\Illuminate\Http\Request $request)
    {
        // Проверка прав
        if (!auth()->user()->hasRole('organizer')) {
            abort(403, 'Доступ запрещён');
        }

        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048', // до 2МБ
        ]);

        // Загрузка изображения (если есть)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        // Создаём новость
        \App\Models\News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author_id' => auth()->id(),
            'is_published' => true,
            'published_at' => now(),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('news.index')
            ->with('success', '✅ Новость успешно опубликована!');
    }

    /**
     * Display the specified resource.
     */
    // Метод для просмотра одной новости
    public function show(\App\Models\News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
