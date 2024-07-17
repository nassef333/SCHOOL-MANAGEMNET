<!-- resources/views/components/training-resource-modal.blade.php -->
<div id="trainingResourceModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Training Resource</h5>
                <button type="button" class="close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for training resource creation here -->
                <form id="trainingResourceForm">
                    <!-- Form fields go here -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitTrainingResourceForm()">Create and Continue</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const fieldsToWatch = [
        'molars_and_skills',
        'homework',
        'planning',
        'media_usage',
        'learning_strategy',
        'manage_class',
    ];

    fieldsToWatch.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', function() {
                if (this.value === 'مقبول' || this.value === 'جيد') {
                    openModal();
                }
            });
        }
    });
});

function openModal() {
    const modal = document.getElementById('trainingResourceModal');
    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('trainingResourceModal');
    modal.classList.add('hidden');
}

function submitTrainingResourceForm() {
    const form = document.getElementById('trainingResourceForm');
    // Add logic to handle form submission
    closeModal();
}
</script>
