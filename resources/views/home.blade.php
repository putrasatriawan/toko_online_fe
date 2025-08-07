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

<!-- Modal -->
<div class="modal fade"
     id="productDetailModal"
     tabindex="-1"
     aria-labelledby="productDetailLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="productDetailLabel">Detail Produk</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="detailImage"
                             src=""
                             class="img-fluid"
                             alt="Gambar Produk">
                    </div>
                    <div class="col-md-6">
                        <h4 id="detailName"></h4>
                        <p class="text-muted fw-bold">Harga: <span id="detailPrice"></span></p>
                        <p id="detailDescription"
                           class="mt-3"></p> <!-- Tambahan deskripsi -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Section -->
<section id="new-arrival"
         class="new-arrival py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
            <h4 class="text-uppercase">Our New Arrivals</h4>

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
                           class="btn-icon btn-wishlist btn-view-detail"
                           data-name="{{ $product['name'] }}"
                           data-description="{{ $product['description'] }}"
                           data-price="{{ number_format($product['price'], 0, ',', '.') }}"
                           data-image="{{ $product['image'] }}">

                            <svg width="16px"
                                 height="16px"
                                 viewBox="0 0 16 16"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor"
                                 class="bi bi-eye">
                                <path
                                      d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                <path
                                      d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                            </svg>
                        </a>
                        <div class="product-content">
                            <h5 class="text-uppercase fs-5 mt-3">
                                <a href="#">{{ $product['name'] }}</a>
                            </h5>
                            <button class="btn btn-sm btn-outline-dark mt-2 add-to-cart"
                                    data-id="{{ $product['id'] }}"
                                    data-name="{{ $product['name'] }}"
                                    data-price="{{ $product['price'] }}"
                                    data-image="{{ $product['image'] }}">
                                Add to Cart
                            </button>
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

<script src="js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {
    $(document).on('click', '.btn-view-detail', function () {
      const name = $(this).data('name');
      const price = $(this).data('price');
      const image = $(this).data('image');
      const description = $(this).data('description');

      $('#detailName').text(name);
      $('#detailPrice').text('Rp ' + price);
      $('#detailImage').attr('src', image);
      $('#detailDescription').text(description);

      $('#productDetailModal').modal('show');
    });
  });
</script>
<script>
    $(document).ready(function () {
        // Add to cart
        $('.add-to-cart').on('click', function () {
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    price: $(this).data('price'),
                    image: $(this).data('image')
                },
                success: function (response) {
                    updateCartUI(response.cart);
                }
            });
        });

        // Get initial cart
        $.get('{{ route("cart.get") }}', function (response) {
            updateCartUI(response.cart);
        });

        // Update cart UI
        function updateCartUI(cart) {
            let cartList = '';
            let total = 0;
            let qty = 0;

            $.each(cart, function (key, item) {
                total += item.price * item.qty;
                qty += item.qty;

                cartList += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="my-0">${item.name}</h6>
                            <div class="input-group input-group-sm mt-1" style="max-width:120px;">
                                <button class="btn btn-outline-secondary btn-minus" data-id="${item.id}">−</button>
                                <input type="text" class="form-control text-center" value="${item.qty}" readonly>
                                <button class="btn btn-outline-secondary btn-plus" data-id="${item.id}">+</button>
                            </div>
                        </div>
                        <span class="text-body-secondary">Rp${(item.price * item.qty).toLocaleString('id-ID')}</span>
                    </li>`;
            });

            cartList += `
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total</span>
                    <strong>Rp${total.toLocaleString('id-ID')}</strong>
                </li>`;

            $('.offcanvas-body ul.list-group').html(cartList);
            $('.cart-count').text(`(${qty})`);
        }

        // Handler plus/minus after rendering
        $(document).on('click', '.btn-plus', function () {
            const id = $(this).data('id');
            updateQty(id, 1);
        });

        $(document).on('click', '.btn-minus', function () {
            const id = $(this).data('id');
            updateQty(id, -1);
        });

        function updateQty(id, change) {
            $.ajax({
                url: '{{ route("cart.updateQty") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    change: change
                },
                success: function (response) {
                    updateCartUI(response.cart);
                }
            });
        }
        $(document).on('click', '#btnCheckout', function () {
            $.get('{{ route("cart.get") }}', function (response) {
                const cart = response.cart;
                const items = [];

                // Ubah data keranjang ke format yang sesuai untuk checkout
                $.each(cart, function (key, item) {
                    items.push({
                        product_id: item.id,
                        qty: item.qty
                    });
                });

                // Cek apakah keranjang kosong
                if (items.length === 0) {
                    toastr.warning('Keranjang kosong!');
                    return;
                }

                // Kirim data ke server untuk proses checkout
                $.ajax({
                    url: '{{ route("checkout.submit") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: items
                    },
                    success: function (res) {
                        toastr.success(res.message || 'Checkout berhasil!');
                        updateCartUI({});
                    },
                    error: function (err) {
                        const message = err.responseJSON?.message || 'Checkout gagal!';
                        toastr.error(message);
                        console.error(err);
                    }
                });
            });
        });
    });
</script>