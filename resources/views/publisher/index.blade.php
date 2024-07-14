@extends('layouts.master')
@section('content')
    <div id="items" class="container">
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#publisherModal">add<span
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
            <table id="publisherTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Publisher ID</th>
                        <th>image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th> 
                        <th>Country</th> 
                    
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="publisherBody"></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="publisherModal" role="dialog" style="display:none">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Create new Publisher</h4>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="publisherForm" method="#" action="#" enctype="multipart/form-data">
      
                  <div class="form-group">
                      <label for="publisherId" class="control-label">publisher id</label>
                      <input type="text" class="form-control" id="publisherId" name="publisherId" readonly>
                    </div>
                
                <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input type="text" class="form-control " id="name" name="name">
                </div>
                <div class="form-group">
                  <label for="country" class="control-label">Country</label>
                  <input type="text" class="form-control " id="country" name="country">
                </div>
                <div class="form-group">
                  <label for="email" class="control-label">Email</label>
                  <input type="text" class="form-control " id="email" name="email">
                </div>
                
               
                <div class="form-group">
                  <label for="phone" class="control-label">phone</label>
                  <input type="text" class="form-control " id="phone" name="phone">
                </div>
                
                <div class="form-group">
                  <label for="Status" class="control-label">Status</label>
                  <input type="text" class="form-control " id="status" name="status">
                </div>
                
                <div class="form-group">
                  <label for="image" class="control-label">Image</label>
                  <input type="file" class="form-control" id="image_upload" name="image_upload" />
                </div>
              </form>
            </div>
            <div class="modal-footer" id="footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button id="publisherSubmit" type="submit" class="btn btn-primary">Save</button>
              <button id="publisherUpdate" type="submit" class="btn btn-primary">update</button>
            </div>
      
          </div>
        </div>
      </div>
@endsection