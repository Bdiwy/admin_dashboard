<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelFinder - Book Your Perfect Stay</title>
    <!-- CSRF Token for Laravel Forms -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @vite(['resources/css/app.css']) <!-- Assuming you're using Vite for asset management -->
    <style>
        .navbar {
            background-color: #003580;
        }
        .search-container {
            margin-top: -40px;
            position: relative;
            z-index: 1000;
        }
        .price-slider .ui-slider-handle {
            width: 20px;
            height: 20px;
            top: -8px;
            border-radius: 50%;
        }
        .hotel-card {
            transition: transform 0.2s;
        }
        .hotel-card:hover {
            transform: translateY(-5px);
        }
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
        .modal-body .card {
            position: sticky;
            top: 20px;
        }
        .badge {
            text-transform: capitalize;
        }
        @media (max-width: 768px) {
            .carousel-item img { height: 200px; }
            .modal-body .card { position: static; margin-top: 20px; }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fs-3 fw-bold" href="{{ route('hotels.index') }}">TravelFinder</a>
            <div class="d-flex align-items-center text-white">
                @guest
                    <a href="{{ route('login') }}" class="me-3 text-white text-decoration-none">Sign in</a>
                    <a href="{{ route('register') }}" class="text-white text-decoration-none">Register</a>
                @else
                    <span class="me-3">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-white text-decoration-none p-0">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Search Form -->
    <div class="container search-container">
        <div class="card shadow-lg">
            <div class="card-body">
                <form id="searchForm" action="{{ route('hotels.search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="destination" class="form-control" 
                                   value="{{ request('destination', 'New York') }}" placeholder="Destination">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="checkin" class="form-control datepicker" id="checkin" 
                                   value="{{ request('checkin', now()->addDay()->format('Y-m-d')) }}" placeholder="Check-in">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="checkout" class="form-control datepicker" id="checkout" 
                                   value="{{ request('checkout', now()->addDays(2)->format('Y-m-d')) }}" placeholder="Check-out">
                        </div>
                        <div class="col-md-3">
                            <select name="adults" class="form-select">
                                @foreach ([1, 2, 3] as $num)
                                    <option value="{{ $num }}" {{ request('adults', 2) == $num ? 'selected' : '' }}>
                                        {{ $num }} Adult{{ $num > 1 ? 's' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row g-4">
            <!-- Filters -->
            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filters</h5>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Price Range</h6>
                            <div id="price-slider" class="price-slider"></div>
                            <div id="price-values" class="mt-2 text-muted small"></div>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Star Rating</h6>
                            @foreach ([5, 4, 3] as $stars)
                                <div class="form-check">
                                    <input class="form-check-input star-rating" type="checkbox" 
                                           name="rating[]" value="{{ $stars }}" id="rating{{ $stars }}"
                                           {{ in_array($stars, request('rating', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rating{{ $stars }}">{{ str_repeat('★', $stars) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Amenities</h6>
                            @foreach (['wifi' => 'Free WiFi', 'pool' => 'Swimming Pool', 'parking' => 'Free Parking'] as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input amenity" type="checkbox" 
                                           name="amenities[]" value="{{ $value }}" id="{{ $value }}"
                                           {{ in_array($value, request('amenities', ['wifi'])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results -->
            <div class="col-lg-9">
                <div class="row g-4">
                    @foreach ($hotels as $hotel)
                        <div class="col-12 hotel-card" 
                             data-price="{{ $hotel['price'] }}" 
                             data-rating="{{ $hotel['rating'] }}" 
                             data-amenities="{{ implode(' ', $hotel['amenities']) }}">
                            <div class="card shadow-sm h-100">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ $hotel['image'] ?? 'https://via.placeholder.com/300x200' }}" 
                                             class="img-fluid rounded-start" alt="{{ $hotel['name'] }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex flex-column h-100">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title">{{ $hotel['name'] }}</h5>
                                                <span class="text-primary fs-5">${{ $hotel['price'] }}/night</span>
                                            </div>
                                            <div class="mb-2 text-warning">{{ str_repeat('★', $hotel['rating']) }}</div>
                                            <ul class="list-inline mb-3">
                                                @foreach ($hotel['amenities'] as $amenity)
                                                    <li class="list-inline-item">{{ $amenity }}</li>
                                                @endforeach
                                            </ul>
                                            <button class="btn btn-primary mt-auto align-self-start view-deal" 
                                                    data-hotel="{{ json_encode($hotel) }}">View Deal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Hotel Modal -->
    <div class="modal fade" id="hotelModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hotelName"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="hotelCarousel" class="carousel slide mb-4">
                        <div class="carousel-inner"></div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Details</h4>
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="text-primary fs-4" id="hotelPrice"></span>/night
                                    <div class="text-warning" id="hotelRating"></div>
                                </div>
                                <div id="hotelAmenities"></div>
                            </div>
                            <p>{{ $hotelDescription ?? 'A luxurious resort offering premium amenities and exceptional service.' }}</p>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Book Your Stay</h5>
                                    <form action="{{ route('bookings.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="hotel_id" id="hotelId">
                                        <div class="mb-3">
                                            <label class="form-label">Check-in Date</label>
                                            <input type="date" name="checkin" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Check-out Date</label>
                                            <input type="date" name="checkout" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Book Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('register') }}" method="POST" id="registrationForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register & Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            // Datepicker
            $(".datepicker").datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd'
            });

            // Price Slider
            $("#price-slider").slider({
                range: true,
                min: 0,
                max: 500,
                values: [{{ request('price_min', 100) }}, {{ request('price_max', 300) }}],
                slide: function(event, ui) {
                    $("#price-values").text("$" + ui.values[0] + " - $" + ui.values[1]);
                    filterResults();
                }
            });
            $("#price-values").text("$" + $("#price-slider").slider("values", 0) + " - $" + $("#price-slider").slider("values", 1));

            // Filter Handling
            $(".star-rating, .amenity").change(filterResults);

            function filterResults() {
                const minPrice = $("#price-slider").slider("values", 0);
                const maxPrice = $("#price-slider").slider("values", 1);
                const selectedStars = $(".star-rating:checked").map(function() { return parseInt($(this).val()); }).get();
                const selectedAmenities = $(".amenity:checked").map(function() { return $(this).val(); }).get();

                $(".hotel-card").each(function() {
                    const price = parseInt($(this).data("price"));
                    const rating = parseInt($(this).data("rating"));
                    const amenities = $(this).data("amenities").split(" ");
                    const priceMatch = price >= minPrice && price <= maxPrice;
                    const ratingMatch = selectedStars.length === 0 || selectedStars.includes(rating);
                    const amenitiesMatch = selectedAmenities.length === 0 || selectedAmenities.every(a => amenities.includes(a));

                    $(this).toggle(priceMatch && ratingMatch && amenitiesMatch);
                });
            }

            // View Deal
            $('.view-deal').click(function() {
                const hotel = JSON.parse($(this).data('hotel'));
                $('#hotelName').text(hotel.name);
                $('#hotelPrice').text('$' + hotel.price);
                $('#hotelRating').html('★'.repeat(hotel.rating));
                $('#hotelId').val(hotel.id || 1); // Assuming hotel has an ID
                const amenitiesHtml = hotel.amenities.map(a => `<span class="badge bg-primary me-1">${a}</span>`).join('');
                $('#hotelAmenities').html(amenitiesHtml);

                const carouselInner = $('#hotelCarousel .carousel-inner');
                carouselInner.empty();
                const images = hotel.images || ['https://via.placeholder.com/800x400'];
                images.forEach((img, i) => {
                    carouselInner.append(`
                        <div class="carousel-item ${i === 0 ? 'active' : ''}">
                            <img src="${img}" class="d-block w-100">
                        </div>
                    `);
                });

                new bootstrap.Modal(document.getElementById('hotelModal')).show();
            });

            // Form Submission
            $("#searchForm").submit(function(e) {
                // Let Laravel handle the GET request
            });

            // Registration Form
            $('#registrationForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        alert('Registration successful! Please login to complete booking.');
                        $('#registerModal').modal('hide');
                        $('#hotelModal').modal('hide');
                        window.location.href = '{{ route('login') }}';
                    },
                    error: function(xhr) {
                        alert('Registration failed: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>
</html>