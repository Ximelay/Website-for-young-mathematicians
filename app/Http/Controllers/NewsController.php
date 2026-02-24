<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        // Только организатор может управлять новостями; index и show — публичные
        $this->middleware(['auth', 'role:organizer'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    // Метод для списка новостей
    public function index()
    {
        // Берём только опубликованные новости, сортируем по дате
        $news = News::published()
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
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // Сохранить новую новость
    public function store(Request $request)
    {
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

        // slug генерируется в boot() модели; уникальность обеспечиваем здесь
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $i = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        // Создаём новость
        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => $slug,
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
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Показать форму редактирования (только для организатора)
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Обновить новость (только для организатора)
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        // Загрузка нового изображения (если есть)
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        // Убираем 'image' (объект UploadedFile) — он не нужен модели
        unset($validated['image']);

        $news->update($validated);

        return redirect()->route('news.show', $news)
            ->with('success', '✅ Новость успешно обновлена!');
    }


    /**
     * Remove the specified resource from storage.
     */
    // Удалить новость (только для организатора)
    public function destroy(News $news)
    {
        // Удаляем изображение если есть
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', '🗑️ Новость удалена');
    }
}
