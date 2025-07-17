<x-layout.default>
    <form action="{{ route('pim.role.store') }}" method="POST">
        @csrf
        <div class="flex xl:flex-row flex-col gap-2">
            <div class="px-0 flex-1 py-0 ltr:xl:mr-1 rtl:xl:ml-1">
                <div class="panel mb-3 space-y-3">
                    <div>
                        <label for="role_name" class="block text-sm font-medium text-gray-700">Role Name</label>
                        <input
                            id="role_name"
                            type="text"
                            name="role_name"
                            value="{{ old('role_name') }}"
                            class="form-input"
                            placeholder="Enter Role..."
                        />
                        @error('role_name')
                            <small class="text-red-600 pt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <table id="myTable" class="table-responsive">
                        <thead>
                            <tr>
                                <th class="text-left">Modules</th>
                                <th>View All</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $module)
                                <tr>
                                    <td>{{ Str::headline($module->name) }}</td>
                                     @foreach(['view_all', 'view', 'create', 'edit', 'delete'] as $perm)
                                        <td>
                                            <input
                                                type="checkbox"
                                                name="permissions[{{ $module->id }}][]"
                                                value="{{ $perm }}"
                                                class="form-checkbox"
                                                {{ in_array($perm, old('permissions.' . $module->id, [])) ? 'checked' : '' }}
                                            />
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel mb-3">
                    <div class="flex xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-2">
                        <button class="btn btn-success w-full gap-2 flex items-center" type="submit" name="submit">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                    stroke="currentColor"
                                    strokeWidth="1.5"
                                />
                                <path
                                    d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                    stroke="currentColor"
                                    strokeWidth="1.5"
                                />
                                <path d="M7 8H13" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
                            </svg>
                            Publish & Close
                        </button>
                        <a
                            type="button"
                            class="btn btn-danger w-auto"
                            href="/pim/role"
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
                </div>
            </div>
        </div>
    </form>
</x-layout.default>
