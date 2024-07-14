
@extends('public_home.front')

@section ('body')
<main class="site-main-content page-height">
    <div class="npo-breadcrumb" style="background-color: white;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <span class="bcm-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                    fill="none">
                                    <path
                                        d="M7.30975 1.00158C7.26911 0.960836 7.22083 0.928511 7.16768 0.906455C7.11453 0.8844 7.05755 0.873047 7 0.873047C6.94245 0.873047 6.88547 0.8844 6.83232 0.906455C6.77917 0.928511 6.73089 0.960836 6.69025 1.00158L1.44025 6.25158C1.39965 6.29228 1.36747 6.34059 1.34555 6.39374C1.32363 6.44689 1.3124 6.50384 1.3125 6.56133V12.6863C1.3125 12.8024 1.35859 12.9136 1.44064 12.9957C1.52269 13.0777 1.63397 13.1238 1.75 13.1238H5.6875C5.80353 13.1238 5.91481 13.0777 5.99686 12.9957C6.07891 12.9136 6.125 12.8024 6.125 12.6863V9.18633H7.875V12.6863C7.875 12.8024 7.92109 12.9136 8.00314 12.9957C8.08519 13.0777 8.19647 13.1238 8.3125 13.1238H12.25C12.366 13.1238 12.4773 13.0777 12.5594 12.9957C12.6414 12.9136 12.6875 12.8024 12.6875 12.6863V6.56133C12.6876 6.50384 12.6764 6.44689 12.6545 6.39374C12.6325 6.34059 12.6004 6.29228 12.5598 6.25158L11.375 5.0677V2.18633C11.375 2.0703 11.3289 1.95902 11.2469 1.87697C11.1648 1.79492 11.0535 1.74883 10.9375 1.74883H10.0625C9.94647 1.74883 9.83519 1.79492 9.75314 1.87697C9.67109 1.95902 9.625 2.0703 9.625 2.18633V3.3177L7.30975 1.00158ZM2.1875 12.2488V6.74245L7 1.92995L11.8125 6.74245V12.2488H8.75V8.74883C8.75 8.6328 8.70391 8.52152 8.62186 8.43947C8.53981 8.35742 8.42853 8.31133 8.3125 8.31133H5.6875C5.57147 8.31133 5.46019 8.35742 5.37814 8.43947C5.29609 8.52152 5.25 8.6328 5.25 8.74883V12.2488H2.1875Z"
                                        fill="#0D6EFD" />
                                </svg>
                            </span> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Messages</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <section class="" style="background-color: white;">
        <div class="container">
            <div class="npo-content-container">
                <div class="npo-msg-block">
                    <div class="npo-bio-msg-item d-flex flex-row" style="background-color: whitesmoke;">
                        <div class="msg-item-photo">
                            <img src="{{ asset($message->image) }}" alt="Image not found" class=" rounded">
                        </div>
                        <div class="npo-bio-info pt-3">
                            <h2> {{ $message->name_en }}</h2>
                            <div class="d-flex flex-column npo-bio-msg pt-2">
                                <span class="pb-1"> {{ $message->designation_en }}</span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="npo-details-block py-4">
                    <p>{{ $message->description_en }}</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection