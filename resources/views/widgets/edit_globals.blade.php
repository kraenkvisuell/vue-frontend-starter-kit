<div class="card p-0 content">
    <div class="p-4">
        <h2 class="group flex items-center font-medium">
            <div class="h-6 w-6 rtl:ml-2 ltr:mr-2 text-gray-800 dark:text-dark-200">
                {!! $icon !!}
            </div>

            <span>{{ __('Globals') }}</span>
        </h2>
    </div>

    <table class="data-table">
        @foreach($globals as $global)
            <tr>
                <td>
                    <a href="{{ route('statamic.cp.globals.variables.edit', [$global['handle']]) }}" class="block">
                        {{ $global['title'] }}
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

</div>
