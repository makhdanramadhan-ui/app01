<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishnotes Pohon Natal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* CSS Animasi Kustom */
        @keyframes twinkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.9); }
        }
        .animate-twinkle {
            animation: twinkle 2s infinite ease-in-out;
            transform-origin: center;
            transform-box: fill-box;
        }

        @keyframes fall {
            0% { transform: translateY(-10vh) translateX(0); opacity: 1; }
            100% { transform: translateY(110vh) translateX(20px); opacity: 0.3; }
        }
        .snowflake {
            position: absolute;
            top: -10px;
            color: white;
            border-radius: 50%;
            background-color: white;
            animation: fall linear infinite;
        }

        /* Modal Animation */
        @keyframes modalPop {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .modal-content-anim {
            animation: modalPop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .ornament-hover {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: center;
            transform-box: fill-box;
            cursor: pointer;
        }
        .ornament-hover:hover {
            transform: scale(1.4);
            z-index: 50;
        }

        /* Glassmorphism Panel */
        .glass-panel {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Custom Radio Button for Colors */
        .color-radio:checked + label {
            transform: scale(1.2);
            border: 2px solid white;
            box-shadow: 0 0 10px rgba(255,255,255,0.5);
        }

        /* Cursor saat mode placing */
        .cursor-crosshair-custom {
            cursor: crosshair !important;
        }
        
        .pulse-ring {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }
    </style>
<script type="importmap">
{
  "imports": {
    "react": "https://aistudiocdn.com/react@^19.2.0",
    "react-dom/": "https://aistudiocdn.com/react-dom@^19.2.0/",
    "react/": "https://aistudiocdn.com/react@^19.2.0/",
    "lucide-react": "https://aistudiocdn.com/lucide-react@^0.555.0"
  }
}
</script>
</head>
<body class="overflow-hidden font-sans text-white">

    <!-- Background dengan warna request #a18cd1 -->
    <div class="relative min-h-screen w-full bg-gradient-to-b from-[#a18cd1] to-[#7f6eb0] flex flex-col items-center justify-center overflow-hidden">
        
        <!-- Efek Salju (Diisi oleh JS) -->
        <div id="snow-container" class="absolute inset-0 pointer-events-none overflow-hidden z-0"></div>
        
        <!-- Back to Dashboard Button -->
        <a href="dashboard" class="absolute top-4 left-4 z-40 bg-pink-500 hover:bg-pink-600 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-transform hover:scale-110 group">
            <i class="fas fa-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
        </a>

        <!-- Header -->
        <div class="absolute top-4 md:top-8 text-center z-10 px-4 w-full transition-opacity duration-300" id="main-header">
            <h1 class="text-3xl md:text-5xl font-serif text-yellow-300 drop-shadow-[0_0_10px_rgba(250,204,21,0.5)] tracking-wide mb-1">
                Christmas Wishnotes
            </h1>
            <p class="text-white text-sm md:text-base font-light opacity-90 drop-shadow-sm">
                Gantungkan harapanmu di pohon natal ini
            </p>
        </div>

        <!-- Placement Instruction Banner (Hidden by default) -->
        <div id="placement-banner" class="absolute top-24 z-30 hidden flex-col items-center animate-bounce">
            <div class="bg-slate-800/90 text-white px-6 py-3 rounded-full border border-yellow-400 shadow-[0_0_15px_rgba(250,204,21,0.3)] flex items-center gap-3">
                <i class="fas fa-hand-pointer text-yellow-400"></i>
                <span class="font-bold">Klik di mana saja pada pohon!</span>
            </div>
            <button onclick="cancelPlacement()" class="mt-2 text-sm bg-red-600/80 px-4 py-1 rounded-full hover:bg-red-600 transition-colors shadow-sm">
                Batal
            </button>
        </div>

        <!-- Area Pohon Natal SVG -->
        <div class="relative z-10 w-full max-w-lg md:max-w-xl px-4 mt-8 flex items-center justify-center h-[65vh] md:h-[75vh]">
            <svg id="christmas-tree-svg" viewBox="0 0 100 120" class="w-full h-full max-h-[85vh] overflow-visible transition-all duration-300" preserveAspectRatio="xMidYMax meet" onclick="handleSvgClick(event)">
                <!-- Definisi Gradient & Efek -->
                <defs>
                    <linearGradient id="treeGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#052e16" stop-opacity="0.8" />
                        <stop offset="50%" stop-color="#14532d" stop-opacity="0" />
                        <stop offset="100%" stop-color="#052e16" stop-opacity="0.8" />
                    </linearGradient>
                    <radialGradient id="ballShine" cx="30%" cy="30%" r="50%">
                        <stop offset="0%" stop-color="white" stop-opacity="0.9" />
                        <stop offset="100%" stop-color="white" stop-opacity="0" />
                    </radialGradient>
                    <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                        <feGaussianBlur stdDeviation="1.5" result="blur" />
                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                    </filter>
                </defs>

                <!-- Bayangan Lantai -->
                <ellipse cx="50" cy="105" rx="30" ry="5" fill="#000000" opacity="0.3" />

                <!-- Batang Pohon -->
                <rect x="45" y="90" width="10" height="15" fill="#451a03" />

                <!-- Lapisan Daun -->
                <path d="M50 20 L15 90 H85 Z" fill="#14532d" />
                <path d="M50 20 L15 90 H85 Z" fill="url(#treeGradient)" />
                <path d="M50 30 L20 90 H80 Z" fill="#166534" opacity="0.8" />
                <path d="M50 15 L25 60 H75 Z" fill="#15803d" />

                <!-- Hiasan Tali Emas -->
                <path d="M35 45 Q50 55 65 45" fill="none" stroke="#FCD34D" stroke-width="0.5" opacity="0.6" />
                <path d="M25 70 Q50 85 75 70" fill="none" stroke="#FCD34D" stroke-width="0.5" opacity="0.6" />

                <!-- Bintang -->
                <g class="animate-twinkle cursor-pointer" onclick="event.stopPropagation(); alert('Selamat Natal!')">
                    <polygon points="50,5 53,15 63,15 55,22 58,32 50,25 42,32 45,22 37,15 47,15"
                        fill="#FACC15" stroke="#FEF08A" stroke-width="0.5"
                        class="drop-shadow-[0_0_15px_rgba(250,204,21,1)]" />
                </g>

                <!-- Group untuk Bola-Bola (Ornamen) -->
                <g id="ornaments-layer">
                    <!-- Bola akan digenerate via JS -->
                </g>
            </svg>
        </div>

        <!-- Dashboard Kontrol (Statistik & Tombol) -->
        <div id="controls-dashboard" class="absolute bottom-6 md:right-8 flex flex-col md:flex-row items-center gap-4 z-20 transition-transform duration-300">
            
            <!-- Stats Panel -->
            <div class="glass-panel rounded-2xl p-3 flex items-center gap-6 px-6 shadow-lg">
                <div class="text-center">
                    <div class="text-xs text-blue-100 uppercase tracking-wider">Total Bola</div>
                    <div class="text-xl font-bold text-white" id="total-balls">0</div>
                </div>
                <div class="w-px h-8 bg-white/40"></div>
                <div class="text-center cursor-pointer group" onclick="toggleLike()">
                    <div class="text-xs text-blue-100 uppercase tracking-wider group-hover:text-pink-300 transition-colors">Likes</div>
                    <div class="flex items-center gap-1 justify-center">
                        <i id="like-icon" class="fas fa-heart text-white transition-all duration-300"></i>
                        <span class="text-xl font-bold text-white" id="total-likes">0</span>
                    </div>
                </div>
            </div>

            <!-- Add Button (Trigger Placement Mode) -->
            <button onclick="startPlacementMode()" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white rounded-full p-4 shadow-lg shadow-red-900/50 transform hover:scale-105 transition-all flex items-center gap-2 group pulse-ring border border-red-400">
                <i class="fas fa-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="font-bold pr-2">Tambah Pesan</span>
            </button>

        </div>

        <!-- Modal Baca Pesan (View Modal) -->
        <div id="view-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <div onclick="closeViewModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity cursor-pointer"></div>
            
            <div class="modal-content-anim relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 overflow-hidden">
                <!-- Background Decoration -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 via-red-500 to-green-500"></div>
                
                <!-- Icon Header -->
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white rounded-full p-3 shadow-lg border-4 border-red-50">
                    <div id="view-icon-bg" class="rounded-full bg-red-100 p-3">
                        <i class="fas fa-gift text-2xl text-red-600"></i>
                    </div>
                </div>

                <button onclick="closeViewModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <div class="mt-8 text-center">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Pesan Dari</h3>
                    <h2 id="view-author" class="text-xl font-serif text-gray-800 font-bold mb-4">Nama Pengirim</h2>
                    
                    <div class="bg-gray-50 rounded-xl p-6 mb-4 relative">
                        <i class="fas fa-quote-left absolute top-2 left-3 text-gray-300 text-xl"></i>
                        <p id="view-message" class="text-gray-700 text-lg leading-relaxed font-light italic">
                            Isi pesan akan muncul di sini...
                        </p>
                        <i class="fas fa-quote-right absolute bottom-2 right-3 text-gray-300 text-xl"></i>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button onclick="closeViewModal()" class="px-6 py-2 bg-slate-800 text-white rounded-full hover:bg-slate-700 transition-colors shadow-lg">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Pesan (Form Modal) -->
        <div id="form-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <div onclick="closeFormModal()" class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity cursor-pointer"></div>
            
            <div class="modal-content-anim relative bg-slate-800 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-md p-6 text-white">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-serif text-yellow-400">Tulis Harapanmu</h3>
                    <button onclick="closeFormModal()" class="text-slate-400 hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form id="msgForm" onsubmit="event.preventDefault(); submitMessage();">
                    <div class="mb-4">
                        <label class="block text-slate-400 text-sm font-bold mb-2">Nama (Boleh Anonim)</label>
                        <input type="text" id="inputName" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-yellow-500 transition-colors text-white placeholder-slate-500" placeholder="Contoh: Secret Santa">
                    </div>

                    <div class="mb-4">
                        <label class="block text-slate-400 text-sm font-bold mb-2">Pesan Natal</label>
                        <textarea id="inputMessage" rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:border-yellow-500 transition-colors text-white placeholder-slate-500" placeholder="Tulis harapan atau ucapanmu disini..." required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-slate-400 text-sm font-bold mb-3">Pilih Warna Bola</label>
                        <div class="flex justify-center gap-3">
                            <!-- Merah -->
                            <div class="relative">
                                <input type="radio" name="ballColor" id="c_red" value="#EF4444" class="opacity-0 absolute inset-0 cursor-pointer color-radio" checked>
                                <label for="c_red" class="block w-10 h-10 rounded-full bg-red-500 cursor-pointer transition-transform hover:scale-110"></label>
                            </div>
                            <!-- Kuning -->
                            <div class="relative">
                                <input type="radio" name="ballColor" id="c_yellow" value="#EAB308" class="opacity-0 absolute inset-0 cursor-pointer color-radio">
                                <label for="c_yellow" class="block w-10 h-10 rounded-full bg-yellow-500 cursor-pointer transition-transform hover:scale-110"></label>
                            </div>
                            <!-- Hijau -->
                            <div class="relative">
                                <input type="radio" name="ballColor" id="c_green" value="#10B981" class="opacity-0 absolute inset-0 cursor-pointer color-radio">
                                <label for="c_green" class="block w-10 h-10 rounded-full bg-emerald-500 cursor-pointer transition-transform hover:scale-110"></label>
                            </div>
                            <!-- Biru -->
                            <div class="relative">
                                <input type="radio" name="ballColor" id="c_blue" value="#3B82F6" class="opacity-0 absolute inset-0 cursor-pointer color-radio">
                                <label for="c_blue" class="block w-10 h-10 rounded-full bg-blue-500 cursor-pointer transition-transform hover:scale-110"></label>
                            </div>
                            <!-- Ungu -->
                            <div class="relative">
                                <input type="radio" name="ballColor" id="c_purple" value="#A855F7" class="opacity-0 absolute inset-0 cursor-pointer color-radio">
                                <label for="c_purple" class="block w-10 h-10 rounded-full bg-purple-500 cursor-pointer transition-transform hover:scale-110"></label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-500 hover:to-green-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-900/50 transition-all transform hover:scale-[1.02]">
                        Gantung Pesan <i class="fas fa-tree ml-2"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        // --- DATA AWAL ---
        const initialData = [
            { name: "Admin", message: "Selamat Natal! Klik tombol + lalu klik pohon untuk menambah bola baru.", color: "#EF4444", x: 50, y: 30 },
            { name: "Santa", message: "Ho Ho Ho! Semoga liburanmu menyenangkan.", color: "#EAB308", x: 40, y: 55 },
            { name: "Rudolph", message: "Jaga kesehatan di musim dingin ini ya!", color: "#3B82F6", x: 60, y: 55 }
        ];

        let messages = [];
        let likeCount = 0;
        let isLiked = false;

        let isPlacementMode = false;
        let tempCoords = null; 

        // --- Logic Salju ---
        function createSnowflakes() {
            const container = document.getElementById('snow-container');
            const flakeCount = 50;
            container.innerHTML = ''; // Reset

            for (let i = 0; i < flakeCount; i++) {
                const flake = document.createElement('div');
                flake.classList.add('snowflake');
                flake.style.left = Math.random() * 100 + '%';
                flake.style.width = (Math.random() * 0.5 + 0.2) + 'rem';
                flake.style.height = flake.style.width;
                flake.style.opacity = Math.random() * 0.5 + 0.3;
                flake.style.animationDuration = (Math.random() * 5 + 5) + 's';
                flake.style.animationDelay = (Math.random() * 5) + 's';
                container.appendChild(flake);
            }
        }

        // --- Logic Mode Penempatan ---
        function startPlacementMode() {
            isPlacementMode = true;
            tempCoords = null;
            
            // UI Updates
            document.getElementById('controls-dashboard').classList.add('translate-y-40', 'opacity-0'); 
            document.getElementById('placement-banner').classList.remove('hidden');
            document.getElementById('placement-banner').classList.add('flex');
            document.getElementById('christmas-tree-svg').classList.add('cursor-crosshair-custom');
            document.getElementById('main-header').classList.add('opacity-50');
        }

        function exitPlacementMode(clearData = true) {
            isPlacementMode = false;
            
            if (clearData) {
                tempCoords = null;
            }

            // UI Reset
            document.getElementById('controls-dashboard').classList.remove('translate-y-40', 'opacity-0');
            document.getElementById('placement-banner').classList.add('hidden');
            document.getElementById('placement-banner').classList.remove('flex');
            document.getElementById('christmas-tree-svg').classList.remove('cursor-crosshair-custom');
            document.getElementById('main-header').classList.remove('opacity-50');
        }

        function cancelPlacement() {
            exitPlacementMode(true);
        }

        // --- Handle Klik di SVG ---
        function handleSvgClick(evt) {
            if (!isPlacementMode) return;

            evt.stopPropagation();

            const svg = document.getElementById('christmas-tree-svg');
            const pt = svg.createSVGPoint();

            pt.x = evt.clientX;
            pt.y = evt.clientY;

            const cursorPoint = pt.matrixTransform(svg.getScreenCTM().inverse());
            
            tempCoords = {
                x: Math.round(cursorPoint.x * 10) / 10,
                y: Math.round(cursorPoint.y * 10) / 10
            };

            exitPlacementMode(false);
            openFormModal();
        }

        // --- Logic Render Bola ---
        function renderBall(data) {
            const container = document.getElementById('ornaments-layer');
            const pos = { x: data.x || 50, y: data.y || 50 };
            
            const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
            g.setAttribute("class", "ornament-hover");
            g.setAttribute("onclick", `event.stopPropagation(); openViewModal('${data.name.replace(/'/g, "\\'")}', '${data.message.replace(/'/g, "\\'")}')`);

            // Tali
            const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
            line.setAttribute("x1", pos.x);
            line.setAttribute("y1", pos.y - 3);
            line.setAttribute("x2", pos.x);
            line.setAttribute("y2", pos.y - 6);
            line.setAttribute("stroke", "#FCD34D");
            line.setAttribute("stroke-width", "0.5");
            line.setAttribute("opacity", "0.8");

            // Bola Warna
            const circleBase = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            circleBase.setAttribute("cx", pos.x);
            circleBase.setAttribute("cy", pos.y);
            circleBase.setAttribute("r", "3.5");
            circleBase.setAttribute("fill", data.color);
            circleBase.setAttribute("class", "drop-shadow-lg");

            // Efek Kilap
            const circleShine = document.createElementNS("http://www.w3.org/2000/svg", "circle");
            circleShine.setAttribute("cx", pos.x);
            circleShine.setAttribute("cy", pos.y);
            circleShine.setAttribute("r", "3.5");
            circleShine.setAttribute("fill", "url(#ballShine)");
            circleShine.setAttribute("opacity", "0.6");

            g.appendChild(line);
            g.appendChild(circleBase);
            g.appendChild(circleShine);

            g.style.opacity = '0';
            g.style.transform = 'scale(0)';
            container.appendChild(g);

            setTimeout(() => {
                g.style.transition = "all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
                g.style.opacity = '1';
                g.style.transform = 'scale(1)';
            }, 50);

            messages.push(data);
            document.getElementById('total-balls').innerText = messages.length;
        }

        // --- Logic Modals ---
        function openViewModal(name, message) {
            if (isPlacementMode) return;
            document.getElementById('view-author').textContent = name;
            document.getElementById('view-message').textContent = message;
            document.getElementById('view-modal').classList.remove('hidden');
        }

        function closeViewModal() {
            document.getElementById('view-modal').classList.add('hidden');
        }

        function openFormModal() {
            document.getElementById('form-modal').classList.remove('hidden');
            setTimeout(() => document.getElementById('inputName').focus(), 100);
        }

        function closeFormModal() {
            document.getElementById('form-modal').classList.add('hidden');
            tempCoords = null; 
        }

        // --- Logic Submit Form ---
        function submitMessage() {
            const nameInput = document.getElementById('inputName').value;
            const msgInput = document.getElementById('inputMessage').value;
            
            const colors = document.getElementsByName('ballColor');
            let selectedColor = '#EF4444';
            for(const c of colors) {
                if(c.checked) selectedColor = c.value;
            }

            if (!msgInput.trim()) {
                alert("Isi pesan dulu ya!");
                return;
            }

            const finalX = tempCoords ? tempCoords.x : 50;
            const finalY = tempCoords ? tempCoords.y : 50;

            const newMessage = {
                name: nameInput.trim() || "Anonim",
                message: msgInput,
                color: selectedColor,
                x: finalX,
                y: finalY
            };

            renderBall(newMessage);

            document.getElementById('msgForm').reset();
            document.getElementById('c_red').checked = true;
            tempCoords = null;
            
            closeFormModal();
            document.getElementById('christmas-tree-svg').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // --- Logic Like ---
        function toggleLike() {
            const likeEl = document.getElementById('total-likes');
            const iconEl = document.getElementById('like-icon');
            
            if (isLiked) {
                likeCount--;
                isLiked = false;
                iconEl.classList.remove('text-pink-500');
            } else {
                likeCount++;
                isLiked = true;
                iconEl.classList.add('text-pink-500');
                
                iconEl.classList.add('scale-125');
                setTimeout(() => {
                    iconEl.classList.remove('scale-125');
                }, 200);
            }

            likeEl.innerText = likeCount;
        }

        // --- Initialize ---
        document.addEventListener('DOMContentLoaded', () => {
            createSnowflakes();
            initialData.forEach(item => renderBall(item));
        });

    </script>
</body>
</html>