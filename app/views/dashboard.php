<div class="card">
    <h2>¡Bienvenido a Puertas Adentro!</h2>
    
    <div class="welcome-content">
        <p class="welcome-message">
            Hola, <strong><?= $this->escape($userName) ?></strong>! 
            Has iniciado sesión correctamente.
        </p>
        
        <div class="info-section">
            <h3>Información del Sistema</h3>
            <ul class="info-list">
                <li><strong>Entorno:</strong> <?= $this->escape($environment) ?></li>
                <li><strong>Modo Desarrollo:</strong> <?= $isDevelopment ? 'Sí' : 'No' ?></li>
                <li><strong>Fecha de Acceso:</strong> <?= date('d/m/Y H:i:s') ?></li>
            </ul>
        </div>
        
        <div class="actions">
            <a href="/logout" class="btn btn-secondary">Cerrar Sesión</a>
        </div>
    </div>
</div>

<style>
.welcome-content {
    padding: 1rem 0;
}

.welcome-message {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    color: #2c3e50;
}

.info-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 6px;
    margin-bottom: 2rem;
}

.info-section h3 {
    color: #495057;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.info-list {
    list-style: none;
    padding: 0;
}

.info-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.info-list li:last-child {
    border-bottom: none;
}

.actions {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    border-radius: 4px;
    display: inline-block;
    transition: background-color 0.3s;
}

.btn-secondary:hover {
    background: #545b62;
    color: white;
    text-decoration: none;
}
</style>