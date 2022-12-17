@extends('layouts.app')

@section('content')
        <div class="container">
            <div id="list_data" class="row justify-content-start">

            </div>
            <ul id="pagination" class="pagination pt-5">

            </ul>
        </div>

@endsection

@section('scripts')
    <script>
        $(()=>{
            var page;
            fetch_data()
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page)
            {
                if(page == ''){
                    page = 1;
                }
                $.ajax({
                    url:"/?page="+page,
                    success:function(response)
                    {
                        var res = '';
                        var pag = '';
                        $.each (response.data, function (index, item) {
                            res +=
                                '<div class="col-12 col-sm-8 col-md-6 col-lg-4 pt-4"><div class="card">' +
                                item.image +
                                '<div class="card-img-overlay"> <a href="#" class="btn btn-light btn-sm">Myblog</a> </div>' +
                                '<div class="card-body"> <h4 class="card-title">'+ item.title +'<small class="text-muted cat"> <i class="far fa-clock text-info"></i> '+ item.published_at +' </small>' +
                                '<br><br><a href="/list-blog/'+ item.id +'" class="btn btn-primary" style="z-index: 9;position: relative;">Read More</a></div></div></div>';

                        })
                        $.each (response.meta.links, function (index, item) {
                            let active;
                            if(item.active){
                                active = 'active'
                            }
                            pag += '<li class="paginate_button page-item"><a href="'+ item.url +'" class="page-link '+ active +'">'+item.label+'</a></li>';
                        })
                        $('#list_data').html(res);
                        $('#pagination').html(pag);
                    }
                });
            }

        });
    </script>
@endsection
