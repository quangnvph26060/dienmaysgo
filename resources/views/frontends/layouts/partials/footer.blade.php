<section class="section dark" id="section_1854166680">
    <div class="bg section-bg fill bg-fill bg-loaded">
        <div class="section-bg-overlay absolute fill"></div>
    </div>

    <div class="section-content relative">
        <div class="row row-small" id="row-872954512">
            <div id="col-88304985" class="col medium-5 small-12 large-5">
                <div class="col-inner">
                    <h3>LIÊN HỆ VỚI CHÚNG TÔI</h3>
                    <ul class="info-list">
                        <li>
                            <i class="fa fa-angle-right"></i>
                            <span style="font-size: 90%"><strong>{{ $settings->company_name ?? '' }}</strong></span>
                        </li>
                        <li>
                            <i class="fa fa-angle-right"></i>
                            <span style="font-size: 90%">Địa chỉ: {{ $settings->address ?? '' }}</span>
                        </li>
                        <li>
                            <i class="fa fa-angle-right"></i>
                            <span style="font-size: 90%">Kho hàng: {{ $settings->warehouse ?? '' }}</span>
                        </li>
                        <li>
                            <i class="fa fa-angle-right"></i>
                            <span style="font-size: 90%">Điện thoại: {{ $settings->phone ?? '' }}
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-angle-right"></i>
                            <span style="font-size: 90%">MST: {{ $settings->tax_code ?? '' }}</span>
                        </li>
                        <li>
                            <i class="fa fa-angle-right"></i>
                            <span style="font-size: 90%">Email: {{ $settings->email ?? '' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div id="col-4684101" class="col medium-4 small-12 large-4">
                <div class="col-inner">
                    <div class="bg-ft">
                        <h3 class="heading">HỖ TRỢ KHÁCH HÀNG</h3>
                        <div class="bg-ft">
                            <?php
                            $lishhome = \App\Models\SgoHome::get();
                            // dd($lishhome)
                            ?>
                            <ul class="list-mn">
                                @forelse ($lishhome as $item)
                                    <li>
                                        <span style="font-size: 90%"><a
                                                href="{{ route('introduce', ['slug' => $item->slug]) }}">
                                                {{ $item->name }}
                                            </a></span>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="col-970340967" class="col cot4 medium-3 small-12 large-3">
                <div class="col-inner">
                    <h3>KẾT NỐI VỚI CHÚNG TÔI</h3>
                    <div class="social-icons follow-icons full-width text-left social-icons">
                        <a href="{{ $settings->link_fb ?? '' }}" target="_blank" data-label="Facebook"
                            rel="noopener noreferrer nofollow" class="icon primary button circle facebook tooltip"
                            title="Follow on Facebook" aria-label="Follow on Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>

                        <a href="{{ $settings->link_ig ?? '' }}" target="_blank" rel="noopener noreferrer nofollow"
                            data-label="Instagram" class="icon primary button circle instagram tooltip"
                            title="Follow on Instagram" aria-label="Follow on Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="mailto:{{ $settings->email }}" data-label="E-mail" rel="nofollow"
                            class="icon primary button circle email tooltip" title="Send us an email"
                            aria-label="Send us an email">
                            <i class="fas fa-envelope"></i>
                        </a>

                        <a href="tel:{{ $settings->phone }}" target="_blank" data-label="Phone"
                            rel="noopener noreferrer nofollow" class="icon primary button circle phone tooltip"
                            title="Call us" aria-label="Call us">
                            <i class="fas fa-phone-square-alt"></i>
                        </a>

                    </div>

                    <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1190465660">
                        <a class="" href="http://online.gov.vn/Home/WebDetails/104877">
                            <div class="img-inner dark">
                                <img width="600" height="227"
                                    src="{{ asset('frontends/assets/image/logoSaleNoti.png') }}"
                                    class="attachment-large size-large" alt="" decoding="async" loading="lazy"
                                    srcset="
                {{ asset('frontends/assets/image/logoSaleNoti.png') }}       600w,
                {{ asset('frontends/assets/image/logoSaleNoti-300x114.png') }} 300w
              "
                                    sizes="auto, (max-width: 600px) 100vw, 600px" />
                            </div>
                        </a>
                        <style>
                            #image_1190465660 {
                                width: 48%;
                                margin-top: 10px;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #section_1854166680 {
            padding-top: 42px;
            padding-bottom: 42px;
            background-color: #1e73be;
        }

        #section_1854166680 .section-bg-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }

        #section_1854166680 .ux-shape-divider--top svg {
            height: 150px;
            --divider-top-width: 100%;
        }

        #section_1854166680 .ux-shape-divider--bottom svg {
            height: 150px;
            --divider-width: 100%;
        }
    </style>
</section>

<div class="absolute-footer light medium-text-center small-text-center">
    <div class="container clearfix" style="text-align: center">
        <div class="footer-primary ">
            <div class="copyright-footer">
                {{ $settings->copyright ?? '' }}
            </div>
        </div>
    </div>
</div>
