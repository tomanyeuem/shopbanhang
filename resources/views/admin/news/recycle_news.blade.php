@extends('admin_layout')

@section('main_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh Sách Tin Tức Đã Xóa
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-4 m-b-xs">
                    <form action="#" method="POST">
                    {{ @csrf_field() }}
                    <select name="hint" class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Tên từ A-Z</option>
                        <option value="1">Mới nhất</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-default">Sắp xếp theo</button>
                    </form>
                </div>
                <div class="col-sm-5">
                    @if (Session::has('message'))
                        <h3 class="text-danger">{{ Session::get('message') }}</h3>
                    @endif
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="button">Tìm kiếm</button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input id="selectAll" type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            {{-- <th>Người đăng</th> --}}
                            {{-- <th>Tags</th> --}}
                            {{-- <th>Views</th> --}}
                            <th>Trạng Thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $key => $items)
                            <tr id="news_{{$items->id}}">
                                <td><label class="i-checks m-b-none"><input class="checkbox" type="checkbox" name="post[]"><i></i></label></td>
                                <td>{{$items->id}}</td>
                                <td>{{$items->title}}</td>
                                <td>
                                    <?php
                                        if($items->status == 0){
                                    ?>
                                        <a href="#"><span style="font-size: 25px; color: red" class="fa fa-thumbs-down"></span></a>
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <a href="#"><span style="font-size: 25px; color: blue" class="fa fa-thumbs-up"></span></a>
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td>{{ Helper::getDate($items->created_at) }}</td>
                                <td>
                                    <a href="{{ route('restore_news', ['id' => $items->id ]) }}"><i class="fa fa-recycle text-success"></i></a>
                                    <a href="javascript:void(0)" onclick="deleteMe({{$items->id}})" ><i class="fa fa-eraser text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-3 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">Hiển thị {{ $count }} trên tổng số {{ $count_all }} tin tức</small>
                    </div>
                    <div class="col-sm-5 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $news->links() }}
                        </ul>
                    </div>
                    <div class="col-sm-4 text-center">
                        <span style="font-size: 20px; color: red; padding-right: 20px" class="fa fa-thumbs-down">Ẩn</span>
                        <span style="font-size: 20px; color: blue" class="fa fa-thumbs-up">Hiển thị</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script type="text/javascript">
        
        //on click "Select All", set all checkbox "checked"
        $(document).ready(function(){
            $("#selectAll").on('change', function(){
                $(".checkbox").prop("checked", $(this).prop("checked"));
            });

        //if one checkbox is not checked, disable "Select All" 
            $(".checkbox").on('change', function(){
                if($(this).prop("checked") == false){
                    $("#selectAll").prop("checked", false);
                }

                //if all checkbox are checked, make "Select All" become available
                if($(".checkbox:checked").length == $(".checkbox").length){
                    $("#selectAll").prop("checked", true);
                }
            });
        });
    </script>

    <script type="text/javascript">
       function deleteMe(id){
           if(confirm('Bạn có chắc chắn muốn xóa tin tức này vĩnh viễn. Thao tác này không thể hoàn tác.')){
                $.ajaxSetup({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });

                $.ajax({
                    url:'force_delete/'+id,
                    type: 'DELETE',
                    success: function(response){
                        alert(response.success);
                        $('#news_'+id).remove();
                    },
                    error: function(response){
                        console.log('AJAX Failed!!!');
                    }
                })
           }
       }
    </script>

@endsection
