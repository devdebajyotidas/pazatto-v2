$(document).ready(function () {

    $(".left-aside .scrollable").slimScroll({
        height: "700px",
        position: "right",
        size: "4px",
        color: "#dcdcdc",
        alwaysVisible: true
    });

    // Switchery
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());

    });

    $('.clockpicker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now',
        donetext: 'Select',
//                    afterDone: function(data) {
//                        console.log(data);
//                        $(this).val('x');
//                    }
    });

    $(document).on('click', '.archive', function() {

        var that = $(this);
        swal({
            title: 'Archive this record?',
            text: "You can revert this later.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive'
        }).then((result) => {
            if (result.value) {
                that.parent().submit();
            }
        });
    });

    $(document).on('click', '.restore', function() {

        var that = $(this);
        swal({
            title: 'Restore this record?',
            text: "Are you sure?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore'
        }).then((result) => {
            if (result.value) {
                that.parent().submit();
            }
        });
    });

});


function showToast(title, message, type) {
    $.toast({
        heading: title,
        text: message,
        position: 'top-right',
        loaderBg:'#eb3270',
        icon: type,
        hideAfter: 7000,
        stack: 6
    });
}

function initDataTable(selector, buttons = [], ajaxDataSource = false) {
    console.log(buttons);

    var config = {
        dom: 'Bfrtip',
        bSort: false,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return '# '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
        pageResize: true,
        "autoWidth": false,
        select: true,
        buttons: [
            // 'copy', 'csv', 'excel', 'pdf', 'print'
            'csv', 'excel', 'pdf', 'print'

            // {
            //     extend: 'copyHtml5',
            //     exportOptions: {
            //         columns: [ 0, 1, 2, 3, 4, 5]
            //     }
            // },
            // {
            //     extend: 'excelHtml5',
            //     exportOptions: {
            //         columns: [ 0, 1, 2, 3, 4, 5]
            //     }
            // },
            // {
            //     extend: 'pdfHtml5',
            //     exportOptions: {
            //         columns: [ 0, 1, 2, 3, 4, 5]
            //     }
            // },
            // {
            //     extend: 'csv',
            //     exportOptions: {
            //         columns: [ 0, 1, 2, 3, 4, 5]
            //     }
            // },
            // {
            //     extend: 'print',
            //     exportOptions: {
            //         columns: [ 0, 1, 2, 3, 4, 5]
            //     }
            // }
        ]
    };

    if(ajaxDataSource){
        console.log(ajaxDataSource);
        // config['ajax'] = ajaxDataSource;
    }

    for(var i =0; i<buttons.length; i++ ){
        // config.buttons.push(buttons[i]);
        config.buttons.unshift(buttons[i]);
        console.log(config.buttons);
    }


    if(selector.trim() != '' && $(selector).length){

        var table;

        if ( ! $.fn.DataTable.isDataTable( selector ) ) {
           table = $(selector).DataTable(config);
        }

        $('.left-aside ul a').click(function (event) {
            $('.left-aside ul li').removeClass('box-label');
            $(this).parent('li').addClass('box-label');
            table.columns(0).search($(this).data('name')).draw();
        });

        if(ajaxDataSource) {
            setInterval(function () {
                // table.ajax.reload();
            }, 10000);
        }
        return table;
    }else{
        console.log('Could not initialize DataTable on "' + selector + '"');
    }
    return false;
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

var initVendorForm = function () {

    $(".select2").select2();

    $('#service-list .service').click(function () {
        var name = $(this).attr('data-name');
        table.columns(4).search(name).draw();
        $('#service-list li').removeClass('box-label');
        $(this).parent('li').addClass('box-label');
    });

    $('.service .edit').click(function () {
        $('#service-editor input').val($(this).attr('data-name'));
        var action = $('#service-editor').find('form').attr('action');
        $('#service-editor').find('form').attr('action',action + '/' + $(this).attr('data-id'));
        $('#service-editor').modal('show');
    });

    $("#service-list").slimScroll({
        height: "400px",
        position: "right",
        size: "4px",
        color: "#dcdcdc",
        alwaysVisible: true
    });

    $('.wizard').wizard({
        templates: {
            buttons: function() {
                const options = this.options;
                return `<div class="wizard-buttons text-right p-20"><button class="wizard-back btn btn-default m-r-10" href="#${this.id}" data-wizard="back" role="button">${options.buttonLabels.back}</button><button class="wizard-next btn btn-default m-r-10" href="#${this.id}" data-wizard="next" role="button">${options.buttonLabels.next}</button><button type="submit" class="wizard-finish btn btn-info" href="#${this.id}" data-wizard="finish" role="button">${options.buttonLabels.finish}</button></div>`;
            }
        },
        enableWhenVisited: true,
        keyboard: false,
        onFinish: function() {
//                        swal("Message Finish!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            $('#vendor-form').submit();
        }
    });

    initGeoCoder();

    $("#delivery-range").ionRangeSlider({
        type: "double",
        grid: true,
        min: 1,
        max: 20,
        from: 5,
        to: 10,
        prefix: "KM ",
        onChange: function (data) {
            console.log(data);
            var from = data.from;
            var to = data.to;

            $('input[name="vendor[free_delivery_range]"]').val(from);
            $('input[name="vendor[paid_delivery_range]"]').val(to);
            $('#free-delivery-range').text('0 - ' + from);
            $('#paid-delivery-range').text(from + ' - ' + to);

            var leftWidth = Math.ceil(data.from_percent);
            var rightWidth = 100 - leftWidth;
            $(".irs-line-left").css({ 'width': leftWidth + "%", 'background': 'green' });
        }
    });
};

var initGeoCoder = function () {
    $('input.address').geocomplete().bind("geocode:result", function (event, result) {

        // console.log(result);

        // var latitude = result.geometry.location.lat();
        // var longitude = result.geometry.location.lng();

        // $(this).siblings('.latitude').val(latitude);
        // $(this).siblings('.longitude').val(longitude);
    });

    $('input.address').focusout(function(){

        var that = this;
        var geocoder = new google.maps.Geocoder();
        var address = that.value;

        if(address.trim() != "") {

            console.log("inside trim");
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                    console.log(results, latitude, longitude);

                    $(that).siblings('.latitude').val(latitude);
                    $(that).siblings('.longitude').val(longitude);

                }else{
                    swal('Address not found','Sorry, we couldn\'t locate the given address','error' );
                }
            });
        }
    });
};