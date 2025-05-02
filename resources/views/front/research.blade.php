@extends('front.layouts.app')

@push('css')
    <style>
        body {
            /*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;*/
            background-color: #f8f9fa;
        }
        .hero-section {
            background: linear-gradient(135deg, #007bff 0%, #00c6ff 100%);
            padding: 80px 0;
            border-bottom: 4px solid #0056b3;
        }
        .hero-section h1 {
            font-size: 2.8rem;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }
        .hero-section .lead {
            font-size: 1.25rem;
            opacity: 0.9;
        }
        /* Professional Search Box */
        .custom-search-container {
            max-width: 420px;
            margin: 30px auto;
            position: relative;
        }

        .custom-search-input {
            height: 55px;
            border-radius: 50px;
            border: 2px solid #fff;
            padding: 0 60px 0 20px;
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
        }

        .custom-search-input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 12px rgba(0, 86, 179, 0.3);
            outline: none;
        }

        .custom-search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 65px;
            color: white;
            height: 47px;
            background: #00b5ff;

        }

        .custom-search-btn:hover {
            background: #003d82;
        }

        /* Filter Modal Styling */
        .filter-modal {
            position: fixed;
            top: 0;
            left: -350px;
            width: 350px;
            height: 100%;
            background: #fff;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            transition: left 0.4s ease-in-out;
            z-index: 1050;
        }

        .filter-modal.open {
            left: 0;
        }

        .filter-modal-content {
            height: 100%;
            overflow-y: auto;
            padding: 30px;
            background: #fafafa;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            color: #555;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #dc3545;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 450px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: stretch;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .card-body h5 {
            font-size: 18px;
            color: #007bff;
        }
        .card-body p {
            color: #666;
            font-size: 0.95rem;
        }
        .badge {
            padding: 6px 12px;
            font-size: 0.9rem;
            border-radius: 20px;
        }
        .btn-outline-primary {
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-outline-primary:hover {
            background: #007bff;
            color: #fff;
        }
        .btn-outline-danger {
            border-radius: 20px;
            padding: 8px 20px;

        .btn-primary {
            border-radius: 20px;
            padding: 10px 20px;
            background: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background: #0056b3;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 50%;
            margin: 0 5px;
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background: #007bff;
            border-color: #007bff;
        }
    </style>
@endpush

@section('content')
    <!-- Research Hero Section -->
    <div class="hero-section text-center text-white py-5">
        <div class="container">
            <h1 class="fw-bold">Explore Scientific Research</h1>
            <p class="lead">Discover cutting-edge research, trending topics, and connect with leading researchers.</p>

            <!-- Professional Search Box -->
            <form method="GET" action="{{ route('research.list') }}" class="custom-search-container">
                <input type="text" name="search" class="custom-search-input form-control" placeholder=" Search..." value="{{ request('search') }}">
                <button type="submit" class="custom-search-btn btn"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <!-- Research Filters Section -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark"><i class="fas fa-book-open"></i> Recent Research Papers</h4>
            <div>
                <button class="btn btn-outline-primary me-2" onclick="openFilterModal()">
                    <i class="fas fa-filter"></i> Advanced Filters
                </button>
                <a href="{{ route('research.list') }}" class="btn btn-outline-danger">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            </div>


        </div>
        @if(request()->hasAny(['search', 'category', 'author', 'date', 'citations', 'status', 'min_rating', 'sort_by', 'college', 'department']))
            <div class="mb-4">
                <h6 class="fw-bold text-dark"><i class="fas fa-tags"></i> Active Filters:</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(['search' => 'Keyword', 'category' => 'Category', 'author' => 'Author', 'date' => 'Date', 'college' => 'college', 'department' => 'department', 'min_rating' => 'Rating', 'sort_by' => 'Sorting'] as $key => $label)
                        @if(request($key))
                            <span class="badge bg-primary text-white px-3 py-2">
                        {{ $label }}: {{ request($key) }}
                        <a href="{{ route('research.list', request()->except($key)) }}" class="text-white ms-2">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Research List -->
        <div class="row mt-4">
            @foreach($researches as $research)
                <div class="col-md-4 mb-4">
                    <div class="card p-3">
                        <div class="card-body">
                            <h5 class="fw-bold"><i class="fas fa-file-alt"></i> {{ $research->title }}</h5>
                            <p>{{ Str::limit($research->abstract, 100) }}</p>
                            <div class="d-flex justify-content-between text-muted">
                                <small><i class="fas fa-user text-success"></i>{{ Str::limit($research->authors, 20) }}  </small>
                                <small><i class="fas fa-calendar text-warning"></i> {{ date('M d, Y', strtotime($research->date_submitted)) }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="badge bg-info text-white"><i class="fas fa-comments"></i> {{ $research->comments->count() }} Comments</span>
                                </div>
                                <a href="{{ route('research.details', $research->research_id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-book-reader"></i> Read More
                                </a>
                            </div>
                            <!-- Average Rating with Stars -->
                            <div class="mt-2">
                                @php
                                    $avgRating = $research->ratings->avg('rating_value') ?? 0; // Default to 0 if no ratings
                                    $fullStars = floor($avgRating);
                                    $halfStar = ($avgRating - $fullStars) >= 0.5 ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                                @endphp
                                <span class="text-warning">
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if ($halfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </span>
                                <small class="text-muted ms-2">({{ number_format($avgRating, 1) }}/5)</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $researches->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>


    </div>

    <!-- Left-Side Filter Modal -->
    <div id="filterModal" class="filter-modal">
        <div class="filter-modal-content">
            <button class="close-btn" onclick="closeFilterModal()">×</button>
            <h5 class="fw-bold text-dark"><i class="fas fa-filter"></i> Advanced Filters</h5>
            <form method="GET" action="{{ route('research.list') }}">
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label fw-bold">Category</label>--}}
{{--                    <select name="category" class="form-control">--}}
{{--                        <option value="">All Categories</option>--}}
{{--                        <option value="Artificial Intelligence" {{ request('category') == 'Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>--}}
{{--                        <option value="Biotechnology" {{ request('category') == 'Biotechnology' ? 'selected' : '' }}>Biotechnology</option>--}}
{{--                        <option value="Climate Change" {{ request('category') == 'Climate Change' ? 'selected' : '' }}>Climate Change</option>--}}
{{--                        <option value="Medical Science" {{ request('category') == 'Medical Science' ? 'selected' : '' }}>Medical Science</option>--}}
{{--                        <option value="Robotics" {{ request('category') == 'Robotics' ? 'selected' : '' }}>Robotics & Automation</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <label class="form-label fw-bold">Rating (Minimum)</label>--}}
{{--                    <select name="min_rating" class="form-control">--}}
{{--                        <option value="">Any Rating</option>--}}
{{--                        @for ($i = 1; $i <= 5; $i++)--}}
{{--                            <option value="{{ $i }}" {{ request('min_rating') == $i ? 'selected' : '' }}>--}}
{{--                                {{ $i }} Stars & Above--}}
{{--                            </option>--}}
{{--                        @endfor--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <label class="form-label fw-bold">Sort By</label>--}}
{{--                    <select name="sort_by" class="form-control">--}}
{{--                        <option value="">Default</option>--}}
{{--                        <option value="date_newest" {{ request('sort_by') == 'date_newest' ? 'selected' : '' }}>Newest First</option>--}}
{{--                        <option value="date_oldest" {{ request('sort_by') == 'date_oldest' ? 'selected' : '' }}>Oldest First</option>--}}
{{--                        <option value="rating_high" {{ request('sort_by') == 'rating_high' ? 'selected' : '' }}>Highest Rated</option>--}}
{{--                        <option value="rating_low" {{ request('sort_by') == 'rating_low' ? 'selected' : '' }}>Lowest Rated</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label fw-bold">Author</label>--}}
{{--                    <input type="text" name="author" class="form-control" placeholder="Enter author name" value="{{ request('author') }}">--}}
{{--                </div>--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="form-label fw-bold">Publication Date</label>--}}
{{--                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">--}}
{{--                </div>--}}


                <div class="mb-3">
                    <label class="form-label fw-bold">College</label>
                    <select name="college" class="form-control">
                        <option value="">All Colleges</option>
                        <option value="College of Medicine" {{ request('college') == 'College of Medicine' ? 'selected' : '' }}>College of Medicine</option>
                        <option value="College of Dentistry" {{ request('college') == 'College of Dentistry' ? 'selected' : '' }}>College of Dentistry</option>
                        <option value="College of Pharmacy" {{ request('college') == 'College of Pharmacy' ? 'selected' : '' }}>College of Pharmacy</option>
                        <option value="College of Applied Medical Sciences" {{ request('college') == 'College of Applied Medical Sciences' ? 'selected' : '' }}>College of Applied Medical Sciences</option>
                        <option value="College of Nursing" {{ request('college') == 'College of Nursing' ? 'selected' : '' }}>College of Nursing</option>
                        <option value="College of Engineering" {{ request('college') == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                        <option value="College of Computer Science and Information Systems" {{ request('college') == 'College of Computer Science and Information Systems' ? 'selected' : '' }}>College of Computer Science and Information Systems</option>
                        <option value="College of Administrative Sciences" {{ request('college') == 'College of Administrative Sciences' ? 'selected' : '' }}>College of Administrative Sciences</option>
                        <option value="College of Education" {{ request('college') == 'College of Education' ? 'selected' : '' }}>College of Education</option>
                        <option value="College of Languages and Translation" {{ request('college') == 'College of Languages and Translation' ? 'selected' : '' }}>College of Languages and Translation</option>
                        <option value="College of Science and Arts" {{ request('college') == 'College of Science and Arts' ? 'selected' : '' }}>College of Science and Arts</option>
                        <option value="College of Sharia and Fundamentals of Religion" {{ request('college') == 'College of Sharia and Fundamentals of Religion' ? 'selected' : '' }}>College of Sharia and Fundamentals of Religion</option>
                        <option value="College of Science and Arts – Sharurah" {{ request('college') == 'College of Science and Arts – Sharurah' ? 'selected' : '' }}>College of Science and Arts – Sharurah</option>
                        <option value="Applied College" {{ request('college') == 'Applied College' ? 'selected' : '' }}>Applied College</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Department</label>
                    <select name="department" class="form-control">
                        <option value="">All Departments</option>
                        <option value="Surgery" {{ request('department') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                        <option value="Internal Medicine" {{ request('department') == 'Internal Medicine' ? 'selected' : '' }}>Internal Medicine</option>
                        <option value="Pediatrics" {{ request('department') == 'Pediatrics' ? 'selected' : '' }}>Pediatrics</option>
                        <option value="Obstetrics and Gynecology" {{ request('department') == 'Obstetrics and Gynecology' ? 'selected' : '' }}>Obstetrics and Gynecology</option>
                        <option value="Biochemistry" {{ request('department') == 'Biochemistry' ? 'selected' : '' }}>Biochemistry</option>
                        <option value="Preventive Dentistry" {{ request('department') == 'Preventive Dentistry' ? 'selected' : '' }}>Preventive Dentistry</option>
                        <option value="Clinical Pharmacy" {{ request('department') == 'Clinical Pharmacy' ? 'selected' : '' }}>Clinical Pharmacy</option>
                        <option value="Radiological Sciences" {{ request('department') == 'Radiological Sciences' ? 'selected' : '' }}>Radiological Sciences</option>
                        <option value="Medical-Surgical Nursing" {{ request('department') == 'Medical-Surgical Nursing' ? 'selected' : '' }}>Medical-Surgical Nursing</option>
                        <option value="Civil Engineering" {{ request('department') == 'Civil Engineering' ? 'selected' : '' }}>Civil Engineering</option>
                        <option value="Architectural Engineering" {{ request('department') == 'Architectural Engineering' ? 'selected' : '' }}>Architectural Engineering</option>
                        <option value="Computer Science" {{ request('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                        <option value="Business Administration" {{ request('department') == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                        <option value="Accounting" {{ request('department') == 'Accounting' ? 'selected' : '' }}>Accounting</option>
                        <option value="Curriculum and Instruction" {{ request('department') == 'Curriculum and Instruction' ? 'selected' : '' }}>Curriculum and Instruction</option>
                        <option value="English Language" {{ request('department') == 'English Language' ? 'selected' : '' }}>English Language</option>
                        <option value="Physics" {{ request('department') == 'Physics' ? 'selected' : '' }}>Physics</option>
                        <option value="Sharia" {{ request('department') == 'Sharia' ? 'selected' : '' }}>Sharia</option>
                        <option value="Islamic Studies" {{ request('department') == 'Islamic Studies' ? 'selected' : '' }}>Islamic Studies</option>
                        <option value="Law" {{ request('department') == 'Law' ? 'selected' : '' }}>Law</option>
                        <option value="Marketing and E-Commerce" {{ request('department') == 'Marketing and E-Commerce' ? 'selected' : '' }}>Marketing and E-Commerce</option>
                        <option value="Network and Communications Engineering" {{ request('department') == 'Network and Communications Engineering' ? 'selected' : '' }}>Network and Communications Engineering</option>
                        <option value="Public Administration" {{ request('department') == 'Public Administration' ? 'selected' : '' }}>Public Administration</option>
                    </select>
                </div>



                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Apply Filters</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openFilterModal() {
            document.getElementById('filterModal').classList.add('open');
        }

        function closeFilterModal() {
            document.getElementById('filterModal').classList.remove('open');
        }
    </script>
@endpush
