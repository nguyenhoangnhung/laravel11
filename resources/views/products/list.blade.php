@extends('layouts.admin_master')
@section('content')
<div class="container">
	@if(session()->has('notification'))
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{session()->get('notification')}}
		</div>
	@endif
    <div class="table-responsive" style="margin-right: 40px;">
    	<button id="btn_add" name="btn_add" class="btn btn-primary pull-left" style="margin-bottom: 15px; margin-top: 15px;"><i class="fa fa-plus"></i>  Add New Product</button>
        <table class="table table-hover" id="products-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Material</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            
        </table>
    </div>
</div>
<div class="modal fade" id="add">
	<div class="modal-dialog" style="width: 75%">
		<div class="modal-content" style="height: 600px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">ADD NEW PRODUCT</h4>
			</div>
			<div class="modal-body">
				<div style="vertical-align: top;" class="p col-md-8">
					<div class="form-group">
						<label>Name(<span style="color: red">*</span>)</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Name">
						{{-- <input type="hidden" name="" value="" id="add_id"> --}}
					</div>
					<div class="form-group">
						<label>Price(<span style="color: red">*</span>)</label>
						<input  type="text" name="price" id="price" class="form-control"  placeholder="Price"></input>
					</div>
					<div class="form-group">
						<label>Description(<span style="color: red">*</span>)</label>
						<textarea name="description" id="editor1" rows="10" cols="80"  class="form-control">

						</textarea>
					</div>
				</div>
				<div  style="vertical-align: top;" class="p col-md-4">
					<div class="post-profile">
						<div class="caption">
							<span style="font-weight: bold">Categories</span>
						</div>
						<div class="post-categories">
							<select name="add_Pro" class="form-control" id="add_Pro">
								@if(count($categories)>0)
								@foreach($categories as $category)
								<option value="{{$category->name}}" class="category" name="category_id">{{$category->name}}</option>
								@endforeach
								@endif
								
							</select>
						</div>
					</div>
					
					<div class="post-profile">
						<div class="caption">
							<span style="font-weight: bold">SubCategories</span>  
						</div>
						<div class="post-categories">
							<select name="add_subPro" class="form-control" id="add_subPro">
								@if(count($subcategories)>0) @foreach ($subcategories as $subcategory)
								<option value="{{$subcategory->name}}" class="subcategory" name="subcategory_id">{{$subcategory->name}}</option>
								@endforeach @endif        
							</select>
						</div>
					</div>
					<div class="post-profile">
						<div class="caption">
							<label>Material(<span style="color: red">*</span>)</label>
							<input  type="text" name="material" id="material" class="form-control"  placeholder="Material"></input>
						</div>
					</div>

					<div class="post-profile">
						<div class="caption">
							<span style="font-weight: bold">Action</span>  
						</div>
						<div class="post-action">
							<button type="submit" class="btn btn-info">Lưu</button>
							<button type="reset" class="btn btn-warning">Nhập lại</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="AddDetail">
	<div class="modal-dialog" style="width: 75%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Detail</h4>
			</div>
			<div class="modal-body" style="height: 350px;">
				<div class="addDe col-md-8">
					<table class="table-bordered table " id="scolors-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Size</th>
								<th>Color</th>
								<th>Quantity</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="addDe col-md-4">
					<div class="form-group">
						<label>Size(<span style="color: red">*</span>)</label>
						
						<select name="size" id="size" class="form-control" required="required">
							@if(count($size)>0) @foreach ($size as $sizes)
							<option value="{{$sizes->id}}" name="size_id">{{$sizes->sizename}}</option>
							@endforeach @endif 
							
						</select>
						<br>
					</div> 
					<div class="form-group abc">
						<label>Color(<span style="color: red">*</span>)</label>
						<input type="color" name="" class="form-control colorDetail" style="width: 45px;">
					</div>
					<div class="form-group">
						<label>Quantity(<span style="color: red">*</span>)</label>
						<input type="numeric" name="" value="" class="form-control" id="quantity">
					</div>
					<div>
						<div class="caption">
							<span style="font-weight: bold">Action</span>  
						</div>
						<div class="post-action">
							<button type="submit" class="btn btn-success " id="formAddDetail" >Lưu</button>
							<button type="reset" class="btn btn-warning">Nhập lại</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="showDetail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Show Detail</h4>
			</div>
			<div class="modal-body">
				<div class="showDetail col-md-8">
					<p style="font-weight: bold;">Name(<span style="color: red">*</span>) :</p>
					<p class="showname"></p>
					<hr width="75%">
					<p style="font-weight: bold;">Price(<span style="color: red">*</span>) :</p>
					<p class="showprice"></p>
					<hr width="75%">
					<p style="font-weight: bold;">Description(<span style="color: red">*</span>) :</p>
					<p class="showdescription"></p>
					<hr width="75%">
					<p style="font-weight: bold;">Material(<span style="color: red">*</span>) :</p>
					<p class="showmaterial"></p>
					<hr width="75%">
					<p style="font-weight: bold;">Size(<span style="color: red">*</span>) :</p>
					<p class="showsize"></p>
					<hr width="75%">
					<p style="font-weight: bold;">Color(<span style="color: red">*</span>) :</p>
					<p class="showcolor"></p>
					<hr width="75%">
				</div>
				<div class="showDetail col-md-4">
					<p style="font-weight: bold;">Categories(<span style="color: red">*</span>) :</p>
					<p class="showcategory"></p>
					<hr width="75%">
					<p style="font-weight: bold;">SubCategories(<span style="color: red">*</span>) :</p>
					<p class="showsubcategory"></p>
					<hr width="75%">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden"  id="hiddenup">
<input type="hidden"  id="hiddenadd">

