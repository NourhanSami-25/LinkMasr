"use strict";

// Class definition
var KTAppCalendar = (function () {
    // Shared variables
    // Calendar variables
    var calendar;
    var data = {
        id: "",
        eventName: "",
        eventDescription: "",
        eventLocation: "",
        startDate: "",
        endDate: "",
        allDay: false,
    };

    // Add event variables
    var eventName;
    var eventDescription;
    var eventLocation;
    var startDatepicker;
    var startFlatpickr;
    var endDatepicker;
    var endFlatpickr;
    var startTimepicker;
    var startTimeFlatpickr;
    var endTimepicker;
    var endTimeFlatpickr;
    var modal;
    var modalTitle;
    var form;
    var validator;
    var addButton;
    // var submitButton;
    var cancelButton;
    var closeButton;

    // View event variables
    var viewEventName;
    var viewAllDay;
    var viewEventDescription;
    var viewEventLocation;
    var viewStartDate;
    var viewEndDate;
    var viewModal;
    var editModal;
    var viewEditButton;
    var viewDeleteButton;
    var allEvents;
    var eventFilter;
    // var filterButton;

    // Private functions
    var initCalendarApp = function () {
        // Define variables
        // var filterButton = document.getElementById('kt_calendar_filter');
        var calendarEl = document.getElementById("kt_calendar_app");
        var todayDate = moment().startOf("day");
        var YM = todayDate.format("YYYY-MM");
        var YESTERDAY = todayDate
            .clone()
            .subtract(1, "day")
            .format("YYYY-MM-DD");
        var TODAY = todayDate.format("YYYY-MM-DD");
        var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

        allEvents = ["project", "task", "paymentRequest", "contract", "event"];
        eventFilter = allEvents;

        // Init calendar --- more info: https://fullcalendar.io/docs/initialize-globals
        // Detect if Arabic locale
        var isArabic = document.documentElement.lang === 'ar' || document.querySelector('html[dir="rtl"]');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: isArabic ? 'ar' : 'en', // Set locale based on page language
            direction: isArabic ? 'rtl' : 'ltr', // RTL for Arabic
            headerToolbar: {
                left: isArabic ? "dayGridMonth,timeGridWeek,timeGridDay" : "prev,next today",
                center: "title",
                right: isArabic ? "prev,next today" : "dayGridMonth,timeGridWeek,timeGridDay",
            },
            buttonText: isArabic ? {
                today: 'اليوم',
                month: 'شهر',
                week: 'أسبوع',
                day: 'يوم',
                list: 'قائمة'
            } : {},
            initialDate: TODAY,
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,

            // Select dates action --- more info: https://fullcalendar.io/docs/select-callback
            select: function (arg) {
                formatArgs(arg);
                handleNewEvent();
            },

            // Click event --- more info: https://fullcalendar.io/docs/eventClick
            eventClick: function (arg) {
                // Get the URL directly from extendedProps
                const eventUrl = arg.event.extendedProps.event_url;
                const eventType = arg.event.extendedProps.type;

                formatArgs({
                    id: arg.event.id,
                    title: arg.event.title,
                    description: arg.event.extendedProps.description,
                    location: arg.event.extendedProps.location,
                    startStr: arg.event.startStr,
                    endStr: arg.event.endStr,
                    allDay: arg.event.allDay,
                    event_url: eventUrl, // Use the variable directly
                    type: eventType, // Use the variable directly
                });

                handleViewEvent();
            },

            editable: true,
            dayMaxEvents: 3, // Show max 3 events per day, then show "+X more" link
            eventMaxStack: 3, // Stack max 3 events
            moreLinkText: isArabic ? 'المزيد' : 'more', // "More" link text
            eventDisplay: 'block', // Display events as blocks for better visibility

            // events: myevents,
            // events: function (fetchInfo, successCallback, failureCallback) {
            //     fetch('http://localhost:8000/calendar/events')
            //         .then(response => response.json())
            //         .then(events => {
            //             // Filter events based on the global `eventFilter`
            //             var filteredEvents = events.filter(event => eventFilter.includes(event.type));
            //             successCallback(filteredEvents);
            //         })
            //         .catch(error => failureCallback(error));
            // },

            events: function (fetchInfo, successCallback, failureCallback) {
                fetch(baseUrl + "/calendar/events")
                    .then((response) => response.json())
                    .then((events) => {
                        var filteredEvents = events.filter((event) =>
                            eventFilter.includes(event.type)
                        );
                        successCallback(filteredEvents);
                    })
                    .catch((error) => failureCallback(error));
            },

            // Handle changing calendar views --- more info: https://fullcalendar.io/docs/datesSet
            datesSet: function () {
                // do some stuff
            },
        });
        calendar.render();
    };

    document
        .getElementById("apply_filter")
        .addEventListener("click", function () {
            var selectedOptions =
                document.getElementById("kt_calendar_filter").selectedOptions;
            eventFilter = Array.from(selectedOptions).map(
                (option) => option.value
            );
            calendar.refetchEvents();
        });

    document
        .getElementById("reset_filter")
        .addEventListener("click", function () {
            var selectedOptions =
                document.getElementById("kt_calendar_filter").selectedOptions;
            eventFilter = allEvents;
            calendar.refetchEvents();
        });

    // Init validator
    const initValidator = () => {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(form, {
            fields: {
                calendar_event_name: {
                    validators: {
                        notEmpty: {
                            message: "Event name is required",
                        },
                    },
                },
                calendar_event_start_date: {
                    validators: {
                        notEmpty: {
                            message: "Start date is required",
                        },
                    },
                },
                calendar_event_end_date: {
                    validators: {
                        notEmpty: {
                            message: "End date is required",
                        },
                    },
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });
    };

    // Initialize datepickers --- more info: https://flatpickr.js.org/
    const initDatepickers = () => {
        startFlatpickr = flatpickr(startDatepicker, {
            enableTime: false,
            dateFormat: "Y-m-d",
        });

        endFlatpickr = flatpickr(endDatepicker, {
            enableTime: false,
            dateFormat: "Y-m-d",
        });

        startTimeFlatpickr = flatpickr(startTimepicker, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        endTimeFlatpickr = flatpickr(endTimepicker, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    };

    // Handle add button
    const handleAddButton = () => {
        addButton.addEventListener("click", (e) => {
            // Reset form data
            data = {
                id: "",
                eventName: "",
                eventDescription: "",
                startDate: new Date(),
                endDate: new Date(),
                allDay: false,
                type: "event",
            };
            handleNewEvent();
        });
    };

    // Handle add new event
    const handleNewEvent = () => {
        // Update modal title
        modalTitle.innerText = "اضافة حدث جديد";

        modal.show();

        // Select datepicker wrapper elements
        const datepickerWrappers = form.querySelectorAll(
            '[data-kt-calendar="datepicker"]'
        );

        // Handle all day toggle
        const allDayToggle = form.querySelector(
            "#kt_calendar_datepicker_allday"
        );
        allDayToggle.addEventListener("click", (e) => {
            if (e.target.checked) {
                datepickerWrappers.forEach((dw) => {
                    dw.classList.add("d-none");
                });
            } else {
                endFlatpickr.setDate(data.startDate, true, "Y-m-d");
                datepickerWrappers.forEach((dw) => {
                    dw.classList.remove("d-none");
                });
            }
        });

        populateForm(data);

        // Handle submit form
        // submitButton.addEventListener('click', function (e) {
        //     // Prevent default button action
        //     e.preventDefault();

        //     // Validate form before submit
        //     if (validator) {
        //         validator.validate().then(function (status) {

        //             if (status == 'Valid') {
        //                 // Show loading indication
        //                 submitButton.setAttribute('data-kt-indicator', 'on');

        //                 // Disable submit button whilst loading
        //                 submitButton.disabled = true;

        //                 // Simulate form submission
        //                 setTimeout(function () {
        //                     // Simulate form submission
        //                     submitButton.removeAttribute('data-kt-indicator');

        //                     // Show popup confirmation
        //                     Swal.fire({
        //                         text: "New event added to calendar!",
        //                         icon: "success",
        //                         buttonsStyling: false,
        //                         confirmButtonText: "Ok, got it!",
        //                         customClass: {
        //                             confirmButton: "btn btn-primary"
        //                         }
        //                     }).then(function (result) {
        //                         if (result.isConfirmed) {
        //                             modal.hide();

        //                             // Enable submit button after loading
        //                             submitButton.disabled = false;

        //                             // Detect if is all day event
        //                             let allDayEvent = false;
        //                             if (allDayToggle.checked) { allDayEvent = true; }
        //                             if (startTimeFlatpickr.selectedDates.length === 0) { allDayEvent = true; }

        //                             // Merge date & time
        //                             var startDateTime = moment(startFlatpickr.selectedDates[0]).format();
        //                             var endDateTime = moment(endFlatpickr.selectedDates[endFlatpickr.selectedDates.length - 1]).format();
        //                             if (!allDayEvent) {
        //                                 const startDate = moment(startFlatpickr.selectedDates[0]).format('YYYY-MM-DD');
        //                                 const endDate = startDate;
        //                                 const startTime = moment(startTimeFlatpickr.selectedDates[0]).format('HH:mm:ss');
        //                                 const endTime = moment(endTimeFlatpickr.selectedDates[0]).format('HH:mm:ss');

        //                                 startDateTime = startDate + 'T' + startTime;
        //                                 endDateTime = endDate + 'T' + endTime;
        //                             }

        //                             // Add new event to calendar
        //                             calendar.addEvent({
        //                                 id: uid(),
        //                                 title: eventName.value,
        //                                 description: eventDescription.value,
        //                                 location: eventLocation.value,
        //                                 start: startDateTime,
        //                                 end: endDateTime,
        //                                 allDay: allDayEvent
        //                             });
        //                             calendar.render();

        //                             // Reset form for demo purposes only
        //                             form.reset();
        //                         }
        //                     });

        //                     //form.submit(); // Submit form
        //                 }, 2000);
        //             } else {
        //                 // Show popup warning
        //                 Swal.fire({
        //                     text: "Sorry, looks like there are some errors detected, please try again.",
        //                     icon: "error",
        //                     buttonsStyling: false,
        //                     confirmButtonText: "Ok, got it!",
        //                     customClass: {
        //                         confirmButton: "btn btn-primary"
        //                     }
        //                 });
        //             }
        //         });
        //     }
        // });
    };

    // Handle edit event
    // const handleEditEvent = () => {
    //     // Update modal title
    //     modalTitle.innerText = "Edit an Event";

    //     modal.show();

    //     // Select datepicker wrapper elements
    //     const datepickerWrappers = form.querySelectorAll('[data-kt-calendar="datepicker"]');

    //     // Handle all day toggle
    //     const allDayToggle = form.querySelector('#kt_calendar_datepicker_allday');
    //     allDayToggle.addEventListener('click', e => {
    //         if (e.target.checked) {
    //             datepickerWrappers.forEach(dw => {
    //                 dw.classList.add('d-none');
    //             });
    //         } else {
    //             endFlatpickr.setDate(data.startDate, true, 'Y-m-d');
    //             datepickerWrappers.forEach(dw => {
    //                 dw.classList.remove('d-none');
    //             });
    //         }
    //     });

    //     populateForm(data);

    //     // Handle submit form
    //     // submitButton.addEventListener('click', function (e) {
    //     //     // Prevent default button action
    //     //     e.preventDefault();

    //     //     // Validate form before submit
    //     //     if (validator) {
    //     //         validator.validate().then(function (status) {

    //     //             if (status == 'Valid') {
    //     //                 // Show loading indication
    //     //                 submitButton.setAttribute('data-kt-indicator', 'on');

    //     //                 // Disable submit button whilst loading
    //     //                 submitButton.disabled = true;

    //     //                 // Simulate form submission
    //     //                 setTimeout(function () {
    //     //                     // Simulate form submission
    //     //                     submitButton.removeAttribute('data-kt-indicator');

    //     //                     // Show popup confirmation
    //     //                     Swal.fire({
    //     //                         text: "New event added to calendar!",
    //     //                         icon: "success",
    //     //                         buttonsStyling: false,
    //     //                         confirmButtonText: "Ok, got it!",
    //     //                         customClass: {
    //     //                             confirmButton: "btn btn-primary"
    //     //                         }
    //     //                     }).then(function (result) {
    //     //                         if (result.isConfirmed) {
    //     //                             modal.hide();

    //     //                             // Enable submit button after loading
    //     //                             submitButton.disabled = false;

    //     //                             // Remove old event
    //     //                             calendar.getEventById(data.id).remove();

    //     //                             // Detect if is all day event
    //     //                             let allDayEvent = false;
    //     //                             if (allDayToggle.checked) { allDayEvent = true; }
    //     //                             if (startTimeFlatpickr.selectedDates.length === 0) { allDayEvent = true; }

    //     //                             // Merge date & time
    //     //                             var startDateTime = moment(startFlatpickr.selectedDates[0]).format();
    //     //                             var endDateTime = moment(endFlatpickr.selectedDates[endFlatpickr.selectedDates.length - 1]).format();
    //     //                             if (!allDayEvent) {
    //     //                                 const startDate = moment(startFlatpickr.selectedDates[0]).format('YYYY-MM-DD');
    //     //                                 const endDate = startDate;
    //     //                                 const startTime = moment(startTimeFlatpickr.selectedDates[0]).format('HH:mm:ss');
    //     //                                 const endTime = moment(endTimeFlatpickr.selectedDates[0]).format('HH:mm:ss');

    //     //                                 startDateTime = startDate + 'T' + startTime;
    //     //                                 endDateTime = endDate + 'T' + endTime;
    //     //                             }

    //     //                             // Add new event to calendar
    //     //                             calendar.addEvent({
    //     //                                 id: uid(),
    //     //                                 title: eventName.value,
    //     //                                 description: eventDescription.value,
    //     //                                 location: eventLocation.value,
    //     //                                 start: startDateTime,
    //     //                                 end: endDateTime,
    //     //                                 allDay: allDayEvent
    //     //                             });
    //     //                             calendar.render();

    //     //                             // Reset form for demo purposes only
    //     //                             form.reset();
    //     //                         }
    //     //                     });

    //     //                     //form.submit(); // Submit form
    //     //                 }, 2000);
    //     //             } else {
    //     //                 // Show popup warning
    //     //                 Swal.fire({
    //     //                     text: "Sorry, looks like there are some errors detected, please try again.",
    //     //                     icon: "error",
    //     //                     buttonsStyling: false,
    //     //                     confirmButtonText: "Ok, got it!",
    //     //                     customClass: {
    //     //                         confirmButton: "btn btn-primary"
    //     //                     }
    //     //                 });
    //     //             }
    //     //         });
    //     //     }
    //     // });
    // }

    // Handle view event
    const handleViewEvent = () => {
        viewModal.show();

        // Detect all day event
        var eventNameMod;
        var startDateMod;
        var endDateMod;

        // Generate labels
        if (data.allDay) {
            eventNameMod = "All Day";
            startDateMod = moment(data.startDate).format("Do MMM, YYYY");
            // For case sessions, use startDate as endDate if they're the same
            endDateMod = data.endDate
                ? moment(data.endDate).format("Do MMM, YYYY")
                : moment(data.startDate).format("Do MMM, YYYY");
        } else {
            eventNameMod = "";
            startDateMod = moment(data.startDate).format(
                "Do MMM, YYYY - h:mm a"
            );
            // For case sessions, use startDate as endDate if they're the same
            endDateMod = data.endDate
                ? moment(data.endDate).format("Do MMM, YYYY - h:mm a")
                : moment(data.startDate).format("Do MMM, YYYY - h:mm a");
        }

        // Populate view data
        viewEventName.innerText = data.eventName;
        viewAllDay.innerText = eventNameMod;
        viewEventDescription.innerText = data.eventDescription
            ? data.eventDescription
            : "--";
        viewEventLocation.innerText = data.eventLocation
            ? data.eventLocation
            : "--";
        viewStartDate.innerText = startDateMod;
        viewEndDate.innerText = endDateMod;

        // Make the event name clickable if it's a task and has URL
        if (data.event_url) {
            // Make it look clickable
            viewEventName.style.cursor = "pointer";
            viewEventName.style.color = "#0d6efd";
            // viewEventName.style.textDecoration = "underline";
            viewEventName.title = "click here for details";

            // Clone and replace the element to remove old event listeners
            const newViewEventName = viewEventName.cloneNode(true);
            viewEventName.parentNode.replaceChild(
                newViewEventName,
                viewEventName
            );

            // Update the reference to the new element
            viewEventName = newViewEventName;

            // Add click event to the NEW element
            viewEventName.addEventListener("click", function (e) {
                e.preventDefault();
                window.location.href = data.event_url;
            });
        } else {
            // Reset styles if not clickable
            viewEventName.style.cursor = "default";
            viewEventName.style.color = "";
            viewEventName.style.textDecoration = "none";

            // Also remove any existing click listeners for non-clickable events
            const newViewEventName = viewEventName.cloneNode(true);
            viewEventName.parentNode.replaceChild(
                newViewEventName,
                viewEventName
            );
            viewEventName = newViewEventName;
        }
    };

    const handleEditEvent = () => {
        editModal.show();
    };

    // Handle delete event
    const handleDeleteEvent = () => {
        viewDeleteButton.addEventListener("click", (e) => {
            e.preventDefault();
            Swal.fire({
                text: "هل انت متاكد انك تريد حذف هذا الحدث؟",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "احذف",
                cancelButtonText: "الغاء",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light",
                },
            }).then(async function (result) {
                if (result.value) {
                    try {
                        // Make API call to delete from database
                        const response = await fetch(`/events/${data.id}`, {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                        });

                        if (response.ok) {
                            // Only remove from calendar if DB deletion succeeded
                            calendar.getEventById(data.id).remove();
                            viewModal.hide();

                            // Show success message
                            Swal.fire({
                                text: "تم حذف الحدث بنجاح",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "حسناً",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        } else {
                            throw new Error("Failed to delete event");
                        }
                    } catch (error) {
                        console.error("Error deleting event:", error);
                        Swal.fire({
                            text: "حدث خطأ أثناء محاولة الحذف",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "حسناً",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                        });
                    }
                }
            });
        });
    };

    // Handle edit button
    const handleEditButton = () => {
        viewEditButton.addEventListener("click", (e) => {
            e.preventDefault();

            viewModal.hide();
            editModal.show();
            if (data.allDay) {
                let eventNameMod = "All Day";
                document.getElementById("event_start").value = moment(
                    data.startDate
                ).format("Do MMM, YYYY");
                document.getElementById("event_end").value = moment(
                    data.endDate
                ).format("Do MMM, YYYY");
            } else {
                eventNameMod = "";
                document.getElementById("event_start").value = moment(
                    data.startDate
                ).format("Do MMM, YYYY - h:mm a");
                document.getElementById("event_end").value = moment(
                    data.endDate
                ).format("Do MMM, YYYY - h:mm a");
            }

            // Update hidden input field
            document.getElementById("event_id").value = data.id;
            document.getElementById("event_name").value = data.eventName;
            document.getElementById("event_description").value =
                data.eventDescription || "";
            document.getElementById("event_location").value =
                data.eventLocation || "";
        });
    };

    // Handle cancel button
    const handleCancelButton = () => {
        // Edit event modal cancel button
        cancelButton.addEventListener("click", function (e) {
            e.preventDefault();
            form.reset(); // Reset form
            modal.hide(); // Hide modal
        });
    };

    // Handle close button
    const handleCloseButton = () => {
        // Edit event modal close button
        closeButton.addEventListener("click", function (e) {
            e.preventDefault();
            form.reset(); // Reset form
            modal.hide(); // Hide modal
        });
    };

    // Handle view button
    const handleViewButton = () => {
        const viewButton = document.querySelector(
            "#kt_calendar_event_view_button"
        );
        viewButton.addEventListener("click", (e) => {
            e.preventDefault();

            hidePopovers();
            handleViewEvent();
        });
    };

    // Helper functions

    // Reset form validator on modal close
    const resetFormValidator = (element) => {
        // Target modal hidden event --- For more info: https://getbootstrap.com/docs/5.0/components/modal/#events
        element.addEventListener("hidden.bs.modal", (e) => {
            if (validator) {
                // Reset form validator. For more info: https://formvalidation.io/guide/api/reset-form
                validator.resetForm(true);
            }
        });
    };

    // Populate form
    const populateForm = () => {
        eventName.value = data.eventName ? data.eventName : "";
        eventDescription.value = data.eventDescription
            ? data.eventDescription
            : "";
        eventLocation.value = data.eventLocation ? data.eventLocation : "";
        startFlatpickr.setDate(data.startDate, true, "Y-m-d");

        // Handle null end dates
        const endDate = data.endDate
            ? data.endDate
            : moment(data.startDate).format();
        endFlatpickr.setDate(endDate, true, "Y-m-d");

        const allDayToggle = form.querySelector(
            "#kt_calendar_datepicker_allday"
        );
        const datepickerWrappers = form.querySelectorAll(
            '[data-kt-calendar="datepicker"]'
        );
        if (data.allDay) {
            allDayToggle.checked = true;
            datepickerWrappers.forEach((dw) => {
                dw.classList.add("d-none");
            });
        } else {
            startTimeFlatpickr.setDate(data.startDate, true, "Y-m-d H:i");
            endTimeFlatpickr.setDate(data.endDate, true, "Y-m-d H:i");
            endFlatpickr.setDate(data.startDate, true, "Y-m-d");
            allDayToggle.checked = false;
            datepickerWrappers.forEach((dw) => {
                dw.classList.remove("d-none");
            });
        }
    };

    // Format FullCalendar reponses
    const formatArgs = (res) => {
        data.id = res.id;
        data.eventName = res.title;
        data.eventDescription = res.description;
        data.eventLocation = res.location;
        data.startDate = res.startStr;
        data.endDate = res.endStr;
        data.allDay = res.allDay;
        data.type = res.type;
        data.event_url = res.event_url;
    };

    // Generate unique IDs for events
    const uid = () => {
        return (
            Date.now().toString() + Math.floor(Math.random() * 1000).toString()
        );
    };

    return {
        // Public Functions
        init: function () {
            // Define variables
            // Add event modal

            // filterButton = document.getElementById('kt_calendar_filter');

            const element = document.getElementById("kt_modal_add_event");
            form = element.querySelector("#kt_modal_add_event_form");
            eventName = form.querySelector('[name="calendar_event_name"]');
            eventDescription = form.querySelector(
                '[name="calendar_event_description"]'
            );
            eventLocation = form.querySelector(
                '[name="calendar_event_location"]'
            );
            startDatepicker = form.querySelector(
                "#kt_calendar_datepicker_start_date"
            );
            endDatepicker = form.querySelector(
                "#kt_calendar_datepicker_end_date"
            );
            startTimepicker = form.querySelector(
                "#kt_calendar_datepicker_start_time"
            );
            endTimepicker = form.querySelector(
                "#kt_calendar_datepicker_end_time"
            );
            addButton = document.querySelector('[data-kt-calendar="add"]');
            // submitButton = form.querySelector('#kt_modal_add_event_submit');
            cancelButton = form.querySelector("#kt_modal_add_event_cancel");
            closeButton = element.querySelector("#kt_modal_add_event_close");
            modalTitle = form.querySelector('[data-kt-calendar="title"]');
            modal = new bootstrap.Modal(element);

            // View event modal
            const viewElement = document.getElementById("kt_modal_view_event");
            // const editElement = document.getElementById('kt_modal_view_event_edit');

            viewModal = new bootstrap.Modal(viewElement);
            // editModal = new bootstrap.Modal(editElement);

            viewEventName = viewElement.querySelector(
                '[data-kt-calendar="event_name"]'
            );
            viewAllDay = viewElement.querySelector(
                '[data-kt-calendar="all_day"]'
            );
            viewEventDescription = viewElement.querySelector(
                '[data-kt-calendar="event_description"]'
            );
            viewEventLocation = viewElement.querySelector(
                '[data-kt-calendar="event_location"]'
            );
            viewStartDate = viewElement.querySelector(
                '[data-kt-calendar="event_start_date"]'
            );
            viewEndDate = viewElement.querySelector(
                '[data-kt-calendar="event_end_date"]'
            );
            // viewEditButton = viewElement.querySelector('#kt_modal_view_event_edit');
            viewDeleteButton = viewElement.querySelector(
                "#kt_modal_view_event_delete"
            );

            initCalendarApp();
            initValidator();
            initDatepickers();
            // handleEditButton();
            handleAddButton();
            handleDeleteEvent();
            handleCancelButton();
            handleCloseButton();
            resetFormValidator(element);
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppCalendar.init();
});
