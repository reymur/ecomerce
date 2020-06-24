<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CSS Grid Example</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    </head>
    <body>

        <header>
            <div class="top-nav container">
                <div class="logo">CSS Grid Example</div>
                <ul>
                    <li><a href="{{ route('shop.index') }}">Shop</a>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Blog</a></li>
                    <li>
                        <a href="{{ route('cart.index') }}">
                            Cart @if(Cart::instance('default')->count() > 0)
                                     <span class="cart-count">{{ Cart::instance('default')->count() }}</span>
                                 @endif
                        </a>
                    </li>
                </ul>
            </div> <!--end top nav-->

            <div class="hero container">
                <div class="hero-copy">
                    <h1>CSS Grid Example</h1>
                    <p>CSS Grid Example practicals learn for me...</p>
                    <div class="hero-buttons">
                        <button class="button button-white">Button 1</button>
                        <button class="button button-white">Button 2</button>
                    </div>
                </div> <!--end hero copy-->

                <div class="hero-image">
                    <img src="img/macbook-pro-laravel.png" alt="hero image">
                </div>
            </div> <!--end hero-->
        </header>

        <div class="featured-section">
            <div class="container">
                <h1 class="text-center">CSS Grid Example</h1>
                <p class="section-description">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Asperiores harum neque quis repudiandae sed tempore ut veniam. Accusantium blanditiis
                    consectetur consequatur cum distinctio esse, magnam praesentium provident quasi quis
                    temporibus!
                </p>
                <div class="text-center button-container">
                    <a href="https://youtube.com" class="button">Featured</a>
                    <a href="https://yandex.ru" target="_blank" class="button">On Sale</a>
                </div>

                <div class="products text-center">
                    @foreach($products as $product)
                        <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}"><img src="{{ asset('img/products/'.$product->slug.'.jpg') }}" alt="product"></a>
                        <a href="{{ route('shop.show', $product->slug) }}"><span class="product-name">{{ $product->name ?? '' }}</span></a>
                        <div class="product-price">{{ $product->presentPrice() ?? ''}}</div>
                    </div>
                    @endforeach
                </div> <!--end products-->

                <div class="text-center button-center">
                    <a href="{{ route('shop.index') }}" class="button">View more products...</a>
                </div>
            </div> <!--end container-->
        </div> <!--end fetured section-->

        <div class="blog-section">
            <div class="container">
                <h1 class="text-center">From our blog</h1>
                <p class="section-description   ">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate delectus dolor doloremque
                    dolores, ducimus enim eos eveniet hic id laudantium libero obcaecati officia officiis porro quaerat,
                    rerum tenetur veritatis?
                </p>
                <div class="blog-posts">
                    <div class="blog-post">
                        <a href="#"><img src="img/blog1.png" alt=""></a>
                        <a href="#"><h2>Blog post title 1</h2></a>
                        <div class="blog-description">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam
                            at corporis cumque doloribus enim eum ipsa ipsum laborum natus perferendis provident quae
                            quaerat quibusdam repellendus saepe temporibus, tenetur, velit voluptates.
                        </div>
                    </div>
                    <div class="blog-post">
                        <a href="#"><img src="img/blog1.png" alt=""></a>
                        <a href="#"><h2>Blog post title 1</h2></a>
                        <div class="blog-description">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam
                            at corporis cumque doloribus enim eum ipsa ipsum laborum natus perferendis provident quae
                            quaerat quibusdam repellendus saepe temporibus, tenetur, velit voluptates.
                        </div>
                    </div>
                    <div class="blog-post">
                        <a href="#"><img src="img/blog1.png" alt=""></a>
                        <a href="#"><h2>Blog post title 1</h2></a>
                        <div class="blog-description">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam
                            at corporis cumque doloribus enim eum ipsa ipsum laborum natus perferendis provident quae
                            quaerat quibusdam repellendus saepe temporibus, tenetur, velit voluptates.
                        </div>
                    </div>
                </div> <!--end blog-posts-->
            </div> <!--end-container-->
        </div> <!--end blog-section-->

        <footer>
            <div class="footer-content container">
                <div class="made-with">Made with <i class="fa fa-heart">by Teymur Orucov</i></div>
                <ul>
                    <li>Follow me:</li>
                    <li><a href="#"><i class="fa fa-globe"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa fa-github"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                </ul>
            </div> <!--footer-content-->
        </footer>

    </body>
</html>
