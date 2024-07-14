$(document).ready(function () {

    new DataTable('#authorTable', {
        ajax: {
            url: 'api/authors',
            dataType: 'json',
            dataSrc: ''  // This ensures DataTables expects an array directly from the JSON response
        },
        columns: [
            { data: 'lname' },
            { data: 'fname' },
            { data: 'address' },
            { data: 'phone' },
            { data: 'gender' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<button data-toggle="modal" data-target="#bookModal" class="btn btn-sm btn-primary edit-btn" data-id="' + row.id + '">Edit</button>';
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
    //     url: "/api/authors",
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
    //             tr.append($("<td>").html(value.lname));
    //             tr.append($("<td>").html(value.fname));
    //             tr.append($("<td>").html(value.gender));
    //             tr.append($("<td>").html(value.address));
    //             tr.append($("<td>").html(value.phone));
    //             tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#authorModal' id='editbtn' data-id=" + id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
    //             tr.append("<td><a href='#'  class='deletebtn' data-id=" + id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
    //             $("#authorBody").append(tr);
    //         });
    //     },
    //     error: function () {
    //         console.log('AJAX load did not work');
    //         alert("error");
    //     }
    // });

    $("#authorSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#authorForm')[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/api/authors",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#authorModal").modal("hide");
                var img = "<img src='storage/" + data.author.images + "' width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(data.author.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(data.author.lname));
                tr.append($("<td>").html(data.author.fname));
                tr.append($("<td>").html(data.author.gender));
                tr.append($("<td>").html(data.author.address));
                tr.append($("<td>").html(data.author.phone));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#authorModal' id='editbtn' data-id=" + data.author.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px' ></a></i></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + data.author.id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $("#authorBody").prepend(tr);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#authorModal').on('show.bs.modal', function(e) {
        
        $("#authorForm").trigger("reset");
        $('#authorId').remove()
        $('#image').remove()
        console.log(e.relatedTarget)
        var id = $(e.relatedTarget).attr('data-id');
        console.log(id);
       
        $('<input>').attr({type: 'hidden', id:'authorId',name: 'authorId',value: id}).appendTo('#authorForm');
        $.ajax({
            type: "GET",
            url: `/api/authors/${id}`,
            success: function(data){
                   // console.log(data);
                   $("#authorId").val(data.id);
                   $("#lname").val(data.lname);
                   $("#fname").val(data.fname);
                   $("#gender").val(data.gender);
                   $("#address").val(data.address);
                   $("#phone").val(data.phone); 

                   if (data.images !== undefined) {
                    $("#cform").prepend(`<img src='storage/${data.images}' width='200px', height='200px' id="image"   />`)
                   } else {
                        
                   }    
                   
              },
             error: function(){
              console.log('AJAX load did not work');
              alert("error");
              }
          });
    });

    $('#authorTable #authorBody').on('click', 'a.deletebtn', function (e) {
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        console.log(id);
        // console.log(table);
        e.preventDefault();
        bootbox.confirm({
            message: "do you want to delete this author?",
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
                        url: `/api/authors/${id}`,
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

    $("#authorUpdate").on('click', function (e) {
        e.preventDefault
        var id = $('#authorId').val();
        var $row = $('tr td > a[data-id="' + id + '"]').closest('tr');
        console.log(id)
        // var data = $('#cform')[0];
        let formData = new FormData($('#authorForm')[0]);
        formData.append('_method', 'PUT')
        $.ajax({
            type: "POST",
            url: `/api/authors/${id}`,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                console.log(data);
                
                $('#authorModal').modal('hide')
                $row.remove()
                var img = "<img src='storage/" + data.author.images + "' width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(data.author.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(data.author.lname));
                tr.append($("<td>").html(data.author.fname));
                tr.append($("<td>").html(data.author.gender));
                tr.append($("<td>").html(data.author.address));
                tr.append($("<td>").html(data.author.phone));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#authorModal' id='editbtn' data-id=" + data.author.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px' ></a></i></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + data.author.id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $('#authorTable').prepend(tr.hide().fadeIn(5000));
            },
            error: function (error) {
                console.log(error);
            }
        });
    });



})