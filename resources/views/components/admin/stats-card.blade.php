<div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 sm:p-8 border border-gray-100">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm sm:text-base font-medium text-gray-600 mb-2">{{ $title }}</p>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">{{ $value }}</p>
            @if(isset($subtitle))
                <p class="text-sm text-gray-500">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="text-4xl sm:text-5xl ml-4">
            {!! $icon !!}
        </div>
    </div>
</div>