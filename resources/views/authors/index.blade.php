@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
  <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
  <script src="{{ asset('js/authors.js') }}"></script>
    <div id="items" class="container">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#authorModal">add<span
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
            <table id="authorTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                      <th>lname</th>
                      <th>fname</th>
                      <th>address</th>
                      <th>phone</th>
                      <th>gender</th>
                      
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="authorBody"></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="authorModal" role="dialog" style="display:none">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create new Authors</h4>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="authorForm" method="#" action="#" enctype="multipart/form-data">
      
                  <div class="form-group">
                      <label for="authorId" class="control-label">author id</label>
                      <input type="text" class="form-control" id="authorId" name="authorId">
                    </div>
                
                <div class="form-group">
                  <label for="lname" class="control-label">last name</label>
                  <input type="text" class="form-control " id="lname" name="lname">
                </div>
                <div class="form-group">
                  <label for="fname" class="control-label">first name</label>
                  <input type="text" class="form-control " id="fname" name="fname">
                </div>
                <div class="form-group">
                  <label for="address" class="control-label">address</label>
                  <input type="text" class="form-control " id="address" name="address">
                </div>
                
               
                <div class="form-group">
                  <label for="phone" class="control-label">phone</label>
                  <input type="text" class="form-control " id="phone" name="phone">
                </div>
                
                <div class="form-group">
                  <label for="gender" class="control-label">gender</label>
                  <input type="text" class="form-control " id="gender" name="gender">
                </div>
                
                
                
                <div class="form-group">
                  <label for="image" class="control-label">Image</label>
                  <input type="file" class="form-control" id="image_upload" name="image_upload" />
                </div>
              </form>
            </div>
            <div class="modal-footer" id="footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button id="authorSubmit" type="submit" class="btn btn-primary">Save</button>
              <button id="authorUpdate" type="submit" class="btn btn-primary">update</button>
            </div>
      
          </div>
        </div>
      </div>
@endsection