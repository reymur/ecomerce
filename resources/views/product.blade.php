@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span><a href="{{ route('shop.index') }}">Shop</a></span>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->name }}</span>
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
            </div>
            <div class="product-section-images">

                @if($product->image && count(json_decode($product->images)) > 1)
{{--                    {{ dd(json_decode($product->images)) }}--}}
                    @foreach(json_decode($product->images) as $image)
                        <div class="product-section-thumbnail selected">
                            <img src="{{ productImage($image) }}" alt="product">
                        </div>
                    @endforeach
                @else
                    <div class="product-section-thumbnail selected">
                        <img src="{{ productImage($product->image) }}" alt="product">
                    </div>
                @endif
            </div>
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->name }}</h1>
            <div class="product-section-subtitle">{{ $product->details }}</div>
{{--            <div>{!! $stockLevel !!}</div>--}}
            <div class="product-section-price">{{ $product->presentPrice() }}</div>

            <p>
                {!! $product->description !!}
            </p>

            <p>&nbsp;</p>

            <form action="{{ route('cart.store') }}" method="POST">
                @csrf()
                <input type="text" name="id" value="{{ $product->id }}">
                <input type="text" name="name" value="{{ $product->name }}">
                <input type="text" name="price" value="{{ $product->price }}">
                <button type="submit" class="button button-plain">Add to Cart</button>
            </form>

        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')

@endsection

@section('extra-js')
    <script>
        (function(){
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click', thumbnailClick));

            function thumbnailClick(e) {
                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })

                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }

        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
