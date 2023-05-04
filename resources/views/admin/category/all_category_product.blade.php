@extends('admin.layout.layout')
@section('content')
    <div id="content" class="fl-right">
        <div class="section" id="title-page">
            <div class="clearfix">
                <h3 id="index" class="fl-left">Danh sách danh mục</h3>
                <a href="{{ URL::to('add_category_product') }}" title="" id="add-new" class="fl-left">Thêm mới</a>
            </div>



        </div>
        <div class="section" id="detail-page">
            <div class="section-detail">
                <div class="filter-wp clearfix">
                    <ul class="post-status fl-left">
                        <li class="all"><a href="">Tất cả <span class="count">({{ $count }})</span></a>
                        </li>
                    </ul>
                    <form method="get" action="{{ URL::to('search_category') }}" class="form-s fl-right">
                        {{-- @csrf --}}
                        <input type="text" name="key" id="search_admin" class="search_admin" placeholder="">
                        <input type="submit" name="sm_s" value="Tìm kiếm" class="search_admin">
                    </form>
                </div>
                <div class="actions">
                    <form method="get" action="{{ URL::to('filter_status_category') }}" class="form-actions">
                        {{-- @csrf --}}
                        <select name="actions">
                            <option value="">Trạng thái</option>
                            <option value="1">Kích hoạt</option>
                            <option value="0">Không kích hoạt</option>

                        </select>
                        <input type="submit" name="sm_action" value="Áp dụng">
                    </form>
                </div>
                @if (Session::get('message'))
                    <span class="text-success mr-5">{{ Session::get('message') }}</span>
                @endif
                <div class="table-responsive">
                    <table class="table list-table-wp">
                        <thead>
                            <tr>
                                <td><input type="checkbox" name="checkAll" id="checkAll"></td>

                                <td><span class="thead-text">Tiêu đề</span></td>
                                <td><span class="thead-text"></span></td>
                                <td><span class="thead-text">Trạng thái</span></td>
                                <td><span class="thead-text">Người tạo</span></td>
                                <td><span class="thead-text">Thời gian</span></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_category_product as $category)
                                <tr>
                                    <td><input type="checkbox" name="checkItem" class="checkItem"></td>

                                    <td class="clearfix">
                                        <div class="tb-title fl-left">
                                            <a href="" title="">{{ $category->category_name }}</a>
                                        </div>
                                        <ul class="list-operation fl-right">
                                            <li><a href="{{ URL::to('update_category') }}/{{ $category->id }}"
                                                    title="Sửa" class="edit"><i class="fa fa-pencil"
                                                        aria-hidden="true"></i></a></li>
                                            <li><a onclick="return confirm('Bạn có muốn xoá {{ $category->category_name }}?')"
                                                    href="{{ URL::to('delete_category') }}/{{ $category->id }}"
                                                    title="Xóa" class="delete"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                    <td><span class="tbody-text">{{ $category->category_parent }}</span></td>
                                    {{-- <td><span class="tbody-text">Hoạt động</span></td> --}}
                                    <td><span class="tbody-text">
                                            @if ($category->category_status == 0)
                                                <a href="{{ URL::to('unactive_category_product') }}/{{ $category->id }}"
                                                    class="unact"><span class="fa fa-thumbs-down fa-thumbs"></span></a>
                                            @else
                                                <a href="{{ URL::to('active_category_product') }}/{{ $category->id }}"
                                                    class="act"><span class="fa fa-thumbs-up fa-thumbs"></span></a>
                                            @endif
                                        </span></td>
                                    <td><span class="tbody-text">{{ $category->category_by }}</span></td>
                                    <td><span class="tbody-text">{{ $category->created_at }}</span></td>
                                </tr>
                            @endforeach


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        @if (isset($_GET['key']))
            {{ $all_category_product->appends(['key' => $_GET['key']])->links('/vendor/pagination/bootstrap-4') }}
        @elseif (isset($_GET['actions']))
            {{ $all_category_product->appends(['actions' => $_GET['actions']])->links('/vendor/pagination/bootstrap-4') }}
        @else
            {{ $all_category_product->links('/vendor/pagination/bootstrap-4') }}
        @endif

    </div>
@endsection
