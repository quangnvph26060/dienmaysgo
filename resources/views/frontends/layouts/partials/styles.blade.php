<link rel="icon" href="{{ showImage($settings->icon) }}" sizes="32x32" />
<link rel="icon" href="{{ showImage($settings->icon) }}" sizes="192x192" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/styles.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/cookieblocker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/plugins/style.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/wishlist.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/flatsome.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/flatsome-shop.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/themes/style.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/wc-blocks.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/main.css') }}" />
<link rel="stylesheet" href="{{ asset('frontends/assets/css/toastr.min.css') }}">


{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"> --}}
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />

<style>

    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-spinner {
        display: flex;
        gap: 0.5rem;
    }

    .loading-spinner div {
        width: 1rem;
        height: 1rem;
        background-color: #ffffff;
        border-radius: 50%;
        animation: bounce 1.5s infinite;
    }

    .loading-spinner div:nth-child(2) {
        animation-delay: 0.3s;
    }

    .loading-spinner div:nth-child(3) {
        animation-delay: 0.6s;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: scale(0.8);
            opacity: 0.6;
        }

        50% {
            transform: scale(1.2);
            opacity: 1;
        }
    }

    .loading-text {
        margin-top: 1rem;
        font-size: 1.2rem;
        text-align: center;
    }
</style>
@stack('styles')
