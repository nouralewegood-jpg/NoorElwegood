<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of portfolio items.
     */
    public function index()
    {
        // only active portfolios
        $portfolios = Portfolio::where('active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('front.portfolio.index', compact('portfolios'));
    }

    /**
     * Display the specified portfolio item.
     */
    public function show($id)
    {
        // retrieve active portfolio by ID
        $portfolio = Portfolio::active()->findOrFail($id);

        // prepare related works
        $relatedWorks = Portfolio::where('category', $portfolio->category)
            ->where('id', '!=', $portfolio->id)
            ->where('active', true)
            ->take(3)
            ->get();

        return view('front.portfolio.show', compact('portfolio', 'relatedWorks'));
    }
}
