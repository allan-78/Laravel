document.addEventListener('DOMContentLoaded', function() {
    const statusForms = document.querySelectorAll('.transaction-status-form');
    
    statusForms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const transactionId = this.dataset.transactionId;
            const status = this.querySelector('select[name="status"]').value;
            const token = document.querySelector('meta[name="csrf-token"]').content;
            
            try {
                const response = await fetch(`/transactions/${transactionId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Update the UI to show success
                    const statusElement = document.querySelector(`#status-${transactionId}`);
                    if (statusElement) {
                        statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                    }
                    
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4';
                    successMessage.textContent = 'Status updated successfully!';
                    form.parentNode.insertBefore(successMessage, form);
                    
                    // Remove success message after 3 seconds
                    setTimeout(() => successMessage.remove(), 3000);
                } else {
                    throw new Error(data.message || 'Error updating status');
                }
            } catch (error) {
                // Show error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4';
                errorMessage.textContent = error.message;
                form.parentNode.insertBefore(errorMessage, form);
                
                // Remove error message after 3 seconds
                setTimeout(() => errorMessage.remove(), 3000);
            }
        });
    });
});