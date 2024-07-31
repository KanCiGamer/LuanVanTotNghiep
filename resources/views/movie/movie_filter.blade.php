@extends('layouts.home')

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <div class="container" style="margin-top:20px; margin-bottom: 100px">
        <div>
            <div class="owl-carousel owl-theme content" >
                @if($showtimes)
                @foreach ($showtimes as $showtime)
                @php
                    $movie = $showtime->movie;
                @endphp  
                <a href="{{ route('MovieDetail', ['id' => $movie->movie_id]) }}" class="movie-link">
                    <div class="movie-container">
                        <img src="{{ asset('images/movies/' . $movie->poster) }}" alt="{{ $movie->movie_name }}">
                        <div class="content-movie">
                            <p class="movie-title">{{ $movie->movie_name }}</p>
                            <div class="infor-movie">
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow"
                                        class="bi bi-tags" viewBox="0 0 16 16">
                                        <path
                                            d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
                                        <path
                                            d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
                                    </svg>
                                    @foreach ($movie->categories as $value)
                                        {{ $value->category_name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow"
                                        class="bi bi-clock" viewBox="0 0 16 16">
                                        <path
                                            d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                                    </svg> {{ $movie->time }}'
                                </p>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow"
                                        class="bi bi-globe-asia-australia" viewBox="0 0 16 16">
                                        <path
                                            d="m10.495 6.92 1.278-.619a.483.483 0 0 0 .126-.782c-.252-.244-.682-.139-.932.107-.23.226-.513.373-.816.53l-.102.054c-.338.178-.264.626.1.736a.48.48 0 0 0 .346-.027ZM7.741 9.808V9.78a.413.413 0 1 1 .783.183l-.22.443a.6.6 0 0 1-.12.167l-.193.185a.36.36 0 1 1-.5-.516l.112-.108a.45.45 0 0 0 .138-.326M5.672 12.5l.482.233A.386.386 0 1 0 6.32 12h-.416a.7.7 0 0 1-.419-.139l-.277-.206a.302.302 0 1 0-.298.52z" />
                                        <path
                                            d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M1.612 10.867l.756-1.288a1 1 0 0 1 1.545-.225l1.074 1.005a.986.986 0 0 0 1.36-.011l.038-.037a.88.88 0 0 0 .26-.755c-.075-.548.37-1.033.92-1.099.728-.086 1.587-.324 1.728-.957.086-.386-.114-.83-.361-1.2-.207-.312 0-.8.374-.8.123 0 .24-.055.318-.15l.393-.474c.196-.237.491-.368.797-.403.554-.064 1.407-.277 1.583-.973.098-.391-.192-.634-.484-.88-.254-.212-.51-.426-.515-.741a7 7 0 0 1 3.425 7.692 1 1 0 0 0-.087-.063l-.316-.204a1 1 0 0 0-.977-.06l-.169.082a1 1 0 0 1-.741.051l-1.021-.329A1 1 0 0 0 11.205 9h-.165a1 1 0 0 0-.945.674l-.172.499a1 1 0 0 1-.404.514l-.802.518a1 1 0 0 0-.458.84v.455a1 1 0 0 0 1 1h.257a1 1 0 0 1 .542.16l.762.49a1 1 0 0 0 .283.126 7 7 0 0 1-9.49-3.409Z" />
                                    </svg> {{ $movie->nation }}
                                </p>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow"
                                        class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                        <path
                                            d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                    </svg> {{ $movie->language }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <p
                        style="margin-top:10px; font-weight: bold; overflow: hidden; text-overflow: ellipsis; text-align:center; line-height:1.8; font-size: 20px;display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                        {{ $movie->movie_name }}
                    </p>
                </a>
            @endforeach
            
                   
                @else
                <div>
                    <p >Không tìm thấy phim</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: false,
                margin: 5,
                nav: false,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });

        });
    </script>
@endsection
