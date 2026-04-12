<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-primary">
                    <i class="fas fa-bell mr-1"></i> Centre de notifications
                </p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Mes notifications
                </h2>
            </div>

            @if($notifications->total() > 0)
                <form method="POST" action="{{ route('notifications.markAllRead') }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button 
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl bg-blue-100 px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-200 transition-colors"
                    >
                        <i class="fas fa-check-double"></i>
                        Marquer tout comme lu
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if($notifications->count() > 0)
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="rounded-2xl border {{ $notification->read ? 'border-gray-200 bg-white' : 'border-blue-200 bg-blue-50' }} p-4 shadow-sm hover:shadow-md transition-all">
                            <div class="flex items-start gap-4">
                                <div class="flex-1">
                                    @if($notification->type === 'new_answer')
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-comment text-blue-600"></i>
                                            <p class="font-semibold text-gray-900">{{ $notification->message }}</p>
                                        </div>
                                    @elseif($notification->type === 'answer_accepted')
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-check-circle text-green-600"></i>
                                            <p class="font-semibold text-gray-900">{{ $notification->message }}</p>
                                        </div>
                                    @elseif($notification->type === 'content_deleted')
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-trash-alt text-red-600"></i>
                                            <p class="font-semibold text-gray-900">{{ $notification->message }}</p>
                                        </div>
                                    @endif
                                    <p class="mt-1 text-xs text-gray-600">{{ $notification->created_at->format('d M Y \à H:i') }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if(!$notification->read)
                                        <form method="POST" action="{{ route('notifications.read', $notification) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button 
                                                type="submit"
                                                class="rounded-lg text-blue-600 hover:text-blue-700 p-2"
                                                title="Marquer comme lu"
                                            >
                                                <i class="fas fa-envelope-open"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="inline" onsubmit="return confirm('Supprimer cette notification ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="rounded-lg text-gray-400 hover:text-red-600 transition-colors p-2"
                                            title="Supprimer"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
                    <i class="fas fa-inbox text-4xl text-gray-400 mb-3"></i>
                    <p class="text-lg font-semibold text-gray-900">Aucune notification</p>
                    <p class="mt-2 text-sm text-gray-600">Vous êtes à jour ! Continuez à poser des questions et répondre aux autres.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
