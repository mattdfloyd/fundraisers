<?php

namespace App\Http\Controllers;

use App\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FundraiserReviewsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fundraiser  $fundraiser
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Fundraiser $fundraiser)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'rating' => 'required|int|min:1|max:5',
        ]);

        if ($fundraiser->reviews()->where('email', $request->input('email'))->count()) {
            throw ValidationException::withMessages([
                'email' => 'Reviewers cannot enter more than one review for the same fundraiser.',
            ]);
        }

        $fundraiser->reviews()->create($validated + [
            'comment' => $request->input('comment') ?? '',
        ]);

        return redirect()->route('fundraisers.index');
    }
}
