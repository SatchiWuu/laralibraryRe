$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/book",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value);
                id = value.id;
                var img = "<img src='storage/" + value.images + "' width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(value.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(value.title));
                tr.append($("<td>").html(value.publication));
                tr.append($("<td>").html(value.genre));
                tr.append($("<td>").html(value.language ));
                tr.append($("<td>").html(value.summary));
                tr.append($("<td>").html(value.reviews));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#bookModal' id='editbtn' data-id=" + id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px; color:blue'></i></a></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $("#bookBody").append(tr);
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("error");
        }
    });

    $('#bookTable').on('click', 'a.deletebtn', function (e) {
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

    $('#bookModal').on('show.bs.modal', function(e) {
        
        console.log(e.relatedTarget)
        var id = $(e.relatedTarget).attr('data-id');
        console.log(id);
        if (id !== undefined ) {
            
        } else {
            // $('<input>').attr({type: 'hidden', id:'authorId',name: 'authorId',value: id}).appendTo('#authorForm');
        $.ajax({
            type: "GET",
            url: `/api/authors`,
            success: function(data){

                var selectBox = $('#authorBox');
                selectBox.empty();
                $.each(data, function (key, value) {
                    selectBox.append($('<option>').text(value.lname).attr('value', value.id));
                });
    
                   
              },
             error: function(){
              console.log('AJAX load did not work');
              alert("error");
              }
          });

          $.ajax({
            type: "GET",
            url: `/api/publisher`,
            success: function(data){

                var selectBox = $('#publisherBox');
                selectBox.empty();
                $.each(data, function (key, value) {
                    selectBox.append($('<option>').text(value.name).attr('value', value.id));
                });
    
                   
              },
             error: function(){
              console.log('AJAX load did not work');
              alert("error");
              }
          });
        }
       
        
    });

    $("#bookSubmit").on('click', function (e) {
        e.preventDefault();
        var data = $('#bookForm')[0];
        console.log(data);
        let formData = new FormData(data);
        console.log(formData);
        for (var pair of formData.entries()) {
            console.log(pair[0] + ', ' + pair[1]);
        }
        $.ajax({
            type: "POST",
            url: "/api/book",
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: "json",
            success: function (data) {
                $("#bookModal").modal("hide");
                var img = "<img src='storage/" + data.book.images + "' width='200px', height='200px'/>";
                var tr = $("<tr>");
                tr.append($("<td>").html(data.book.id));
                tr.append($("<td>").html(img));
                tr.append($("<td>").html(data.book.title));
                tr.append($("<td>").html(data.book.genre));
                tr.append($("<td>").html(data.book.publication));
                tr.append($("<td>").html(data.book.language));
                tr.append($("<td>").html(data.book.reviews));
                tr.append($("<td>").html(data.book.summary));
                tr.append("<td align='center'><a href='#' data-toggle='modal' data-target='#authorModal' id='editbtn' data-id=" + data.book.id + "><i class='fas fa-edit' aria-hidden='true' style='font-size:24px' ></a></i></td>");
                tr.append("<td><a href='#'  class='deletebtn' data-id=" + data.book.id + "><i  class='fa fa-trash' style='font-size:24px; color:red' ></a></i></td>");
                $("#bookBody").prepend(tr);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

})