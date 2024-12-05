<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">

<link rel="icon" href="{{ asset('backend/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
<!-- CSS Files -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css') }}" />

<!-- CSS Just for demo purpose, don't include it in your project -->
<link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />

<style>
    .roboto-thin {
        font-family: "Roboto", serif;
        font-weight: 100;
        font-style: normal;
    }

    .roboto-light {
        font-family: "Roboto", serif;
        font-weight: 300;
        font-style: normal;
    }

    .roboto-regular {
        font-family: "Roboto", serif;
        font-weight: 400;
        font-style: normal;
    }

    .roboto-medium {
        font-family: "Roboto", serif;
        font-weight: 500;
        font-style: normal;
    }

    .roboto-bold {
        font-family: "Roboto", serif;
        font-weight: 700;
        font-style: normal;
    }

    .roboto-black {
        font-family: "Roboto", serif;
        font-weight: 900;
        font-style: normal;
    }

    .roboto-thin-italic {
        font-family: "Roboto", serif;
        font-weight: 100;
        font-style: italic;
    }

    .roboto-light-italic {
        font-family: "Roboto", serif;
        font-weight: 300;
        font-style: italic;
    }

    .roboto-regular-italic {
        font-family: "Roboto", serif;
        font-weight: 400;
        font-style: italic;
    }

    .roboto-medium-italic {
        font-family: "Roboto", serif;
        font-weight: 500;
        font-style: italic;
    }

    .roboto-bold-italic {
        font-family: "Roboto", serif;
        font-weight: 700;
        font-style: italic;
    }

    .roboto-black-italic {
        font-family: "Roboto", serif;
        font-weight: 900;
        font-style: italic;
    }

    .file-input {
        display: none !important;
    }

    .toggle {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 29px;
    }

    .toggle input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input.status-change:checked+.slider {
        background-color: #4CAF50;
    }

    input.status-change:checked+.slider:before {
        transform: translateX(24px);
    }

    .label {
        margin-left: 20px;
        font-size: 18px;
        font-weight: bold;
    }

    .status-input {
        margin-bottom: 20px;
    }

    .status-input label {
        font-weight: bold;
        margin-right: 10px;
    }

    .radio-group {
        display: flex;
        align-items: center;
    }

    .radio-group input[type="radio"] {
        margin-right: 5px;
        accent-color: #007bff;
        /* Màu xanh cho Hoạt động */
    }

    .radio-group label {
        margin-right: 20px;
        font-size: 16px;
    }
</style>

@stack('styles')
