

document.addEventListener('DOMContentLoaded', function () {
    //#region Admission - Show/Hide 'entry-new'
    const entrySelect = document.querySelector('select[name="enrollment-information-entry"]');
    const entryNewDivs = document.querySelectorAll('.entry-new');

    const strandSelect = document.querySelector('select[name="enrollment-information-strand"]');
    const typeStudentSelect = document.querySelector('select[name="enrollment-information-typeStudent"]');
    const lrnInput = document.querySelector('input[name="enrollment-information-LRN"]');

    function toggleEntryNewFields() {
        const entryValue = entrySelect.value;

        const isNew = entryValue === "New" || entryValue === "";

        // Show or hide entry-new fields
        entryNewDivs.forEach(div => {
            div.style.display = isNew ? 'block' : 'none';

            // Reset values if not "New"
            if (!isNew) {
                const inputs = div.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.value = '';
                    input.removeAttribute('required');
                });
            }
        });

        // Toggle 'required' attributes
        if (isNew) {
            if (strandSelect) strandSelect.setAttribute('required', 'required');
            if (typeStudentSelect) {
                typeStudentSelect.removeAttribute('disabled');
                typeStudentSelect.setAttribute('required', 'required');
            }
            if (lrnInput) lrnInput.setAttribute('required', 'required');
        } else {
            if (strandSelect) strandSelect.removeAttribute('required');
            if (typeStudentSelect) {
                typeStudentSelect.setAttribute('disabled', 'disabled');
                typeStudentSelect.removeAttribute('required');
            }
            if (lrnInput) lrnInput.removeAttribute('required');
        }
    }

    toggleEntryNewFields(); // initial state

    entrySelect.addEventListener('change', toggleEntryNewFields);
    //#endregion
    //#region Personal - Refresh Provinces

    //#endregion


});

//#region Control Number - Disable everything
// Select all elements with class 'enrollment-information-disabled'
const container = document.querySelector('.enrollment-information-disabled');

// Check if the container exists
if (container) {
    // Select all inputs and selects inside the container
    const inputsAndSelects = container.querySelectorAll('input, select, button');

    // Loop through each input and select element and disable them
    inputsAndSelects.forEach(element => {
        element.disabled = true;
    });
}
//#endregion


