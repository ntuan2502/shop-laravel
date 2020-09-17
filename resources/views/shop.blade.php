@extends('layouts.app')
@section('css')

@endsection

@section('body')

    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ route('index') }}"><i class="fa fa-home"></i> Home</a>
                        @if ($currentShop)
                            <a href="{{ route('shop.index') }}">Shop</a>
                            <span>{{ $currentShop->name ?? '' }}</span>
                        @else
                            <span>Shop</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    @include('layouts.menu-left')
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-show-option">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="select-option">
                                    <select class="sorting">
                                        <option value="">Default Sorting</option>
                                    </select>
                                    <select class="p-show">
                                        <option value="">Show:</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 text-right">
                                <p>Show {{$products->firstItem()}} - {{$products->lastItem()}} Of {{ $products->total() }} Product</p>
                            </div>
                        </div>
                    </div>
                    <div class="product-list">
                        <div class="row">
                            @foreach ($products as $key => $product)
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product-item">
                                        <div class="pi-pic">
                                            <img src="{{ asset('assets/img/products/product-1.jpg') }}" alt="">
                                            <div class="sale pp-sale">Sale</div>
                                            <div class="icon">
                                                <i class="icon_heart_alt"></i>
                                            </div>
                                            <ul>
                                                <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                                                <li class="quick-view"><a href="#">+ Quick View</a></li>
                                                <li class="w-icon"><a href="#"><i class="fa fa-random"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="pi-text">
                                            <div class="catagory-name">Towel</div>
                                            <a href="{{ route('shop.show', $product->slug) }}">
                                                <h5>{{ $product->name }}</h5>
                                            </a>
                                            <div class="product-price">
                                                {{ $product->vnd_price }}
                                                <span>{{ $product->vnd_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $products->withQueryString()->links() }}
                    {{-- <div class="loading-more">
                        <i class="icon_loading"></i>
                        <a href="#">
                            Loading More
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- Product Shop Section End -->

@endsection

@section('js')

@endsection
