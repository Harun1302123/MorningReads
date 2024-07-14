<section class="home-banner-sec mt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="home-banner-slider">
                    <div id="carouselHomeSlider" class="carousel slide" data-ride="carousel" data-interval="7000">
                        <div class="carousel-inner">
                            @foreach ($home_page_sliders as $key => $home_page_slider)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="npo-hbs-item"style="background-image: url({{ asset($home_page_slider->slider_image) }})">
                                    <div class="hbs-slide-caption">
                                        <h2>{!! $home_page_slider->slider_title !!}</h2>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
          
                        <div class="slider-nav">
                            <a class="slide-nav-prev" href="#carouselHomeSlider" role="button" data-slide="prev" aria-label="Previous Slide in Carousel">
                                <span class="slider-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M11.3281 14L4.66068 7.9986L11.3281 1.9972" stroke="#EBF2F8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                            <a class="slide-nav-next" href="#carouselHomeSlider" role="button" data-slide="next"  aria-label="Next Slide in Carousel">
                                <span class="slider-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                        <path d="M5.46875 2L12.1362 8.0014L5.46875 14.0028" stroke="#EBF2F8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="npo-msg-lists">
                    <div class="msg-title">
                        <p style="margin-bottom: 0;line-height: 1.4;font-weight: normal;font-size: 20px;font-family: 'Raleway', sans-serif;">Messages</p>
                    </div>
            
                    <div class="npo-msg-block">
                        @foreach ($messages as $message)
                            <div class="npo-msg-item">
                                <div class="msg-item-photo" style="background-image: url({{ asset($message->image ?? null) }})"></div>
                                <div class="msg-item-desc">
                                    <p  class="msg-designation">{{ $message->name_en ?? null }}</p>
                                    <p>
                                        <span style=" margin-bottom: 5px;line-height: 1.3;display: block;font-weight: 600;font-size: 14px;">{{ $message->designation_en ?? null }}</span>
                                    </p>
                                    <p>
                                        <span class="msg-designation">{{ $message->organization_en ?? null }}</span>
                                    </p>
                                    <a href="{{ route('frontend.messages.detail',['id' => Encryption::encodeId($message->id)]) }}"
                                        class="msg-details-btn">Details</a>
                                </div>
                            </div>
                        @endforeach
            
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>