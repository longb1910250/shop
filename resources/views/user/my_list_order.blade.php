@extends('welcome')
@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ 'trang-chu' }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Lịch sử mua hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <span>{{ Session('message') }}</span>
        @if (is_array($list_order_detail) && isset($list_order_detail))
            <div class="actions">
                <form method="post" action="{{ URL::to('filter_list_order') }}" class="form-actions">
                    @csrf
                    <select name="actions">
                        <option value="0">Tất cả</option>
                        <option value="Đang chờ xử lý">Đang chờ xử lý</option>
                        <option value="Đang vận chuyện">Đang vận chuyện</option>
                        <option value="Thành công">Giao hàng thành công</option>

                    </select>
                    <input type="submit" name="sm_action" value="Lọc">
                </form>
            </div>
            <div id="wrapper" class="wp-inner clearfix">
                <div class="section" id="info-cart-wp">
                    <div class="section-detail table-responsive">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($list_order_detail as $product)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Mã đơn hàng</td>
                                        <td>Ảnh sản phẩm</td>
                                        <td>Tên sản phẩm</td>
                                        <td>Giá sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td>Thành tiền</td>
                                        <td>Trạng thái đơn hàng</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($product as $item)
                                        <tr>
                                            <td>HCA0{{ $item->order_id }}</td>
                                            <td>
                                                <a href="" title="" class="thumb">
                                                    <img src="{{ URL::to('public/uploads/product') }}/{{ $product_image[$i]->product_image }}"
                                                        alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="" title=""
                                                    class="name-product">{{ $item->product_name }}</a>
                                            </td>
                                            <td> {{ number_format($item->product_price) }}đ</td>
                                            <td>
                                                {{ $item->product_qty }}
                                            </td>
                                            <td> {{ number_format($item->product_price * $item->product_qty) }}đ</td>
                                            <td>{{ $item->order->order_status }}</td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                                <p id="total-price" class="fl-right">Tổng giá:
                                                    {{ number_format($item->order->order_total) }}đ<span></span></p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <div class="clearfix">
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                                </tfoot>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div id="wrapper_2" class="wp-inner clearfix">
                <div class="section" id="info-cart-wp">
                    <div class="section-detail table-responsive">
                        <h1 class="annouce">Bạn chưa mua sắm tại trang web của chúng tôi!!!</h1>
                    </div>
                </div>

            </div>
        @endif



    </div>
@endsection
