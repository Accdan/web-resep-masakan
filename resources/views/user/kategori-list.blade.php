<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dapur Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icondapur.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Nunito:wght@300;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            scroll-behavior: smooth;
            margin: 0;
            padding: 0;
        }

        .navbar-brand {
            font-family: 'Pacifico', cursive;
            font-size: 1.8rem;
        }

        .carousel-caption h1 {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
        }

        .hover-shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .floating-navbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffffff;
            border-radius: 20px;
            padding: 0.5rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 1050;
            width: auto;
            max-width: 90%;
        }

        .navbar {
            background: #ffffff;
            border: none !important;
        }

        .vh-100 {
            height: 100vh;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .custom-card {
            background-color: #f9f9f9;
            border-radius: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .carousel-wrapper {
            height: 400px;
            overflow: hidden;
        }

        .carousel-inner,
        .carousel-item {
            height: 100%;
        }

        .carousel-item > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .carousel-item {
            height: 100%;
        }


        .carousel-caption h1 {
            font-size: 2rem;
        }

        .carousel-caption p {
            font-size: 1rem;
        }

        .card:hover img {
            transform: scale(1.03);
            transition: transform 0.3s ease;
        }

        .text-shadow {
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>

    @include('include.navbarUser')

    <!-- Hero Section dengan Grid Layout -->
    <section class="container pt-5 mt-5 pb-5">
        <div class="row g-4">
            <div class="carousel-wrapper mb-3">
                <div id="carouselExample" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100 rounded-4 overflow-hidden shadow">
                        @foreach ([
                            ['image' => 'slide1.jpg', 'title' => 'Selamat Datang di Dapur Indonesia', 'desc' => 'Temukan berbagai resep nusantara yang menggoda selera'],
                            ['image' => 'slide2.jpg', 'title' => 'Resep Masakan Nusantara', 'desc' => 'Setiap masakan membawa cerita dan kenangan'],
                            ['image' => 'slide3.jpg', 'title' => 'Inspirasi Dapur Anda', 'desc' => 'Resep inovatif untuk semua kesempatan'],
                        ] as $index => $slide)
                            <div class="carousel-item position-relative {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('image/' . $slide['image']) }}"
                                    class="d-block w-100 h-100"
                                    alt="Slide {{ $index + 1 }}">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded-3 px-3 py-2">
                                    <h1 class="fw-bold">{{ $slide['title'] }}</h1>
                                    <p>{{ $slide['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5">
        <h2 class="text-center fw-bold mb-4">Kategori Resep Makanan</h2>

        <div class="row g-4">
            @foreach ($kategoris as $item)
            <div class="col-md-6 col-lg-3">
                <a href="{{ url('/kategori/' . $item->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 border-0 position-relative overflow-hidden">
                        <img src="{{ asset('uploads/kategori/' . $item->gambar_kategori) }}"
                            class="card-img"
                            alt="{{ $item->nama_kategori }}"
                            style="height: 250px; object-fit: cover;">

                        <div class="card-img-overlay d-flex flex-column justify-content-end p-3">
                            <h5 class="card-title text-white fw-bold text-shadow">{{ $item->nama_kategori }}</h5>
                            <p class="card-text text-white small text-shadow">Kategori masakan khas Indonesia</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Resep Masakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-start">
                        <div class="col-md-6">
                            <img id="detailImage" src="" alt="" class="img-fluid rounded shadow-sm w-100" style="max-height: 300px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h4 id="detailTitle" class="fw-semibold mb-3"></h4>
                            <p id="detailDesc" class="text-muted"></p>
                            <a id="detailLink" href="#" class="btn btn-warning w-100 mt-3">
                                <i class="bi bi-book-open"></i> Lihat Resep Lengkap
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const detailModal = document.getElementById('detailModal');
        detailModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            document.getElementById('detailTitle').textContent = button.getAttribute('data-title');
            document.getElementById('detailDesc').textContent = button.getAttribute('data-desc');
            document.getElementById('detailImage').src = button.getAttribute('data-image');
            document.getElementById('detailImage').alt = button.getAttribute('data-title');
            document.getElementById('detailLink').href = button.getAttribute('data-detail-url');
        });

        document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('liked');
            const icon = btn.querySelector('i');
            const countSpan = btn.nextElementSibling;
            let count = parseInt(countSpan.textContent);
            if (btn.classList.contains('liked')) {
                icon.classList.replace('bi-star', 'bi-star-fill');
                count++;
            } else {
                icon.classList.replace('bi-star-fill', 'bi-star');
                count--;
            }
            countSpan.textContent = count;
        });
    });

    document.querySelectorAll('.btn-submit-comment').forEach(btn => {
        btn.addEventListener('click', () => {
            const parent = btn.closest('.collapse');
            const input = parent.querySelector('.comment-input');
            const commentsSection = parent.querySelector('.comments-section');
            const text = input.value.trim();
            if (text === '') return alert('Komentar tidak boleh kosong!');
            const newComment = document.createElement('div');
            newComment.innerHTML = `<strong>Anda:</strong> ${text}`;
            commentsSection.appendChild(newComment);
            input.value = '';

            const commentBtn = parent.previousElementSibling.querySelector('.comment-btn');
            const match = commentBtn.innerText.match(/\((\d+)\)/);
            let current = match ? parseInt(match[1]) : 0;
            commentBtn.innerHTML = `<i class="bi bi-chat-left-text"></i> (${current + 1})`;
        });
    });
    </script>
</body>
</html>
