<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        <div class="ml-4">
            <span class="text-{{ $color }}-500">
                {!! $icon !!}
            </span>
        </div>
    </div>
</div>