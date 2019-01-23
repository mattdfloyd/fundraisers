<?php

namespace App\Http\Controllers;

use App\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FundraiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fundraisers = Fundraiser::orderBy('rating_avg', 'DESC')
            ->orderBy('reviews_count', 'desc')
            ->withCount('reviews')
            ->get();

        return view('fundraisers.index', compact('fundraisers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fundraiser  $fundraiser
     * @return \Illuminate\Http\Response
     */
    public function show(Fundraiser $fundraiser)
    {
        $reviews = $fundraiser->reviews()->orderBy('created_at', 'desc')->get();

        $stars = $reviews->groupBy('rating')->mapWithKeys(function ($rating, $key) use ($reviews) {
            return [$key => 100 * $rating->count() / $reviews->count()];
        });

        return view('fundraisers.show', compact('fundraiser', 'reviews', 'stars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fundraisers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('fundraisers'),
            ],
        ]);

        $fundraiser = Fundraiser::create($validated);

        return redirect()->route('fundraisers.show', $fundraiser);
    }
}
