/**
 *  Form Wizard
 */

'use strict';

(function () {

   $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
   
  // Vertical Wizard
  // --------------------------------------------------------------------

  const wizardPropertyListing = document.querySelector('#wizard-property-listing');
  if (typeof wizardPropertyListing !== undefined && wizardPropertyListing !== null) {
    // Wizard form
    const wizardPropertyListingForm = wizardPropertyListing.querySelector('#wizard-property-listing-form');
    // Wizard steps
    const wizardPropertyListingFormStep1 = wizardPropertyListingForm.querySelector('#tenant-info');
    const wizardPropertyListingFormStep2 = wizardPropertyListingForm.querySelector('#contact-info');
    // Wizard next prev button
    const wizardPropertyListingNext = [].slice.call(wizardPropertyListingForm.querySelectorAll('.btn-next'));

    const wizardPropertyListingPrev = [].slice.call(wizardPropertyListingForm.querySelectorAll('.btn-prev'));

    const validationStepper = new Stepper(wizardPropertyListing, {
      linear: true
    });

    // Personal Details
    const FormValidation1 = FormValidation.formValidation(wizardPropertyListingFormStep1, {
      fields: {
        // * Validate the fields here based on your requirements
        full_name: {
          validators: {
            notEmpty: {
              message: 'Please enter full name'
            }
          }
        },
        firm_name: {
          validators: {
            notEmpty: {
              message: 'Please enter firm name'
            }
          }
        },
        
        email: {
          validators: {
            notEmpty: {
              message: 'Please enter email'
            }
          }
        }
      },

      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-6'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          //* Move the error message out of the `input-group` element
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    }).on('core.form.valid', function () {
      // Jump to the next step when all fields in the current step are valid
      validationStepper.next();
    });

   
    
    // Price Details
    const FormValidation2 = FormValidation.formValidation(wizardPropertyListingFormStep2, {
      fields: {
        // * Validate the fields here based on your requirements
         'contact_type[]': {
          validators: {
            notEmpty: {
              message: 'Please select type'
            }
          }
        },
        'fullname[]': {
          validators: {
            notEmpty: {
              message: 'Please enter full name'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-4'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // You can submit the form
      // wizardPropertyListingForm.submit()
      // or send the form data to server via an Ajax request
      // To make the demo simple, I just placed an alert
       // Gather form data
      const formData = new FormData(wizardPropertyListingForm);

  
      // Submit form data via AJAX
      submitFormViaAjax(formData);
    });

    wizardPropertyListingNext.forEach(item => {
      item.addEventListener('click', event => {
        //alert(1);
        // When click the Next button, we will validate the current step
        switch (validationStepper._currentIndex) {
          case 0:
            FormValidation1.validate();
            break;

          case 1:
            FormValidation2.validate();
            break;

         

          default:
            break;
        }
      });
    });

    wizardPropertyListingPrev.forEach(item => {
      item.addEventListener('click', event => {

        switch (validationStepper._currentIndex) {
          
          case 1:
            validationStepper.previous();
            break;

          case 0:

          default:
            break;
        }
      });
    });
  }
})();


function submitFormViaAjax(formData) {
    $.ajax({
        url: appurl + 'tenants', // Replace with your server endpoint
        type: 'POST',
        data: formData,
        contentType: false, // Important: Tell jQuery not to set Content-Type
        processData: false, // Important: Prevent jQuery from processing the data
        success: function(response) {
            toastr.success(response.message || "Submitted successfully!");
            window.location.href = appurl+'tenants'; // Change this URL to the desired route
        },
        error: function(xhr) {
            const errors = xhr.responseJSON.errors;
            let errorMessage = '';

            if (errors) {
                $.each(errors, function(key, messages) {
                    errorMessage += messages.join('<br>') + '<br>';
                });
            } else {
                errorMessage = "An unexpected error occurred.";
            }

            toastr.error(errorMessage);
        }
    });
}

