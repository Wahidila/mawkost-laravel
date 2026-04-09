{{-- Facility Modal with Icon Picker --}}
@push('modals')
<div id="facilityModal" style="display:none;" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center p-4">
    <div class="bg-white/95 backdrop-blur-xl rounded-2xl shadow-[0_16px_48px_rgba(92,61,46,0.15)] border border-primary-lighter/30 relative w-full max-w-lg max-h-[90vh] overflow-y-auto animate-fade-in">
        <button onclick="closeFacilityModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10">
            <i class="fas fa-times text-lg"></i>
        </button>

        <div class="p-6">
            <h3 class="text-lg font-bold font-display text-primary-dark mb-1">Tambah Fasilitas Baru</h3>
            <p class="text-xs text-gray-500 mb-5">Fasilitas ini akan langsung tersedia di seluruh data kost.</p>

            <form id="form-add-facility" onsubmit="submitFacility(event)">
                {{-- Icon Picker --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-primary-dark mb-2">Pilih Ikon</label>
                    <input type="hidden" id="fac_icon" value="fa-solid fa-check" required>

                    {{-- Search --}}
                    <div class="relative mb-3">
                        <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                        <input type="text" id="icon-search" placeholder="Cari ikon..." class="border border-primary-lighter rounded-xl w-full py-2 pl-8 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-primary-lighter/10 transition-all">
                    </div>

                    {{-- Selected Preview --}}
                    <div class="flex items-center gap-3 mb-3 p-3 bg-primary-lighter/30 border border-primary-lighter rounded-xl">
                        <div id="icon-preview" class="w-10 h-10 bg-primary text-white rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-primary-dark" id="icon-label">fa-solid fa-check</p>
                            <p class="text-xs text-primary">Ikon yang dipilih</p>
                        </div>
                    </div>

                    {{-- Icon Grid --}}
                    <div id="icon-grid" class="grid grid-cols-8 gap-1 max-h-48 overflow-y-auto border border-primary-lighter rounded-xl p-2 bg-primary-lighter/10">
                        {{-- Icons will be populated by JS --}}
                    </div>
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <label class="block text-sm font-semibold text-primary-dark mb-2">Nama Fasilitas</label>
                    <input type="text" id="fac_name" placeholder="Contoh: Dispenser, Jemuran, Laundry" class="border border-primary-lighter rounded-xl w-full py-2.5 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-primary-lighter/10 transition-all" required>
                </div>

                {{-- Category --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-primary-dark mb-2">Kategori</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="fac_cat_radio" value="kamar" class="peer hidden" checked>
                            <div class="peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary border-2 border-primary-lighter rounded-xl p-3 text-center transition-all hover:border-primary-light">
                                <i class="fas fa-bed text-lg mb-1"></i>
                                <p class="text-xs font-bold">Kamar</p>
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="fac_cat_radio" value="bersama" class="peer hidden">
                            <div class="peer-checked:bg-cta peer-checked:text-white peer-checked:border-cta border-2 border-primary-lighter rounded-xl p-3 text-center transition-all hover:border-cta/50">
                                <i class="fas fa-users text-lg mb-1"></i>
                                <p class="text-xs font-bold">Bersama</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 border-t border-primary-lighter/30 pt-4">
                    <button type="button" onclick="closeFacilityModal()" class="px-4 py-2 rounded-full bg-primary-lighter/40 hover:bg-primary-lighter text-primary-dark text-sm font-medium transition-colors">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white py-2 px-5 rounded-full text-sm font-bold transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-[0_6px_18px_rgba(139,94,60,0.3)]" id="btn-save-fac">
                        <i class="fas fa-plus text-xs"></i> Simpan Fasilitas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .icon-btn {
        width: 2.25rem; height: 2.25rem;
        display: flex; align-items: center; justify-content: center;
        border-radius: 0.625rem; border: 1px solid transparent;
        color: #8C7A6E; cursor: pointer;
        transition: all 0.15s ease;
        font-size: 0.875rem;
        background: transparent;
    }
    .icon-btn:hover { background: #F5E6DB; color: #8B5E3C; border-color: #DEB8A0; }
    .icon-btn.selected { background: #8B5E3C; color: #fff; border-color: #8B5E3C; box-shadow: 0 4px 6px -1px rgba(139,94,60,.3); }
    .animate-fade-in { animation: fadeInUp 0.2s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@push('scripts')
<script>
    let ICON_SET = [];
    let selectedIcon = 'fa-solid fa-check';

    // Fetch FontAwesome icon metadata from our local JSON file
    async function loadIconsFromStylesheet() {
        if (ICON_SET.length > 0) return;
        
        try {
            const response = await fetch('/fa-icons.json?v={{ filemtime(public_path("fa-icons.json")) }}');
            if (response.ok) {
                const allIcons = await response.json();
                
                // Show all icons including brands and regular
                ICON_SET = allIcons;
                
                // Put common kost-relevant icons at the top
                const topIconNames = ['fa-wifi','fa-snowflake','fa-bed','fa-bath','fa-car','fa-motorcycle','fa-check','fa-tv','fa-fan','fa-plug','fa-lock','fa-dumbbell','fa-utensils'];
                ICON_SET.sort((a, b) => {
                    const aName = a.class.replace('fa-solid ', 'fa-');
                    const bName = b.class.replace('fa-solid ', 'fa-');
                    const aIdx = topIconNames.indexOf(aName);
                    const bIdx = topIconNames.indexOf(bName);
                    if(aIdx !== -1 && bIdx !== -1) return aIdx - bIdx;
                    if(aIdx !== -1) return -1;
                    if(bIdx !== -1) return 1;
                    return a.label.localeCompare(b.label);
                });
                
                renderIconGrid();
            } else {
                throw new Error('Failed to load icons metadata');
            }
        } catch(e) {
            console.error("Failed to fetch FontAwesome icons:", e);
            // Fallback
            ICON_SET = [
                {class:'fa-solid fa-check', label:'Check'}, 
                {class:'fa-solid fa-wifi', label:'Wifi'},
                {class:'fa-solid fa-snowflake', label:'AC'}
            ];
            renderIconGrid();
        }
    }

    function renderIconGrid(filter = '') {
        const grid = document.getElementById('icon-grid');
        const q = filter.toLowerCase();
        
        // Show all icons instead of limiting
        const filtered = ICON_SET.filter(ic => 
            ic.label.toLowerCase().includes(q) || ic.class.toLowerCase().includes(q)
        );

        grid.innerHTML = filtered.map(ic => `
            <button type="button" 
                class="icon-btn ${ic.class === selectedIcon ? 'selected' : ''}" 
                data-icon="${ic.class}" 
                title="${ic.label}"
                onclick="pickIcon('${ic.class}', '${ic.label}')">
                <i class="${ic.class}"></i>
            </button>
        `).join('');

        if (filtered.length === 0) {
            grid.innerHTML = '<p class="col-span-8 text-center text-sm text-gray-400 py-4">Ikon tidak ditemukan</p>';
        }
    }

    function pickIcon(iconClass, label) {
        selectedIcon = iconClass;
        document.getElementById('fac_icon').value = iconClass;
        document.getElementById('icon-preview').innerHTML = `<i class="${iconClass}"></i>`;
        document.getElementById('icon-label').textContent = iconClass;

        // Update grid selection
        document.querySelectorAll('.icon-btn').forEach(btn => {
            btn.classList.toggle('selected', btn.dataset.icon === iconClass);
        });
    }

    function openFacilityModal() {
        loadIconsFromStylesheet();
        document.getElementById('facilityModal').style.display = 'flex';
        renderIconGrid();
    }

    function closeFacilityModal() {
        document.getElementById('facilityModal').style.display = 'none';
        document.getElementById('form-add-facility').reset();
        selectedIcon = 'fa-solid fa-check';
        document.getElementById('fac_icon').value = 'fa-solid fa-check';
        document.getElementById('icon-preview').innerHTML = '<i class="fa-solid fa-check"></i>';
        document.getElementById('icon-label').textContent = 'fa-solid fa-check';
        document.getElementById('icon-search').value = '';
    }

    // Search
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('icon-search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                renderIconGrid(e.target.value);
            });
        }
    });

    async function submitFacility(event) {
        event.preventDefault();
        const btn = document.getElementById('btn-save-fac');
        const icon = document.getElementById('fac_icon').value;
        const name = document.getElementById('fac_name').value;
        const categoryEl = document.querySelector('input[name="fac_cat_radio"]:checked');
        const category = categoryEl ? categoryEl.value : 'kamar';

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        try {
            const response = await fetch("{{ route('admin.facilities.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ icon, name, category })
            });

            if (!response.ok) throw new Error('Gagal menyimpan fasilitas');
            const data = await response.json();

            if (data.success && data.facility) {
                const isKamar = data.facility.category === 'kamar';
                const containerId = isKamar ? 'facilities-kamar-container' : 'facilities-bersama-container';
                const container = document.getElementById(containerId);
                
                const html = `
                    <div class="mb-1 facility-checkbox-wrapper">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="facilities[]" value="${data.facility.id}" class="form-checkbox text-blue-600" checked>
                            <span class="ml-2 text-sm"><i class="${data.facility.icon} text-gray-500 w-4 inline-block text-center mr-1"></i> ${data.facility.name}</span>
                        </label>
                    </div>
                `;
                
                if (container) {
                    container.insertAdjacentHTML('beforeend', html);
                    closeFacilityModal();
                } else {
                    window.location.reload();
                }
            }
        } catch (error) {
            console.error(error);
            alert('Gagal menambahkan fasilitas. Pastikan isian sudah benar.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plus"></i> Simpan Fasilitas';
        }
    }
</script>
@endpush
