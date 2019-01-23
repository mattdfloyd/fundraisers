@extends('layouts.content')

@section('header')
    <div class="d-flex align-items-center">
        Fundraisers
        <div class="ml-auto">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('fundraisers.create') }}">Add a fundraiser</a>
        </div>
    </div>
@endsection

@section('main')

<table class="table">
    @foreach ($fundraisers as $fundraiser)
        <tr>
            <th>
                <a href="{{ route('fundraisers.show', $fundraiser) }}">{{ $fundraiser->name }}</a>
            </th>
            <td>
                {{ $fundraiser->rating_avg }} stars &middot;
                {{ $fundraiser->reviews_count }} reviews</td>
            <td style="font-size: .875rem"><a href="{{ route('fundraisers.show', [$fundraiser, '#review']) }}">review</a></td>
        </tr>
    @endforeach
</table>

@endsection
