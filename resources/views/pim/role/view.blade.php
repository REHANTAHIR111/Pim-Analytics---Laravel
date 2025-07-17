<x-layout.default>
    <form>
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
                            value="{{ old('role_name', $role->role) }}"
                            class="form-input"
                            placeholder="Enter Role..."
                            disabled
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

                                    @php
                                        $selectedPermissions = collect($rolePermissions[$module->id] ?? [])
                                            ->filter(fn($value) => $value == 1)
                                            ->keys()
                                            ->toArray();
                                    @endphp

                                    @foreach(['view_all', 'view', 'create', 'edit', 'delete'] as $perm)
                                        <td>
                                            <input
                                                type="checkbox"
                                                disabled
                                                name="permissions[{{ $module->id }}][]"
                                                value="{{ $perm }}"
                                                class="form-checkbox"
                                                {{ in_array($perm, old("permissions.{$module->id}") ?? $selectedPermissions) ? 'checked' : '' }}
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
                        <a
                            type="button"
                            class="btn btn-danger w-full"
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
