<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('battles.show', $battle) }}"
               class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                ← Retour à la battle
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🎭 Soumettre un Mème
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                        🏆 {{ $battle->title }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ $battle->description }}
                    </p>
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <span>📅 Deadline: {{ $battle->deadline->format('d/m/Y à H:i') }}</span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-xs font-semibold">
                            🟢 Ouverte
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('memes.store', $battle) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf


                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🖼️ Image du Mème *
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-gray-400 dark:hover:border-gray-500 transition duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Choisir un fichier</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*" required>
                                        </label>
                                        <p class="pl-1">ou glisser-déposer ici</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG, GIF, WebP jusqu'à 5MB
                                    </p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>


                        <div id="image-preview" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                👁️ Aperçu
                            </label>
                            <div class="relative">
                                <img id="preview-img" class="max-w-full h-64 object-contain mx-auto rounded-lg border border-gray-300 dark:border-gray-600" alt="Aperçu">
                                <button type="button" id="remove-image" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1">
                                    ✕
                                </button>
                            </div>
                        </div>


                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <h4 class="font-semibold text-white dark:text-white mb-2">
                                ⚠️ Règles importantes
                            </h4>
                            <ul class="text-sm text-white dark:text-white space-y-1">
                                <li>• <strong>Pas de légende</strong> : l'image doit être drôle par elle-même</li>
                                <li>• Respectez les droits d'auteur et la propriété intellectuelle</li>
                                <li>• Contenu approprié uniquement (pas de contenu offensant)</li>
                                <li>• Une seule image par soumission</li>
                                <li>• Vous ne pourrez pas voter pour votre propre mème</li>
                            </ul>
                        </div>


                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h4 class="font-semibold text-white dark:text-white mb-2">
                                ℹ️ Informations techniques
                            </h4>
                            <ul class="text-sm text-white dark:text-white space-y-1">
                                <li>• Formats acceptés : JPG, PNG, GIF, WebP</li>
                                <li>• Taille maximale : 5MB</li>
                                <li>• Résolution recommandée : 800x600 ou plus</li>
                                <li>• L'image sera redimensionnée automatiquement si nécessaire</li>
                            </ul>
                        </div>


                        <div class="flex gap-4 pt-4">
                            <button type="submit"
                                    class="flex-1 border-2 border-green-600 bg-transparent text-green-700 hover:bg-green-600 hover:text-white font-semibold py-3 px-6 rounded-lg transition duration-200 shadow-sm">
                                🚀 Soumettre le Mème
                            </button>
                            <a href="{{ route('battles.show', $battle) }}"
                               class="flex-1 border-2 border-gray-400 bg-transparent text-gray-700 hover:bg-gray-700 hover:text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center shadow-sm">
                                ❌ Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });


        document.getElementById('remove-image').addEventListener('click', function() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        });


        const dropZone = document.querySelector('.border-dashed');

        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('image').files = files;
                const event = new Event('change', { bubbles: true });
                document.getElementById('image').dispatchEvent(event);
            }
        });
    </script>
</x-app-layout>
