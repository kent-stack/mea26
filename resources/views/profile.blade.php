@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<style>
    .region-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%230ea5e9' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem 1rem;
        padding-right: 2.75rem;
    }

</style>
<section class="py-20 bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">{{ auth()->user()->is_admin ? 'Admin Profile' : 'Participant Profile' }}</p>
            <h1 class="mt-2 text-3xl font-extrabold text-slate-800">Profile</h1>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->is_admin)
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="space-y-4 text-slate-700">
                    <div class="flex justify-between border-b border-slate-200 pb-3">
                        <span class="font-medium">Name</span>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 pb-3">
                        <span class="font-medium">Email</span>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 pb-3">
                        <span class="font-medium">Role</span>
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        @else
            <div class="space-y-6">
                <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="profile-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                            <h2 class="text-lg font-bold text-slate-800">Participant Profile</h2>
                            <button type="button" class="toggle-card inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 transition hover:bg-slate-100" aria-expanded="true" aria-label="Toggle participant profile card">
                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body p-5">
                            <div class="grid gap-5 md:grid-cols-[140px_1fr] md:items-center">
                                <div class="mx-auto h-40 w-32 overflow-hidden rounded-xl border border-slate-200 bg-slate-100 shadow-inner">
                                    @if(auth()->user()->photo_3x4)
                                        <img src="{{ route('users.photo', auth()->user()) }}" alt="3x4 Photo" class="h-full w-full object-cover" />
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-sky-100 to-sky-200 text-3xl font-bold text-sky-700">
                                            {{ strtoupper(substr(auth()->user()->full_name ?: auth()->user()->name ?: 'P', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
 
                                <div class="space-y-4">
                                    <div>
                                        <label for="full_name" class="mb-2 block text-sm font-semibold text-slate-700">Full name</label>
                                        <input id="full_name" name="full_name" type="text" value="{{ old('full_name', auth()->user()->full_name ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                        @error('full_name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
 
                                    <div>
                                        <label for="school_origin" class="mb-2 block text-sm font-semibold text-slate-700">School origin</label>
                                        <input id="school_origin" name="school_origin" type="text" value="{{ old('school_origin', auth()->user()->school_origin ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                        @error('school_origin')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
 
                                    <div>
                                        <label for="photo_3x4" class="mb-2 block text-sm font-semibold text-slate-700">3x4 Photo</label>
                                        <input id="photo_3x4" name="photo_3x4" type="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.webp,.avif,image/*" class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-sky-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-sky-700">
                                        @error('photo_3x4')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                            <h2 class="text-lg font-bold text-slate-800">Participant Details</h2>
                            <button type="button" class="toggle-card inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 transition hover:bg-slate-100" aria-expanded="true" aria-label="Toggle personal data card">
                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body grid gap-4 p-5 md:grid-cols-2">
                            <div>
                                <label for="gender" class="mb-2 block text-sm font-semibold text-slate-700">Gender</label>
                                <select id="gender" name="gender" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                    <option value="">-- Select --</option>
                                    <option value="Laki-laki" {{ old('gender', auth()->user()->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Male</option>
                                    <option value="Perempuan" {{ old('gender', auth()->user()->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="place_of_birth" class="mb-2 block text-sm font-semibold text-slate-700">Place of birth</label>
                                <input id="place_of_birth" name="place_of_birth" type="text" value="{{ old('place_of_birth', auth()->user()->place_of_birth ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                @error('place_of_birth')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_of_birth" class="mb-2 block text-sm font-semibold text-slate-700">Date of birth</label>
                                <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', optional(auth()->user()->date_of_birth)->format('Y-m-d') ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                @error('date_of_birth')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="profile-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                            <h2 class="text-lg font-bold text-slate-800">Participant Address</h2>
                            <button type="button" class="toggle-card inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 transition hover:bg-slate-100" aria-expanded="true" aria-label="Toggle address card">
                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body grid gap-4 p-5 md:grid-cols-2">
                            <div>
                                <label for="provinsi" class="mb-2 block text-sm font-semibold text-slate-700">Province</label>
                                <select id="provinsi" name="provinsi" data-selected="{{ old('provinsi', auth()->user()->provinsi ?? '') }}" class="region-select w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value=""></option>
                                </select>
                            </div>

                            <div>
                                <label for="kabupaten_kota" class="mb-2 block text-sm font-semibold text-slate-700">City / Regency</label>
                                <select id="kabupaten_kota" name="kabupaten_kota" data-selected="{{ old('kabupaten_kota', auth()->user()->kabupaten_kota ?? '') }}" class="region-select w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value=""></option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="jalan" class="mb-2 block text-sm font-semibold text-slate-700">Street</label>
                                <input id="jalan" name="jalan" type="text" value="{{ old('jalan', auth()->user()->jalan ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            </div>

                            <div>
                                <label for="dusun" class="mb-2 block text-sm font-semibold text-slate-700">Sub-Village</label>
                                <input id="dusun" name="dusun" type="text" value="{{ old('dusun', auth()->user()->dusun ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            </div>

                            <div>
                                <label for="kecamatan" class="mb-2 block text-sm font-semibold text-slate-700">District</label>
                                <select id="kecamatan" name="kecamatan" data-selected="{{ old('kecamatan', auth()->user()->kecamatan ?? '') }}" class="region-select w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value=""></option>
                                </select>
                            </div>

                            <div>
                                <label for="kelurahan_desa" class="mb-2 block text-sm font-semibold text-slate-700">Sub-District</label>
                                <select id="kelurahan_desa" name="kelurahan_desa" data-selected="{{ old('kelurahan_desa', auth()->user()->kelurahan_desa ?? '') }}" class="region-select w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                    <option value=""></option>
                                </select>
                            </div>

                            <div>
                                <label for="rt" class="mb-2 block text-sm font-semibold text-slate-700">RT</label>
                                <input id="rt" name="rt" type="text" value="{{ old('rt', auth()->user()->rt ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            </div>

                            <div>
                                <label for="rw" class="mb-2 block text-sm font-semibold text-slate-700">RW</label>
                                <input id="rw" name="rw" type="text" value="{{ old('rw', auth()->user()->rw ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            </div>

                            <div>
                                <label for="kode_pos" class="mb-2 block text-sm font-semibold text-slate-700">Postal code</label>
                                <input id="kode_pos" name="kode_pos" type="text" value="{{ old('kode_pos', auth()->user()->kode_pos ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Complete address</label>
                                <textarea id="address" name="address" rows="3" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                            </div>

                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-card rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
                            <h2 class="text-lg font-bold text-slate-800">Account & Other Information</h2>
                            <button type="button" class="toggle-card inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 transition hover:bg-slate-100" aria-expanded="true" aria-label="Toggle account card">
                                <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body grid gap-4 p-5 md:grid-cols-2">
                            <div>
                                <label for="whatsapp_number" class="mb-2 block text-sm font-semibold text-slate-700">WhatsApp Number</label>
                                <input id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number', auth()->user()->whatsapp_number ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                @error('whatsapp_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="telegram_number" class="mb-2 block text-sm font-semibold text-slate-700">Telegram Number</label>
                                <input id="telegram_number" name="telegram_number" type="text" value="{{ old('telegram_number', auth()->user()->telegram_number ?? '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                                @error('telegram_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', '') }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200" required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="rounded-full bg-sky-600 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-700">Save Profile</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const provinceSelect = document.getElementById('provinsi');
        const citySelect = document.getElementById('kabupaten_kota');
        const districtSelect = document.getElementById('kecamatan');
        const villageSelect = document.getElementById('kelurahan_desa');
        const postalCodeInput = document.getElementById('kode_pos');

        function syncPostalCodeFromVillage() {
            if (!postalCodeInput) {
                return;
            }

            const selectedOption = Array.from(villageSelect.options).find(function (option) {
                return option.value === villageSelect.value;
            });

            postalCodeInput.value = selectedOption && selectedOption.dataset.postalCode ? selectedOption.dataset.postalCode : '';
        }

        function fillSelect(selectElement, items, selectedValue, labelKey = 'name', valueKey = 'name') {
            selectElement.innerHTML = '<option value=""></option>';

            items.forEach(function (item) {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[labelKey];
                option.dataset.code = item.code || '';
                option.dataset.postalCode = item.postal_code || item.postalCode || '';

                if (String(item[valueKey]) === String(selectedValue)) {
                    option.selected = true;
                }

                selectElement.appendChild(option);
            });
        }

        function setSelectedState() {
            const provinceValue = provinceSelect.dataset.selected || provinceSelect.value || '';
            const cityValue = citySelect.dataset.selected || citySelect.value || '';
            const districtValue = districtSelect.dataset.selected || districtSelect.value || '';
            const villageValue = villageSelect.dataset.selected || villageSelect.value || '';

            if (provinceValue) {
                provinceSelect.value = provinceValue;
            }
            if (cityValue) {
                citySelect.value = cityValue;
            }
            if (districtValue) {
                districtSelect.value = districtValue;
            }
            if (villageValue) {
                villageSelect.value = villageValue;
            }
        }

        function loadProvinces() {
            fetch('/wilayah/provinces')
                .then(function (response) { return response.json(); })
                .then(function (provinces) {
                    fillSelect(provinceSelect, provinces, provinceSelect.dataset.selected || provinceSelect.value || '', 'name', 'name');
                    if (provinceSelect.dataset.selected) {
                        provinceSelect.value = provinceSelect.dataset.selected;
                    }
                    if (provinceSelect.value) {
                        loadCities(provinceSelect.value);
                    }
                });
        }

        function loadCities(provinceName) {
            const currentProvince = Array.from(provinceSelect.options).find(function (option) {
                return String(option.value) === String(provinceName);
            });
            const provinceCode = currentProvince && currentProvince.dataset.code ? currentProvince.dataset.code : '';

            citySelect.dataset.selected = citySelect.dataset.selected || citySelect.value || '';
            districtSelect.dataset.selected = '';
            villageSelect.dataset.selected = '';
            citySelect.innerHTML = '<option value=""></option>';
            districtSelect.innerHTML = '<option value=""></option>';
            villageSelect.innerHTML = '<option value=""></option>';

            if (!provinceCode) {
                return;
            }

            fetch('/wilayah/cities/' + encodeURIComponent(provinceCode))
                .then(function (response) { return response.json(); })
                .then(function (cities) {
                    fillSelect(citySelect, cities, citySelect.dataset.selected || citySelect.value || '', 'name', 'name');
                    if (citySelect.dataset.selected) {
                        citySelect.value = citySelect.dataset.selected;
                    }
                    if (citySelect.value) {
                        loadDistricts(citySelect.value);
                    }
                });
        }

        function loadDistricts(cityName) {
            const currentCity = Array.from(citySelect.options).find(function (option) {
                return String(option.value) === String(cityName);
            });
            const cityCode = currentCity && currentCity.dataset.code ? currentCity.dataset.code : '';

            districtSelect.dataset.selected = districtSelect.dataset.selected || districtSelect.value || '';
            villageSelect.dataset.selected = '';
            districtSelect.innerHTML = '<option value=""></option>';
            villageSelect.innerHTML = '<option value=""></option>';

            if (!cityCode) {
                return;
            }

            fetch('/wilayah/districts/' + encodeURIComponent(cityCode))
                .then(function (response) { return response.json(); })
                .then(function (districts) {
                    fillSelect(districtSelect, districts, districtSelect.dataset.selected || districtSelect.value || '', 'name', 'name');
                    if (districtSelect.dataset.selected) {
                        districtSelect.value = districtSelect.dataset.selected;
                    }
                    if (districtSelect.value) {
                        loadVillages(districtSelect.value);
                    }
                });
        }

        function loadVillages(districtName) {
            const currentDistrict = Array.from(districtSelect.options).find(function (option) {
                return String(option.value) === String(districtName);
            });
            const districtCode = currentDistrict && currentDistrict.dataset.code ? currentDistrict.dataset.code : '';

            villageSelect.dataset.selected = villageSelect.dataset.selected || villageSelect.value || '';
            villageSelect.innerHTML = '<option value=""></option>';

            if (!districtCode) {
                return;
            }

            fetch('/wilayah/villages/' + encodeURIComponent(districtCode))
                .then(function (response) { return response.json(); })
                .then(function (villages) {
                    fillSelect(villageSelect, villages, villageSelect.dataset.selected || villageSelect.value || '', 'name', 'name');
                    if (villageSelect.dataset.selected) {
                        villageSelect.value = villageSelect.dataset.selected;
                    }
                    syncPostalCodeFromVillage();
                });
        }

        provinceSelect.addEventListener('change', function () {
            citySelect.dataset.selected = '';
            districtSelect.dataset.selected = '';
            villageSelect.dataset.selected = '';
            loadCities(provinceSelect.value);
        });

        citySelect.addEventListener('change', function () {
            districtSelect.dataset.selected = '';
            villageSelect.dataset.selected = '';
            if (citySelect.value) {
                loadDistricts(citySelect.value);
            }
        });

        districtSelect.addEventListener('change', function () {
            villageSelect.dataset.selected = '';
            if (districtSelect.value) {
                loadVillages(districtSelect.value);
            } else {
                villageSelect.innerHTML = '<option value=""></option>';
                syncPostalCodeFromVillage();
            }
        });

        villageSelect.addEventListener('change', function () {
            syncPostalCodeFromVillage();
        });

        document.querySelectorAll('.toggle-card').forEach(function (button) {
            button.addEventListener('click', function () {
                const card = button.closest('.profile-card');
                const body = card.querySelector('.card-body');
                const isExpanded = button.getAttribute('aria-expanded') === 'true';

                button.setAttribute('aria-expanded', String(!isExpanded));
                body.classList.toggle('hidden');
                button.querySelector('svg').style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
            });
        });

        setSelectedState();
        loadProvinces();
    });
</script>
@endsection
