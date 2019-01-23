@extends('layouts.content')

@section('header', 'Review ' . $fundraiser->name)

@section('main')

<form action="{{ route('fundraisers.reviews.store', $fundraiser) }}" method="POST">
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

@endsection
