<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\CreateCommentRequest;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Store comment/review for product
     *
     * @param CreateCommentRequest $request
     * @param $categories
     * @param $productSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCommentRequest $request, $categories, $productSlug)
    {
        // Get reviewed product
        $product = Product::getProductByUrl($categories, $productSlug);

        if ($product) {
            // $user = Auth::user();
            $user = User::find(3);
            $user->comment($product, $request->message, $request->rating ?: false);

            session()->flash('success', 'Uspešno ostavljen utisak, čeka se na odobrenje.');
            return response()->json('Successfully');
        }
    }
}
