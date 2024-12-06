@extends('backend.layouts.master')

{{-- @section('title', $title) --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" rel="stylesheet">
@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{ isset($origin) ? route('admin.origin.update', $origin->id) : route('admin.origin.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Danh mục -->
            <h5 class="section-title">Thông tin xuất xứ{{ isset($origin)  ? ' : '.$origin->name : ''}}</h5>
            <div class="mb-3">
                <label for="name" class="form-label">Quốc gia</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Nhập tên danh mục" value="{{ old('name', $origin->name ?? '') }}" />
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="description" class="form-label">Mô tả </label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3"
                    placeholder="Nhập mô tả">{{ old('description', $origin->description ?? '') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Buttons -->
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-danger me-2">Hủy</button>
                <button type="submit" class="btn btn-success">{{ isset($origin) ? 'Cập nhật' : 'Lưu' }}</button>
            </div>
        </form>


    </div>
</div>


@endsection

@push('styles')
<script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<style>
    .cke_notifications_area {
        display: none;
    }

    .error {
        color: red;
    }

    .selectize-control {
        border: 0px !important;
        padding: 0px !important;
    }

    .selectize-input {
        padding: 10px 12px !important;
        border: 2px solid #ebedf2 !important;
        border-radius: 5px !important;
        border-top: 1px solid #ebedf2 !important;
    }

    /* Phần danh mục */
    .section-title {
        font-size: 1.2rem;
        font-weight: bold;
        padding-top: 20px;
        margin-bottom: 15px;
        padding: 10px;
        color: #fff;
        text-align: center;
    }

    .section-title+.section-title {
        color: #FF9800
    }

    .section-title:nth-of-type(1) {
        background-color: #4CAF50;
    }

    /* Nền cam cho SEO */
    .section-title:nth-of-type(2) {
        margin-top: 20px;
        background-color: #695aec;
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .btn {
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editorIds = ['description_short', 'description'];

        editorIds.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                CKEDITOR.replace(id, {
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                        { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ] },
                        { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                        '/',
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', '-', 'Subscript', 'Superscript', '-', 'Strike', 'RemoveFormat' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks', '-' ] },
                        { name: 'about', items: [ 'About' ] }
                    ],
                    extraPlugins: 'font,colorbutton,justify',
                    fontSize_sizes: '11px;12px;13px;14px;15px;16px;18px;20px;22px;24px;26px;28px;30px;32px;34px;36px',
                });
            }
        });
    });
</script>

<script>
    var $jq = jQuery.noConflict();
    $jq(document).ready(function() {
        $jq('#keyword_seo').selectize({
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                };
            },
            plugins: ['remove_button'],
            onKeyDown: function(e) {
                if (e.key === ' ') {
                    e.preventDefault();
                    var value = this.$control_input.val().trim();
                    if (value) {
                        this.addItem(value);
                        this.$control_input.val('');
                    }
                }
            }
        });
    });
</script>
@endpush
