@extends('front.layouts.app')

@push('css')
    <style>
        #researchCarousel .carousel-item img {
            height: 550px;
            object-fit: cover;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.23);
            padding: 15px;
            border-radius: 8px;
        }
        .counter-wrap {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')

    <!-- Research Highlights Carousel -->
    <div id="researchCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#researchCarousel" data-bs-slide-to="0" class="active" aria-label="Top Research 1"></button>
            <button type="button" data-bs-target="#researchCarousel" data-bs-slide-to="1" aria-label="Top Research 2"></button>
        </div>
        <div class="carousel-inner rounded-3">
            <div class="carousel-item active">
                <img src="{{ asset('sliders/1.jpg') }}" class="d-block w-100" alt="Top Research 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Breakthrough in AI-Powered Data Analysis</h5>
                    <p>Discover how AI-driven dashboards are transforming research management and scientific collaboration.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('sliders/1.jpg') }}" class="d-block w-100" alt="Top Research 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Enhancing Research Visibility & Impact</h5>
                    <p>Explore how interactive dashboards facilitate research tracking, citation analysis, and open-access publishing.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="untree_co-section count-numbers py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="counter-wrap">
                        <div class="counter">
                            <span  data-number="3434">{{ 3434 }}</span>
                        </div>
                        <span class="caption">Total Research Papers</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-wrap">
                        <div class="counter">
                            <span data-number="900">{{ 900 }}</span>
                        </div>
                        <span class="caption">Active Researchers</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-wrap">
                        <div class="counter">
                            <span data-number="344">{{ 344 }}</span>
                        </div>
                        <span class="caption">Total Users</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<hr class="hrr">
    <!-- Research Features Section -->
    <div class="untree_co-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-6  mx-auto">
                    <h2 class="section-title">Explore Scientific Research</h2>
                    <p>Use SciDashboard to access top-tier research, track academic progress, and collaborate on groundbreaking studies.</p>
                </div>
            </div>
            <div class="row align-items-stretch text-center py-4">
                <div class="col-md-4">
                    <div class="feature-box p-4 shadow-sm rounded bg-light">
                        <i class="fas fa-chart-line display-3 text-primary mb-3"></i>
                        <h3 class="fw-bold">Data-Driven Insights</h3>
                        <p class="text-muted">Get real-time analytics and reports on research trends and scientific productivity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box p-4 shadow-sm rounded bg-light">
                        <i class="fas fa-users display-3 text-primary mb-3"></i>
                        <h3 class="fw-bold">Collaborative Research</h3>
                        <p class="text-muted">Connect with researchers, share findings, and collaborate on innovative projects.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box p-4 shadow-sm rounded bg-light">
                        <i class="fas fa-book-open display-3 text-primary mb-3"></i>
                        <h3 class="fw-bold">Publication Management</h3>
                        <p class="text-muted">Track research impact, manage citations, and enhance visibility through indexed journals.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <hr class="hrr">
    <div class="untree_co-section bg-white py-5">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title fw-bold">Suggested Research & Trends</h2>
                    <p class="text-muted">Explore recommended research papers, trending topics, and featured studies in various scientific fields.</p>
                </div>
            </div>

            <div class="row">
                <!-- Suggested Research Card 1 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3">
                        <i class="fas fa-flask text-primary display-3 text-center"></i>
                        <div class="card-body text-center">
                            <h4 class="fw-bold">AI in Scientific Research</h4>
                            <p class="text-muted">Discover how artificial intelligence is revolutionizing data analysis and academic research.</p>
                            <a href="{{ route('research.list').'?search=ai' }}" class="btn btn-outline-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Suggested Research Card 2 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3">
                        <i class="fas fa-dna text-success display-3 text-center"></i>
                        <div class="card-body text-center">
                            <h4 class="fw-bold">Genomics & Bioinformatics</h4>
                            <p class="text-muted">Explore the latest advancements in DNA sequencing and biomedical research.</p>
                            <a href="{{ route('research.list').'?search=Bioinformatics' }}" class="btn btn-outline-success btn-sm">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Suggested Research Card 3 -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3">
                        <i class="fas fa-globe text-warning display-3 text-center"></i>
                        <div class="card-body text-center">
                            <h4 class="fw-bold">Climate Change Studies</h4>
                            <p class="text-muted">Stay updated with research on climate change, sustainability, and environmental policies.</p>
                            <a href="{{ route('research.list').'?search=Climate' }}" class="btn btn-outline-warning btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="hrr">

    <!-- Video Presentation Section -->
    <div class="untree_co-section ">
        <div class="container">
            <div class="row align-items-center">
                <!-- Video Thumbnail -->
                <div class="col-lg-6">
                    <figure class="img-play-video">
{{--                        <a id="play-video" class="video-play-button" href="https://www.youtube.com/watch?v=zLIQ3ACQZT8" data-fancybox="">--}}
{{--                            <span></span>--}}
{{--                        </a>--}}
                        <img src="{{ asset('logo1.png') }}" alt="Watch Video" class="img-fluid rounded-20">
                    </figure>
                </div>

                <!-- Video Description -->
                <div class="col-lg-6">
                    <h2 class="section-title fw-bold mb-4 text-primary">Why Choose SciDashboard?</h2>
                    <p class="text-muted">
                        SciDashboard is the ultimate research management platform, offering powerful tools to analyze, track, and visualize scientific data with ease.
                    </p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <i class="fas fa-chart-line text-success me-2"></i> Advanced Data Visualization
                        </div>
                        <div class="col-md-6 mb-3">
                            <i class="fas fa-brain text-warning me-2"></i> AI-Powered Citation Analysis
                        </div>
                        <div class="col-md-6 mb-3">
                            <i class="fas fa-sync-alt text-primary me-2"></i> Real-Time Research Monitoring
                        </div>
                        <div class="col-md-6 mb-3">
                            <i class="fas fa-book-open text-info me-2"></i> Publication Impact Metrics
                        </div>
                        <div class="col-md-6 mb-3">
                            <i class="fas fa-user-friends text-danger me-2"></i> Collaborative Research Tools
                        </div>
                        <div class="col-md-6 mb-3">
                            <i class="fas fa-database text-dark me-2"></i> Comprehensive Research Tracking
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
