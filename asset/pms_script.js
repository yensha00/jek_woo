$(document).ready(function() {
    // SWEET ALERT MESSAGE
    function showMessage(message, type) {
        Swal.fire({
            icon: type,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    }

    // Disable the "Generate Report" button if search asset ID in history is empty
    var generateReportBtn = $('#generate-report');
    var searchInput = $('#search-pms-quarter');
    function toggleGenerateReportBtn() {
        generateReportBtn.prop('disabled', searchInput.val().trim() === '');
    }
    toggleGenerateReportBtn();
    searchInput.on('keyup', toggleGenerateReportBtn);
    $('#search-pms-quarter-btn').on('click', toggleGenerateReportBtn);

    
    // Function to fetch equipment codes based on input value
    function fetchEquipmentCodes(inputValue) {
        $.ajax({
            url: './backend/fetch_active_equipment_codes.php',
            type: 'GET',
            dataType: 'json',
            data: {inputValue: inputValue},
            success: function (data) {
                var dropdownMenu = $('#equipment-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus
    $('#asset-id').on('focus', function () {
        var inputValue = $(this).val().trim();
        if (inputValue !== '') {
            fetchEquipmentCodes(inputValue);
        }
    });
    // Event listener for input change
    $('#asset-id, #search-pms-quarter').on('input', function () {
        var inputValue = $(this).val().trim();
        if (inputValue === '') {
            $('#equipment-code-dropdown').empty().hide();
        } else {
            fetchEquipmentCodes(inputValue);
        }
    });
    // Event listener for input change
    $('#asset-id, #search-pms-quarter').on('input', function () {
        var inputValue = $(this).val().trim();
        if (inputValue === '') {
            $('#equipment-code-dropdown').empty().hide();
        } else {
            fetchEquipmentCodes(inputValue);
        }
    });
    // Keyboard navigation
    $('#asset-id').on('keydown', function(e) {
        var dropdown = $('#equipment-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown
    $('#equipment-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#asset-id, #search-pms-quarter').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#asset-id, #search-pms-quarter').length) {
            $('#equipment-code-dropdown').hide();
        }
    });


    // Function to fetch equipment codes based on input value for MOUSE
    function fetchMouseAssetId(mouseAssetId) {
        $.ajax({
            url: './backend/fetch_mouse_asset_id.php',
            type: 'GET',
            dataType: 'json',
            data: {mouseAssetId: mouseAssetId},
            success: function (data) {
                var dropdownMenu = $('#mouse-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus for MOUSE
    $('#mouse-asset-id').on('focus', function () {
        var mouseAssetId = $(this).val().trim();
        if (mouseAssetId !== '') {
            fetchMouseAssetId(mouseAssetId);
        }
    });
    // Event listener for input change for MOUSE
    $('#mouse-asset-id').on('input', function () {
        var mouseAssetId = $(this).val().trim();
        if (mouseAssetId === '') {
            $('#mouse-code-dropdown').empty().hide();
        } else {
            fetchMouseAssetId(mouseAssetId);
        }
    });
    // Event listener for input change for MOUSE
    $('#mouse-asset-id').on('input', function () {
        var mouseAssetId = $(this).val().trim();
        if (mouseAssetId === '') {
            $('#mouse-code-dropdown').empty().hide();
        } else {
            fetchMouseAssetId(mouseAssetId);
        }
    });
    // Keyboard navigation for MOUSE
    $('#mouse-asset-id').on('keydown', function(e) {
        var dropdown = $('#mouse-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown for MOUSE
    $('#mouse-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#mouse-asset-id').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside for MOUSE
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#mouse-asset-id').length) {
            $('#mouse-code-dropdown').hide();
        }
    });


    // Function to fetch equipment codes based on input value for KEYBOARD
    function fetchKeyboardAssetId(keyboardAssetId) {
        $.ajax({
            url: './backend/fetch_keyboard_asset_id.php',
            type: 'GET',
            dataType: 'json',
            data: {keyboardAssetId: keyboardAssetId},
            success: function (data) {
                var dropdownMenu = $('#keyboard-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus for KEYBOARD
    $('#keyboard-asset-id').on('focus', function () {
        var keyboardAssetId = $(this).val().trim();
        if (keyboardAssetId !== '') {
            fetchKeyboardAssetId(keyboardAssetId);
        }
    });
    // Event listener for input change for KEYBOARD
    $('#keyboard-asset-id').on('input', function () {
        var keyboardAssetId = $(this).val().trim();
        if (keyboardAssetId === '') {
            $('#keyboard-code-dropdown').empty().hide();
        } else {
            fetchKeyboardAssetId(keyboardAssetId);
        }
    });
    // Event listener for input change for KEYBOARD
    $('#keyboard-asset-id').on('input', function () {
        var keyboardAssetId = $(this).val().trim();
        if (keyboardAssetId === '') {
            $('#keyboard-code-dropdown').empty().hide();
        } else {
            fetchKeyboardAssetId(keyboardAssetId);
        }
    });
    // Keyboard navigation for KEYBOARD
    $('#keyboard-asset-id').on('keydown', function(e) {
        var dropdown = $('#keyboard-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown for KEYBOARD
    $('#keyboard-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#keyboard-asset-id').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside for KEYBOARD
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#keyboard-asset-id').length) {
            $('#keyboard-code-dropdown').hide();
        }
    });


    // Function to fetch equipment codes based on input value for MONITOR
    function fetchMonitorAssetId(monitorAssetId) {
        $.ajax({
            url: './backend/fetch_monitor_asset_id.php',
            type: 'GET',
            dataType: 'json',
            data: {monitorAssetId: monitorAssetId},
            success: function (data) {
                var dropdownMenu = $('#monitor-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus for MONITOR
    $('#monitor-asset-id').on('focus', function () {
        var monitorAssetId = $(this).val().trim();
        if (monitorAssetId !== '') {
            fetchMonitorAssetId(monitorAssetId);
        }
    });
    // Event listener for input change for MONITOR
    $('#monitor-asset-id').on('input', function () {
        var monitorAssetId = $(this).val().trim();
        if (monitorAssetId === '') {
            $('#monitor-code-dropdown').empty().hide();
        } else {
            fetchMonitorAssetId(monitorAssetId);
        }
    });
    // Event listener for input change for MONITOR
    $('#monitor-asset-id').on('input', function () {
        var monitorAssetId = $(this).val().trim();
        if (monitorAssetId === '') {
            $('#monitor-code-dropdown').empty().hide();
        } else {
            fetchMonitorAssetId(monitorAssetId);
        }
    });
    // Keyboard navigation for MONITOR
    $('#monitor-asset-id').on('keydown', function(e) {
        var dropdown = $('#monitor-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown for MONITOR
    $('#monitor-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#monitor-asset-id').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside for MONITOR
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#monitor-asset-id').length) {
            $('#monitor-code-dropdown').hide();
        }
    });


    // Function to fetch equipment codes based on input value for UPS/AVR
    function fetchUPSAVRAssetId(upsavrAssetId) {
        $.ajax({
            url: './backend/fetch_upsavr_asset_id.php',
            type: 'GET',
            dataType: 'json',
            data: {upsavrAssetId: upsavrAssetId},
            success: function (data) {
                var dropdownMenu = $('#upsavr-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus for UPS/AVR
    $('#upsavr-asset-id').on('focus', function () {
        var upsavrAssetId = $(this).val().trim();
        if (upsavrAssetId !== '') {
            fetchUPSAVRAssetId(upsavrAssetId);
        }
    });
    // Event listener for input change for UPS/AVR
    $('#upsavr-asset-id').on('input', function () {
        var upsavrAssetId = $(this).val().trim();
        if (upsavrAssetId === '') {
            $('#upsavr-code-dropdown').empty().hide();
        } else {
            fetchUPSAVRAssetId(upsavrAssetId);
        }
    });
    // Event listener for input change for UPS/AVR
    $('#upsavr-asset-id').on('input', function () {
        var upsavrAssetId = $(this).val().trim();
        if (upsavrAssetId === '') {
            $('#upsavr-code-dropdown').empty().hide();
        } else {
            fetchUPSAVRAssetId(upsavrAssetId);
        }
    });
    // Keyboard navigation for UPS/AVR
    $('#upsavr-asset-id').on('keydown', function(e) {
        var dropdown = $('#upsavr-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown for UPS/AVR
    $('#upsavr-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#upsavr-asset-id').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside for UPS/AVR
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#upsavr-asset-id').length) {
            $('#upsavr-code-dropdown').hide();
        }
    });


    // Function to fetch equipment codes based on input value for PRINTER
    function fetchPrinterAssetId(printerAssetId) {
        $.ajax({
            url: './backend/fetch_printer_asset_id.php',
            type: 'GET',
            dataType: 'json',
            data: {printerAssetId: printerAssetId},
            success: function (data) {
                var dropdownMenu = $('#printer-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus for PRINTER
    $('#printer-asset-id').on('focus', function () {
        var printerAssetId = $(this).val().trim();
        if (printerAssetId !== '') {
            fetchPrinterAssetId(printerAssetId);
        }
    });
    // Event listener for input change for PRINTER
    $('#printer-asset-id').on('input', function () {
        var printerAssetId = $(this).val().trim();
        if (printerAssetId === '') {
            $('#printer-code-dropdown').empty().hide();
        } else {
            fetchPrinterAssetId(printerAssetId);
        }
    });
    // Event listener for input change for PRINTER
    $('#printer-asset-id').on('input', function () {
        var printerAssetId = $(this).val().trim();
        if (printerAssetId === '') {
            $('#printer-code-dropdown').empty().hide();
        } else {
            fetchPrinterAssetId(printerAssetId);
        }
    });
    // Keyboard navigation for PRINTER
    $('#printer-asset-id').on('keydown', function(e) {
        var dropdown = $('#printer-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown for PRINTER
    $('#printer-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#printer-asset-id').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside for PRINTER
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#printer-asset-id').length) {
            $('#printer-code-dropdown').hide();
        }
    });


    // Function to fetch equipment codes based on input value for TELEPHONE
    function fetchTelephoneAssetId(telephoneAssetId) {
        $.ajax({
            url: './backend/fetch_telephone_asset_id.php',
            type: 'GET',
            dataType: 'json',
            data: {telephoneAssetId: telephoneAssetId},
            success: function (data) {
                var dropdownMenu = $('#telephone-code-dropdown');
                dropdownMenu.empty();
                if (data.length > 0) {
                    $.each(data, function (index, item) {
                        dropdownMenu.append('<button class="dropdown-item" type="button">' + item.equipment_code + '</button>');
                    });
                    dropdownMenu.show();
                } else {
                    dropdownMenu.append('<button class="dropdown-item" type="button" disabled>No matching equipment codes</button>');
                }
            },
            error: function () {
                console.error('Failed to fetch data from the server');
            }
        });
    }
    // Event listener for input focus for TELEPHONE
    $('#telephone-asset-id').on('focus', function () {
        var telephoneAssetId = $(this).val().trim();
        if (telephoneAssetId !== '') {
            fetchTelephoneAssetId(telephoneAssetId);
        }
    });
    // Event listener for input change for TELEPHONE
    $('#telephone-asset-id').on('input', function () {
        var telephoneAssetId = $(this).val().trim();
        if (telephoneAssetId === '') {
            $('#telephone-code-dropdown').empty().hide();
        } else {
            fetchTelephoneAssetId(telephoneAssetId);
        }
    });
    // Event listener for input change for TELEPHONE
    $('#telephone-asset-id').on('input', function () {
        var telephoneAssetId = $(this).val().trim();
        if (telephoneAssetId === '') {
            $('#telephone-code-dropdown').empty().hide();
        } else {
            fetchTelephoneAssetId(telephoneAssetId);
        }
    });
    // Keyboard navigation for TELEPHONE
    $('#telephone-asset-id').on('keydown', function(e) {
        var dropdown = $('#telephone-code-dropdown');
        var dropdownItems = dropdown.find('.dropdown-item');
        if (dropdownItems.length === 0) return;
        var currentFocusedIndex = dropdownItems.index(dropdown.find('.dropdown-item:focus'));
        if (e.keyCode === 40) { // Down arrow key
            e.preventDefault();
            if (currentFocusedIndex < dropdownItems.length - 1) {
                dropdownItems.eq(currentFocusedIndex + 1).focus();
            } else {
                dropdownItems.first().focus();
            }
        } else if (e.keyCode === 38) { // Up arrow key
            e.preventDefault();
            if (currentFocusedIndex > 0) {
                dropdownItems.eq(currentFocusedIndex - 1).focus();
            } else {
                dropdownItems.last().focus();
            }
        }
    });
    // Handle equipment code selection from the dropdown for TELEPHONE
    $('#telephone-code-dropdown').on('click', '.dropdown-item', function () {
        var selectedEquipmentCode = $(this).text();
        $('#telephone-asset-id').val(selectedEquipmentCode);
    });
    // Hide dropdown when clicking outside for TELEPHONE
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#telephone-asset-id').length) {
            $('#telephone-code-dropdown').hide();
        }
    });


    // Generate Report Button
    $('#generate-report').click(function() {
        // Retrieve the asset ID from the search input
        let assetId = $('#search-pms-quarter').val();
        // Create a form dynamically
        let form = $('<form>', {
            'method': 'post',
            'action': './pdf.php',
            'target': '_blank'
        }).append($('<input>', {
            'type': 'hidden',
            'name': 'assetId',
            'value': assetId
        }));
        // Append the form to the body and submit it
        $('body').append(form);
        form.submit();
    });

    // Function to fetch asset ID data
    function fetchAssetId(assetId) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: './backend/fetch_equipment.php',
                method: 'POST',
                data: { equipmentCode: assetId },
                dataType: 'json',
                success: function(response) {                    
                    if (response.status === 'success') {
                        $('#employee-name-pms').val(response.username);
                        $('#processor-pms').val(response.processor);
                        $('#ram-pms').val(response.ram);
                        $('#location-pms').val(response.location);
                        resolve(true);
                    } else {
                        $('#employee-name-pms').val('');
                        $('#processor-pms').val('');
                        $('#ram-pms').val('');
                        $('#location-pms').val('');
                        resolve(false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr, status, error);
                    reject(error);
                }
            });
        });
    }

    // Function to validate PMS form inputs
    function validateForm() {
        const radioGroups = [
            'sys1', 'sys2', 'net-set1', 'net-set2', 'net-set3', 'net-set4', 'net-set5',
            'hw-set1', 'hw-set2', 'hw-set3', 'hw-set4', 'sw1', 'sw2', 'sw3', 'sw4', 'sw5',
            'sw6', 'sw7', 'sec1', 'sec2', 'sec3', 'gen-main1', 'gen-main2', 'gen-main3',
            'gen-main4', 'gen-main5', 'gen-main6', 'gen-main7', 'gen-main8', 'per-dev1',
            'per-dev2', 'per-dev3', 'per-dev4', 'per-dev5', 'per-dev6'
        ];

        // VALIDATE QUARTER
        const quarterDropdown = $('#quarter-dropdown');
        const quarter = quarterDropdown.val();

        if (!quarter) {
            showMessage('SELECT A QUARTER.', 'error');
            setTimeout(function() {
                quarterDropdown.focus();
            }, 0);
            return false;
        }

        // VALIDATE TASK ID
        const taskIdInput = $('#task-id');
        const taskId = taskIdInput.val();

        if (!taskId) {
            showMessage('TASK ID IS REQUIRED.', 'error');
            setTimeout(function() {
                taskIdInput.focus();
            }, 0);
            return false;
        }

        // VALIDATE ASSET ID
        const assetIdInput = $('#asset-id');
        const assetId = assetIdInput.val();

        if (!assetId) {
            showMessage('ASSET ID IS REQUIRED.', 'error');
            setTimeout(function() {
                assetIdInput.focus();
            }, 0);
            return false;
        }

        // VALIDATE COMPUTER NAME
        const computerNameInput = $('#computer-name');
        const computerName = computerNameInput.val();

        if (!computerName) {
            showMessage('COMPUTER NAME IS REQUIRED.', 'error');
            setTimeout(function() {
                computerNameInput.focus();
            }, 0);
            return false;
        }

        // FETCH ASSET ID DATA
        return fetchAssetId(assetId).then(function(found) {
            if (!found) {
                showMessage('ASSET ID IS NOT FOUND.', 'error');
                setTimeout(function() {
                    $('#asset-id').focus();
                }, 0);
                return false;
            } else {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: './backend/validate_asset_id.php',
                        method: 'POST',
                        data: { assetId: assetId, quarter: quarter },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                for (let group of radioGroups) {
                                    const checked = $(`input[name="${group}"]:checked`).length > 0;
                                    if (!checked) {
                                        showMessage('RADIO INPUTS ARE REQUIRED.', 'error');
                                        let foundUnchecked = false;
                                        $('input[type="radio"]').each(function() {
                                            if (!$(this).prop('checked') && !foundUnchecked) {
                                                setTimeout(function() {
                                                    $(this).focus();
                                                }, 0);
                                                foundUnchecked = true;
                                            }
                                        });
                                        resolve(false);
                                        return;
                                    }
                                }
                                resolve(true);
                            } else {
                                showMessage(response.message, 'error');
                                setTimeout(function() {
                                    $('#asset-id').focus();
                                }, 0);
                                resolve(false);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr, status, error);
                            resolve(false);
                        }
                    });
                });
            }
        }).catch(function(error) {
            console.error(error);
            return false;
        });
    }
    
    // INSERT PMS QUARTER TO THE DATABASE
    function insertData() {
        $.ajax({
            url: './backend/create_pms.php',
            method: 'POST',
            data: $('#create-pms-form').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showMessage(response.message, 'success');
                    $('#create-pms-form')[0].reset();
                } else {
                    showMessage(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr, status, error);
            }
        });
    }
    
    // PMS FORM SUBMIT EVENT
    $('#create-pms-form').submit(function(event) {
        event.preventDefault();

        // CHECK IF FORM IS VALID BEFORE INSERTING DATA
        validateForm().then(function(isValid) {
            if (isValid) {
                $('#employee-name').val('');
                $('#processor').val('');
                $('#ram').val('');
                $('#location').val('');
                insertData();
                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }
        });
    });

    // FETCH ASSET ID DATA
    $('#asset-id-search-btn').click(function() {
        const assetId = $('#asset-id').val().trim();
        if (!assetId) {
            showMessage('ASSET ID IS REQUIRED.', 'error');
            setTimeout(function() {
                $('#asset-id').focus();
            }, 0);
            resolve(false);
            return;
        }

        // FETCH ASSET ID
        fetchAssetId(assetId).then(function(found) {
            if (!found) {
                const allowedPrefixes = ['ICT-DC-', 'ICT-LC-'];
                const isValidPrefix = allowedPrefixes.some(prefix => assetId.startsWith(prefix));
                if (!isValidPrefix) {
                    showMessage('NOT APPLICABLE ASSET ID.', 'error');
                    $('#employee-name').val('');
                    $('#processor').val('');
                    $('#ram').val('');
                    $('#location').val('');
                    return;
                }
                showMessage('ASSET ID IS NOT FOUND.', 'error');
                return;
            }
        }).catch(function(error) {
            console.error(error);
        });
    });

    // DROPDOWN EVENT QUARTER BUTTON
    $('#quarter-dropdown').change(function() {
        var selectedQuarter = $(this).val();
        $('#selectedQuarter').text(selectedQuarter);
    });

    // SHOW PMS FORM EVENT
    $('#perform-pms-btn').click(function(event) {
        event.preventDefault();
        $('#pms-form-cont').toggle();
    });

    // SELECT ALL OK RADIO INPUTS
    $('#ok').click(function() {
        $('table input[type="radio"][value="ok"]').prop('checked', true);
    });

    // SELECT ALL NOT OK RADIO INPUTS
    $('#not-ok').click(function() {
        $('table input[type="radio"][value="not_ok"]').prop('checked', true);
    });

    // SELECT ALL NONE RADIO INPUTS
    $('#none').click(function() {
        $('table input[type="radio"][value="none"]').prop('checked', true);
    });

    // DISPLAY ICONS FOR DATA
    function getIcon(data) {
        if (data === 'ok') {
            return '<i class="bi bi-check text-success" style="font-size: 1.4rem;"></i>';
        } else if (data === 'not_ok') {
            return '<i class="bi bi-x text-danger" style="font-size: 1.4rem;"></i>';
        } else {
            return '<span class="na-text">N/A</span>';
        }
    }

    // DISPLAY FIRST REMARKS
    function getFirstRemarks(remark) {
        if (remark != '') {
            return '1st: ' + remark + '<br>';
        } else {
            return '';
        }
    }

    // DISPLAY SECOND REMARKS
    function getSecondRemarks(remark) {
        if (remark != '') {
            return '2nd: ' + remark + '<br>';
        } else {
            return '';
        }
    }

    // DISPLAY 3RD REMARKS
    function getThirdRemarks(remark) {
        if (remark != '') {
            return '3rd: ' + remark + '<br>';
        } else {
            return '';
        }
    }

    // DISPLAY FOURTH REMARKS
    function getFourthRemarks(remark) {
        if (remark != '') {
            return '4th: ' + remark + '<br>';
        } else {
            return '';
        }
    }

    // FETCH PMS DATA TO PMS HISTORY FORM
    $('#search-pms-quarter-btn').click(function(event) {
        event.preventDefault();
        let searchedAssetId = $('#search-pms-quarter').val();
        $.ajax({
            url: 'backend/fetch_pms_data.php',
            type: 'POST',
            data: { assetId: searchedAssetId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let data = response.data;

                    // Empty remarks
                    $('#sys1-remarks').empty();
                    $('#sys2-remarks').empty();

                    $('#net_set1-remarks').empty();
                    $('#net_set2-remarks').empty();
                    $('#net_set3-remarks').empty();
                    $('#net_set4-remarks').empty();
                    $('#net_set5-remarks').empty();

                    $('#hw_set1-remarks').empty();
                    $('#hw_set2-remarks').empty();
                    $('#hw_set3-remarks').empty();
                    $('#hw_set4-remarks').empty();

                    $('#sw1-remarks').empty();
                    $('#sw2-remarks').empty();
                    $('#sw3-remarks').empty();
                    $('#sw4-remarks').empty();
                    $('#sw5-remarks').empty();
                    $('#sw6-remarks').empty();
                    $('#sw7-remarks').empty();

                    $('#sec1-remarks').empty();
                    $('#sec2-remarks').empty();
                    $('#sec3-remarks').empty();

                    $('#gen_main1-remarks').empty();
                    $('#gen_main2-remarks').empty();
                    $('#gen_main3-remarks').empty();
                    $('#gen_main4-remarks').empty();
                    $('#gen_main5-remarks').empty();
                    $('#gen_main6-remarks').empty();
                    $('#gen_main7-remarks').empty();
                    $('#gen_main8-remarks').empty();

                    $('#per_dev1-remarks').empty();
                    $('#per_dev2-remarks').empty();
                    $('#per_dev3-remarks').empty();
                    $('#per_dev4-remarks').empty();
                    $('#per_dev5-remarks').empty();
                    $('#per_dev6-remarks').empty();

                    data.forEach(row => {
                        let year = new Date(row.created_at).getFullYear();
                        $('#pms-year-display').text(year);

                        let date = new Date(row.created_at);
                        let monthAbbrev = date.toLocaleString('default', { month: 'short' });
                        let day = date.getDate();
                        let formattedDate = monthAbbrev + '. ' + day;

                        if (searchedAssetId && row.quarter == '1') {
                            // display month and day for quarter 1
                            $('#pms-quarter1-date-display').text(formattedDate);

                            $('#pms-quarter1-user').text(row.user_name);

                            $('#sys1-1st').html(getIcon(row.sys1));
                            $('#sys2-1st').html(getIcon(row.sys2));

                            $('#sys1-remarks').append(getFirstRemarks(row.sys1_remarks));
                            $('#sys2-remarks').append(getFirstRemarks(row.sys2_remarks));

                            $('#net_set1-1st').html(getIcon(row.net_set1));
                            $('#net_set2-1st').html(getIcon(row.net_set2));
                            $('#net_set3-1st').html(getIcon(row.net_set3));
                            $('#net_set4-1st').html(getIcon(row.net_set4));
                            $('#net_set5-1st').html(getIcon(row.net_set5));

                            $('#net_set1-remarks').append(getFirstRemarks(row.net_set1_remarks));
                            $('#net_set2-remarks').append(getFirstRemarks(row.net_set2_remarks));
                            $('#net_set3-remarks').append(getFirstRemarks(row.net_set3_remarks));
                            $('#net_set4-remarks').append(getFirstRemarks(row.net_set4_remarks));
                            $('#net_set5-remarks').append(getFirstRemarks(row.net_set5_remarks));

                            $('#hw_set1-1st').html(getIcon(row.hw_set1));
                            $('#hw_set2-1st').html(getIcon(row.hw_set2));
                            $('#hw_set3-1st').html(getIcon(row.hw_set3));
                            $('#hw_set4-1st').html(getIcon(row.hw_set4));

                            $('#hw_set1-remarks').append(getFirstRemarks(row.hw_set1_remarks));
                            $('#hw_set2-remarks').append(getFirstRemarks(row.hw_set2_remarks));
                            $('#hw_set3-remarks').append(getFirstRemarks(row.hw_set3_remarks));
                            $('#hw_set4-remarks').append(getFirstRemarks(row.hw_set4_remarks));

                            $('#sw1-1st').html(getIcon(row.sw1));
                            $('#sw2-1st').html(getIcon(row.sw2));
                            $('#sw3-1st').html(getIcon(row.sw3));
                            $('#sw4-1st').html(getIcon(row.sw4));
                            $('#sw5-1st').html(getIcon(row.sw5));
                            $('#sw6-1st').html(getIcon(row.sw6));
                            $('#sw7-1st').html(getIcon(row.sw7));

                            $('#sw1-remarks').append(getFirstRemarks(row.sw1_remarks));
                            $('#sw2-remarks').append(getFirstRemarks(row.sw2_remarks));
                            $('#sw3-remarks').append(getFirstRemarks(row.sw3_remarks));
                            $('#sw4-remarks').append(getFirstRemarks(row.sw4_remarks));
                            $('#sw5-remarks').append(getFirstRemarks(row.sw5_remarks));
                            $('#sw6-remarks').append(getFirstRemarks(row.sw6_remarks));
                            $('#sw7-remarks').append(getFirstRemarks(row.sw7_remarks));

                            $('#sec1-1st').html(getIcon(row.sec1));
                            $('#sec2-1st').html(getIcon(row.sec2));
                            $('#sec3-1st').html(getIcon(row.sec3));

                            $('#sec1-remarks').append(getFirstRemarks(row.sec1_remarks));
                            $('#sec2-remarks').append(getFirstRemarks(row.sec2_remarks));
                            $('#sec3-remarks').append(getFirstRemarks(row.sec3_remarks));

                            $('#gen_main1-1st').html(getIcon(row.gen_main1));
                            $('#gen_main2-1st').html(getIcon(row.gen_main2));
                            $('#gen_main3-1st').html(getIcon(row.gen_main3));
                            $('#gen_main4-1st').html(getIcon(row.gen_main4));
                            $('#gen_main5-1st').html(getIcon(row.gen_main5));
                            $('#gen_main6-1st').html(getIcon(row.gen_main6));
                            $('#gen_main7-1st').html(getIcon(row.gen_main7));
                            $('#gen_main8-1st').html(getIcon(row.gen_main8));

                            $('#gen_main1-remarks').append(getFirstRemarks(row.gen_main1_remarks));
                            $('#gen_main2-remarks').append(getFirstRemarks(row.gen_main2_remarks));
                            $('#gen_main3-remarks').append(getFirstRemarks(row.gen_main3_remarks));
                            $('#gen_main4-remarks').append(getFirstRemarks(row.gen_main4_remarks));
                            $('#gen_main5-remarks').append(getFirstRemarks(row.gen_main5_remarks));
                            $('#gen_main6-remarks').append(getFirstRemarks(row.gen_main6_remarks));
                            $('#gen_main7-remarks').append(getFirstRemarks(row.gen_main7_remarks));
                            $('#gen_main8-remarks').append(getFirstRemarks(row.gen_main8_remarks));

                            $('#per_dev1-1st').html(getIcon(row.per_dev1));
                            $('#per_dev2-1st').html(getIcon(row.per_dev2));
                            $('#per_dev3-1st').html(getIcon(row.per_dev3));
                            $('#per_dev4-1st').html(getIcon(row.per_dev4));
                            $('#per_dev5-1st').html(getIcon(row.per_dev5));
                            $('#per_dev6-1st').html(getIcon(row.per_dev6));

                            $('#per_dev1-remarks').append(getFirstRemarks(row.per_dev1_remarks));
                            $('#per_dev2-remarks').append(getFirstRemarks(row.per_dev2_remarks));
                            $('#per_dev3-remarks').append(getFirstRemarks(row.per_dev3_remarks));
                            $('#per_dev4-remarks').append(getFirstRemarks(row.per_dev4_remarks));
                            $('#per_dev5-remarks').append(getFirstRemarks(row.per_dev5_remarks));
                            $('#per_dev6-remarks').append(getFirstRemarks(row.per_dev6_remarks));
                        } else if (searchedAssetId && row.quarter == '2') {
                            // display month and day for quarter 2
                            $('#pms-quarter2-date-display').text(formattedDate);

                            $('#pms-quarter2-user').text(row.user_name);

                            $('#sys1-2nd').html(getIcon(row.sys1));
                            $('#sys2-2nd').html(getIcon(row.sys2));

                            $('#sys1-remarks').append(getSecondRemarks(row.sys1_remarks));
                            $('#sys2-remarks').append(getSecondRemarks(row.sys2_remarks));

                            $('#net_set1-2nd').html(getIcon(row.net_set1));
                            $('#net_set2-2nd').html(getIcon(row.net_set2));
                            $('#net_set3-2nd').html(getIcon(row.net_set3));
                            $('#net_set4-2nd').html(getIcon(row.net_set4));
                            $('#net_set5-2nd').html(getIcon(row.net_set5));

                            $('#net_set1-remarks').append(getSecondRemarks(row.net_set1_remarks));
                            $('#net_set2-remarks').append(getSecondRemarks(row.net_set2_remarks));
                            $('#net_set3-remarks').append(getSecondRemarks(row.net_set3_remarks));
                            $('#net_set4-remarks').append(getSecondRemarks(row.net_set4_remarks));
                            $('#net_set5-remarks').append(getSecondRemarks(row.net_set5_remarks));

                            $('#hw_set1-2nd').html(getIcon(row.hw_set1));
                            $('#hw_set2-2nd').html(getIcon(row.hw_set2));
                            $('#hw_set3-2nd').html(getIcon(row.hw_set3));
                            $('#hw_set4-2nd').html(getIcon(row.hw_set4));

                            $('#hw_set1-remarks').append(getSecondRemarks(row.hw_set1_remarks));
                            $('#hw_set2-remarks').append(getSecondRemarks(row.hw_set2_remarks));
                            $('#hw_set3-remarks').append(getSecondRemarks(row.hw_set3_remarks));
                            $('#hw_set4-remarks').append(getSecondRemarks(row.hw_set4_remarks));

                            $('#sw1-2nd').html(getIcon(row.sw1));
                            $('#sw2-2nd').html(getIcon(row.sw2));
                            $('#sw3-2nd').html(getIcon(row.sw3));
                            $('#sw4-2nd').html(getIcon(row.sw4));
                            $('#sw5-2nd').html(getIcon(row.sw5));
                            $('#sw6-2nd').html(getIcon(row.sw6));
                            $('#sw7-2nd').html(getIcon(row.sw7));

                            $('#sw1-remarks').append(getSecondRemarks(row.sw1_remarks));
                            $('#sw2-remarks').append(getSecondRemarks(row.sw2_remarks));
                            $('#sw3-remarks').append(getSecondRemarks(row.sw3_remarks));
                            $('#sw4-remarks').append(getSecondRemarks(row.sw4_remarks));
                            $('#sw5-remarks').append(getSecondRemarks(row.sw5_remarks));
                            $('#sw6-remarks').append(getSecondRemarks(row.sw6_remarks));
                            $('#sw7-remarks').append(getSecondRemarks(row.sw7_remarks));

                            $('#sec1-2nd').html(getIcon(row.sec1));
                            $('#sec2-2nd').html(getIcon(row.sec2));
                            $('#sec3-2nd').html(getIcon(row.sec3));

                            $('#sec1-remarks').append(getSecondRemarks(row.sec1_remarks));
                            $('#sec2-remarks').append(getSecondRemarks(row.sec2_remarks));
                            $('#sec3-remarks').append(getSecondRemarks(row.sec3_remarks));

                            $('#gen_main1-2nd').html(getIcon(row.gen_main1));
                            $('#gen_main2-2nd').html(getIcon(row.gen_main2));
                            $('#gen_main3-2nd').html(getIcon(row.gen_main3));
                            $('#gen_main4-2nd').html(getIcon(row.gen_main4));
                            $('#gen_main5-2nd').html(getIcon(row.gen_main5));
                            $('#gen_main6-2nd').html(getIcon(row.gen_main6));
                            $('#gen_main7-2nd').html(getIcon(row.gen_main7));
                            $('#gen_main8-2nd').html(getIcon(row.gen_main8));

                            $('#gen_main1-remarks').append(getSecondRemarks(row.gen_main1_remarks));
                            $('#gen_main2-remarks').append(getSecondRemarks(row.gen_main2_remarks));
                            $('#gen_main3-remarks').append(getSecondRemarks(row.gen_main3_remarks));
                            $('#gen_main4-remarks').append(getSecondRemarks(row.gen_main4_remarks));
                            $('#gen_main5-remarks').append(getSecondRemarks(row.gen_main5_remarks));
                            $('#gen_main6-remarks').append(getSecondRemarks(row.gen_main6_remarks));
                            $('#gen_main7-remarks').append(getSecondRemarks(row.gen_main7_remarks));
                            $('#gen_main8-remarks').append(getSecondRemarks(row.gen_main8_remarks));

                            $('#per_dev1-2nd').html(getIcon(row.per_dev1));
                            $('#per_dev2-2nd').html(getIcon(row.per_dev2));
                            $('#per_dev3-2nd').html(getIcon(row.per_dev3));
                            $('#per_dev4-2nd').html(getIcon(row.per_dev4));
                            $('#per_dev5-2nd').html(getIcon(row.per_dev5));
                            $('#per_dev6-2nd').html(getIcon(row.per_dev6));

                            $('#per_dev1-remarks').append(getSecondRemarks(row.per_dev1_remarks));
                            $('#per_dev2-remarks').append(getSecondRemarks(row.per_dev2_remarks));
                            $('#per_dev3-remarks').append(getSecondRemarks(row.per_dev3_remarks));
                            $('#per_dev4-remarks').append(getSecondRemarks(row.per_dev4_remarks));
                            $('#per_dev5-remarks').append(getSecondRemarks(row.per_dev5_remarks));
                            $('#per_dev6-remarks').append(getSecondRemarks(row.per_dev6_remarks));
                        } else if (searchedAssetId && row.quarter == '3') {
                            // display month and day for quarter 3
                            $('#pms-quarter3-date-display').text(formattedDate);

                            $('#pms-quarter3-user').text(row.user_name);

                            $('#sys1-3rd').html(getIcon(row.sys1));
                            $('#sys2-3rd').html(getIcon(row.sys2));

                            $('#sys1-remarks').append(getThirdRemarks(row.sys1_remarks));
                            $('#sys2-remarks').append(getThirdRemarks(row.sys2_remarks));

                            $('#net_set1-3rd').html(getIcon(row.net_set1));
                            $('#net_set2-3rd').html(getIcon(row.net_set2));
                            $('#net_set3-3rd').html(getIcon(row.net_set3));
                            $('#net_set4-3rd').html(getIcon(row.net_set4));
                            $('#net_set5-3rd').html(getIcon(row.net_set5));

                            $('#net_set1-remarks').append(getThirdRemarks(row.net_set1_remarks));
                            $('#net_set2-remarks').append(getThirdRemarks(row.net_set2_remarks));
                            $('#net_set3-remarks').append(getThirdRemarks(row.net_set3_remarks));
                            $('#net_set4-remarks').append(getThirdRemarks(row.net_set4_remarks));
                            $('#net_set5-remarks').append(getThirdRemarks(row.net_set5_remarks));

                            $('#hw_set1-3rd').html(getIcon(row.hw_set1));
                            $('#hw_set2-3rd').html(getIcon(row.hw_set2));
                            $('#hw_set3-3rd').html(getIcon(row.hw_set3));
                            $('#hw_set4-3rd').html(getIcon(row.hw_set4));

                            $('#hw_set1-remarks').append(getThirdRemarks(row.hw_set1_remarks));
                            $('#hw_set2-remarks').append(getThirdRemarks(row.hw_set2_remarks));
                            $('#hw_set3-remarks').append(getThirdRemarks(row.hw_set3_remarks));
                            $('#hw_set4-remarks').append(getThirdRemarks(row.hw_set4_remarks));

                            $('#sw1-3rd').html(getIcon(row.sw1));
                            $('#sw2-3rd').html(getIcon(row.sw2));
                            $('#sw3-3rd').html(getIcon(row.sw3));
                            $('#sw4-3rd').html(getIcon(row.sw4));
                            $('#sw5-3rd').html(getIcon(row.sw5));
                            $('#sw6-3rd').html(getIcon(row.sw6));
                            $('#sw7-3rd').html(getIcon(row.sw7));

                            $('#sw1-remarks').append(getThirdRemarks(row.sw1_remarks));
                            $('#sw2-remarks').append(getThirdRemarks(row.sw2_remarks));
                            $('#sw3-remarks').append(getThirdRemarks(row.sw3_remarks));
                            $('#sw4-remarks').append(getThirdRemarks(row.sw4_remarks));
                            $('#sw5-remarks').append(getThirdRemarks(row.sw5_remarks));
                            $('#sw6-remarks').append(getThirdRemarks(row.sw6_remarks));
                            $('#sw7-remarks').append(getThirdRemarks(row.sw7_remarks));

                            $('#sec1-3rd').html(getIcon(row.sec1));
                            $('#sec2-3rd').html(getIcon(row.sec2));
                            $('#sec3-3rd').html(getIcon(row.sec3));

                            $('#sec1-remarks').append(getThirdRemarks(row.sec1_remarks));
                            $('#sec2-remarks').append(getThirdRemarks(row.sec2_remarks));
                            $('#sec3-remarks').append(getThirdRemarks(row.sec3_remarks));

                            $('#gen_main1-3rd').html(getIcon(row.gen_main1));
                            $('#gen_main2-3rd').html(getIcon(row.gen_main2));
                            $('#gen_main3-3rd').html(getIcon(row.gen_main3));
                            $('#gen_main4-3rd').html(getIcon(row.gen_main4));
                            $('#gen_main5-3rd').html(getIcon(row.gen_main5));
                            $('#gen_main6-3rd').html(getIcon(row.gen_main6));
                            $('#gen_main7-3rd').html(getIcon(row.gen_main7));
                            $('#gen_main8-3rd').html(getIcon(row.gen_main8));

                            $('#gen_main1-remarks').append(getThirdRemarks(row.gen_main1_remarks));
                            $('#gen_main2-remarks').append(getThirdRemarks(row.gen_main2_remarks));
                            $('#gen_main3-remarks').append(getThirdRemarks(row.gen_main3_remarks));
                            $('#gen_main4-remarks').append(getThirdRemarks(row.gen_main4_remarks));
                            $('#gen_main5-remarks').append(getThirdRemarks(row.gen_main5_remarks));
                            $('#gen_main6-remarks').append(getThirdRemarks(row.gen_main6_remarks));
                            $('#gen_main7-remarks').append(getThirdRemarks(row.gen_main7_remarks));
                            $('#gen_main8-remarks').append(getThirdRemarks(row.gen_main8_remarks));

                            $('#per_dev1-3rd').html(getIcon(row.per_dev1));
                            $('#per_dev2-3rd').html(getIcon(row.per_dev2));
                            $('#per_dev3-3rd').html(getIcon(row.per_dev3));
                            $('#per_dev4-3rd').html(getIcon(row.per_dev4));
                            $('#per_dev5-3rd').html(getIcon(row.per_dev5));
                            $('#per_dev6-3rd').html(getIcon(row.per_dev6));

                            $('#per_dev1-remarks').append(getThirdRemarks(row.per_dev1_remarks));
                            $('#per_dev2-remarks').append(getThirdRemarks(row.per_dev2_remarks));
                            $('#per_dev3-remarks').append(getThirdRemarks(row.per_dev3_remarks));
                            $('#per_dev4-remarks').append(getThirdRemarks(row.per_dev4_remarks));
                            $('#per_dev5-remarks').append(getThirdRemarks(row.per_dev5_remarks));
                            $('#per_dev6-remarks').append(getThirdRemarks(row.per_dev6_remarks));
                        } else if (searchedAssetId && row.quarter == '4') {
                            // display month and day for quarter 4
                            $('#pms-quarter4-date-display').text(formattedDate);

                            $('#pms-quarter4-user').text(row.user_name);

                            $('#sys1-4th').html(getIcon(row.sys1));
                            $('#sys2-4th').html(getIcon(row.sys2));

                            $('#sys1-remarks').append(getFourthRemarks(row.sys1_remarks));
                            $('#sys2-remarks').append(getFourthRemarks(row.sys2_remarks));

                            $('#net_set1-4th').html(getIcon(row.net_set1));
                            $('#net_set2-4th').html(getIcon(row.net_set2));
                            $('#net_set3-4th').html(getIcon(row.net_set3));
                            $('#net_set4-4th').html(getIcon(row.net_set4));
                            $('#net_set5-4th').html(getIcon(row.net_set5));

                            $('#net_set1-remarks').append(getFourthRemarks(row.net_set1_remarks));
                            $('#net_set2-remarks').append(getFourthRemarks(row.net_set2_remarks));
                            $('#net_set3-remarks').append(getFourthRemarks(row.net_set3_remarks));
                            $('#net_set4-remarks').append(getFourthRemarks(row.net_set4_remarks));
                            $('#net_set5-remarks').append(getFourthRemarks(row.net_set5_remarks));

                            $('#hw_set1-4th').html(getIcon(row.hw_set1));
                            $('#hw_set2-4th').html(getIcon(row.hw_set2));
                            $('#hw_set3-4th').html(getIcon(row.hw_set3));
                            $('#hw_set4-4th').html(getIcon(row.hw_set4));

                            $('#hw_set1-remarks').append(getFourthRemarks(row.hw_set1_remarks));
                            $('#hw_set2-remarks').append(getFourthRemarks(row.hw_set2_remarks));
                            $('#hw_set3-remarks').append(getFourthRemarks(row.hw_set3_remarks));
                            $('#hw_set4-remarks').append(getFourthRemarks(row.hw_set4_remarks));

                            $('#sw1-4th').html(getIcon(row.sw1));
                            $('#sw2-4th').html(getIcon(row.sw2));
                            $('#sw3-4th').html(getIcon(row.sw3));
                            $('#sw4-4th').html(getIcon(row.sw4));
                            $('#sw5-4th').html(getIcon(row.sw5));
                            $('#sw6-4th').html(getIcon(row.sw6));
                            $('#sw7-4th').html(getIcon(row.sw7));

                            $('#sw1-remarks').append(getFourthRemarks(row.sw1_remarks));
                            $('#sw2-remarks').append(getFourthRemarks(row.sw2_remarks));
                            $('#sw3-remarks').append(getFourthRemarks(row.sw3_remarks));
                            $('#sw4-remarks').append(getFourthRemarks(row.sw4_remarks));
                            $('#sw5-remarks').append(getFourthRemarks(row.sw5_remarks));
                            $('#sw6-remarks').append(getFourthRemarks(row.sw6_remarks));
                            $('#sw7-remarks').append(getFourthRemarks(row.sw7_remarks));

                            $('#sec1-4th').html(getIcon(row.sec1));
                            $('#sec2-4th').html(getIcon(row.sec2));
                            $('#sec3-4th').html(getIcon(row.sec3));

                            $('#sec1-remarks').append(getFourthRemarks(row.sec1_remarks));
                            $('#sec2-remarks').append(getFourthRemarks(row.sec2_remarks));
                            $('#sec3-remarks').append(getFourthRemarks(row.sec3_remarks));

                            $('#gen_main1-4th').html(getIcon(row.gen_main1));
                            $('#gen_main2-4th').html(getIcon(row.gen_main2));
                            $('#gen_main3-4th').html(getIcon(row.gen_main3));
                            $('#gen_main4-4th').html(getIcon(row.gen_main4));
                            $('#gen_main5-4th').html(getIcon(row.gen_main5));
                            $('#gen_main6-4th').html(getIcon(row.gen_main6));
                            $('#gen_main7-4th').html(getIcon(row.gen_main7));
                            $('#gen_main8-4th').html(getIcon(row.gen_main8));

                            $('#gen_main1-remarks').append(getFourthRemarks(row.gen_main1_remarks));
                            $('#gen_main2-remarks').append(getFourthRemarks(row.gen_main2_remarks));
                            $('#gen_main3-remarks').append(getFourthRemarks(row.gen_main3_remarks));
                            $('#gen_main4-remarks').append(getFourthRemarks(row.gen_main4_remarks));
                            $('#gen_main5-remarks').append(getFourthRemarks(row.gen_main5_remarks));
                            $('#gen_main6-remarks').append(getFourthRemarks(row.gen_main6_remarks));
                            $('#gen_main7-remarks').append(getFourthRemarks(row.gen_main7_remarks));
                            $('#gen_main8-remarks').append(getFourthRemarks(row.gen_main8_remarks));

                            $('#per_dev1-4th').html(getIcon(row.per_dev1));
                            $('#per_dev2-4th').html(getIcon(row.per_dev2));
                            $('#per_dev3-4th').html(getIcon(row.per_dev3));
                            $('#per_dev4-4th').html(getIcon(row.per_dev4));
                            $('#per_dev5-4th').html(getIcon(row.per_dev5));
                            $('#per_dev6-4th').html(getIcon(row.per_dev6));

                            $('#per_dev1-remarks').append(getFourthRemarks(row.per_dev1_remarks));
                            $('#per_dev2-remarks').append(getFourthRemarks(row.per_dev2_remarks));
                            $('#per_dev3-remarks').append(getFourthRemarks(row.per_dev3_remarks));
                            $('#per_dev4-remarks').append(getFourthRemarks(row.per_dev4_remarks));
                            $('#per_dev5-remarks').append(getFourthRemarks(row.per_dev5_remarks));
                            $('#per_dev6-remarks').append(getFourthRemarks(row.per_dev6_remarks));
                        }
                    });
                } else {
                    showMessage('NO PMS FOUND.', 'error');
                    setTimeout(function() {
                        $('#search-pms-quarter').focus();
                    }, 0);

                    // Clear dates
                    $('#pms-year-display').text('');

                    $('#pms-quarter1-date-display').text('')
                    $('#pms-quarter2-date-display').text('')
                    $('#pms-quarter3-date-display').text('')
                    $('#pms-quarter4-date-display').text('')

                    // 1st

                    $('#sys1-1st').text('');
                    $('#sys2-1st').text('');

                    $('#sys1-remarks').text('');
                    $('#sys2-remarks').text('');

                    $('#net_set1-1st').text('');
                    $('#net_set2-1st').text('');
                    $('#net_set3-1st').text('');
                    $('#net_set4-1st').text('');
                    $('#net_set5-1st').text('');

                    $('#net_set1-remarks').text('');
                    $('#net_set2-remarks').text('');
                    $('#net_set3-remarks').text('');
                    $('#net_set4-remarks').text('');
                    $('#net_set5-remarks').text('');

                    $('#hw_set1-1st').text('');
                    $('#hw_set2-1st').text('');
                    $('#hw_set3-1st').text('');
                    $('#hw_set4-1st').text('');

                    $('#hw_set1-remarks').text('');
                    $('#hw_set2-remarks').text('');
                    $('#hw_set3-remarks').text('');
                    $('#hw_set4-remarks').text('');

                    $('#sw1-1st').text('');
                    $('#sw2-1st').text('');
                    $('#sw3-1st').text('');
                    $('#sw4-1st').text('');
                    $('#sw5-1st').text('');
                    $('#sw6-1st').text('');
                    $('#sw7-1st').text('');

                    $('#sw1-remarks').text('');
                    $('#sw2-remarks').text('');
                    $('#sw3-remarks').text('');
                    $('#sw4-remarks').text('');
                    $('#sw5-remarks').text('');
                    $('#sw6-remarks').text('');
                    $('#sw7-remarks').text('');

                    $('#sec1-1st').text('');
                    $('#sec2-1st').text('');
                    $('#sec3-1st').text('');

                    $('#sec1-remarks').text('');
                    $('#sec2-remarks').text('');
                    $('#sec3-remarks').text('');

                    $('#gen_main1-1st').text('');
                    $('#gen_main2-1st').text('');
                    $('#gen_main3-1st').text('');
                    $('#gen_main4-1st').text('');
                    $('#gen_main5-1st').text('');
                    $('#gen_main6-1st').text('');
                    $('#gen_main7-1st').text('');
                    $('#gen_main8-1st').text('');

                    $('#gen_main1-remarks').text('');
                    $('#gen_main2-remarks').text('');
                    $('#gen_main3-remarks').text('');
                    $('#gen_main4-remarks').text('');
                    $('#gen_main5-remarks').text('');
                    $('#gen_main6-remarks').text('');
                    $('#gen_main7-remarks').text('');
                    $('#gen_main8-remarks').text('');

                    $('#per_dev1-1st').text('');
                    $('#per_dev2-1st').text('');
                    $('#per_dev3-1st').text('');
                    $('#per_dev4-1st').text('');
                    $('#per_dev5-1st').text('');
                    $('#per_dev6-1st').text('');

                    $('#per_dev1-remarks').text('');
                    $('#per_dev2-remarks').text('');
                    $('#per_dev3-remarks').text('');
                    $('#per_dev4-remarks').text('');
                    $('#per_dev5-remarks').text('');
                    $('#per_dev6-remarks').text('');

                    // 2nd

                    $('#sys1-2nd').text('');
                    $('#sys2-2nd').text('');

                    $('#net_set1-2nd').text('');
                    $('#net_set2-2nd').text('');
                    $('#net_set3-2nd').text('');
                    $('#net_set4-2nd').text('');
                    $('#net_set5-2nd').text('');

                    $('#hw_set1-2nd').text('');
                    $('#hw_set2-2nd').text('');
                    $('#hw_set3-2nd').text('');
                    $('#hw_set4-2nd').text('');

                    $('#sw1-2nd').text('');
                    $('#sw2-2nd').text('');
                    $('#sw3-2nd').text('');
                    $('#sw4-2nd').text('');
                    $('#sw5-2nd').text('');
                    $('#sw6-2nd').text('');
                    $('#sw7-2nd').text('');

                    $('#sec1-2nd').text('');
                    $('#sec2-2nd').text('');
                    $('#sec3-2nd').text('');

                    $('#gen_main1-2nd').text('');
                    $('#gen_main2-2nd').text('');
                    $('#gen_main3-2nd').text('');
                    $('#gen_main4-2nd').text('');
                    $('#gen_main5-2nd').text('');
                    $('#gen_main6-2nd').text('');
                    $('#gen_main7-2nd').text('');
                    $('#gen_main8-2nd').text('');

                    $('#per_dev1-2nd').text('');
                    $('#per_dev2-2nd').text('');
                    $('#per_dev3-2nd').text('');
                    $('#per_dev4-2nd').text('');
                    $('#per_dev5-2nd').text('');
                    $('#per_dev6-2nd').text('');

                    // 3rd

                    $('#sys1-3rd').text('');
                    $('#sys2-3rd').text('');

                    $('#net_set1-3rd').text('');
                    $('#net_set2-3rd').text('');
                    $('#net_set3-3rd').text('');
                    $('#net_set4-3rd').text('');
                    $('#net_set5-3rd').text('');

                    $('#hw_set1-3rd').text('');
                    $('#hw_set2-3rd').text('');
                    $('#hw_set3-3rd').text('');
                    $('#hw_set4-3rd').text('');

                    $('#sw1-3rd').text('');
                    $('#sw2-3rd').text('');
                    $('#sw3-3rd').text('');
                    $('#sw4-3rd').text('');
                    $('#sw5-3rd').text('');
                    $('#sw6-3rd').text('');
                    $('#sw7-3rd').text('');

                    $('#sec1-3rd').text('');
                    $('#sec2-3rd').text('');
                    $('#sec3-3rd').text('');

                    $('#gen_main1-3rd').text('');
                    $('#gen_main2-3rd').text('');
                    $('#gen_main3-3rd').text('');
                    $('#gen_main4-3rd').text('');
                    $('#gen_main5-3rd').text('');
                    $('#gen_main6-3rd').text('');
                    $('#gen_main7-3rd').text('');
                    $('#gen_main8-3rd').text('');

                    $('#per_dev1-3rd').text('');
                    $('#per_dev2-3rd').text('');
                    $('#per_dev3-3rd').text('');
                    $('#per_dev4-3rd').text('');
                    $('#per_dev5-3rd').text('');
                    $('#per_dev6-3rd').text('');

                    // 4th

                    $('#sys1-4th').text('');
                    $('#sys2-4th').text('');

                    $('#net_set1-4th').text('');
                    $('#net_set2-4th').text('');
                    $('#net_set3-4th').text('');
                    $('#net_set4-4th').text('');
                    $('#net_set5-4th').text('');

                    $('#hw_set1-4th').text('');
                    $('#hw_set2-4th').text('');
                    $('#hw_set3-4th').text('');
                    $('#hw_set4-4th').text('');

                    $('#sw1-4th').text('');
                    $('#sw2-4th').text('');
                    $('#sw3-4th').text('');
                    $('#sw4-4th').text('');
                    $('#sw5-4th').text('');
                    $('#sw6-4th').text('');
                    $('#sw7-4th').text('');

                    $('#sec1-4th').text('');
                    $('#sec2-4th').text('');
                    $('#sec3-4th').text('');

                    $('#gen_main1-4th').text('');
                    $('#gen_main2-4th').text('');
                    $('#gen_main3-4th').text('');
                    $('#gen_main4-4th').text('');
                    $('#gen_main5-4th').text('');
                    $('#gen_main6-4th').text('');
                    $('#gen_main7-4th').text('');
                    $('#gen_main8-4th').text('');

                    $('#per_dev1-4th').text('');
                    $('#per_dev2-4th').text('');
                    $('#per_dev3-4th').text('');
                    $('#per_dev4-4th').text('');
                    $('#per_dev5-4th').text('');
                    $('#per_dev6-4th').text('');

                    // Remarks

                    $('#sys1-remarks').text('');
                    $('#sys2-remarks').text('');

                    $('#net_set1-remarks').text('');
                    $('#net_set2-remarks').text('');
                    $('#net_set3-remarks').text('');
                    $('#net_set4-remarks').text('');
                    $('#net_set5-remarks').text('');

                    $('#hw_set1-remarks').text('');
                    $('#hw_set2-remarks').text('');
                    $('#hw_set3-remarks').text('');
                    $('#hw_set4-remarks').text('');

                    $('#sw1-remarks').text('');
                    $('#sw2-remarks').text('');
                    $('#sw3-remarks').text('');
                    $('#sw4-remarks').text('');
                    $('#sw5-remarks').text('');
                    $('#sw6-remarks').text('');
                    $('#sw7-remarks').text('');

                    $('#sec1-remarks').text('');
                    $('#sec2-remarks').text('');
                    $('#sec3-remarks').text('');

                    $('#gen_main1-remarks').text('');
                    $('#gen_main2-remarks').text('');
                    $('#gen_main3-remarks').text('');
                    $('#gen_main4-remarks').text('');
                    $('#gen_main5-remarks').text('');
                    $('#gen_main6-remarks').text('');
                    $('#gen_main7-remarks').text('');
                    $('#gen_main8-remarks').text('');

                    $('#per_dev1-remarks').text('');
                    $('#per_dev2-remarks').text('');
                    $('#per_dev3-remarks').text('');
                    $('#per_dev4-remarks').text('');
                    $('#per_dev5-remarks').text('');
                    $('#per_dev6-remarks').text('');
                }
            },            
            error: function(xhr, status, error) {
                console.error(xhr, status, error);
            }
        });
    });
});