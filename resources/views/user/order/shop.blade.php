@include('user.includes.header')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
        
        <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
            <form action="" method="GET" id="searchForm">
                <div class="input-group">
                    <input type="text" placeholder="Search For Products" class="form-control"
                        aria-label="Amount (to the nearest dollar)" value="{{ Request::get('keyword') }}">
                    <span class="input-group-text">
                        <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                    </span>
                </div>
            </form>
        </div>
    </section>
    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    @if ($categorys->isNotEmpty())
                                        @foreach ($categorys as $key => $category)
                                            @if ($category->status == 1)
                                                <a href="{{ route('usershop', $category->slug) }}">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        @if ($category->subcategory->isNotEmpty())
                                                            <button
                                                                class="accordion-button collapsed {{ $categorySelected == $category->id ? 'text-danger' : '' }}"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne-{{ $key }}"
                                                                aria-expanded="false" aria-controls="collapseOne">
                                                                {{ $category->name }}
                                                            </button>
                                                    </h2>
                                                </a>
                                            @else
                                                <a href="{{ route('usershop', $category->slug) }}"
                                                    class="nav-item- nav-link {{ $categorySelected == $category->id ? 'text-danger' : '' }}">{{ $category->name }}</a>
                                            @endif
                                            @if ($category->subcategory->isNotEmpty())
                                                <div id="collapseOne-{{ $key }}"
                                                    class="accordion-collapse collapse {{ $categorySelected == $category->id ? 'show' : '' }}"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                    style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($category->subcategory as $subcategory)
                                                                <a href="{{ route('usershop', ['categoryslug' => $category->slug, 'subcategoryslug' => $subcategory->slug]) }}"
                                                                    {{-- <a href="/user/shop/{{ $category->slug}}/{{$subcategory->slug}}" --}}
                                                                    class="nav-item nav-link {{ $subcategorySelected == $subcategory->id ? 'text-danger' : '' }}">{{ $subcategory->subcate_name }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    <div id="product-list">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">

                                        <select id="sort" name="sort" class="form-control"
                                            onchange="sortProducts()">
                                            <option value="">---Sort---</option>
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Latest</option>
                                            <option value="price_desc"
                                                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High
                                            </option>
                                            <option value="price_asc"
                                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low
                                            </option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @foreach ($products as $prod)
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <img style="width: 70px; height: 70px;"
                                                src="{{ asset('admin_assets/images/' . $prod->brand->image) }}">
                                            <a href="{{ route('viewproduct', $prod->slug) }}">
                                                <img style="width: 200px; height: 200px; object-fit: contain;"
                                                    class="cardimgtop"
                                                    src="{{ asset('admin_assets/images/' . $prod->image) }}"
                                                    alt="">
                                            </a>
                                            <form method="POST" action="{{ route('user.addToWishlist') }}">
                                                @csrf
                                                <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                                <input type="hidden" name="user_id" value="{{ checkUserLogin() }}" />
                                                <button type="submit" class="whishlist "> <i
                                                        class="far fa-heart"></i></button>
                                            </form>
                                            <div class="product-action">


                                                <form action="{{ route('user.addToCart') }}" method="POST">
                                                    {{-- @dd($product) --}}
                                                    @csrf
                                                    <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                                    <input type="hidden" name="user_id"
                                                        value="{{ checkUserLogin() }}" />
                                                    <input type="hidden" name="qty" value="1" />
                                                    <input type="hidden" name="price" value="{{ $prod->price }}" />
                                                    <input type="hidden" name="name"
                                                        value="{{ $prod->prod_name }}" />
                                                    <input type="hidden" name="image" value="{{ $prod->image }}" />
                                                    <input type="hidden" name="max_qty" value="{{ $prod->qty }}" />
                                                    <button type="submit" class="btn btn-dark"><i
                                                            class="fas fa-shopping-cart"></i> Add To Cart</button>
                                                </form>
                                                {{-- @endif --}}
                                            </div>
                                        </div>

                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link"
                                                href="{{ route('viewproduct', $prod->slug) }}">{{ $prod->prod_name }}</a>

                                            <div class="price mt-2">
                                                <span class="h5"><strong><i class="fa fa-inr" aria-hidden="true">
                                                        </i>
                                                        {{ $prod->price }}</strong></span>
                                                <span
                                                    class="h6 text-underline"><del>{{ $prod->compare_price }}</del></span>
                                                <div class="text-secondary"> InStock:- {{ $prod->qty }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12 pt-5">
                                <nav aria-label="Page navigation example">
                                    {{ $products->appends(['sort' => request('sort')])->onEachSide(1)->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>


<script>
    function sortProducts() {
        var sortValue = document.getElementById('sort').value;
        var url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.href;
    }
</script>
<script>
    $(document).ready(function() {
        $('#sort').on('change', function() {
            var sortValue = $(this).val();
            fetchProducts(1, sortValue);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var sortValue = $('#sort').val();
            fetchProducts(page, sortValue);
        });

        function fetchProducts(page, sort) {
            $.ajax({
                url: '?page=' + page + '&sort=' + sort,
                type: 'GET',
                success: function(data) {
                    $('#product-list').html($(data).find('#product-list').html());
                },
                error: function() {
                    alert('Products could not be loaded.');
                }
            });
        }
    });
</script>
@include('user.includes.footer')
