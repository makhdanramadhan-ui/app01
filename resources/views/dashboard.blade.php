<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishnotes - Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8f9fa; }
        .navbar { background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .navbar-brand { font-weight: 700; color: #a18cd1 !important; font-size: 1.5rem; }
        .nav-profile-img { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 2px solid #fbc2eb; }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            color: white; border-radius: 20px; 
            /* Padding responsif: lebih kecil di mobile, lebih besar di desktop */
            margin-bottom: 30px; 
            position: relative; overflow: hidden; transition: all 0.3s ease;
        }
        .hero-section::after {
            content: '\f004'; font-family: "Font Awesome 6 Free"; font-weight: 900;
            position: absolute; right: -20px; bottom: -30px; font-size: 150px; opacity: 0.1; transform: rotate(-20deg);
        }
        .fade-in { animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Card Styling */
        /* cursor: pointer agar user tahu ini bisa diklik */
        .wish-card {
            border: none; border-radius: 20px; transition: all 0.3s; background: white; 
            overflow: hidden; height: 100%; position: relative; cursor: pointer; 
        }
        .wish-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        
        /* Skin Indicators */
        .skin-badge {
            position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; z-index: 2;
        }
        .skin-tree { background-color: #61c0bf; }
        .skin-mading { background-color: #ffb6b9; }
        .skin-mailbox { background-color: #fce38a; color: #555; }

        .card-body { padding: 25px; }
        .card-title { font-weight: 700; color: #444; }
        .card-text { color: #888; font-size: 0.9rem; min-height: 40px; }
        
        .status-pill { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; margin-top: 10px; }
        .status-public { background-color: #e3f2fd; color: #2196f3; }
        .status-private { background-color: #fbe9e7; color: #ff5722; }

        .btn-create { background: #fff; color: #a18cd1; font-weight: 700; border-radius: 50px; border: none; padding: 10px 25px; }
        
        /* Tabs */
        .nav-pills .nav-link { cursor: pointer; transition: all 0.3s; user-select: none; }
        .nav-pills .nav-link.active { background-color: #a18cd1; color: white !important; }
        .nav-pills .nav-link:not(.active) { color: #6c757d; background-color: transparent; }
    </style>
</head>
<body>

     <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard"><i class="fa-solid fa-gift me-2"></i>Wishnotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link text-muted" href="#">Jelajahi</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="me-2 fw-bold text-dark">Guest User</span>
                            <img src="https://ui-avatars.com/api/?name=Guest+User&background=random" class="nav-profile-img">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                             <li><a class="dropdown-item rounded" href="profil"><i class="fas fa-user-circle me-2 text-primary"></i> Profile</a></li>
                            <li><a class="dropdown-item rounded" href="friendlist"><i class="fas fa-user-plus me-2 text-success"></i> Teman</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- logout -->
                            @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li>
                                    <button type="submit" class="text-textMuted hover:text-white transition-colors text-sm font-semibold uppercase tracking-wider"><i class="fas fa-sign-out-alt me-2"></i>
                                        Logout
                                    </button>
                                </li>
                            </form>
                            @endauth
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <!-- Hero Section dengan padding responsif (p-4 di mobile, p-md-5 di desktop) -->
        <div class="hero-section d-flex justify-content-between align-items-center p-4 p-md-5" id="hero-section">
            <div id="hero-text-container" class="fade-in">
                <h2 class="fw-bold mb-2" id="hero-title">Selamat Datang!</h2>
                <p class="mb-3 opacity-75" id="hero-desc">Buat wadah harapanmu atau sampaikan doa untuk temanmu.</p>
                <button class="btn btn-create shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus me-2"></i>Buat Wishnote Baru
                </button>
            </div>
            <div class="d-none d-md-block fade-in" id="hero-icon" style="font-size: 5rem; opacity: 0.8;">🎄 📝</div>
        </div>

        <!-- Tabs Responsif: Tengah di mobile, Kiri di desktop -->
        <ul class="nav nav-pills mb-4 justify-content-center justify-content-md-start" id="pills-tab">
            <li class="nav-item"><a class="nav-link active rounded-pill px-4" data-filter="all">Semua</a></li>
            <li class="nav-item ms-2"><a class="nav-link rounded-pill px-4" data-filter="mine">Milik Saya</a></li>
            <li class="nav-item ms-2"><a class="nav-link rounded-pill px-4" data-filter="friends">Teman</a></li>
        </ul>

        <div class="row g-4" id="cards-container">
            
            <!-- UPDATE: Grid Responsif (col-12 mobile, col-sm-6 tablet, col-lg-4 desktop) -->
            
            <!-- Card 1 -->
            <div class="col-12 col-sm-6 col-lg-4 filter-item" data-category="friends">
                <div class="wish-card shadow-sm" onclick="openDetail('Harapan Natal 2025', 'Kevin', 'tree')">
                    <div class="skin-badge skin-tree"><i class="fa-solid fa-tree"></i></div>
                    <div class="card-body mt-4">
                        <h5 class="card-title">Harapan Natal 2025</h5>
                        <p class="card-text text-truncate">Kumpulkan ucapan natal kalian di pohon ini ya!</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="status-pill status-public">Public</span>
                            <small class="text-muted"><i class="fas fa-envelope me-1"></i> 12 Pesan</small>
                        </div>
                        <hr class="my-3 text-muted opacity-25">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Kevin&background=ef5350&color=fff" class="rounded-circle me-2" width="25">
                            <small class="text-muted">by Kevin</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-sm-6 col-lg-4 filter-item" data-category="friends">
                <div class="wish-card shadow-sm" onclick="openDetail('Untuk Kelulusan Sarah', 'Sarah', 'mading')">
                    <div class="skin-badge skin-mading"><i class="fa-solid fa-note-sticky"></i></div>
                    <div class="card-body mt-4">
                        <h5 class="card-title">Untuk Kelulusan Sarah</h5>
                        <p class="card-text text-truncate">Tulis kenangan manis kalian di mading virtual ini.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="status-pill status-public">Public</span>
                            <small class="text-muted"><i class="fas fa-envelope me-1"></i> 45 Pesan</small>
                        </div>
                        <hr class="my-3 text-muted opacity-25">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Sarah&background=ab47bc&color=fff" class="rounded-circle me-2" width="25">
                            <small class="text-muted">by Sarah</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-sm-6 col-lg-4 filter-item" data-category="mine">
                <div class="wish-card shadow-sm" onclick="openDetail('Rahasia Hati', 'You', 'mailbox')">
                    <div class="skin-badge skin-mailbox"><i class="fa-solid fa-envelope-open-text"></i></div>
                    <div class="card-body mt-4">
                        <h5 class="card-title">Rahasia Hati</h5>
                        <p class="card-text text-truncate">Hanya aku yang bisa baca, silakan curhat.</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="status-pill status-private">Private</span>
                            <small class="text-muted"><i class="fas fa-envelope me-1"></i> 5 Pesan</small>
                        </div>
                        <hr class="my-3 text-muted opacity-25">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Guest+User&background=random" class="rounded-circle me-2" width="25">
                            <small class="text-muted">by You</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-12 col-sm-6 col-lg-4 filter-item" data-category="mine">
                <div class="wish-card shadow-sm" onclick="openDetail('Resolusi 2025', 'You', 'mading')">
                    <div class="skin-badge skin-mading"><i class="fa-solid fa-note-sticky"></i></div>
                    <div class="card-body mt-4">
                        <h5 class="card-title">Resolusi 2025</h5>
                        <p class="card-text text-truncate">Target dan mimpi yang harus dicapai tahun depan!</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="status-pill status-public">Public</span>
                            <small class="text-muted"><i class="fas fa-envelope me-1"></i> 0 Pesan</small>
                        </div>
                        <hr class="my-3 text-muted opacity-25">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=Guest+User&background=random" class="rounded-circle me-2" width="25">
                            <small class="text-muted">by You</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- modal wishnote baru  -->
        <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-secondary">✨ Wishnote Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="addWishForm" method="POST" action="{{ route('wishnote.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Judul</label>
                            <input type="text" class="form-control rounded-pill" id="inputTitle" placeholder="Contoh: Resolusi 2025" required name='judul'>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Deskripsi Singkat</label>
                            <textarea class="form-control" id="inputDesc" rows="3" style="border-radius: 15px;" placeholder="Tulis harapanmu disini..." required name='deskripsi_singkat'></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small fw-bold">Tipe Wadah</label>
                                <select class="form-select rounded-pill" id="inputType" name='tipe_wadah'>
                                    <option value="tree">Pohon Natal 🎄</option>
                                    <option value="mading">Mading 📝</option>
                                    <option value="mailbox">Kotak Surat 📮</option>
                                </select>
                            </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label text-muted small fw-bold">Privasi</label>
                                    <select class="form-select rounded-pill" id="inputStatus" name='privasi'>
                                        <option value="public">Public 🌍</option>
                                        <option value="private">Private 🔒</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button  class="btn btn-primary rounded-pill fw-bold" type="submit" style="background: #a18cd1; border: none;">Simpan Wishnote</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- 1. Fungsi Navigasi ke Halaman Detail ---
        function openDetail(title, author, type) {
            // Kita kirim data lewat URL parameter
            // encodeURIComponent() digunakan agar spasi atau karakter khusus aman di URL
            window.location.href = `pohon?title=${encodeURIComponent(title)}&author=${encodeURIComponent(author)}&type=${type}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // --- 2. Logika Tab Filter & Hero Section ---
            const heroContent = {
                all: { title: "Selamat Datang!", desc: "Buat wadah harapanmu atau sampaikan doa untuk temanmu.", icon: "🎄 📝" },
                mine: { title: "Koleksi Saya", desc: "Semua catatan dan wadah harapan yang telah Anda buat.", icon: "📂" },
                friends: { title: "Punya Teman", desc: "Lihat apa yang teman-temanmu harapkan saat ini.", icon: "👯‍♂️" }
            };

            const tabs = document.querySelectorAll('.nav-link[data-filter]');
            const cards = document.querySelectorAll('.filter-item');
            const heroTitle = document.getElementById('hero-title');
            const heroDesc = document.getElementById('hero-desc');
            const heroIcon = document.getElementById('hero-icon');
            const heroTextContainer = document.getElementById('hero-text-container');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Update Tab Active
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');

                    // Filter Kartu
                    cards.forEach(card => {
                        const cardCategory = card.getAttribute('data-category');
                        if (filterValue === 'all' || cardCategory === filterValue) {
                            card.classList.remove('d-none');
                        } else {
                            card.classList.add('d-none');
                        }
                    });

                    // Update Hero Section
                    heroTextContainer.classList.remove('fade-in');
                    heroIcon.classList.remove('fade-in');
                    void heroTextContainer.offsetWidth; // Trigger reflow untuk restart animasi
                    
                    heroTitle.innerText = heroContent[filterValue].title;
                    heroDesc.innerText = heroContent[filterValue].desc;
                    heroIcon.innerText = heroContent[filterValue].icon;
                    
                    heroTextContainer.classList.add('fade-in');
                    heroIcon.classList.add('fade-in');

                    // --- 1. Fungsi Navigasi (Bawaan) ---
    function openDetail(title, author, type) {
        window.location.href = `detail?title=${encodeURIComponent(title)}&author=${encodeURIComponent(author)}&type=${type}`;
    }

    // --- 2. Fungsi LOAD: Menampilkan Data dari Memory Browser ---
    // Fungsi ini akan otomatis jalan saat halaman dibuka
    document.addEventListener('DOMContentLoaded', function() {
        // Kita cek, apakah kita sedang di halaman "Milik Saya" atau "Semua"?
        // Karena kita hanya ingin menampilkan kartu buatan sendiri di sana.
        const path = window.location.pathname;
        const isMinePage = path.includes("mine.html");
        const isIndexPage = path.includes("index.html");

        if (isMinePage || isIndexPage) {
            loadWishnotes(); 
        }
    });

    function loadWishnotes() {
        // Ambil data dari LocalStorage
        const storedNotes = JSON.parse(localStorage.getItem('myWishnotes')) || [];
        const container = document.getElementById('cards-container') || document.querySelector('.row.g-4');

        // Loop setiap data dan buatkan HTML-nya
        storedNotes.forEach(note => {
            // Tentukan style berdasarkan tipe
            let skinClass = '', iconClass = '';
            if(note.type === 'tree') { skinClass = 'skin-tree'; iconClass = 'fa-tree'; }
            else if (note.type === 'mading') { skinClass = 'skin-mading'; iconClass = 'fa-note-sticky'; }
            else { skinClass = 'skin-mailbox'; iconClass = 'fa-envelope-open-text'; }

            let statusClass = (note.status === 'public') ? 'status-public' : 'status-private';
            let statusText = (note.status === 'public') ? 'Public' : 'Private';

            // const html = `
            //     <div class="col-12 col-sm-6 col-lg-4 fade-in">
            //         <div class="wish-card shadow-sm" onclick="openDetail('${note.title}', 'You', '${note.type}')">
            //             <div class="skin-badge ${skinClass}"><i class="fa-solid ${iconClass}"></i></div>
            //             <div class="card-body mt-4">
            //                 <h5 class="card-title">${note.title}</h5>
            //                 <p class="card-text text-truncate">${note.desc}</p>
            //                 <div class="d-flex justify-content-between align-items-center mt-3">
            //                     <span class="status-pill ${statusClass}">${statusText}</span>
            //                     <small class="text-muted"><i class="fas fa-envelope me-1"></i> 0 Pesan</small>
            //                 </div>
            //                 <hr class="my-3 text-muted opacity-25">
            //                 <div class="d-flex align-items-center">
            //                     <img src="https://ui-avatars.com/api/?name=Guest+User&background=random" class="rounded-circle me-2" width="25">
            //                     <small class="text-muted">by You</small>
            //                 </div>
            //             </div>
            //         </div>
            //     </div>
            // `;
            
            // Masukkan kartu baru di urutan paling depan (setelah kartu statis jika ada)
            // Atau gunakan 'afterbegin' agar muncul paling atas
            // container.insertAdjacentHTML('afterbegin', html);
        });
    }

    // --- 3. Fungsi SAVE: Menyimpan ke Memory & Pindah Halaman ---
    // function saveWishnote() {
    //     // A. Ambil Value Input
    //     const title = document.getElementById('inputTitle').value;
    //     const desc = document.getElementById('inputDesc').value;
    //     const type = document.getElementById('inputType').value;
    //     const status = document.getElementById('inputStatus').value;

    //     if(title === "" || desc === "") {
    //         alert("Judul dan Deskripsi wajib diisi!");
    //         return;
    //     }

    //     // B. Bungkus data jadi Object
    //     const newNote = {
    //         id: Date.now(), // ID unik pakai waktu sekarang
    //         title: title,
    //         desc: desc,
    //         type: type,
    //         status: status,
    //         author: 'You'
    //     };

    //     // C. Ambil data lama, gabung dengan data baru, simpan lagi
    //     let notes = JSON.parse(localStorage.getItem('myWishnotes')) || [];
    //     notes.push(newNote); // Tambah data baru
    //     localStorage.setItem('myWishnotes', JSON.stringify(notes)); // Simpan ke browser

    //     // D. Tutup Modal
    //     const modalElement = document.getElementById('createModal');
    //     const modalInstance = bootstrap.Modal.getInstance(modalElement);
    //     modalInstance.hide();
    //     document.getElementById('addWishForm').reset();

    //     // E. LOGIKA UTAMA: REDIRECT (PINDAH) KE MILIK SAYA
    //     // Walaupun kamu buat di 'Teman', layar akan otomatis pindah ke 'mine.html'
    //     // untuk melihat hasilnya.
    //     window.location.href = 'mine.html';
    // }
                });
            });
        });
    </script>
</body>
</html>