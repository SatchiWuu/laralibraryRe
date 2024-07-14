@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
  <script src="{{ asset('js/book.js') }}"></script>
    <div id="items" class="container">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#bookModal">add<span
            class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
        {{-- @include('layouts.flash-messages') --}}
        {{-- <a class="btn btn-primary" href="{{ route('items.create') }}" role="button">add</a> --}}
        {{-- <form method="POST" enctype="multipart/form-data" action="{{ route('item-import') }}">
            {{ csrf_field() }}
            <input type="file" id="uploadName" name="item_upload" required>
            <button type="submit" class="btn btn-info btn-primary ">Import Excel File</button>

        </form> --}}
        <div class="card-body" style="height: 210px;">
            <input type="text" id='itemSearch' placeholder="--search--">
        </div>
        <div class="table-responsive">
            <table id="bookTable" class="table table-striped table-hover">
                <thead>
                    <tr>

                        <th>Title</th>
                        <th>Genre</th>
                        <th>Publication</th>
                        <th>Language</th>
                        <th>Reviews</th>
                        <th>Summary</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="bookBody"></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="bookModal" role="dialog" style="display:none">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create new Books</h4>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="bookForm" method="#" action="#" enctype="multipart/form-data">
      
                  <div class="form-group">
                      <label for="bookId" class="control-label">Book id</label>
                      <input type="text" class="form-control" id="bookId" name="bookId" readonly>
                    </div>
                
                <div class="form-group">
                  <label for="title" class="control-label">Title</label>
                  <input type="text" class="form-control " id="title" name="title">
                </div>
                <div class="form-group">
                  <label for="title" class="control-label">Author</label>
                  <select class="form-control " id="authorBox" name="authorBox">
                  </select>
                </div>
                <div class="form-group">
                  <label for="title" class="control-label">Publisher</label>
                  <select class="form-control " id="publisherBox" name="publisherBox">
                  </select>
                </div>
                <div class="form-group">
                  <label for="title" class="control-label">Title</label>
                  <input type="text" class="form-control " id="title" name="title">
                </div>
                <div class="form-group">
                  <label for="genre" class="control-label">Genre</label>
                  <input type="text" class="form-control " id="genre" name="genre">
                </div>
                <div class="form-group">
                  <label for="publication" class="control-label">Publication</label>
                  <input type="text" class="form-control " id="publication" name="publication">
                </div>
                
               
                <div class="form-group">
                  <label for="language" class="control-label">Language</label>
                  <input type="text" class="form-control " id="language" name="language">
                </div>
                
                <div class="form-group">
                  <label for="image" class="control-label">Image</label>
                  <input type="file" class="form-control" id="image_upload" name="image_upload" />
                </div>
                
                
                <div class="form-group">
                  <label for="reviews" class="control-label">Reviews</label>
                  <input type="text" class="form-control" id="reviews" name="reviews" />
                </div>

                <div class="form-group">
                  <label for="summary" class="control-label">Summary</label>
                  <input type="text" class="form-control" id="summary" name="summary" />
                </div>
              </form>
            </div>
            <div class="modal-footer" id="footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button id="bookSubmit" type="submit" class="btn btn-primary">Save</button>
              <button id="bookUpdate" type="submit" class="btn btn-primary">update</button>
            </div>
      
          </div>
        </div>
      </div>
@endsection