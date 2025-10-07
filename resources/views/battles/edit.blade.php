<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('battles.show', $battle) }}" 
               class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                ← Retour à la battle
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ✏️ Modifier la Battle
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('battles.update', $battle) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🏆 Titre de la Battle *
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $battle->title) }}"
                                   placeholder="Ex: Battle des mèmes de chat les plus drôles"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror"
                                   required>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📝 Description *
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Décrivez le thème de votre battle de mèmes. Soyez créatif et encouragez la participation !"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror"
                                      required>{{ old('description', $battle->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ⏰ Date limite de soumission *
                            </label>
                            <input type="datetime-local" 
                                   id="deadline" 
                                   name="deadline" 
                                   value="{{ old('deadline', $battle->deadline->format('Y-m-d\TH:i')) }}"
                                   min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white @error('deadline') border-red-500 @enderror"
                                   required>
                            @error('deadline')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                💡 La battle sera automatiquement fermée à cette date. Les utilisateurs ne pourront plus soumettre de mèmes après.
                            </p>
                        </div>

                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">
                                📊 Statut actuel
                            </h4>
                            <div class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                <div>🎭 {{ $battle->memes->count() }} mème(s) soumis</div>
                                <div>❤️ {{ $battle->memes->sum('votes_count') }} vote(s) au total</div>
                                <div>📅 Créée le {{ $battle->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>

                        
                        @if($battle->memes->count() > 0)
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <h4 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">
                                    ⚠️ Attention
                                </h4>
                                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                    Des mèmes ont déjà été soumis à cette battle. Modifier la date limite pourrait affecter les participants.
                                </p>
                            </div>
                        @endif

                        
                        <div class="flex gap-4 pt-4">
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 shadow-lg">
                                💾 Sauvegarder les modifications
                            </button>
                            <a href="{{ route('battles.show', $battle) }}" 
                               class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                                ❌ Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
