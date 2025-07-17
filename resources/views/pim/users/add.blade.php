<x-layout.default>
    <form action="{{ route('pim.users.store') }}" method="POST">
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
                                placeholder="Enter First Name Here"
                                value="{{ old('fname') }}" />
                            @error('fname')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="lname">
                                Last Name
                            </label>
                            <input id="lname" type="text" name="lname" class="form-input disabled:bg-gray-100"
                                placeholder="Enter Last Name Here"
                                value="{{ old('lname') }}" />
                            @error('lname')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="phn">
                                Phone Number
                            </label>
                            <input id="phn" type="text" name="phn" class="form-input disabled:bg-gray-100"
                                placeholder="Enter Phone Here"
                                value="{{ old('phn', $old['phn'] ?? '') }}" />
                            @error('phn')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="email">
                                Email
                            </label>
                            <input id="email" type="email" name="email" class="form-input disabled:bg-gray-100"
                                placeholder="Enter Email Here"
                                value="{{ old('email') }}" />
                            @error('email')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="dob">
                                D.O.B
                            </label>
                            <input id="dob" type="date" name="dob" class="form-input disabled:bg-gray-100"
                                placeholder="Enter Date of Birth"
                                value="{{ old('dob') }}" />
                            @error('dob')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="gender">
                                Gender
                            </label>
                            <select id="gender" class="form-select" name="gender">
                                <option value="" disabled {{ old('gender') === null ? 'selected' : '' }}>Select Gender</option>
                                <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                                <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="password">
                                Password
                            </label>
                            <div class="flex items-center space-x-2">
                                <div class="relative w-full">
                                    <input id="password" type="password" name="password" class="form-input pr-10" placeholder="Enter Password Here" autocomplete="new-password" />
                                    <button type="button" id="togglePassword" tabindex="-1" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" title="Show/Hide Password">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path id="eyeOpen2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <path id="eyeClosed" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.73 10.73a3 3 0 004.24 4.24M17.94 17.94A10.97 10.97 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.97 10.97 0 012.293-3.95M6.06 6.06A10.97 10.97 0 0112 5c4.478 0 8.269 2.943 9.543 7a10.97 10.97 0 01-1.249 2.043" />
                                        </svg>
                                    </button>
                                </div>
                                <button type="button" id="generatePassword"
                                    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-lg shadow hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 gap-2"
                                    title="Generate Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <small style="color: #b91c1c;" class="mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="cpassword">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input id="cpassword" type="password" name="cpassword" class="form-input pr-10 w-full" placeholder="Enter Password Here" autocomplete="new-password" />
                                <button type="button" id="toggleCPassword" tabindex="-1" class="absolute inset-y-0 right-2 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" title="Show/Hide Password">
                                    <svg id="eyeIconC" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path id="eyeOpenC" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path id="eyeOpen2C" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        <path id="eyeClosedC" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.73 10.73a3 3 0 004.24 4.24M17.94 17.94A10.97 10.97 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.97 10.97 0 012.293-3.95M6.06 6.06A10.97 10.97 0 0112 5c4.478 0 8.269 2.943 9.543 7a10.97 10.97 0 01-1.249 2.043" />
                                    </svg>
                                </button>
                            </div>
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
                        <button class="btn btn-success w-full gap-2" type="submit" name="submit">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                    stroke="currentColor" strokeWidth="1.5" />
                                <path
                                    d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                    stroke="currentColor" strokeWidth="1.5" />
                                <path opacity="1" d="M7 8H13" stroke="currentColor" strokeWidth="1.5"
                                    strokeLinecap="round" />
                            </svg>
                            Publish & Close
                        </button>
                        <a type="button" class="btn btn-danger w-auto" href="/pim/users/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round"
                                strokeLinejoin="round" class="shrink-0">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </a>
                    </div>
                    <label class="mt-5 mb-0">
                        <input type="checkbox" name="status" class="form-checkbox" value="1" {{ old('status', $old['status'] ?? '') == '1' ? 'checked' : '' }} />
                        <span class="mb-0">Enable this User</span>
                    </label>
                </div>
                <div class="panel">
                    <label for="users" class="mb-2 block font-medium text-sm">Choose Role</label>
                    <select id="selectRole" class="form-select" name="selectRole">
                        <option value="" disabled {{ old('selectRole') === null ? 'selected' : '' }}>Select Role</option>
                        @if(is_iterable($role))
                            @foreach($role as $roles)
                                <option value="{{ $roles->id }}" {{ old('selectRole') == $roles->id ? 'selected' : '' }}>
                                    {{ $roles->role }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="panel mt-3">
                    <div class='flex justify-between items-baseline'>
                        <label for="mobileImage" class="block font-semibold mb-2">Upload Profile Image</label>
                        <div class="text-center mt-2">
                            <button type="button" class="btn btn-dark" onclick="document.getElementById('mobileImage').click()">Upload</button>
                        </div>
                    </div>
                    <div class="relative rounded-md mt-3 overflow-hidden w-full max-w-sm" id="mobilePreview">
                        @php
                            $image_mobile = old('image_mobile');
                        @endphp
                        @if (!empty($image_mobile))
                            <div class="relative inline-block">
                                <button type="button" class="text-danger text-xl font-bold z-10 absolute top-0 left-1"
                                    onclick="removeImageElement(this, 'image_mobile_hidden', '{{ $image_mobile }}')">×</button>
                                <img src="{{ $image_mobile }}" id="existingMobileImage">
                            </div>
                        @endif
                    </div>
                    <input type="file" id="mobileImage" name="mobileImage" accept="image/*" class="hidden">
                    <input type="hidden" id="image_mobile_hidden" name="image_mobile" value="{{ $image_mobile }}">
                </div>
            </div>
        </div>
    </form>
    <script>
            function generatePasswordWithRegex(length = 12) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789._%+-@";
                let password = "";
                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    password += charset[randomIndex];
                }
                return password;
            }

            document.addEventListener('DOMContentLoaded', function () {
                const generateBtn = document.getElementById('generatePassword');
                const passwordInput = document.getElementById('password');
                const cpassword = document.getElementById('cpassword');

                generateBtn.addEventListener('click', function () {
                    // Length between 8 and 16
                    const pwdLength = Math.floor(Math.random() * 9) + 8;
                    const pwd = generatePasswordWithRegex(pwdLength);
                    passwordInput.value = pwd;
                    cpassword.value = pwd;
                });
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const toggleCPassword = document.getElementById('toggleCPassword');
            const passwordInput = document.getElementById('password');
            const cpassword = document.getElementById('cpassword');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeOpen2 = document.getElementById('eyeOpen2');
            const eyeClosed = document.getElementById('eyeClosed');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                if (type === 'text') {
                    eyeOpen.style.display = '';
                    eyeOpen2.style.display = '';
                    eyeClosed.style.display = 'none';
                } else {
                    eyeOpen.style.display = 'none';
                    eyeOpen2.style.display = 'none';
                    eyeClosed.style.display = '';
                }
            });

            toggleCPassword.addEventListener('click', function () {
                const type = cpassword.type === 'password' ? 'text' : 'password';
                cpassword.type = type;
                if (type === 'text') {
                    eyeOpenC.style.display = '';
                    eyeOpen2C.style.display = '';
                    eyeClosedC.style.display = 'none';
                } else {
                    eyeOpenC.style.display = 'none';
                    eyeOpen2C.style.display = 'none';
                    eyeClosedC.style.display = '';
                }
            });
        });
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

