<?php
require_once '../partials_reception/header.php';
require_once '../partials_reception/sidebar.php';
?>

<style>
    main {
        margin-left: 0;
        padding: 2rem;
        font-family: 'Inter', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
    }

    .filters {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    label {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    select, input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    button {
        padding: 8px 16px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.9;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        position: sticky;
        top: 0;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .actions {
        display: flex;
        gap: 5px;
    }

    .action-btn {
        padding: 5px 10px;
        font-size: 12px;
    }

    .rembourser-btn {
        background-color: #4CAF50;
    }

    .loading {
        text-align: center;
        padding: 20px;
    }

    .apply-btn {
        background-color: #2196F3;
    }

    .reset-btn {
        background-color: #f44336;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 1rem;
    }
</style>

<main>
    <h2>Prêts en cours - Gestion des remboursements</h2>
    
    <div class="filters">
        <div class="filter-group">
            <label for="filter-client">Client</label>
            <select id="filter-client">
                <option value="">Tous les clients</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-type">Type de prêt</label>
            <select id="filter-type">
                <option value="">Tous les types</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-montant-min">Montant min</label>
            <input type="number" id="filter-montant-min" min="0" step="100" placeholder="Montant minimum">
        </div>
        
        <div class="filter-group">
            <label for="filter-montant-max">Montant max</label>
            <input type="number" id="filter-montant-max" min="0" step="100" placeholder="Montant maximum">
        </div>
        
        <div class="filter-group" style="align-self: flex-end;">
            <button id="apply-filters" class="apply-btn">Appliquer</button>
            <button id="reset-filters" class="reset-btn">Réinitialiser</button>
        </div>
    </div>
    
    <div id="loading" class="loading">Chargement en cours...</div>
    <div id="prets-container">
        <table id="prets-table">
            <thead>
                <tr>
                    <th>ID Prêt</th>
                    <th>Montant</th>
                    <th>Durée</th>
                    <th>Mensualité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="prets-body"></tbody>
        </table>
    </div>
</main>

<!-- Modal pour le remboursement -->
<div id="remboursement-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Enregistrer un remboursement</h3>
        <form id="remboursement-form">
            <input type="hidden" id="pret-id">
            
            <div class="form-group">
                <label for="date-remboursement">Date de remboursement</label>
                <input type="date" id="date-remboursement" required>
            </div>
            
            <div class="form-group">
                <label for="mois-rembourse">Mois remboursé</label>
                <input type="number" id="mois-rembourse" min="1" max="12" required>
            </div>
            
            <div class="form-group">
                <label for="annee-rembourse">Année remboursée</label>
                <input type="number" id="annee-rembourse" min="2000" max="2100" required>
            </div>
            
            <div class="form-group">
                <label for="montant-rembourse">Montant remboursé</label>
                <input type="number" id="montant-rembourse" step="0.01" min="0" required>
            </div>
            
            <button type="submit" class="rembourser-btn">Enregistrer</button>
        </form>
    </div>
</div>

<script src="../js/ajax.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('remboursement-modal');
    const closeBtn = document.querySelector('.close');
    const applyFiltersBtn = document.getElementById('apply-filters');
    const resetFiltersBtn = document.getElementById('reset-filters');
    const remboursementForm = document.getElementById('remboursement-form');
    
    // Initialisation
    loadClients();
    loadTypesPret();
    loadPretsEnCours();
    
    // Gestion des événements
    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    applyFiltersBtn.addEventListener('click', loadPretsEnCours);
    // resetFiltersBtn.addEventListener('click', resetFilters);
    
    remboursementForm.addEventListener('submit', function(e) {
        e.preventDefault();
        saveRemboursement();
    });

    function loadClients() {
        const clientSelect = document.getElementById('filter-client');
        ajax("GET", "/clients", null, (clients) => {
            clientSelect.innerHTML = '<option value="">Tous les clients</option>';
            clients.forEach(client => {
                const option = document.createElement('option');
                option.value = client.id;
                option.textContent = `${client.nom} ${client.prenom}`;
                clientSelect.appendChild(option);
            });
        }, (error) => {
            console.error("Erreur lors du chargement des clients :", error);
            clientSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
    }
    
    function loadTypesPret() {
        const typeSelect = document.getElementById('filter-type');
        ajax("GET", "/types-pret", null, (types) => {
            typeSelect.innerHTML = '<option value="">Tous les types</option>';
            types.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.nom;
                typeSelect.appendChild(option);
            });
        }, (error) => {
            console.error("Erreur lors du chargement des types de prêt :", error);
            typeSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
    }
    
    function loadPretsEnCours() {
    const loading = document.getElementById('loading');
    const container = document.getElementById('prets-container');
    const tbody = document.getElementById('prets-body');
    
    loading.style.display = 'block';
    container.style.display = 'none';
    
    // const clientId = document.getElementById('filter-client').value;
    // const typeId = document.getElementById('filter-type').value;
    // const montantMin = document.getElementById('filter-montant-min').value;
    // const montantMax = document.getElementById('filter-montant-max').value;
    
    // let params = [];
    // if (clientId) params.push(`client=${clientId}`);
    // if (typeId) params.push(`type=${typeId}`);
    // if (montantMin) params.push(`min=${montantMin}`);
    // if (montantMax) params.push(`max=${montantMax}`);
    
    // const queryString = params.length > 0 ? `?${params.join('&')}` : '';
    
    ajax('GET', `/pret/enCours`, null, 
        function(response) {
            try {
                // Vérifier si la réponse est valide
                if (!response) {
                    throw new Error('Réponse vide du serveur');
                }
                
                tbody.innerHTML = '';
                
                if (Array.isArray(response) && response.length > 0) {
                    response.forEach(pret => {
                        try {
                            // Calculer le montant déjà remboursé
                            const montantDejaRembourse = pret.montant_total_remboursement - pret.montant_pret;
                            const resteAPayer = pret.montant_total_remboursement - montantDejaRembourse;
                            
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${pret.id}</td>
                                <td>${parseFloat(pret.montant_pret).toFixed(2)} €</td>
                                <td>${pret.duree_remboursement} mois</td>
                                <td>${parseFloat(pret.montant_remboursement_par_mois).toFixed(2)} €</td>
                                <td class="actions">
                                    <button class="action-btn rembourser-btn" 
                                            data-id="${pret.id}" 
                                            data-mensualite="${pret.montant_remboursement_par_mois}">
                                        Rembourser
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(row);
                            
                            // Ajouter l'événement au bouton
                            row.querySelector('.rembourser-btn').addEventListener('click', function() {
                                initRemboursement(this.getAttribute('data-id'), this.getAttribute('data-mensualite'));
                            });
                            
                        } catch (e) {
                            console.error('Erreur lors du traitement d\'un prêt:', e);
                            // Ajouter une ligne d'erreur pour ce prêt
                            const errorRow = document.createElement('tr');
                            errorRow.innerHTML = `<td colspan="8" style="color: red;">Erreur d'affichage du prêt</td>`;
                            tbody.appendChild(errorRow);
                        }
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="8" style="text-align: center;">Aucun prêt en cours trouvé</td>';
                    tbody.appendChild(row);
                }
                
            } catch (error) {
                console.error('Erreur lors du traitement de la réponse:', error);
                tbody.innerHTML = '<tr><td colspan="8" style="color: red; text-align: center;">Erreur lors du chargement des données</td></tr>';
                
                // Afficher le détail de l'erreur dans la console ou un log
                if (error instanceof Error) {
                    console.error('Stack trace:', error.stack);
                }
            } finally {
                loading.style.display = 'none';
                container.style.display = 'block';
            }
        },
        function(error, status) {
            console.error('Erreur AJAX:', status, error);
            loading.style.display = 'none';
            
            try {
                // Essayer de parser l'erreur comme JSON
                const errorData = JSON.parse(error);
                tbody.innerHTML = `<tr><td colspan="8" style="color: red; text-align: center;">
                    ${errorData.message || 'Erreur serveur'}
                </td></tr>`;
            } catch (e) {
                // Si le parsing échoue, afficher l'erreur brute
                tbody.innerHTML = `<tr><td colspan="8" style="color: red; text-align: center;">
                    Erreur lors de la communication avec le serveur (${status})
                </td></tr>`;
            }
        }
    );
}
    
    // function resetFilters() {
    //     document.getElementById('filter-client').value = '';
    //     document.getElementById('filter-type').value = '';
    //     document.getElementById('filter-montant-min').value = '';
    //     document.getElementById('filter-montant-max').value = '';
    //     loadPretsEnCours();
    // }
    
    function initRemboursement(pretId, mensualite) {
        document.getElementById('pret-id').value = pretId;
        document.getElementById('montant-rembourse').value = mensualite;
        
        const today = new Date();
        document.getElementById('date-remboursement').value = today.toISOString().split('T')[0];
        document.getElementById('mois-rembourse').value = today.getMonth() + 1;
        document.getElementById('annee-rembourse').value = today.getFullYear();
        
        modal.style.display = 'block';
    }
    
    function saveRemboursement() {
        const data = {
            id_pret: document.getElementById('pret-id').value,
            date_remboursement: document.getElementById('date-remboursement').value,
            mois_rembourse: document.getElementById('mois-rembourse').value,
            annee_rembourse: document.getElementById('annee-rembourse').value,
            montant_rembourse: document.getElementById('montant-rembourse').value
        };
        
        const params = new URLSearchParams();
        for (const key in data) {
            params.append(key, data[key]);
        }
        
        ajax('POST', '/remboursements', params.toString(), (response) => {
            alert('Remboursement enregistré avec succès');
            modal.style.display = 'none';
            loadPretsEnCours();
        }, (error) => {
            console.error('Erreur:', error);
            alert('Erreur lors de l\'enregistrement du remboursement');
        });
    }
});
</script>

<?php require_once '../partials_reception/footer.php'; ?>