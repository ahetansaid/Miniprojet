<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl x-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Message de Bienvenue personnalisé -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">
                        Ravi de vous revoir, {{ Auth::user()->name }} ! 
                    </h3>
                    <p class="text-gray-600 mt-1">Voici un aperçu rapide de votre carnet de contacts personnel.</p>
                </div>

                <!-- Grille des statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Carte Statistique -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600 uppercase tracking-wider">Contacts enregistrés</p>
                            <h4 class="text-4xl font-extrabold text-blue-900 mt-2">{{ $totalContacts }}</h4>
                        </div>
                        <div class="bg-blue-500 text-white p-3 rounded-lg shadow-md">
                            <!-- Icône de carnet d'adresses -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Carte Action Rapide -->
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 flex flex-col justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">Gestion des contacts</h4>
                            <p class="text-sm text-gray-600 mt-1">Ajoutez, modifiez, supprimez ou filtrez vos contacts en temps réel grâce au script JavaScript intégré.</p>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('contacts.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadowTransition duration-150 ease-in-out">
                                Ouvrir mon carnet →
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>