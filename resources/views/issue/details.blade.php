@extends('layouts.main')
@section('css')
<style>
    .main-timeline{
    overflow: hidden;
    position: relative;
}
.main-timeline .timeline{ position: relative; }
.main-timeline .timeline:before,
.main-timeline .timeline:after{
    content: "";
    display: block;
    width: 100%;
    clear: both;
}
.main-timeline .timeline:before{
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #fff;
    margin: auto;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 2;
}
.main-timeline .timeline-icon{
    width: 16px;
    height: 95%;
    background: #029bbd;
    margin: auto;
    position: absolute;
    top: 5%;
    left: 0;
    bottom: 0;
    right: 0;
    z-index: 1;
}
.main-timeline .timeline-icon:before,
.main-timeline .timeline-icon:after{
    content: "";
    border-bottom: 11px solid #029bbd;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    position: absolute;
    top: -11px;
    left: 0;
}
.main-timeline .timeline-icon:after{
    border-bottom-color: #fff;
    top: auto;
    bottom: 0;
}
.main-timeline .year{
    display: inline-block;
    padding: 5px 35px;
    margin: 0;
    border-radius: 4px;
    font-size: 26px;
    color: #fff;
    background: linear-gradient(to right, #079dc0, #01c2bf);
    text-align: center;
    position: absolute;
    top: 50%;
    left: 32%;
    transform: translateY(-50%);
}
.main-timeline .timeline-content{
    width: 50%;
    float: right;
    padding: 0 60px 30px 60px;
    position: relative;
}
.main-timeline .icon{
    display: inline-block;
    font-size: 40px;
    color: #a7a7a7;
    margin-bottom: 7px;
}
.main-timeline .title{
    font-size: 20px;
    font-weight: bold;
    color: #a7a7a7;
    margin: 0 0 7px 0;
}
.main-timeline .description{
    font-size: 18px;
    color: #333;
    line-height: 30px;
    margin: 0;
}

.main-timeline .timeline:nth-child(2n) .year{
    left: auto;
    right: 32%;
}
.main-timeline .timeline:nth-child(2n) .timeline-content{ float: left; }
.main-timeline .timeline:nth-child(2n) .year{ background: linear-gradient(to right, #9e489f, #b64877); }
.main-timeline .timeline:nth-child(2n) .timeline-icon{ background: #9e489f; }
.main-timeline .timeline:nth-child(2n) .timeline-icon:before{ border-bottom-color: #9e489f; }
.main-timeline .timeline:nth-child(3n) .year{ background: linear-gradient(to right, #6ab00f, #9fce26); }
.main-timeline .timeline:nth-child(3n) .timeline-icon{ background: #6ab00f; }
.main-timeline .timeline:nth-child(3n) .timeline-icon:before{ border-bottom-color: #6ab00f; }
.main-timeline .timeline:nth-child(4n) .year{ background: linear-gradient(to right, #d84704, #ea703f); }
.main-timeline .timeline:nth-child(4n) .timeline-icon{ background: #d44908; }
.main-timeline .timeline:nth-child(4n) .timeline-icon:before{ border-bottom-color: #d44908; }

.info{
    font-size: 15px;
    color: #ffffff;
    background: linear-gradient(to right, #079dc0, #01c2bf);
    font-weight: 600;
    
}
.danger{
    font-size: 15px;
    color: #b64877;
    font-weight: 600;
}
.btn-danger{
    font-size: 15px;
    color: #ffffff;
    background: linear-gradient(to right, #9e489f, #b64877);
    font-weight: 600;
    margin-left: 10px;
    border-color: #b64877;
}

.bg-danger{
    background: linear-gradient(to right, #9e489f, #b64877);
    font-weight: bold;
}

.success{
    font-size: 15px;
    color: #9fce26;
    font-weight: 600;
}
.btn-success{
    font-size: 15px;
    color: #ffffff;
    background: linear-gradient(to right, #6ab00f, #9fce26);
    font-weight: 600;
    margin-left: 10px;
    border-color: #9fce26;
}
.bg-success{
    background: linear-gradient(to right, #6ab00f, #9fce26);  
    font-weight: bold;  
}





@media only screen and (max-width: 1200px){
    .main-timeline .year{ left: 28%; }
    .main-timeline .timeline:nth-child(2n) .year{ right: 28%; }
}
@media only screen and (max-width: 990px){
    .main-timeline .year{ left: 25%; }
    .main-timeline .timeline:nth-child(2n) .year{ right: 25%; }
}
@media only screen and (max-width: 767px){
    .main-timeline .timeline{ padding-top: 30px; }
    .main-timeline .timeline:before{
        border: 15px solid transparent;
        border-top-color: #029bbd;
        border-bottom: 10px solid transparent;
        margin: 0 auto;
        position: absolute;
        top: 1px;
        left: 0;
        z-index: 2;
    }
    .main-timeline .timeline:nth-child(2n):before{ border-top-color: #9e489f; }
    .main-timeline .timeline:nth-child(3n):before{ border-top-color: #6ab00f; }
    .main-timeline .timeline:nth-child(4n):before{ border-top-color: #d44908; }
    .main-timeline .timeline-icon{
        width: 100%;
        height: 16px;
        margin: 0;
        top: 0;
        left: 0;
    }
    .main-timeline .timeline-icon:before,
    .main-timeline .timeline-icon:after{
        border: 8px solid transparent;
        border-left: 8px solid #fff;
        top: 0;
        left: 0;
    }
    .main-timeline .timeline-icon:after{
        border-left: none;
        border-right: 8px solid #fff;
        left: auto;
        right: 0;
    }
    .main-timeline .year,
    .main-timeline .timeline:nth-child(2n) .year{
        display: block;
        margin: 0 30px 10px 30px;
        position: relative;
        top: 0;
        left: 0;
        transform: translateY(0);
    }
    .main-timeline .timeline-content,
    .main-timeline .timeline:nth-child(2n) .timeline-content{
        width: 100%;
        float: none;
        text-align: center;
        padding: 0 30px 20px;
    }
}


</style>
<link rel="stylesheet" href="{{ asset('css/popup.css')}}">
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-10">
        <div class="main-timeline">
            <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year">02-02-2018</span>
                <div class="timeline-content">
                    <span class="icon far fa-envelope"></span> 
                    <h3 class="title">Issue Delivered</h3>
                    <p class="description">
                        Issue Delivered From : <span class="badge-pill info">{{$issue->commercial->full_name}}</span>
                    </p>
                </div>
            </div>
            <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year">04-02-2018</span>
                <div class="timeline-content">
                    <span class="icon far fa-envelope-open"></span>
                    <h3 class="title">Issue Received</h3>
                    <p class="description">
                        Issue received and verified also init pictures are token <br>
                        <div class="card" >
                            <div class="card-header text-center text-uppercase bg-danger text-white">
                                More Information
                            </div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Responsable</th>
                                            <td><span class="badge-pill  ">{{$issue->user->name}}</span></td>
                                        </tr>
                                            <th>IMEI</th>
                                            <td><span class="badge-pill  ">{{ $issue->imei }}</span></td>
                                        </tr>
                                            <th>Pictures</th>
                                            <td><button class="btn btn-sm btn-danger info" data-status="before" data-id="{{ $issue->id }}">show</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        
                    </p>
                </div>
            </div>

            <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year">10-02-2018</span>
                <div class="timeline-content">
                        <span class="icon fas fa-wrench"></span> 
                    <h3 class="title">Issue Resolved</h3>
                    <p class="description">
                        Issue resolved and final pictures are token also the phone is returned back <br>
                        {{-- IMEI : <span class="badge-pill success">123456789123456</span><br>
                        Main Issue : <span class="badge-pill success">The Camera was broken</span><br>
                        Solution: <span class="badge-pill success">Replaced by new one</span><br>
                        Fees: <span class="badge-pill success">0 DH</span><br>
                        Pictures : <button class="btn btn-sm success" >show</button><br> --}}
                        <div class="card" >
                            <div class="card-header text-center text-uppercase bg-success text-white">
                                More Information
                            </div>
                            <div class="card-body">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>IMEI</th>
                                            <td><span class="badge-pill ">{{ $issue->imei }}</span></td>
                                        </tr>
                                            <th>Main Issue</th>
                                            <td>
                                                @forelse ($issue->problems as $problem)
                                                <span class="badge-pill ">{{ $problem->content }}</span><br>
                                                @empty
                                                <span class="badge-pill ">Software Issue</span>
                                                @endforelse
                                            </td>
                                            {{-- <td><span class="badge-pill ">{{ $issue->problems->content }}</span></td> --}}
                                        </tr>
                                        @if($issue->extra_problem != '')
                                        </tr>
                                            <th>Extra Problems</th>
                                            <td><span class="badge-pill ">{{ $issue->extra_problem }}</span></td>
                                        </tr>
                                        @endif
                                        <th>Solution</th>
                                        <td><span class="badge-pill ">{{ $issue->solution }}</span></td>
                                        </tr>
                                        <th>Pictures</th>
                                        <td><button class="btn btn-sm btn-success info" data-status='after' data-id="{{ $issue->id }}">show</button></td>
                                        </tr>
                                        <tr>
                                        <th>Fees</th>
                                        <td><span class="badge-pill ">{{ $issue->charges }} DH</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </p>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="images-modal" tabindex="-1" role="dialog" aria-labelledby="images-modal" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="images-modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="popup-gallery">
                    {{-- <a href="https://via.placeholder.com/500?text=Picture+1"><img src="https://via.placeholder.com/150?text=Picture+1" alt="..." width="150" height="150" class="img-thumbnail img-fluid"></a>
                    <a href="https://via.placeholder.com/500?text=Picture+2"><img src="https://via.placeholder.com/150?text=Picture+2" alt="..." class="img-thumbnail img-fluid"></a>
                    <a href="https://via.placeholder.com/500?text=Picture+3"><img src="https://via.placeholder.com/150?text=Picture+3" alt="..." class="img-thumbnail img-fluid"></a>
                    <a href="https://via.placeholder.com/500?text=Picture+4"><img src="https://via.placeholder.com/150?text=Picture+4" alt="..." class="img-thumbnail img-fluid"></a> --}}
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/popup.js')}}"></script>
<script>
  $(document).ready(function(){

      $('body').on('click','.info',function(){
            var id = $(this).data('id');
            var status = $(this).data('status');
            $.ajax({
                type:'GET',
                url:'/issues/images',
                data:{id:id,status:status},
                success:function(response){
                    var images='';
                    $.each(response,function(key,image){
                        images += '<a href="'+image.file_name+'"><img src="'+image.file_name+'" alt="..." style="height:150px; width:150px;"  class="img-thumbnail img-fluid"></a>'+"\n";
                    });
                    $('.popup-gallery').html(images);
                    $('#images-modal').modal('toggle');
                },
                error:function(response){
                    console.log(response);
                }
            });

      });


      $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function(item) {
                    return '<small>the initial status of broken phone</small>';
                }
            },
            callbacks: {
                open:function(){
                    $('#images-modal').modal('toggle');
                    console.log('fsdfsdf');
                },
                close:function(){
                    $('#images-modal').modal('toggle');
                }
            }
        });







  });
</script>

@stop