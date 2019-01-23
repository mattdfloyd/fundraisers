@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="mb-5">
                <h1>{{ $fundraiser->name }}</h2>
                <p><i>Added on {{ $fundraiser->created_at->toDayDateTimeString() }}</i></p>
            </div>

            <div class="mb-3">
                <h4>Ratings & Reviews</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-baseline">
                            <span style="font-weight: 500" class="mr-auto">
                                <strong style="font-size: 3rem; font-weight: 600">{{ $fundraiser->rating_avg }}</strong> out of 5
                            </span>
                            {{ $reviews->count() }} Ratings
                        </div>
                    </div>

                    <div class="col-md-6">
                        <table>
                            @foreach (range(5, 1) as $rating)
                            <tr>
                                <th class="pr-2" style="font-size: 7px; text-align:right">{!! str_repeat("&starf;", $rating) !!}</th>
                                <td class="w-100" style="vertical-align: middle">
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar bg-dark" style="width: {{ $stars[$rating] ?? 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>


            <div class="row mx-n1 mb-5">
                @foreach ($reviews as $review)
                    <div class="col-md-6 pb-2 px-1 d-flex">
                        <div class="bg-light rounded p-2 d-flex flex-column w-100">
                            <h6>{{ $review->name }}</h6>
                            <p style="font-size: 12px" class="text-primary">{!! str_repeat("&starf;", $review->rating) !!}</p>
                            <p style="font-size: .875rem">{!! nl2br($review->comment) !!}</p>
                            <span class="text-muted mt-auto" style="font-size: .75rem">{{ $review->created_at->toDayDateTimeString() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card shadow-sm" id="review">
                <div class="card-header">Add a review</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('fundraisers.reviews.store', [$fundraiser, '#review']) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" >

                            @if ($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <fieldset class="form-group">
                            <legend style="font-size: inherit">Rating</legend>
                            @foreach (range(1,5) as $option)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input {{ $errors->has('rating') ? 'is-invalid' : '' }}" type="radio" name="rating" id="{{ $option }}" value="{{ $option }}" {{ $option == old('rating') ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ $option }}">
                                        {!! str_repeat("&starf;", $option) !!}
                                    </label>
                                </div>
                            @endforeach

                            @if ($errors->has('rating'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('rating') }}
                                </div>
                            @endif
                        </fieldset>

                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" name="comment" id="comment" rows="3">{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






@endsection
