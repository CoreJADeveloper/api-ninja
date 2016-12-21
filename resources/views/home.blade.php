@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="author-box">
                            <div class="image">
                                <img width="90" height="85" src="{{URL::asset('assets/images/Tauhid.jpg')}}" class="img-circle" alt="">
                            </div>
                            <div class="info">
                                <p>I am CS graduated, have been working with web development for more than 5 years, love to work with new technology.</p><br>
                                <blockquote>
                                    "What I do believe, professionalism shouldn't be defined by only giving solution but faster and secure solution."
                                </blockquote>
                                <h6><a href="" title="">Tauhidul Alam |</a> Software Developer</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
