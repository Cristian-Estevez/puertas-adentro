<div>
    <h1>Admin Panel</h1>

    <p>Welcome, <?= htmlspecialchars($user['name']) ?>!</p>

    <?php if (!$scriptHasRun): ?>
        <button class="btn-secondary">Agregar casos a base de datos</button>
    <?php endif; ?>
</div>

<script>
    document.querySelector('.btn-secondary').addEventListener('click', async () => {
        try {
            // First populate the database
            const populateResponse = await fetch('/populate-db.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (populateResponse.ok) {
                // If population successful, mark it as completed
                const markResponse = await fetch('/public/admin.php?action=markPopulateDBAsRan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const responseData = await markResponse.json();
                
                if (markResponse.ok) {
                    alert(responseData.message || 'Database populated successfully!');
                    // Remove the button from DOM
                    document.querySelector('.btn-secondary').remove();
                } else {
                    alert(responseData.error || 'Database populated but failed to mark as completed.');
                }
            } else {
                alert('Failed to populate database.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while populating the database.');
        }
    });
</script>