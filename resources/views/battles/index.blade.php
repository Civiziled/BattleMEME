<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🏆 Battle Arena - Concours de Mèmes
            </h2>
            @auth
                <a href="{{ route('battles.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 shadow-lg"
                   style="color: #1b1b18 !important;">
                    ➕ Créer une Battle
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Barre de recherche et filtres -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('battles.index') }}" class="flex flex-col md:flex-row gap-4">
                        <!-- Recherche -->
                        <div class="flex-1">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="🔍 Rechercher une battle par titre..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Filtre par statut -->
                        <div class="flex gap-2">
                            <select name="status"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <option value="">Tous les statuts</option>
                                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>
                                    🟢 Ouvertes
                                </option>
                                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>
                                    🔴 Fermées
                                </option>
                            </select>

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                🔍 Filtrer
                            </button>

                            @if(request('search') || request('status'))
                                <a href="{{ route('battles.index') }}"
                                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                    🗑️ Effacer
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Liste des battles -->
            @if($battles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($battles as $battle)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition duration-300">
                            <div class="p-6">
                                <!-- En-tête de la battle -->
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2">
                                        {{ $battle->title }}
                                    </h3>
                                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $battle->isOpen() ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ $battle->isOpen() ? '🟢 Ouverte' : '🔴 Fermée' }}
                                    </span>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($battle->description, 120) }}
                                </p>

                                <!-- Informations -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">👤 Créateur:</span>
                                        <span class="ml-1">{{ $battle->user->name }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">📅 Deadline:</span>
                                        <span class="ml-1">{{ $battle->deadline->format('d/m/Y à H:i') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">🎭 Mèmes:</span>
                                        <span class="ml-1">{{ $battle->memes_count }} soumis</span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('battles.show', $battle) }}"
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded-lg transition duration-200">
                                        👁️ Voir
                                    </a>

                                    @auth
                                        @if($battle->isOpen())
                                            <a href="{{ route('memes.create', $battle) }}"
                                               class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                                🎭 Participer
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $battles->links() }}
                </div>
            @else
                <!-- Message si aucune battle -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="text-6xl mb-4">🎭</div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                            Aucune battle trouvée
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">
                            @if(request('search') || request('status'))
                                Aucune battle ne correspond à vos critères de recherche.
                            @else
                                Il n'y a pas encore de battle de mèmes. Soyez le premier à en créer une !
                            @endif
                        </p>
                        @auth
                            <a href="{{ route('battles.create') }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 shadow-lg"
                               style="color: #1b1b18 !important;">
                                ➕ Créer la première battle
                            </a>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
