<x-layout.default>
    <form>
        @csrf
        <div class="flex xl:flex-row flex-col gap-2">
            <div class="px-0 flex-1 py-0 ltr:xl:mr-1 rtl:xl:ml-1">
                <div class="panel mb-3">
                    <div class='grid grid-cols-2 gap-3'>
                        <div>
                            <label for="fname">
                                First Name
                            </label>
                            <input id="fname" type="text" name="fname" class="form-input disabled:bg-gray-100"
                                disabled placeholder="Enter First Name Here"
                                value="{{ old('fname', $users->first_name) }}" />
                            @error('fname')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="lname">
                                Last Name
                            </label>
                            <input id="lname" type="text" name="lname" class="form-input disabled:bg-gray-100"
                                disabled placeholder="Enter Last Name Here"
                                value="{{ old('lname', $users->last_name) }}" />
                            @error('lname')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="phn">
                                Phone Number
                            </label>
                            <input id="phn" type="text" name="phn" class="form-input disabled:bg-gray-100"
                                disabled placeholder="Enter Phone Here"
                                value="{{ old('phn', $users->phone_number) }}" />
                            @error('phn')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="email">
                                Email
                            </label>
                            <input id="email" type="email" name="email" class="form-input disabled:bg-gray-100"
                                disabled placeholder="Enter Email Here"
                                value="{{ old('email', $users->email) }}" />
                            @error('email')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="dob">
                                D.O.B
                            </label>
                            <input id="dob" type="date" name="dob" class="form-input disabled:bg-gray-100"
                                disabled placeholder="Enter Date of Birth"
                                value="{{ old('dob', $users->date_of_birth) }}" />
                            @error('dob')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="gender">
                                Gender
                            </label>
                            <select id="gender" class="form-select" name="gender" disabled>
                                <option value="" disabled {{ old('gender', $users->gender) === null ? 'selected' : '' }}>Select Gender</option>
                                <option value="1" {{ old('gender', $users->gender) == '1' ? 'selected' : '' }}>Male</option>
                                <option value="2" {{ old('gender', $users->gender) == '2' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="password">
                                Password
                            </label>
                            <input id="password" disabled type="password" name="password" class="form-input disabled:bg-gray-100"
                                placeholder="Enter Password Here" />
                            @error('password')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="cpassword">
                                Confirm Password
                            </label>
                            <input id="cpassword" disabled type="password" name="cpassword" class="form-input disabled:bg-gray-100"
                                placeholder="Enter Confirm Password Here" />
                            @error('cpassword')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel mb-3">
                    <div class="flex xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-2">
                        <a type="button" class="btn btn-danger w-full" href="/pim/users/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round"
                                strokeLinejoin="round" class="shrink-0">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </a>
                    </div>
                    <label class="mt-5 mb-0">
                        <input type="checkbox" name="status" disabled class="form-checkbox" value="1" {{ old('status', $users->status) == '1' ? 'checked' : '' }} />
                        <span class="mb-0">Enable this User</span>
                    </label>
                </div>
                <div class="panel">
                    <label for="users" class="mb-2 block font-medium text-sm">Choose Role</label>
                    <select id="selectRole" class="form-select" name="selectRole" disabled>
                        <option value="" disabled {{ old('selectRole', $users->role) === null ? 'selected' : '' }}>Select Role</option>
                        @foreach($role as $roles)
                            <option value="{{ $roles->id }}" {{ old('selectRole', $users->role) == $roles->id ? 'selected' : '' }}>
                                {{ $roles->role }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="panel mt-3">
                    <div class='flex justify-between items-baseline'>
                        <label for="mobileImage" class="block font-semibold mb-2">Upload Profile Image</label>
                        <div class="text-center mt-2">
                            <button disabled type="button" class="btn btn-dark" onclick="document.getElementById('mobileImage').click()">Upload</button>
                        </div>
                    </div>
                    <div class="relative rounded-md mt-3 overflow-hidden w-full max-w-sm" id="mobilePreview">
                        @php
                            $image_mobile = old('image_mobile', $users->profile_image);
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
            </div>
        </div>
    </form>
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
                        <button disabled type="button" class="text-danger text-xl font-bold z-10" onclick="removeImage('${fileInputId.replace('Image','')}')">×</button>
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