<div class="modal fade" id="uploadImage">
	<div class="modal-dialog" style="width: 75%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Upload</h4>
			</div>
			<div class="modal-body">
				<div{{--  class="file-loading" --}}>
				<form method="post" enctype="multipart/form-data">
					{{ @csrf_field()}}
					<input type="hidden" name="" value="" id="idtoaddimg">
					<input id="file-1" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
				</form>
					
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('script')
{{-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
Bootstrap JavaScript
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> --}}
<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'products/list',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'material', name: 'material' },
            { data: 'price', name: 'price' },
            { data: 'action', name: 'action' }
        ]
    });
    //xoa
    $(document).on('click', '.btn-danger', function(){
        var id = $(this).data('id');

        if (confirm('Are you sure?')) {
            $.ajax({
                type: 'delete',
                url: '{{asset('')}}admin/products/' + id,
                success: function (response) {
                    $('#products-table').DataTable().ajax.reload(null,false)
                }
            })
        }
    });
    //them san pham
    $('#btn_add').click(function(){
    	$('#add').modal('show');
    });
   	$('.btn-info').click(function(){
		$.ajax({
			type: 'post',
			url: "products" ,
			data: {
				name: $('#name').val(),
				material: $('#material').val(),
				price:$('#price').val(),
				// description: CKEDITOR.instances['editor1'].getData(),
				description:CKEDITOR.instances['editor1'].getData(),
				category: $('#add_Pro').val(),
				subcategory: $('#add_subPro').val()
			},
			success: function(response){
				console.log(response);	
				$('#modal-add').modal('hide');
				// $('#list').append("<tr><td>"+response.data.id +"</td><td>"+response.data.code+"</td><td>"+response.data.name+"</td><td>"+response.data.quantity+"</td><td>"+response.data.price+"</td><td>"+response.data.created_at+"</td><td>"+response.data.updated_at+"</td><td><button data-toggle='modal' data-target='#show' product_id="+response.data.id+" class='btn btn-info'>Show</button><a href='products/"+response.data.id+"/edit' class='btn btn-warning'>Edit</a><button data-id="+response.data.id+" class='btn btn-danger' >Delete</button></td></tr>");
				toastr.success('Bạn đã thêm thành công!')
				setTimeout(function(){
					window.location.href = "{{asset('admin/products')}}";
				}, 800);
        	}

		})
	});

	$(document).on('click', '.DetailAdd', function(e){
		e.preventDefault();
		var id=$(this).attr('product_id');

		$('#hiddenadd').attr('product_id',id);

	});

	$(document).on('click', '#formAddDetail', function(e){
	// $('#formAddDetail').click(function(){
		// alert('djjjjdks');
		// var id=$('#hiddenadd').attr('product_id');
		var id= $('.DetailAdd').data('id');
		// alert(id);
		var url2="{{ asset('') }}admin/adddetail";
		var formData2 = new FormData();
		formData2.append('size',$('#size').val());
		formData2.append('color',$('.colorDetail').val());
		formData2.append('quantity',$('#quantity').val());
		formData2.append('id',id);
		
		$.ajax({
			url:url2,
			type:'post',
			processData: false,
			contentType: false,
			data:formData2,
			success:function(response){
				toastr.success('Bạn đã thêm chi tiết thành công !');
				var detailTaable = $('#scolors-table').DataTable({

					processing: true,
					serverSide: true,
					ajax: 'admin/adddetail/'+id,
					columns: [
					{ data: 'product_id', name: 'product_id' },
					{ data: 'size', name: 'size'},
					{ data: 'color', name: 'color' },
					{ data: 'quantity', name: 'quantity' },
					{ data: 'action', name: 'action' }
					]
				}); 
				detailTaable.destroy();
				// $('#scolors-table').DataTable().ajax.reload(null, false);

			}
		});

	});

	$(document).on('click','.ShowDetail',function(e){
		e.preventDefault();
		var id= $(this).attr('product_id');
		
		$('#showDetail').text('');
		$.ajax({
			type: 'get',
			url: "{{asset('')}}admin/products/show"+id,
			success: function(response){
				console.log(response);
				$('.showid').text(response.product.id);
				$('.showname').text(response.product.name);
				$('.showprice').text(response.product.price);
				$('.showdescription').text(response.product.description);
				$('.showmaterial').text(response.product.material);
				$('.showsize').text(response.product.size);
				$('.showcolor').text(response.product.color);
				$('.showcategory').text(response.product.category);
				$('.showsubcategory').text(response.product.subcategory);
				
				$.each(response.images.data, function() {
				var html='<img style="width: 300px; margin:10px; boder 1px solid grey;" src="' +$(this)[0].link+'"></img>'

				$('#showDetail').append(html);
			});

			}

			

		});
	});



	//them anh cho san pham
    $(document).on('click', '.uploadImg', function(e){
		e.preventDefault();
		var id=$(this).attr('product_id');

		$('#hiddenup').attr('product_id',id);
		$('#uploadProduct').modal('show');
	});

	$(document).on('click', '.uploadImg', function(){
        var id = $(this).data('id');
        $('#file-1').attr('data-id', id);
    });
	// uploadProduct
	
});
	$("#file-1").fileinput({
		type: 'post',
		theme: 'fa',
		uploadUrl: "{{ asset('') }}admin/upload",
		uploadExtraData: function() {
			return {
				product_id: $('#file-1').attr('data-id'),
				_token: $("input[name='_token']").val(),
			};
		},
		allowedFileExtensions: ['jpg', 'png', 'gif'],
		overwriteInitial: false,
		maxFileSize:2000,
		maxFilesNum: 10,
		slugCallback: function (filename) {
			return filename.replace('(', '').replace(']', '');
		}
	});

	



</script>
@endsection