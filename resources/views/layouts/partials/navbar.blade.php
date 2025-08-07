<div class="preloader text-white fs-6 text-uppercase overflow-hidden"></div>

<div class="search-popup">
    <div class="search-popup-container">
        <form role="search"
              method="get"
              class="form-group"
              action="{{ route('home') }}">
            <input type="search"
                   id="search-form"
                   class="form-control border-0 border-bottom"
                   placeholder="Type and press enter"
                   value="{{ request('search') }}"
                   name="search" />
            <button type="submit"
                    class="search-submit border-0 position-absolute bg-white"
                    style="top: 15px;right: 15px;">
                <svg class="search"
                     width="24"
                     height="24">
                    <use xlink:href="#search"></use>
                </svg>
            </button>
        </form>
    </div>
</div>
<div class="offcanvas offcanvas-end"
     data-bs-scroll="true"
     tabindex="-1"
     id="offcanvasCart"
     aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span>
                {{-- <span class="badge bg-primary rounded-pill">0</span> --}}
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Growers cider</h6>
                        <small class="text-body-secondary">Brief description</small>
                    </div>
                    <span class="text-body-secondary">$12</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Fresh grapes</h6>
                        <small class="text-body-secondary">Brief description</small>
                    </div>
                    <span class="text-body-secondary">$8</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Heinz tomato ketchup</h6>
                        <small class="text-body-secondary">Brief description</small>
                    </div>
                    <span class="text-body-secondary">$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>$20</strong>
                </li>
            </ul>
            <button id="btnCheckout"
                    class="btn btn-success w-100 mt-3">Checkout</button>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg bg-light text-uppercase fs-6 p-3 border-bottom align-items-center">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center w-100">

            <div class="col-auto">
                <a class="navbar-brand text-white"
                   href="#">
                    <img src="{{ asset('image/logo.png') }}"
                         style="width: 40px; height: 40px;">
                </a>
            </div>

            <div class="col-auto">
                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar"
                        aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end"
                     tabindex="-1"
                     id="offcanvasNavbar"
                     aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title"
                            id="offcanvasNavbarLabel">Menu</h5>
                        <button type="button"
                                class="btn-close text-reset"
                                data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                    </div>

                    <div class="offcanvas-body">

                    </div>
                </div>
            </div>

            <div class="col-3 col-lg-auto">
                <ul class="list-unstyled d-flex m-0 align-items-center">
                    {{-- Nama User dan Avatar --}}
                    <li class="d-none d-lg-flex align-items-center mx-2">
                        <img class="rounded-circle me-2"
                             src="{{ asset('image/pp_admin.png') }}"
                             alt="User Avatar"
                             style="width: 40px; height: 40px;">
                        <span class="text-uppercase fw-bold">
                            Hai, {{ session('user_name', 'Guest') }}
                        </span>
                    </li>

                    {{-- Tracking --}}
                    <li class="d-none d-lg-block mx-3">
                        <a href="#"
                           class="text-uppercase text-decoration-none fw-semibold"
                           id="btnTracking">
                            Tracking
                        </a>
                    </li>

                    {{-- Cart --}}
                    @php
                    $cartCount = session('cart') ? count(session('cart')) : 0;
                    @endphp
                    <li class="d-none d-lg-block mx-3">
                        <a href="#"
                           class="text-uppercase text-decoration-none fw-semibold"
                           data-bs-toggle="offcanvas"
                           data-bs-target="#offcanvasCart"
                           aria-controls="offcanvasCart">
                            Cart <span class="cart-count">({{ $cartCount }})</span>
                        </a>
                    </li>

                    {{-- Logout --}}
                    <li class="d-none d-lg-block mx-3">
                        <a href="{{ route('logout') }}"
                           id="btnLogout"
                           class="text-danger text-decoration-none"
                           title="Logout">
                            <i class="fa fa-sign-out me-1"></i> <span class="d-none d-xl-inline">Sign Out</span>
                        </a>
                    </li>

                    {{-- Tombol Cari --}}
                    <li class="search-box"
                        class="mx-2">
                        <a href="#search"
                           class="btn btn-primary px-3 py-1 rounded-pill shadow-sm search-button"
                           style="font-size: 0.9rem;">
                            🔍 Cari Produk
                        </a>
                    </li>


                    {{-- Mobile Icons --}}
                    <li class="d-lg-none mx-2">
                        <a href="#">
                            <svg width="24"
                                 height="24"
                                 viewBox="0 0 24 24">
                                <use xlink:href="#heart"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="d-lg-none mx-2">
                        <a href="#"
                           data-bs-toggle="offcanvas"
                           data-bs-target="#offcanvasCart"
                           aria-controls="offcanvasCart">
                            <svg width="24"
                                 height="24"
                                 viewBox="0 0 24 24">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</nav>
<!-- Modal -->
<div class="modal fade"
     id="trackingModal"
     tabindex="-1"
     aria-labelledby="trackingModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="trackingModalLabel">Tracking Pesanan</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div id="trackingContent">
                    <p class="text-muted">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    $('#btnTracking').on('click', function (e) {
      e.preventDefault();

      $('#trackingModal').modal('show');

      $('#trackingContent').html('<p class="text-muted">Memuat data...</p>');

      $.ajax({
        url: '/tracking-buyer',
        method: 'GET',
        success: function (data) {
          let html = '';

          if (data.length === 0) {
            html = '<p class="text-muted">Belum ada data pesanan.</p>';
          } else {
            html += '<ul class="list-group">';
            data.forEach(order => {
              html += `
                <li class="list-group-item">
                  <strong>ID Pesanan:</strong> ${order.id} <br>
                  <strong>Status:</strong> ${order.status} <br>
                  <strong>Total:</strong> Rp ${parseInt(order.total_price).toLocaleString('id-ID')} <br>
                  <strong>Tanggal:</strong> ${order.created_at}
                </li>`;
            });
            html += '</ul>';
          }

          $('#trackingContent').html(html);
        },
        error: function () {
          $('#trackingContent').html('<p class="text-danger">Gagal memuat data pesanan.</p>');
        }
      });
    });
  });
</script>