<x-layout.default>
    <form action="{{ route('pim.brand.update', ['id' => $brand->id]) }}" method="POST" >
        @csrf
        <div class="flex xl:flex-row flex-col gap-3">
            <div class="px-0 flex-1 py-0 ltr:xl:mr-1 rtl:xl:ml-1">
                <div class="panel mb-5 flex items-center gap-3">
                    <label for="slug" class='w-72'>Brand Slug</label>
                    <input disabled
                        id="slug"
                        type="text"
                        name="slug"
                        class="form-input disabled:bg-gray-100"
                        value="http://127.0.0.1:8000/pim/brand/{{ basename(old('slug', $brand->slug)) }}"
                        readonly
                    />
                    <button id="copyBtn" class="btn btn-success" disabled type="button" onclick="copySlug()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6 11C6 8.17157 6 6.75736 6.87868 5.87868C7.75736 5 9.17157 5 12 5H15C17.8284 5 19.2426 5 20.1213 5.87868C21 6.75736 21 8.17157 21 11V16C21 18.8284 21 20.2426 20.1213 21.1213C19.2426 22 17.8284 22 15 22H12C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V11Z"
                                stroke="currentColor"
                                strokeWidth="1.5"
                            />
                            <path
                                d="M6 19C4.34315 19 3 17.6569 3 16V10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H15C16.6569 2 18 3.34315 18 5"
                                stroke="currentColor"
                                strokeWidth="1.5"
                            />
                        </svg>
                    </button>
                    <div>
                        <input disabled type="number" name="sorting" id="sorting" class="form-input w-24" placeholder='0' value='{{ old('sorting', $brand->sorting) }}'>
                        @error('sorting')
                            <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="mb-5" x-data="{
                    tab: 'English',
                    name: '{{ old('name', $brand->name) }}',
                    brand_description: '{{ old('brand_description', $brand->description) }}',
                    nameAr: '{{ old('nameAr', $brand->name_arabic) }}',
                    brand_descriptionAr: '{{ old('brand_descriptionAr', $brand->description_arabic) }}'
                }">
                    <div>
                        <ul class="flex flex-wrap mt-3">
                            <li>
                                <a href="javascript:;" class="p-7 py-3 flex items-center bg-[#f6f7f8] dark:bg-transparent border-transparent border-t-2 dark:hover:bg-[#191e3a] hover:border-secondary hover:text-secondary" :class="{'!border-secondary text-secondary dark:bg-[#191e3a]' : tab !== 'Arabic'}" @click="tab = 'English'">
                                    English
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="p-7 py-3 flex items-center bg-[#f6f7f8] dark:bg-transparent dark:hover:bg-[#191e3a] border-transparent border-t-2  hover:border-secondary hover:text-secondary" :class="{'!border-secondary text-secondary dark:bg-[#191e3a]' : tab === 'Arabic'}" @click="tab = 'Arabic'">
                                    Arabic
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 text-sm">
                        <!-- English Tab -->
                        <div x-show="tab === 'English'" class="panel space-y-3" >
                            <div>
                                <label class="w-72">Brand Name</label>
                                <input disabled
                                    id="name"
                                    type="text"
                                    name="name"
                                    class="form-input"
                                    placeholder="Enter Brand Name"
                                    x-model="name"
                                    @input="updateSlug(name)"
                                />
                                @error('name')
                                    <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label class="w-72">Brand Description</label>
                                <textarea disabled
                                    id="brand_description"
                                    placeholder="Enter Brand Description ..."
                                    name="brand_description"
                                    class="form-input h-20"
                                    x-model="brand_description"
                                ></textarea>
                            </div>
                        </div>

                        <!-- Arabic Tab -->
                        <div x-show="tab === 'Arabic'" class="panel space-y-3" >
                            <div>
                                <label class="w-72">Brand Name - Ar</label>
                                <input disabled
                                    id="nameAr"
                                    type="text"
                                    name="nameAr"
                                    class="form-input"
                                    placeholder="Enter Brand Name - Ar"
                                    x-model="nameAr"
                                />
                                @error('nameAr')
                                    <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label class="w-72">Brand Description - Ar</label>
                                <textarea disabled
                                    id="brand_descriptionAr"
                                    placeholder="Enter Brand Description - Ar"
                                    name="brand_descriptionAr"
                                    class="form-input h-20"
                                    x-model="brand_descriptionAr"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5" x-data="{
                    tab: 'MetaData - En',
                    metatitle: '{{ old('metatitle', $brand->meta_title) }}',
                    metatags: '{{ old('metatags', $brand->meta_tags) }}',
                    h1: '{{ old('h1', $brand->h1_en) }}',
                    h1Ar: '{{ old('h1Ar', $brand->h1_arabic) }}',
                    metadescription: '{{ old('metadescription', $brand->meta_description) }}',
                    metatitleAr: '{{ old('metatitleAr', $brand->meta_title_arabic) }}',
                    metatagsAr: '{{ old('metatagsAr', $brand->meta_tags_arabic) }}',
                    metadescriptionAr: '{{ old('metadescriptionAr', $brand->meta_description_arabic) }}',
                }">
                    <div>
                        <ul class="flex flex-wrap mt-3">
                            <li>
                                <a href="javascript:;" class="p-7 py-3 flex items-center bg-[#f6f7f8] dark:bg-transparent border-transparent border-t-2 dark:hover:bg-[#191e3a] hover:border-secondary hover:text-secondary" :class="{'!border-secondary text-secondary dark:bg-[#191e3a]' : tab !== 'MetaData - Ar'}" @click="tab = 'MetaData - En'">
                                    MetaData - En
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="p-7 py-3 flex items-center bg-[#f6f7f8] dark:bg-transparent dark:hover:bg-[#191e3a] border-transparent border-t-2 hover:border-secondary hover:text-secondary" :class="{'!border-secondary text-secondary dark:bg-[#191e3a]' : tab === 'MetaData - Ar'}" @click="tab = 'MetaData - Ar'">
                                    MetaData - Ar
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 text-sm">
                        <!-- MetaData - En Tab -->
                        <div x-show="tab === 'MetaData - En'" class="panel space-y-3" >
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="w-72">Meta Title</label>
                                    <input disabled
                                        id="metatitle"
                                        type="text"
                                        name="metatitle"
                                        class="form-input"
                                        placeholder="Enter Meta Title"
                                        x-model="metatitle"
                                    />
                                </div>
                                <div>
                                    <label class="w-72">Meta Tags</label>
                                    <input disabled
                                        id="metatags"
                                        type="text"
                                        name="metatags"
                                        class="form-input"
                                        placeholder="Enter Meta Tags"
                                        x-model="metatags"
                                    />
                                </div>
                            </div>
                           <div>
                                <label class="w-72">H1 - En</label>
                                <input disabled
                                    id="h1"
                                    type="text"
                                    name="h1"
                                    class="form-input"
                                    placeholder="Enter H1 - En"
                                    x-model="h1"
                                />
                            </div>
                            <div>
                                <label class="w-72">Meta Description</label>
                                <textarea disabled
                                    id="metadescription"
                                    placeholder="Enter Meta Description ..."
                                    name="metadescription"
                                    class="form-input h-20"
                                    x-model="metadescription"
                                ></textarea>
                            </div>
                        </div>

                        <!-- MetaData - Ar Tab -->
                        <div x-show="tab === 'MetaData - Ar'" class="panel space-y-3" >
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="w-72">Meta Title - Ar</label>
                                    <input disabled
                                        id="metatitleAr"
                                        type="text"
                                        name="metatitleAr"
                                        class="form-input"
                                        placeholder="Enter Meta Title - Ar"
                                        x-model="metatitleAr"
                                    />
                                </div>
                                <div>
                                    <label class="w-72">Meta Tags - Ar</label>
                                    <input disabled
                                        id="metatagsAr"
                                        type="text"
                                        name="metatagsAr"
                                        class="form-input"
                                        placeholder="Enter Meta Tags - Ar"
                                        x-model="metatagsAr"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="w-72">H1 - Ar</label>
                                <input disabled
                                    id="h1Ar"
                                    type="text"
                                    name="h1Ar"
                                    class="form-input"
                                    placeholder="H1 - Ar"
                                    x-model="h1Ar"
                                />
                            </div>
                            <div>
                                <label class="w-72">Meta Description - Ar</label>
                                <textarea disabled
                                    id="metadescriptionAr"
                                    placeholder="Enter Meta Description - Ar"
                                    name="metadescriptionAr"
                                    class="form-input h-20"
                                    x-model="metadescriptionAr"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5" x-data="{
                    tab: 'Content - En',
                    contentTitleEn: '{{ old('contenttitle', $brand->content_title) }}',
                    contentDescEn: '{{ old('contentdescription', $brand->content_description) }}',
                    contentTitleAr: '{{ old('contenttitleAr', $brand->content_title_arabic) }}',
                    contentDescAr: '{{ old('contentdescriptionAr', $brand->content_description_arabic) }}'
                }">
                    <div>
                        <ul class="flex flex-wrap mt-3">
                            <li>
                                <a href="javascript:;" class="p-7 py-3 flex items-center bg-[#f6f7f8] dark:bg-transparent border-transparent border-t-2 dark:hover:bg-[#191e3a] hover:border-secondary hover:text-secondary" :class="{'!border-secondary text-secondary dark:bg-[#191e3a]' : tab !== 'Content - Ar'}" @click="tab = 'Content - En'">
                                    Content - En
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="p-7 py-3 flex items-center bg-[#f6f7f8] dark:bg-transparent dark:hover:bg-[#191e3a] border-transparent border-t-2 hover:border-secondary hover:text-secondary" :class="{'!border-secondary text-secondary dark:bg-[#191e3a]' : tab === 'Content - Ar'}" @click="tab = 'Content - Ar'">
                                    Content - Ar
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1 text-sm">
                        <!-- Content in English -->
                        <div x-show="tab === 'Content - En'" class="panel space-y-3" >
                            <div>
                                <label>Content Title - En</label>
                                <input disabled
                                    id="contenttitle"
                                    type="text"
                                    name="contenttitle"
                                    class="form-input"
                                    placeholder="Enter Content Title - En"
                                    x-model="contentTitleEn"
                                />
                            </div>
                            <div>
                                <label>Content Description - En</label>
                                <textarea disabled
                                    class="form-input h-20"
                                    id="contentdescription"
                                    name="contentdescription"
                                    placeholder="Enter Content Description - En"
                                    x-model="contentDescEn"
                                ></textarea>
                            </div>
                        </div>


                        <!-- Content in Arabic -->
                        <div x-show="tab === 'Content - Ar'" class="panel space-y-3" >
                            <div>
                                <label>Content Title - Ar</label>
                                <input disabled
                                    id="contenttitleAr"
                                    type="text"
                                    name="contenttitleAr"
                                    class="form-input"
                                    placeholder="Enter Content Title - Ar"
                                    x-model="contentTitleAr"
                                />
                            </div>
                            <div>
                                <label>Content Description - Ar</label>
                                <textarea disabled
                                    class="form-input h-20"
                                    id="contentdescriptionAr"
                                    name="contentdescriptionAr"
                                    placeholder="Enter Content Description - Ar"
                                    x-model="contentDescAr"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel mb-3">
                    <div class="flex xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-2">
                        <a
                            type="button"
                            class="btn btn-danger w-full"
                            href="{{ route('pim.brand.listing') }}"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="1.5"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                class="shrink-0"
                            >
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mt-3">
                        <label class="mt-3 mb-0">
                            <input disabled
                                type="checkbox"
                                name="status"
                                class="form-checkbox"
                                value="1"
                                {{ old('status', $brand->status) == '1' ? 'checked' : '' }}
                            />
                            <span class="mb-0">Enable this brand.</span>
                        </label>
                        <label class="mt-3 b-0">
                            <input disabled
                                type="checkbox"
                                name="popular_brand"
                                class="form-checkbox"
                                value="1"
                                {{ old('status', $brand->popular_brand) == '1' ? 'checked' : '' }}
                            />
                            <span class="mb-0">This is popular brand?</span>
                        </label>
                        <label class="mb-0">
                            <input disabled
                                type="checkbox"
                                name="show_in_front"
                                class="form-checkbox"
                                value="1"
                                {{ old('status', $brand->show_in_front) == '1' ? 'checked' : '' }}
                            />
                            <span class="mb-0">Show In Front?</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3 panel space-y-3">
                    <div>
                        <label for="">Categories</label>
                        <select disabled name="selectCats[]" id="selectCats" class="w-full form-multiselect" multiple>
                            <option value="" disabled>Select</option>
                            @foreach($catOptions as $cats)
                                <option value="{{ $cats->id }}"
                                    {{ in_array($cats->id, old('selectCats', $selectedCats)) ? 'selected' : '' }}>
                                    {{ $cats->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="panel mb-3">
                    <div class='flex justify-between items-baseline'>
                        <label for="mobileImage" class="block font-semibold mb-2">Upload Mobile Image</label>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-dark" onclick="document.getElementById('mobileImage').click()">Update Image</button>
                        </div>
                    </div>
                    <div class="relative rounded-md mt-3 overflow-hidden w-full max-w-sm" id="mobilePreview">
                        @php
                            $image_mobile = old('image_mobile', $brand->mobile_image);
                        @endphp
                        @if (!empty($image_mobile))
                            <div class="relative inline-block">
                                <button type="button" class="text-danger text-xl font-bold z-10 absolute top-0 left-1"
                                    onclick="removeImageElement(this, 'image_mobile_hidden', '{{ $image_mobile }}')">×</button>
                                <img src="{{ $image_mobile }}" id="existingMobileImage">
                            </div>
                        @endif
                    </div>
                    <input disabled type="file" id="mobileImage" name="mobileImage" accept="image/*" class="hidden">
                    <input disabled type="hidden" id="image_mobile_hidden" name="image_mobile" value="{{ $image_mobile }}">
                </div>

                <!-- Website Image Upload -->
                <div class="panel mb-3">
                    <div class='flex justify-between items-baseline'>
                        <label for="websiteImage" class="block font-semibold mb-2">Upload Website Image</label>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-dark" onclick="document.getElementById('websiteImage').click()">Update Image</button>
                        </div>
                    </div>
                    <div class="relative rounded-md mt-3 overflow-hidden w-full max-w-sm" id="websitePreview">
                        @php $image_website = old('image_website', $brand->website_image) ?? $image_website ?? ''; @endphp
                        @if (!empty($image_website))
                            <div class="relative inline-block">
                                <button type="button" class="text-danger text-xl font-bold z-10 absolute top-0 left-1"
                                    onclick="removeImageElement(this, 'image_website_hidden', '{{ $image_website }}')">×</button>
                                <img src="{{ $image_website }}" id="existingWebsiteImage">
                            </div>
                        @endif
                    </div>
                    <input disabled type="file" id="websiteImage" name="websiteImage" accept="image/*" class="hidden">
                    <input disabled type="hidden" id="image_website_hidden" name="image_website" value="{{ $image_website }}">
                </div>
            </div>
        </div>
    </form>
    <script>
        const baseSlug = "http://127.0.0.1:8000/pim/brand/";

        function slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
                .replace(/\s+/g, '-')         // Replace spaces with -
                .replace(/-+/g, '-');         // Collapse multiple -
        }

        function updateSlug(value) {
            const slugInput = document.getElementById("slug");
            const copyBtn = document.getElementById("copyBtn");
            const slugPart = slugify(value);
            slugInput.value = baseSlug + slugPart;

            copyBtn.disabled = slugPart.length === 0;
        }

        function copySlug() {
            const slug = document.getElementById("slug").value;
            navigator.clipboard.writeText(slug).then(() => {
                alert("Slug copied!");
            });
        }
    </script>

    <script>
        function uploadImage(fileInputId, hiddenInputId, previewId) {
            const fileInput = document.getElementById(fileInputId);
            const hiddenInput = document.getElementById(hiddenInputId);
            const preview = document.getElementById(previewId);

            const file = fileInput.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);

            fetch('/pim/upload', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    hiddenInput.value = data.url;
                    preview.innerHTML = `
                        <button type="button" class="text-danger text-xl font-bold z-10" onclick="removeImage('${fileInputId.replace('Image','')}')">×</button>
                        <img src="${data.url}" class="w-full rounded-lg" />
                    `;
                } else {
                    alert("Upload failed: " + data.error);
                }
            })
            .catch(err => alert("Upload error: " + err));
        }

        document.getElementById("mobileImage").addEventListener("change", () => {
            uploadImage('mobileImage', 'image_mobile_hidden', 'mobilePreview');
        });

        document.getElementById("websiteImage").addEventListener("change", () => {
            uploadImage('websiteImage', 'image_website_hidden', 'websitePreview');
        });

        function removeImage(type) {
            document.getElementById(`${type}Preview`).innerHTML = '';
            document.getElementById(`image_${type}_hidden`).value = '';
            const fileInput = document.getElementById(`${type}Image`);
            fileInput.value = '';
        }
    </script>
</x-layout.default>
