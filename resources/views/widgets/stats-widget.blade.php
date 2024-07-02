<div>
    <h2>{{ $this->getHeading() }}</h2>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        @foreach($this->getStats() as $stat)
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            {{ $stat->getTitle() }}
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                            {{ $stat->getValue() }}
                        </dd>
                        <dd class="flex items-center mt-2 text-sm font-medium {{ $stat->getColor() }} text-{{ $stat->getColor() }}-800">
                            @if($stat->getDescriptionIcon())
                                <svg class="mr-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-9a1 1 0 11-1 1 1 1 0 011-1zm1 1a1 1 0 11-2 0 1 1 0 012 0zM8 8a1 1 0 100-2 1 1 0 000 2zm5-1a1 1 0 11-2 0 1 1 0 012 0zm-1 5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            @endif
                            {{ $stat->getDescription() }}
                        </dd>
                    </dl>
                </div>
            </div>
        @endforeach
    </div>
</div>
