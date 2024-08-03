@include('user.includes.header')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('userindex')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
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

                    {{-- <div class="sub-title mt-5">

                        <h2>Brand</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @dd($brand)
                            @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input @if(in_array($brand->id, $brandsArray)) checked @endif
                                            class="form-check-input brand-label " type="checkbox" name="brand[]"
                                            value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                        <label class="form-check-label" for="brand-{{ $brand->id }}">
                                            {{ $brand->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div> --}}

                    {{-- <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div> --}}

                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <i class="fa fa-inr" aria-hidden="true"> 0-2000</i>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <i class="fa fa-inr" aria-hidden="true"> 2000-5000</i>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <i class="fa fa-inr" aria-hidden="true"> 5000-10000</i>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <i class="fa fa-inr" aria-hidden="true"> 10000-20000</i>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <i class="fa fa-inr" aria-hidden="true"> 20000-40000</i>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <i class="fa fa-inr" aria-hidden="true"> 40000-80000</i>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value=""
                                    id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    <i class="fa fa-inr" aria-hidden="true"> 80000+</i>
                                </label>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Price High</a>
                                            <a class="dropdown-item" href="#">Price Low</a>
                                        </div>
                                    </div> --}}
                                    <select id="sort" name="sort" class="form-control">
                                        <option value="latest">Latest</option>
                                        <option value="price_desc">Price High</option>
                                        <option value="price_asc">Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        @foreach ($products as $prod)
                            <div class="col-md-4">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('viewproduct', $prod->slug) }}">
                                            <img style="width: 200px; height: 200px; object-fit: contain;"
                                                class="cardimgtop"
                                                src="{{ asset('admin_assets/images/' . $prod->image) }}"
                                                alt="">
                                        </a>
                                        <a class="whishlist" href="#"><i class="far fa-heart"></i></a>

                                        <div class="product-action">
                                            <a class="btn btn-dark" href="#">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
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
                                           <div> Qty:- {{ $prod->qty }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                {{ $products->onEachSide(1)->links() }}
                            </nav>
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
    $(".brand-label").change(function() {
        apply_filters();
    });

    function apply_filters() {
        var brandss = [];

        $(".brand-label").each(function() {
            if ($(this).is(":checked") == true) {
                brandss.push($(this).val());
            }
        });
        console.log(brandss.toString());
        var url = '{{ url()->current() }}?';
       //  window.location.href = url+'&brands='+brandss;
    }

    // $.("#sort").change(function(){
    //     apply_filters();
    // });

    // url+= '&sort='+$("#sort").val()
    // window.location.href = url;
</script>

@include('user.includes.footer')
