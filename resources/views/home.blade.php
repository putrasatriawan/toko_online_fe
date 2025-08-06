@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section id="billboard"
         class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="section-title text-center mt-4"
                data-aos="fade-up">New Collections</h1>
            <div class="col-md-6 text-center"
                 data-aos="fade-up"
                 data-aos-delay="300">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe voluptas ut dolorum consequuntur,
                    adipisci
                    repellat! Eveniet commodi voluptatem voluptate, eum minima, in suscipit explicabo voluptatibus
                    harum,
                    quibusdam ex repellat eaque!</p>
            </div>
        </div>

    </div>
</section>

<section id="new-arrival"
         class="new-arrival py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
            <h4 class="text-uppercase">Our New Arrivals</h4>
            <a href="{{ url('/products') }}"
               class="btn-link">View All Products</a>
        </div>

        <div class="row">
            @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="product-item image-zoom-effect link-effect">
                    <div class="image-holder position-relative">
                        <a href="#">
                            <img src="{{ $product['image'] }}"
                                 alt="{{ $product['name'] }}"
                                 class="product-image img-fluid"
                                 style="object-fit: cover; width: 100%; height: 250px;">
                        </a>
                        <a href="#"
                           class="btn-icon btn-wishlist">
                            <svg width="24"
                                 height="24"
                                 viewBox="0 0 24 24">
                                <use xlink:href="#heart"></use>
                            </svg>
                        </a>
                        <div class="product-content">
                            <h5 class="text-uppercase fs-5 mt-3">
                                <a href="#">{{ $product['name'] }}</a>
                            </h5>
                            <a href="#"
                               class="text-decoration-none"
                               data-after="Add to cart">
                                <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center text-muted">No products found.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection