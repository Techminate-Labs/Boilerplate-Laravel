//blog
    Route::get('/blogList', [blogController::class, 'blogList']);
    Route::get('/blogGetById/{id}', [blogController::class, 'blogGetById']);
    Route::post('/blogCreate', [blogController::class, 'blogCreate']);
    Route::put('/blogUpdate/{id}', [blogController::class, 'blogUpdate']);
    Route::delete('/blogDelete/{id}', [blogController::class, 'blogDelete']);


$categories = $request->categories;

$products = Product::when($categories, function (Builder $query, $categories) {
    return $query->whereHas('categories', function (Builder $query) use ($categories) {
        $query->whereIn('id', $categories);
    });
})->get();