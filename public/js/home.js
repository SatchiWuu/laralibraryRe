$(document).ready(function () {

    $.ajax({
        type: "GET",
        url: "/api/fetchData",
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
                console.log(value.id);
                var div = $("<div>");
                    
                    div.append($('<div class="card m-2 p-1" style="width: 18rem;"><div style="width:100%;display:flex;justify-content:center"><img class="card-img-top" src="storage/'+value.images+'" alt="Card image cap" style="height:100px;width:100px;margin-top:10px">></div><div class="card-body"><h5 class="card-title">'+ value.title +'</h5><a href="#summaryCollapse'+ value.id +'" class="btn btn-primary" data-toggle="collapse" aria-expanded="false" aria-controls="summaryCollapse'+ value.id +'">Show Summary</a><div class="collapse" id="summaryCollapse'+ value.id +'"><p class="card-text">'+ value.summary +'.</p></div></div><ul class="list-group list-group-flush"><li class="list-group-item">'+ value.fname +' '+ value.lname +'</li><li class="list-group-item">'+value.genre+'</li><li class="list-group-item">'+value.language+'</li></ul><div class="card-body d-flex justify-content-between"><a href="#" class="btn btn-secondary">See Details</a><a href="#" class="btn btn-info borrow-btn">Add to Borrow</a></div></div>'));

                    $("#bookDeck").append(div.hide().fadeIn(1000));
            });
        },
        error: function () {
            console.log('AJAX load did not work');
            alert("error");
        }
    });

    $('#bookDeck').on('click', 'a.borrow-btn', function (e) {
        var id = $(this).data('id');
        console.log("id is " + id); // Make sure this line is correctly logged
        var $card = $('#card' + id); // Select the card element to remove
        // console.log(table);
        e.preventDefault();
        bootbox.confirm({
            message: "Do you want to borrow this book?",
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
                if (result) {
                    bootbox.alert({
                        message: 'You have borrowed the book!', 
                        callback: function () {
                            console.log('Alert closed');
                        }
                    });
                } else {
                    console.log('User canceled borrowing the book.');
                }
            }
        });
    })

})