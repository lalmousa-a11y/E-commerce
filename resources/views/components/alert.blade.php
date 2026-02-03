
@if(session('success'))
    <div class="alert-success p-4 sm:p-6 rounded-lg border-l-4 border-green-600 bg-green-50 mb-4 animate-fadeIn" role="alert">
        <div class="flex items-start">
            <span class="text-2xl ml-3">✅</span>
            <div class="flex-1">
                <strong class="text-green-800 block mb-1">Success!</strong>
                <p class="text-green-700 text-sm">{{ session('success') }}</p>
            </div>
            <button type="button" class="close-alert text-green-600 hover:text-green-800 ml-2">
                <span class="text-xl">&times;</span>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert-error p-4 sm:p-6 rounded-lg border-l-4 border-red-600 bg-red-50 mb-4 animate-fadeIn" role="alert">
        <div class="flex items-start">
            <span class="text-2xl ml-3">❌</span>
            <div class="flex-1">
                <strong class="text-red-800 block mb-1">Error!</strong>
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
            <button type="button" class="close-alert text-red-600 hover:text-red-800 ml-2">
                <span class="text-xl">&times;</span>
            </button>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert-warning p-4 sm:p-6 rounded-lg border-l-4 border-yellow-600 bg-yellow-50 mb-4 animate-fadeIn" role="alert">
        <div class="flex items-start">
            <span class="text-2xl ml-3">⚠️</span>
            <div class="flex-1">
                <strong class="text-yellow-800 block mb-1">Warning!</strong>
                <p class="text-yellow-700 text-sm">{{ session('warning') }}</p>
            </div>
            <button type="button" class="close-alert text-yellow-600 hover:text-yellow-800 ml-2">
                <span class="text-xl">&times;</span>
            </button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="alert-error p-4 sm:p-6 rounded-lg border-l-4 border-red-600 bg-red-50 mb-4 animate-fadeIn" role="alert">
        <div class="flex items-start">
            <span class="text-2xl ml-3">❌</span>
            <div class="flex-1">
                <strong class="text-red-800 block mb-2">Errors Found:</strong>
                <ul class="space-y-1 text-red-700 text-sm">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center">
                            <span class="inline-block w-1 h-1 bg-red-600 rounded-full ml-2"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="close-alert text-red-600 hover:text-red-800 ml-2">
                <span class="text-xl">&times;</span>
            </button>
        </div>
    </div>
@endif

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}

.close-alert {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-size: 1.5rem;
    transition: all 0.2s ease;
}

.close-alert:hover {
    transform: scale(1.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add close functionality
    document.querySelectorAll('.close-alert').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.closest('[role="alert"]').remove();
        });
    });
    
    // Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('[role="alert"]').forEach(alert => {
        setTimeout(function() {
            alert.remove();
        }, 5000);
    });
});
</script>