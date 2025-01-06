<div id="gom-all-in-one">
    <!-- v3 -->

    <!-- zalo -->
    <div id="zalo-vr" class="button-contact">
        <div class="phone-vr">
            <div class="phone-vr-circle-fill"></div>
            <div class="phone-vr-img-circle">
                <a target="_blank" href="https://zalo.me/{{ $settings->zalo_number }}">
                    <img alt="Zalo" src="{{ asset('frontends/assets/image/zalo.png') }}" />
                </a>
            </div>
        </div>
    </div>
    <!-- end zalo -->

    <!-- Phone -->
    <div id="phone-vr" class="button-contact">
        <div class="phone-vr">
            <div class="phone-vr-circle-fill"></div>
            <div class="phone-vr-img-circle">
                <a href="tel:{{ $settings->phone }}">
                    <img alt="Phone" src="{{ asset('frontends/assets/image/phone.png') }}" />
                </a>
            </div>
        </div>
    </div>
    <!-- end phone -->
</div>
