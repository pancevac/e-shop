<?php

// Home
\Breadcrumbs::for('home', function ($trail) {
    $trail->push('home', route('home'));
});

// Login page
\Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Prijava', route('login'));
});
// Register page
\Breadcrumbs::for('register', function ($trail) {
    $trail->parent('home');
    $trail->push('Registracija', route('register'));
});
\Breadcrumbs::for('verification', function ($trail) {
    $trail->parent('home');
    $trail->push('Verifikacija', route('verification.notice'));
});

// Shopping cart and wish-list
\Breadcrumbs::for('shopping-cart', function ($trail) {
    $trail->parent('home');
    $trail->push('Korpa', route('shopping-cart.index'));
});
\Breadcrumbs::for('wish-list', function ($trail) {
    $trail->parent('home');
    $trail->push('Lista želja', route('wishList'));
});

// Shop category
\Breadcrumbs::for('category', function ($trail, $category) {

    if ($category->parentRecursive) {
        $trail->parent('category', $category->parentRecursive);
    } else {
        $trail->parent('home');
    }

    $trail->push($category->title, $category->getUrl(), ['image' => $category->image]);
});

// Product
\Breadcrumbs::for('product', function ($trail, $product) {

    $trail->parent('category', $product->categories->sortByDesc('level')->first());
    $trail->push($product->title, $product->getLink());
});