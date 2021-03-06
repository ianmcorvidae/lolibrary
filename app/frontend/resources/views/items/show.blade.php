@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col text-center">
            <h1 class="h3">{{ $item->english_name }}</h3>
            <h4 class="text-muted">{{ $item->foreign_name }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm p-2">
            <img src="{{ $item->image->url }}"
                        onerror="this.src = '{{ asset('images/default.png') }}'"
                        data-original-url="{{ $item->image->url }}"
                        class="rounded mw-100 d-block">
            <div class="row p-0 mx-0 my-3">
                <div class="col p-1 list-group text-center small">
                    <button class="list-group-item" type="button">
                        <i class="fal fa-star"></i> {{ $item->stargazers()->count() }} Stargazers
                    </button>
                </div>
                <div class="col p-1 list-group text-center small">
                    <button class="list-group-item" type="button">
                        <i class="fal fa-users"></i> {{ $item->owners()->count() }} Owners
                    </button>
                </div>
            </div>
        </div>

        <div class="col-sm p-2 px-4">
            <h4 class="mt-2">{{ __('Item Info') }}</h4>
            <div class="text-muted">
                <p class="m-0">
                    @if ($item->year)
                        Released in <span class="text-regular">{{ $item->year }}</span>
                    @else
                        Unknown release year
                    @endif
                </p>

                <p class="m-0">
                    @if ($item->product_number)
                        Product number: <span class="text-regular">{{ $item->product_number }}</span>
                    @else
                        No product number recorded.
                    @endif
                </p>

                <p class="m-0">
                    @if ($item->price)
                        Originally listed for <span class="text-regular">{{ $item->price_formatted }}</span>
                    @else
                        No listing price recorded.
                    @endif
                </p>

                <p class="m-0">
                    @if ($item->submitter)
                        Submitted by <span class="text-regular">{{ $item->submitter->username }}</span>
                    @else
                        Submitted by anonymous
                    @endif
                </p>

                <p class="m-0">
                    @if ($item->published())
                        Published on <time datetime="{{ $item->created_at->toRfc3339String() }}" class="text-regular">{{ $item->created_at->format('jS M Y, H:i') }} UTC</time>
                    @else
                        <span class="text-danger">This is a Draft Post</span>
                    @endif
                </p>
            </div>

            @foreach ($item->attributes as $attribute)
                <h4 class="mt-4">{{ $attribute->name }}</h4>
                <p class="text-muted text-regular">{{ $attribute->pivot->value }}</p>
            @endforeach

            @if ($item->notes)
                <h4 class="mt-4">Notes</h4>
                <p class="text-muted text-regular">{{ $item->notes }}</p>
            @endif

            <h4 class="mt-4">{{ __('Brand') }}</h4>
            <div class="row">
                <div class="list-group col p-1 text-center small">
                    <a class="list-group-item" href="{{ $item->brand->url }}">
                        {{ $item->brand->name }}
                    </a>
                </div>
            </div>

            <h4 class="mt-4">{{ __('Category') }}</h4>
            <div class="row">
                <div class="list-group col p-1 text-center small">
                    <a class="list-group-item" href="{{ $item->category->url }}">
                        {{ $item->category->name }}
                    </a>
                </div>
            </div>

            <h4 class="mt-4">{{ __('Features') }} <i title="Features are things commonly found on an item, e.g. ruffles or elasticated linings." data-toggle="tooltip" class="fal fa-question-circle"></i></h4>
            <div class="row">
                @forelse ($item->features as $feature)
                    <div class="p-1 list-group text-center col-lg-4 col-6 small">
                        <a class="list-group-item" href="{{ $feature->url }}">
                            {{ $feature->name }}
                        </a>
                    </div>
                @empty
                    <p class="col text-muted">No features recorded!</p>
                @endforelse
            </div>

            <h4 class="mt-4">{{ __('Colorways') }}</h4>
            <div class="row">
                @forelse ($item->colors as $color)
                    <div class="p-1 list-group text-center col-lg-4 col-6 small">
                        <a class="list-group-item" href="{{ $color->url }}">
                            {{ $color->name }}
                        </a>
                    </div>
                @empty
                    <p class="col text-muted">No colors recorded!</p>
                @endforelse
            </div>

            <h4 class="mt-4">{{ __('Tags') }}</h4>
            <div class="row">
                @forelse ($item->tags as $tag)
                    <div class="p-1 list-group text-center col-lg-4 col-6 small">
                        <a class="list-group-item" href="{{ $tag->url }}">
                            #{{ $tag->slug }}
                        </a>
                    </div>
                @empty
                    <p class="col text-muted">No tags recorded!</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row">
        <h4 class="my-4 px-4">{{ __('Images') }}</h4>
        <div class="item-image-columns mb-5">
            @foreach ($item->images as $image)
                <a class="card m-0 p-0" href="{{ $image->url }}">
                    <img src="{{ $image->thumbnail_url }}"
                        onerror="this.src = '{{ asset('images/default.png') }}'"
                        data-original-url="{{ $image->url }}"
                        class="mw-100">
                </a>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col col-sm-4 mx-auto m-0 p-0 list-group text-center">
            <a class="list-group-item rounded-0" href="#" onclick="alert('We plan to have item corrections in at some point, but this is just a sneak peek!')">
                Submit a correction
            </a>
            <a class="list-group-item text-danger rounded-0" href="#" onclick="alert('We plan to have item flagging in at some point, but this is just a sneak peek!')">
                Flag item
            </a>
        </div>
    </div>
</div>
@endsection

@section('meta')
    <link rel="canonical" href="{{ $item->url }}">

    <meta property="og:url" content="{{ $item->url }}">
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $item->english_name }} by {{ $item->brand->name }}">
    <meta property="og:image" content="{{ $item->image->thumbnail_url ?? asset('images/default.png') }}">
    <meta property="product:brand" content="{{ $item->brand->name }}">
@endsection
