<x-layout.default>
    <script src="/assets/js/simple-datatables.js"></script>
    <div x-data="custom">
        <div class="panel mt-6">
            <div class="flex gap-3 absolute">
                @if($permission && $permission->delete)
                    <form id="bulk-delete-form" method="POST" action="{{ route('pim.categories.bulk-delete') }}">
                        @csrf
                        <input type="hidden" name="ids" id="bulk-delete-ids">
                        <button type="button"
                            id="bulk-delete-button"
                            onclick="submitBulkDelete()"
                            disabled
                            class="btn btn-danger">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6" stroke="currentColor" stroke-width="1.5"></path>
                            </svg>
                        </button>
                    </form>
                @endif
                @if($permission && $permission->create)
                    <a href="{{ route('pim.categories.add') }}" type="button" class="btn btn-primary flex roles-top gap-1">
                        <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" strokeLinecap="round" strokeLinejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Create Product Category
                    </a>
                @endif
            </div>
            <table id="myTable" class="whitespace-nowrap table-checkbox relative"></table>
        </div>
    </div>
    <script>
        const categoryData = [
            @foreach($categories as $cat)
                @php
                    $defaultImage = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOYAAACUCAMAAACwXqVDAAAAMFBMVEXp7vG6vsHFyczs8fTQ1NfKztHCxsni5+q2ur29wcTb3+Lf5Ofl6u3M0dTW297U2NvL7GdOAAACY0lEQVR4nO3b7ZZrMBhAYYIkhLj/u52OOi0mWjTryKv7+WlmdXUvlcRXlgEAAAAAAAAAAAAAAKSiiOLsijeMr9TndOfODnmpr/MobF6lG1qUcSIH2pyds6axETNzdXbOGh2zMrfN2T1hbvh2dfWxTg2fVKU53jbDl3Mx5pOhUyecWccYOYrSknkyMneSlGn8bSCplW/3f5KgTH+fRa1V+5dtcjL75zSvd8/zYjLddD2j9+5PMZlqtm4rd36SlMzFIn7v8Cskc3lGZld/tSY4DkvJ7DaebDjdhTZfLNPp8HErJXPbj9b8Tq020Ckkcz6frA1BZvxr9+f4lJK5ZUJxevXPYjLny4PQznSTSyrLcUhM5nSxV4cGIDe7cNTNi+RkZn68ZGuDSz2zuDxWzpIEZWZtr+r6diIW+lezvGw9H28lZWZF1rZZ8HaIC1ycn3aKylzldOi69aTzEplGBSJnx+cVMtu1i/P20XmBzPbFTbN/86fITDfd9GeMDXVKzPS5em5zr28njfOKwEx/2/jodCujz9PQKS/zvhga71Uu1z4hv6cr0jKLZjwU750bbtlbiZn+sQ5Q7csxVvTe9JOvXzXbbmbLy/Rviq6ReahSXGZz7BkhYZnNoUhpmUcrZWUeOy6lZR7el6IylzcXyCSTzDORSeaCpPPNoj/+NL+gzE+Reb7hzOsLMr9ob+ZR3jdI+Vn38cmQGC9PDVNLl2Zm8faS+r4ZNNXXp0zUt4qqs3PWFD5ep033HbG12+0HInc/gvufuTKG3qQ5/DzFeHcq+bdxAQAAAAAAAAAAAAAAAADA1/sBbKMiWm05c2MAAAAASUVORK5CYII=';
                    $statusHtml = $cat->status == 0
                        ? '<div class="text-danger font-semibold">Disabled</div>'
                        : '<div class="text-success font-semibold">Enabled</div>';
                    $showMenu = $cat->show_in_menu == 0
                        ? '<div class="text-danger font-semibold">Disabled</div>'
                        : '<div class="text-success font-semibold">Enabled</div>';
                    $mobileImage = $cat->mobile_image
                        ? "<img src='" . $cat->mobile_image . "' style='width:60px; height:45px;' />"
                        : "<img src='" . $defaultImage . "' style='width:60px; height:45px;' />";
                    $websiteImage = $cat->website_image
                        ? "<img src='" . $cat->website_image . "' style='width:60px; height:45px;' />"
                        : "<img src='" . $defaultImage . "' style='width:60px; height:45px;' />";

                @endphp
                [
                    `@if($permission && $permission->delete) <input name="ids[]" type="checkbox" value="{{ $cat->id }}" class="delete-checkbox form-checkbox" /> @endif`,
                    `<span class='font-bold text-info'>{{ $cat->id }}</span>`,
                    `<span class=''>{{ $cat->name }}</span>`,
                    `<span class=''>{{ $cat->slug }}</span>`,
                    `<span class='font-serif'>{{ $cat->sorting }}</span>`,
                    `{!! $websiteImage !!}`,
                    `{!! $mobileImage !!}`,
                    `{!! $showMenu !!}`,
                    `{!! $statusHtml !!}`,
                    `
                    <div class='flex gap-2'>
                        @if($permission && ($permission->view || $permission->view_all))
                            <a href="{{route('pim.categories.view',['id'=>$cat->id])}}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 12C2 13.6394 2.42496 14.1915 3.27489 15.2957C4.97196 17.5004 7.81811 20 12 20C16.1819 20 19.028 17.5004 20.7251 15.2957C21.575 14.1915 22 13.6394 22 12C22 10.3606 21.575 9.80853 20.7251 8.70433C19.028 6.49956 16.1819 4 12 4C7.81811 4 4.97196 6.49956 3.27489 8.70433C2.42496 9.80853 2 10.3606 2 12Z" stroke="currentColor" stroke-width="1.5" />
                                    <path fillRule="evenodd" clipRule="evenodd" d="M8.25 12C8.25 9.92893 9.92893 8.25 12 8.25C14.0711 8.25 15.75 9.92893 15.75 12C15.75 14.0711 14.0711 15.75 12 15.75C9.92893 15.75 8.25 14.0711 8.25 12ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z" stroke="currentColor" />
                                </svg>
                            </a>
                        @endif
                        @if($permission && $permission->edit)
                            <a href="{{route('pim.categories.edit',['id'=>$cat->id])}}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.2869 3.15178L14.3601 4.07866L5.83882 12.5999L5.83881 12.5999C5.26166 13.1771 4.97308 13.4656 4.7249 13.7838C4.43213 14.1592 4.18114 14.5653 3.97634 14.995C3.80273 15.3593 3.67368 15.7465 3.41556 16.5208L2.32181 19.8021L2.05445 20.6042C1.92743 20.9852 2.0266 21.4053 2.31063 21.6894C2.59466 21.9734 3.01478 22.0726 3.39584 21.9456L4.19792 21.6782L7.47918 20.5844L7.47919 20.5844C8.25353 20.3263 8.6407 20.1973 9.00498 20.0237C9.43469 19.8189 9.84082 19.5679 10.2162 19.2751C10.5344 19.0269 10.8229 18.7383 11.4001 18.1612L11.4001 18.1612L19.9213 9.63993L20.8482 8.71306C22.3839 7.17735 22.3839 4.68748 20.8482 3.15178C19.3125 1.61607 16.8226 1.61607 15.2869 3.15178Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M14.36 4.07812C14.36 4.07812 14.4759 6.04774 16.2138 7.78564C17.9517 9.52354 19.9213 9.6394 19.9213 9.6394M4.19789 21.6777L2.32178 19.8015" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </a>
                        @endif
                        @if($permission && $permission->delete)
                            <a href="{{route('pim.categories.delete',['id'=>$cat->id])}}">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" strokeLinecap="round"></path>
                                    <path d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5" stroke="currentColor" stroke-width="1.5" strokeLinecap="round"></path>
                                    <path d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" strokeLinecap="round"></path>
                                    <path d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" strokeLinecap="round"></path>
                                    <path d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6" stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                    `,
                ],
            @endforeach
        ];
        document.addEventListener("alpine:init", () => {
            Alpine.data("custom", () => ({
                ids: [],
                datatable: null,
                tableData: categoryData,
                init() {
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings: [
                                '@if($permission && $permission->delete) <input type="checkbox" class="form-checkbox" id="select-all" /> @endif',
                                 "ID", "Name", "Slug", "Sorting", "Image", "Mobile Image", "Show in Menu", "Status", "Actions",
                            ],
                            data: this.tableData,
                        },
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [{
                            select: 0,
                            sortable: false,
                            render: (data, cell, row) => {
                                return data;
                            }
                        }, ],
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "{select}"
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    });
                },
            }));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.delete-checkbox');
            const bulkDeleteBtn = document.getElementById('bulk-delete-button');

            function toggleDeleteButton() {
                const checkedCount = document.querySelectorAll('.delete-checkbox:checked').length;
                bulkDeleteBtn.disabled = checkedCount === 0;
                bulkDeleteBtn.classList.toggle('cursor-not-allowed', checkedCount === 0);
                bulkDeleteBtn.classList.toggle('opacity-50', checkedCount === 0);
            }

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                toggleDeleteButton();
            });

            checkboxes.forEach(cb => {
                cb.addEventListener('change', toggleDeleteButton);
            });

            toggleDeleteButton();
        });

        // Multi-delete logic
        function submitBulkDelete() {
            const checked = document.querySelectorAll('.delete-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one record to delete.');
                return;
            }
            const ids = Array.from(checked).map(cb => cb.value);
            document.getElementById('bulk-delete-ids').value = ids.join(',');
            document.getElementById('bulk-delete-form').submit();
        }
    </script>
</x-layout.default>
