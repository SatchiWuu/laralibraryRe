$(document).ready(function () {
    new DataTable('#publisherTable', {
        ajax: {
            url: 'api/publisher',
            dataType: 'json',
            dataSrc: ''  // This ensures DataTables expects an array directly from the JSON response
        },
        columns: [
            { data: 'images' },
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'status' },
            { data: 'country' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<button data-toggle="modal" data-target="#publisherModal" class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '">Edit</button>';
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return '<button class="btn btn-sm btn-danger delete-btn deletebtn"  data-id="' + row.id + '">Delete</button>';
                }
            }
        ],
        columnDefs: [
            {
                targets: [6, 7],  // Targets the 7th and 8th columns (edit and delete buttons)
                orderable: false,  // Disable ordering on these columns
                searchable: false  // Disable searching on these columns
            }
        
        ]
    });

    // $.ajax({
    //     type: "GET",
    //     url: "/api/publisher",
    //     dataType: 'json',
    //     success: function (data) {
    //         console.log(data);
    //         $.each(data, function (key, value) {
    //             console.log(value);
    //             id = value.id;
    //             var img = "<img src='storage/" + value.images + "' width='200px', height='200px'/>";
    //             var tr = $("<tr>");
    //             tr.append($("<td>").html(value.id));
    //             tr.append($("<td>").html(img));
    //             tr.append($("<td>").html(value.name));
    //             tr.append($("<td>").html(value.country));
    //             tr.append($("<td>").html(value.email));
    //             tr.append($("<td>").html(value.phone));
    //             tr.append($("<td>").html(value.status));
    //             tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#publisherModal' id='editbtn' data-id=" + id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
    //             tr.append("<td><a href='#'  class='deletebtn' data-id=" + id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
    //             $("#publisherBody").append(tr);
    //         });
    //     },
    //     error: function () {
    //         console.log('AJAX load did not work');
    //         alert("error");
    //     }
    // });

    $("#publisherSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#publisherForm')[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/api/publisher",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#publisherModal").modal("hide");
                var img = "<img src='storage/" + data.publisher.images + "' width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(data.publisher.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(data.publisher.name));
                tr.append($("<td>").html(data.publisher.email));
                tr.append($("<td>").html(data.publisher.phone));
                tr.append($("<td>").html(data.publisher.status));
                tr.append($("<td>").html(data.publisher.phone));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#publisherModal' id='editbtn' data-id=" + data.publisher.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px' ></a></i></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + data.publisher.id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $("#publisherBody").prepend(tr);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#publisherModal').on('show.bs.modal', function(e) {
        
        $("#publisherForm").trigger("reset");
        $('#publisherId').remove()
        $('#image').remove()
        console.log(e.relatedTarget)
        var id = $(e.relatedTarget).attr('data-id');
        console.log(id);
       
        $('<input>').attr({type: 'hidden', id:'publisherId',name: 'publisherId',value: id}).appendTo('#publisherForm');
        $.ajax({
            type: "GET",
            url: `/api/publisher/${id}`,
            success: function(data){
                   // console.log(data);
                   $("#publisherId").val(data.id);
                   $("#name").val(data.name);
                   $("#country").val(data.country);
                   $("#email").val(data.email);
                   $("#status").val(data.status);
                   $("#phone").val(data.phone); 

                   if (data.images !== undefined) {
                    $("#publisherForm").prepend(`<img src='storage/${data.images}' width='200px', height='200px' id="image"   />`)
                   } else {
                        
                   }    
                   
              },
             error: function(){
              console.log('AJAX load did not work');
              alert("error");
              }
          });
    });

    $('#publisherTable #publisherBody').on('click', 'a.deletebtn', function (e) {
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        console.log(id);
        // console.log(table);
        e.preventDefault();
        bootbox.confirm({
            message: "do you want to delete this publisher?",
            buttons: {
                confirm: {
                    label: 'yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'no',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                console.log(result);
                if (result)
                    $.ajax({
                        type: "DELETE",
                        url: `/api/publisher/${id}`,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            $row.fadeOut(4000, function () {
                                $row.remove()
                            });

                            bootbox.alert(data.message);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
            }
        });
    });

    $("#publisherUpdate").on('click', function (e) {
        e.preventDefault
        var id = $('#publisherId').val();
        var $row = $('tr td > a[data-id="' + id + '"]').closest('tr');
        console.log(id)
        // var data = $('#cform')[0];
        let formData = new FormData($('#publisherForm')[0]);
        formData.append('_method', 'PUT')
        $.ajax({
            type: "POST",
            url: `/api/publisher/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                
                $('#publisherModal').modal('hide')
                $row.remove()
                var img = "<img src='storage/" + data.publisher.images + "' width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(data.publisher.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(data.publisher.name));
                tr.append($("<td>").html(data.publisher.email));
                tr.append($("<td>").html(data.publisher.phone));
                tr.append($("<td>").html(data.publisher.status));
                tr.append($("<td>").html(data.publisher.country));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#authorModal' id='editbtn' data-id=" + data.publisher.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px' ></a></i></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + data.publisher.id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $('#publisherTable').prepend(tr.hide().fadeIn(5000));
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


})