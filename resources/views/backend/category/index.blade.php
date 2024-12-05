@extends('backend.layouts.master')

{{-- @section('title', $title) --}}

@section('content')

<div class="content">
    <!-- Bảng danh sách danh mục -->
    <div class="category-list">
        <h2>Danh sách danh mục</h2>
        <table>
            <thead>
                <tr>

                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Máy bơm nước</td>
                    <td>may-bom-nuoc</td>
                    <td>
                       <a href="" class="edit"> <i class="fas fa-edit btn-edit" title="Sửa"></i></a>
                       <a href="" class="delete"> <i class="fas fa-trash btn-delete" title="Xóa"></i></a>
                    </td>
                </tr>
                <tr>

                    <td>Máy bơm nước Honda</td>
                    <td>may-bom-nuoc-honda</td>
                    <td>
                        <a href="" class="edit"> <i class="fas fa-edit btn-edit" title="Sửa"></i></a>
                        <a href="" class="delete"> <i class="fas fa-trash btn-delete" title="Xóa"></i></a>
                     </td>
                </tr>
                <tr>
                    <td>Máy bơm nước Koop</td>
                    <td>may-bom-nuoc-koop</td>
                    <td>
                        <a href="" class="edit"> <i class="fas fa-edit btn-edit" title="Sửa"></i></a>
                        <a href="" class="delete"> <i class="fas fa-trash btn-delete" title="Xóa"></i></a>
                     </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<script src="{{ asset('backend/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/table.css') }}" />
@endpush
