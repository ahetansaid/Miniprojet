<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Carnet de Contacts</title>
    
    <style>
        body { background: #000000; color: #ffffff; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #222; padding-bottom: 20px; margin-bottom: 20px; }
        button, .btn { background: #eab308; border: none; color: #000; padding: 10px 15px; font-weight: bold; cursor: pointer; border-radius: 4px; text-decoration: none; }
        .btn-logout { background: #333; color: #fff; }
        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; }
        .card { background: #111111; padding: 20px; border-radius: 8px; border: 1px solid #222; }
        input, select { display: block; width: 100%; padding: 10px; margin-bottom: 15px; background: #222; border: 1px solid #333; color: #fff; box-sizing: border-box; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #222; }
        th { background: #111; color: #eab308; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        .badge-famille { background: #2563eb; } .badge-ami { background: #16a34a; } .badge-pro { background: #ca8a04; }
        .actions { display: flex; gap: 10px; }
        .btn-delete { background: #dc2626; color: white; }
        .btn-edit { background: #4b5563; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Annuaire<span style="color: #eab308;"></span></h1>
            <div>
                <span>Compte : <strong>{{ auth()->user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:15px;">
                    @csrf
                    <button type="submit" class="btn btn-logout">Déconnexion</button>
                </form>
            </div>
        </header>

        <div class="grid">
            <div class="card">
                <h3 id="form-title">Ajouter un Contact</h3>
                <form id="contact-form" action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="text" name="nom" id="input-nom" placeholder="Nom" required>
                    <input type="text" name="prenom" id="input-prenom" placeholder="Prénom" required>
                    <input type="text" name="telephone" id="input-telephone" placeholder="Téléphone" required>
                    <input type="email" name="email" id="input-email" placeholder="Email (Optionnel)">
                    <select name="categorie" id="input-categorie" required>
                        <option value="famille">Famille</option>
                        <option value="ami">Ami</option>
                        <option value="pro">Professionnel</option>
                    </select>
                    <button type="submit" id="btn-submit" style="width: 100%;">Enregistrer</button>
                    <button type="button" id="btn-cancel" style="width: 100%; background:#333; color:#fff; margin-top:5px; display:none;" onclick="resetForm()">Annuler</button>
                </form>
            </div>

            <div class="card">
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <input type="text" id="search" placeholder=" Filtrer par nom en direct..." style="margin-bottom: 0;">
                    
                    <a href="{{ route('contacts.index', ['sort' => $ordre === 'asc' ? 'desc' : 'asc']) }}" class="btn" style="white-space: nowrap; align-self: center;">
                        Trier par Nom ({{ $ordre === 'asc' ? 'Z-A' : 'A-Z' }})
                    </a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Téléphone</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="contacts-table">
                        @forelse($contacts as $contact)
                            <tr class="contact-row" data-nom="{{ strtolower($contact->nom) }}">
                                <td>{{ $contact->nom }} {{ $contact->prenom }}<br><small style="color: #666;">{{ $contact->email }}</small></td>
                                <td>{{ $contact->telephone }}</td>
                                <td><span class="badge badge-{{ $contact->categorie }}">{{ $contact->categorie }}</span></td>
                                <td class="actions">
                                    <button class="btn btn-edit" onclick="editContact({{ $contact }})">✏️</button>
                                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Supprimer ce contact définitivement ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #666;">Aucun contact enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Recherche dynamique côté client (DOM JS)
        document.getElementById('search').addEventListener('input', function(e) {
            let filter = e.target.value.toLowerCase();
            let rows = document.querySelectorAll('.contact-row');
            
            rows.forEach(row => {
                let nom = row.getAttribute('data-nom');
                if(nom.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Mode modification dynamique
        function editContact(contact) {
            document.getElementById('form-title').innerText = "Modifier le Contact";
            document.getElementById('contact-form').action = `/contacts/${contact.id}`;
            document.getElementById('form-method').value = "PUT";
            
            document.getElementById('input-nom').value = contact.nom;
            document.getElementById('input-prenom').value = contact.prenom;
            document.getElementById('input-telephone').value = contact.telephone;
            document.getElementById('input-email').value = contact.email;
            document.getElementById('input-categorie').value = contact.categorie;
            
            document.getElementById('btn-submit').innerText = "Mettre à jour";
            document.getElementById('btn-cancel').style.display = 'block';
        }

        function resetForm() {
            document.getElementById('form-title').innerText = "Ajouter un Contact";
            document.getElementById('contact-form').action = "{{ route('contacts.store') }}";
            document.getElementById('form-method').value = "POST";
            document.getElementById('contact-form').reset();
            document.getElementById('btn-submit').innerText = "Enregistrer";
            document.getElementById('btn-cancel').style.display = 'none';
        }
    </script>
</body>
</html>