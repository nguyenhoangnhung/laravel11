<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product DataTable</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            body {
                padding-top: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-hover" id="products-table">
                {{-- <button action="{{asset('')}}products/add" method="POST" class="btn btn-primary" style="margin-bottom: 15px;">Add</button> --}}
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Material</th>
                            <th>Category</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
        </div>

        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- App scripts -->
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
                    { data: 'size', name: 'size' },
                    { data: 'material', name: 'material' },
                    { data: 'category', name: 'category' },
                    { data: 'color', name: 'color' },
                    { data: 'price', name: 'price' },
                    { data: 'action', name: 'action' }
                ]
            });
            $(document).on('click', '.btn-danger', function(){
                var id = $(this).data('id');

                if (confirm('Are you sure?')) {
                    $.ajax({
                        type: 'delete',
                        url: 'products/' + id,
                        success: function (response) {
                            $('#products-table').DataTable().ajax.reload(null,false)
                        }
                    })
                }
            })
        });
        </script>
    </body>
</html>