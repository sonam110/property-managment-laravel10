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
    const wizardPropertyListingFormStep1 = wizardPropertyListingForm.querySelector('#lease-info');
    const wizardPropertyListingFormStep2 = wizardPropertyListingForm.querySelector('#lease-rent');
    const wizardPropertyListingFormStep3 = wizardPropertyListingForm.querySelector('#cam');
    const wizardPropertyListingFormStep4 = wizardPropertyListingForm.querySelector('#payment-setting');
    const wizardPropertyListingFormStep5 = wizardPropertyListingForm.querySelector('#security-deposit');
    const wizardPropertyListingFormStep6 = wizardPropertyListingForm.querySelector('#extra-charges');
    const wizardPropertyListingFormStep7 = wizardPropertyListingForm.querySelector('#utilities');
    const wizardPropertyListingFormStep8 = wizardPropertyListingForm.querySelector('#documents');
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
        tenant_id: {
          validators: {
            notEmpty: {
              message: 'Please select Tenant'
            }
          }
        },
        property_id: {
          validators: {
            notEmpty: {
              message: 'Please select property'
            }
          }
        },
        'unit_ids[]': {
          validators: {
            notEmpty: {
              message: 'Please select units'
            }
          }
        },
        start_date: {
          validators: {
            notEmpty: {
              message: 'Please select Start Date'
            }
          }
        },
        end_month: {
          validators: {
            notEmpty: {
              message: 'Please enter lease end month'
            }
          }
        },
        due_on: {
          validators: {
            notEmpty: {
              message: 'Please enter due on'
            }
          }
        },
        
      },

      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-12,.col-sm-6'
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

    // Property Details
    const FormValidation2 = FormValidation.formValidation(wizardPropertyListingFormStep2, {
      fields: {
        // * Validate the fields here based on your requirements
        total_square: {
          validators: {
            notEmpty: {
              message: 'Please enter total area of sqare foot'
            }
          }
        },
        
        price: {
          validators: {
            notEmpty: {
              message: 'Please enter price per sqare foot'
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
      },
      init: instance => {
        instance.on('core.form.validate', function (e) {
          const price = instance.getFieldElement('price').value;
          const fixedPrice = instance.getFieldElement('fixed_price').value;

          if (!price && !fixedPrice) {
            instance.updateFieldStatus('price', 'INVALID', 'Please enter either price per square foot or a fixed price');
            instance.updateFieldStatus('fixed_price', 'INVALID', 'Please enter either price per square foot or a fixed price');
            e.preventDefault();
          } else {
            instance.updateFieldStatus('price', 'VALID');
            instance.updateFieldStatus('fixed_price', 'VALID');
          }
        });
      }
    }).on('core.form.valid', function () {
      // Jump to the next step when all fields in the current step are valid
      validationStepper.next();
    });

    // select2 (Property type)
    const property_type = $('#property_type');
    if (property_type.length) {
      property_type.wrap('<div class="position-relative"></div>');
      property_type
        .select2({
          placeholder: 'Select property type',
          dropdownParent: property_type.parent()
        })
        .on('change.select2', function () {
          // Revalidate the color field when an option is chosen
          FormValidation2.revalidateField('property_type');
        });
    }

    // Property Features
    const FormValidation3 = FormValidation.formValidation(wizardPropertyListingFormStep3, {
      fields: {
         camp_price: {
          validators: {
            notEmpty: {
              message: 'Please enter CAM price'
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
      }
    }).on('core.form.valid', function () {
      validationStepper.next();
    });

    // Property Features
    const FormValidation4 = FormValidation.formValidation(wizardPropertyListingFormStep4, {
      fields: {
         /*'partners[]': {
          validators: {
            notEmpty: {
              message: 'Please select partner'
            }
          }
        },
        'commission_value[]': {
          validators: {
            notEmpty: {
              message: 'Please enter partner share'
            }
          }
        },
        'commission_type[]': {
          validators: {
            notEmpty: {
              message: 'Please select share type'
            }
          }
        },*/

      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-3,.col-sm-2'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      validationStepper.next();
    });


    // Property Features
    const FormValidation5 = FormValidation.formValidation(wizardPropertyListingFormStep5, {
      fields: {
        // * Validate the fields here based on your requirements
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
      }
    }).on('core.form.valid', function () {
      validationStepper.next();
    });


    const FormValidation6 = FormValidation.formValidation(wizardPropertyListingFormStep6, {
      fields: {
        // * Validate the fields here based on your requirements
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
      }
    }).on('core.form.valid', function () {
      validationStepper.next();
    });
    const FormValidation7 = FormValidation.formValidation(wizardPropertyListingFormStep7, {
      fields: {
        // * Validate the fields here based on your requirements
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
      }
    }).on('core.form.valid', function () {
      validationStepper.next();
    });
    
    // Price Details
    const FormValidation8 = FormValidation.formValidation(wizardPropertyListingFormStep8, {
      fields: {
        // * Validate the fields here based on your requirements
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

          case 2:
            FormValidation3.validate();
            break;

          case 3:
            FormValidation4.validate();
            break;

          case 4:
            FormValidation5.validate();
            break;

            case 5:
            FormValidation6.validate();
            break;

           case 6:
            FormValidation7.validate();
            break;
            case 7:
            FormValidation8.validate();
            break;

          default:
            break;
        }
      });
    });

    wizardPropertyListingPrev.forEach(item => {
      item.addEventListener('click', event => {

        switch (validationStepper._currentIndex) {
          
          case 7:
            validationStepper.previous();
            break;

           case 6:
            validationStepper.previous();
            break;

            case 5:
            validationStepper.previous();
            break;

          case 4:
            validationStepper.previous();
            break;

          case 3:
            validationStepper.previous();
            break;

          case 2:
            validationStepper.previous();
            break;

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
        url: appurl + 'leases', // Replace with your server endpoint
        type: 'POST',
        data: formData,
        contentType: false, // Important: Tell jQuery not to set Content-Type
        processData: false, // Important: Prevent jQuery from processing the data
        success: function(response) {
            toastr.success(response.message || "Submitted successfully!");
            window.location.href = appurl+'leases'; // Change this URL to the desired route
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



