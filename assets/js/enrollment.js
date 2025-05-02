//#region Enrollment Sidebar
// Select all button elements inside the "enrollment-information-aside"
const buttons = document.querySelectorAll('.enrollment-information-aside button');

const targetDivs = [
    document.querySelector('.enrollment-admission-information'),
    document.querySelector('.enrollment-personal-information'),
    document.querySelector('.enrollment-family-information'),
    document.querySelector('.enrollment-education-information'),
    document.querySelector('.enrollment-medical-information')
];

// Loop through each button and add a click event listener
buttons.forEach(button => {
    button.addEventListener('click', function () {
        // Get the data-step value of the clicked button
        const selectedStep = this.getAttribute('data-step');
        
        // Loop through each div in the targetDivs array
        targetDivs.forEach(div => {
            // If the div's class contains the selected step, display it
            if (div.classList.contains(selectedStep)) {
                div.style.display = 'block'; // Show the matching div
            } else {
                div.style.display = 'none'; // Hide the non-matching divs
            }
        });

        // Loop through each button and update the text color
        buttons.forEach(btn => {
            const h1 = btn.querySelector('h1');
            if (btn === this) {
                // Set the text color to primary yellow if the button is selected
                h1.style.color = 'var(--primary-hex-yellow)';
            } else {
                // Reset the text color to white if the button is not selected
                h1.style.color = 'white';
            }
        });
    });
});
//#endregion

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
            strandSelect.setAttribute('required', 'required');
            typeStudentSelect.removeAttribute('disabled');
            typeStudentSelect.setAttribute('required', 'required');
            lrnInput.setAttribute('required', 'required');
        } else {
            strandSelect.removeAttribute('required');
            typeStudentSelect.setAttribute('disabled', 'disabled');
            typeStudentSelect.removeAttribute('required');
            lrnInput.removeAttribute('required');
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
