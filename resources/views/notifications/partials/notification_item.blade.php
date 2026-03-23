<div class="flex items-start gap-x-4 px-6 py-6 transition-all duration-200 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50/50' }} hover:bg-gray-50 border-b border-gray-100 relative group hover:shadow-sm">
    
    {{-- 1. UNREAD INDICATOR DOT --}}
    @if(!$notification->read_at)
        <div class="absolute top-6 right-6 h-2 w-2 rounded-full bg-blue-600 animate-pulse" title="Unread"></div>
    @endif

    {{-- 2. ICON BLOCK (Professional circle background) --}}
    <div class="flex-none pt-1">
        @php
            $type = $notification->data['type'] ?? '';
            $icon = $notification->data['icon'] ?? 'fas fa-bell';
            
            // Default styling
            $icon_color = 'text-gray-600'; 
            $bg_color = 'bg-gray-100';

            // Custom styling based on notification logic
            if($type === 'registration_otp') {
                $icon_color = 'text-blue-600'; 
                $bg_color = 'bg-blue-100';
                $icon = 'fas fa-shield-alt';
            } elseif (str_contains($type, 'claim')) {
                $icon_color = 'text-green-600';
                $bg_color = 'bg-green-100';
                $icon = 'fas fa-clipboard-check';
            } elseif (str_contains($type, 'item')) {
                $icon_color = 'text-purple-600';
                $bg_color = 'bg-purple-100';
                $icon = 'fas fa-box-open';
            }
        @endphp
        
        <div class="h-12 w-12 rounded-full {{ $bg_color }} flex items-center justify-center transition-transform group-hover:scale-110">
            <i class="{{ $icon }} {{ $icon_color }} text-lg"></i>
        </div>
    </div>

    {{-- 3. CONTENT BLOCK --}}
    <div class="flex-auto">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1">
            <p class="font-bold text-gray-900 {{ $notification->read_at ? '' : 'text-blue-900' }}">
                {{ $notification->data['title'] ?? 'System Update' }}
            </p>
            <small class="text-xs text-gray-500 whitespace-nowrap mt-1 sm:mt-0 italic">
                {{ $notification->created_at->diffForHumans() }}
            </small>
        </div>
        
        <p class="text-sm text-gray-600 leading-relaxed mb-3">
            {{ $notification->data['message'] }}
        </p>

        {{-- 4. ACTION BLOCK (Mobile Responsive Buttons) --}}
        <div class="flex flex-col sm:flex-row gap-2 mt-2">
            
            {{-- PRIMARY ACTION --}}
            @if(!empty($notification->data['url']))
                <a href="{{ $notification->data['url'] }}" 
                   class="inline-flex items-center justify-center gap-x-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-sm hover:bg-blue-700 transition w-full sm:w-auto">
                    <i class="fas fa-external-link-alt text-[10px]"></i>
                    {{ __('View Details') }}
                </a>
            @endif

            {{-- SECONDARY ACTION --}}
            @if(!$notification->read_at)
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="inline-flex items-center justify-center gap-x-2 rounded-lg bg-white px-4 py-2 text-xs font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition w-full sm:w-auto">
                        <i class="fas fa-check text-green-600"></i>
                        {{ __('Mark as Read') }}
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>