<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Carnet de Contacts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                    <a href="{{ route('contacts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 w-full md:w-auto text-center">
                        + Ajouter un contact
                    </a>
                    
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <span class="text-gray-600 text-sm">Tri :</span>
                        <a href="{{ route('contacts.index', ['sort' => 'asc']) }}" class="text-blue-600 hover:underline text-sm font-medium">A-Z</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('contacts.index', ['sort' => 'desc']) }}" class="text-blue-600 hover:underline text-sm font-medium">Z-A</a>
                    </div>

                    <input type="text" id="search" placeholder="Filtrer par nom..." class="border border-gray-300 rounded px-4 py-2 w-full md:w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="contact-table" class="bg-white divide-y divide-gray-200">
                            @forelse($contacts as $contact)
                                <tr class="contact-row">
                                    <td class="px-6 py-4 whitespace-nowrap contact-name font-medium text-gray-900">
                                        {{ $contact->nom }} {{ $contact->prenom }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $contact->telephone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $contact->email ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $contact->categorie === 'pro' ? 'bg-purple-100 text-purple-800' : ($contact->categorie === 'ami' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($contact->categorie) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-3">
                                        <a href="{{ route('contacts.edit', $contact) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun contact trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Recherche dynamique côté client
        document.getElementById('search').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.contact-row');
            
            rows.forEach(row => {
                let name = row.querySelector('.contact-name').textContent.toLowerCase();
                if (name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Confirmation JavaScript à la suppression
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm("Voulez-vous vraiment supprimer ce contact ?")) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout>