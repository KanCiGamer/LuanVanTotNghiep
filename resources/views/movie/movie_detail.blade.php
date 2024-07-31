@extends('layouts.home')

@section('noi-dung')

    <link rel="stylesheet" href="{{ asset('css/movie_detail.css') }}">
    <div class="container">


        <div class="movie-info" data-id="{{ $movie->movie_id }}">
            <div class="movie-poster">
                <img src="{{ asset('images/movies/' . $movie->poster) }}" alt="{{ $movie->movie_name }}">
            </div>
            <div class="movie-details">
                <h1>{{ $movie->movie_name }}</h1>
                <p class="center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                        class="bi bi-tags" viewBox="0 0 16 16">
                        <path
                            d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
                        <path
                            d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
                    </svg>
                    @foreach ($movie->categories as $category)
                        {{ $category->category_name }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>

                <p class="center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                        class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg> {{ $movie->time }}'</p>
                <p class="center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                        class="bi bi-globe-asia-australia" viewBox="0 0 16 16">
                        <path
                            d="m10.495 6.92 1.278-.619a.483.483 0 0 0 .126-.782c-.252-.244-.682-.139-.932.107-.23.226-.513.373-.816.53l-.102.054c-.338.178-.264.626.1.736a.48.48 0 0 0 .346-.027ZM7.741 9.808V9.78a.413.413 0 1 1 .783.183l-.22.443a.6.6 0 0 1-.12.167l-.193.185a.36.36 0 1 1-.5-.516l.112-.108a.45.45 0 0 0 .138-.326M5.672 12.5l.482.233A.386.386 0 1 0 6.32 12h-.416a.7.7 0 0 1-.419-.139l-.277-.206a.302.302 0 1 0-.298.52z" />
                        <path
                            d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M1.612 10.867l.756-1.288a1 1 0 0 1 1.545-.225l1.074 1.005a.986.986 0 0 0 1.36-.011l.038-.037a.88.88 0 0 0 .26-.755c-.075-.548.37-1.033.92-1.099.728-.086 1.587-.324 1.728-.957.086-.386-.114-.83-.361-1.2-.207-.312 0-.8.374-.8.123 0 .24-.055.318-.15l.393-.474c.196-.237.491-.368.797-.403.554-.064 1.407-.277 1.583-.973.098-.391-.192-.634-.484-.88-.254-.212-.51-.426-.515-.741a7 7 0 0 1 3.425 7.692 1 1 0 0 0-.087-.063l-.316-.204a1 1 0 0 0-.977-.06l-.169.082a1 1 0 0 1-.741.051l-1.021-.329A1 1 0 0 0 11.205 9h-.165a1 1 0 0 0-.945.674l-.172.499a1 1 0 0 1-.404.514l-.802.518a1 1 0 0 0-.458.84v.455a1 1 0 0 0 1 1h.257a1 1 0 0 1 .542.16l.762.49a1 1 0 0 0 .283.126 7 7 0 0 1-9.49-3.409Z" />
                    </svg> {{ $movie->nation }}</p>
                <p class="center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                        class="bi bi-chat-left-dots" viewBox="0 0 16 16">
                        <path
                            d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                        <path
                            d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                    </svg> {{ $movie->language }}</p>
                <p class="center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                        class="bi bi-person-check" viewBox="0 0 16 16">
                        <path
                            d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                        <path
                            d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                    </svg> {{ $movie->age_rating->description }}</p>
                <h3 class="title">MÔ TẢ:</h3>
                <p>Đạo diễn: {{ $movie->directors }}</p>
                <p>Diễn viên: {{ $movie->actor }}</p>
                <h3 class="title">NỘI DUNG PHIM:</h3>
                <p> {{ $movie->description }}</p>
                <p><strong>Trailer:</strong> <a href="{{ $movie->trailer_link }}" target="_blank"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-youtube" viewBox="0 0 16 16">
                            <path
                                d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z" />
                        </svg></a></p>
            </div>
        </div>

        <div class="showtimes" style="text-align: center;">
            @if ($showTimesGroupedByDate)
                <h2>LỊCH CHIẾU</h2>
                <div class="showtime-dates">
                    @foreach ($showTimesGroupedByDate as $date => $showTimes)
                        <div class="showtime-date" data-date="{{ $date }}"
                            data-target="#showtime-list-{{ \Illuminate\Support\Str::slug($date) }}">
                            {{ $date }}
                        </div>
                    @endforeach
                </div>
                <div id="cinema-list" style="display: flex; justify-content:center;max-width:100%;text-align:center;">
                    <ul class="cinema-list"
                        style="list-style-type: none;display:flex;flex-direction:column;gap:10px;text-align:center; width:80%;">

                    </ul>
                </div>
                <div id="showtime-detail" class="mt-5" style="margin-top:10px;"></div>
                <button id="pay-button" class="button-a">Đặt vé</button>
            @else
                <h2>HIỆN TẠI CHƯA CÓ LỊCH CHIẾU</h2>
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showtimeDates = document.querySelectorAll('.showtime-date');
            let currentShowtimeId = null;
            const movieId = $('.movie-info').data('id');
            showtimeDates.forEach(dateElement => {
                let isShowtimeListVisible = false;
                dateElement.addEventListener('click', () => {
                    const date = dateElement.getAttribute('data-date');
                    $.ajax({
                        url: `/showtimes/${movieId}/${date}`,
                        success: function(cinemas) {
                            $('.cinema-list').empty();
                            if (cinemas.length > 0) {
                                cinemas.forEach(cinema => {
                                    let cinemaItem =
                                        `<li>
                                        <div class="cinema-item" data-cinema-id="${cinema.cinema_id}"
                                        style="display: flex; justify-content: space-between; align-items: center; cursor: pointer; padding: 24px;">
                                            <h4>${cinema.name}</h4>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                            </svg>
                                        </div>
                                        <div class="show-time-list" style="padding: 24px;">
                                            <p class="addr" style="text-align: left;">${cinema.address}</p>
                                            <ul style="list-style-type: none;">
                                                <li>
                                                    <div></div>
                                                        <ul style="list-style-type: none; align-items: center; display: flex; flex-wrap: wrap; gap: 1.2rem; margin-top: 1.2rem;">`;
                                    cinema.cinema_rooms.forEach(room => {
                                        room.show_times.forEach(
                                            showtime => {
                                                let startTime =
                                                    new Date(
                                                        '1970-01-01T' +
                                                        showtime
                                                        .start_time +
                                                        'Z'
                                                    ); // Tạo đối tượng Date từ chuỗi thời gian
                                                let formattedTime =
                                                    startTime
                                                    .getUTCHours() +
                                                    ':' + ('0' +
                                                        startTime
                                                        .getUTCMinutes()
                                                    ).slice(-2);
                                                cinemaItem +=
                                                    `<li class="showtime-link" data-id="${showtime.showtime_id}"  style="border: .5px solid #f8fafc; border-radius: .4rem; cursor: pointer; line-height: 100%; padding: .8rem 1.2rem; transition: all .3s;">
                                                    ${formattedTime}
                                                </li>`;
                                            });
                                    });

                                    cinemaItem +=
                                        `</ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>`;

                                    $('.cinema-list').append(cinemaItem);
                                    showCinemadt();
                                    showTimedt();
                                });
                            } else {
                                $('.cinema-list').append('<li>Không có rạp nào.</li>');
                            }
                        }
                    });

                    // console.log(movieId);
                    showtimeDates.forEach(el => el.classList.remove('active'));

                    dateElement.classList.add('active');
                    const targetListId = dateElement.getAttribute('data-target');

                    // document.querySelector(targetListId).classList.add('active');
                });
            });

            function showCinemadt() {
                const showcinemadt = document.querySelectorAll('.cinema-item');
                showcinemadt.forEach(item => {
                    item.addEventListener('click', function(event) {
                        const showtimeList = item.querySelector('.show-time-list');

                        // Loại bỏ lớp 'active' từ các phần tử khác
                        showcinemadt.forEach(otherItem => {
                            if (otherItem !== item) {
                                const otherShowtimeList = otherItem.querySelector(
                                    '.show-time-list');
                                if (otherShowtimeList) {
                                    otherShowtimeList.classList.remove('active');
                                }
                                otherItem.classList.remove('active');
                            }
                        });

                        // Thêm hoặc loại bỏ lớp 'active' cho phần tử được nhấp
                        showtimeList.classList.toggle('active');
                        item.classList.toggle('active');
                    });
                });
            }

            function showTimedt() {
                // Xử lý khi click vào suất chiếu
                const showtimeDt = document.querySelectorAll('.showtime-link');
                showtimeDt.forEach(link => {
                    link.addEventListener('click', function(event) {
                        console.log("test");
                        // event.preventDefault();
                        currentShowtimeId = this.getAttribute('data-id');

                        // Gửi AJAX request để lấy chi tiết suất chiếu và hiển thị ghế
                        fetch(`/showtimedetail/${currentShowtimeId}`)
                            .then(response => response.json())
                            .then(data => {
                                displayShowtimeDetails(data);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    });
                });
            }

            function displayShowtimeDetails(data) {
                const showtimeDetail = document.getElementById('showtime-detail');
                let detailHtml = `
                                
                                
                                <h5>Danh sách ghế:</h5>
                                <div class="arc">
                                    <p style="color: white;text-align: center;">Màn hình</p></div>
                                <div class="seat-map"> 
                            `;
                // <h3>Chi tiết suất chiếu</h3>
                //     <h4>Phim: ${data.showtime.movie.movie_name}</h4>
                // <p>Ngày: ${data.showtime.start_date}</p>
                //     <p>Giờ: ${data.showtime.start_time}</p>

                const rowMap = 'ACBDEFGHIJKLMNOPQRSTUVWXYZ';
                const soldSeats = data.soldSeats;
                const reservedSeats = data.reservedSeats;
                let currentRow = null;

                data.showtime.cinema_room.seat.forEach(seat => {
                    const rowLetter = seat.seat_name.charAt(0);
                    const colNumber = parseInt(seat.seat_name.slice(1));

                    if (currentRow !== rowLetter) {
                        if (currentRow !== null) {
                            detailHtml += `</div>`;
                        }
                        detailHtml += `<div class="seat-row">`;
                        currentRow = rowLetter;
                    }

                    let seatStatusClass = '';
                    if (soldSeats.includes(seat.seat_id)) {
                        seatStatusClass = 'sold';
                    } else if (reservedSeats.includes(seat.seat_id)) {
                        seatStatusClass = 'reserved';
                    }

                    detailHtml +=
                        `<div class="seat ${seatStatusClass}" data-seat-id="${seat.seat_id}">${seat.seat_name}</div>`;
                });

                if (currentRow !== null) {
                    detailHtml += `</div>`;
                }
                // <div class="seat-legend">
                //         <div class="legend-item">
                //             <div class="seat"></div> Ghế trống
                //         </div>
                //         <div class="legend-item">
                //             <div class="seat selected">A01</div> Ghế đang chọn
                //         </div>
                //         <div class="legend-item">
                //             <div class="seat reserved"></div> Ghế đã đặt
                //         </div>
                //     </div>
                detailHtml += `</div>`; // đóng div .seat-map
                showtimeDetail.innerHTML = detailHtml;

                // Xử lý sự kiện click cho ghế
                const seats = document.querySelectorAll('.seat');
                seats.forEach(seat => {
                    seat.addEventListener('click', function() {
                        if (this.classList.contains('sold') || this.classList.contains(
                                'reserved')) {
                            return; // Không cho chọn ghế đã bán hoặc đã đặt
                        }

                        this.classList.toggle('selected');
                    });
                });
                const seatMapWidth = document.querySelector('.seat-map').offsetWidth;
                document.querySelector('.arc').style.width = seatMapWidth + 'px';
            }


            const payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                const selectedSeats = document.querySelectorAll('.seat.selected');
                const seatIds = Array.from(selectedSeats).map(seat => seat.getAttribute(
                    'data-seat-id'));

                if (!currentShowtimeId) {
                    alert('Vui lòng chọn suất chiếu.');
                    return;
                }

                if (seatIds.length === 0) {
                    alert('Vui lòng chọn ít nhất một ghế.');
                    return;
                }

                const requestData = {
                    showtime_id: currentShowtimeId,
                    seats: seatIds,
                };

                // Gửi AJAX request đến server để xử lý đặt vé
                fetch('/book-ticket', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(requestData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Chuyển hướng đến trang thanh toán hoặc hiển thị thông báo thành công
                            window.location.href = '/payment-information';
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
{{-- //     const rowMap = 'ACBD'; 
            //     const soldSeats = data.soldSeats;
            //     const reservedSeats = data.reservedSeats;

            //     let detailHtml = '<div class="seat-row">';
            //     let currentRow = null;

            //     // Tạo một object để lưu các ghế theo hàng
            //     let seatsByRow = {};
            //     data.showtime.cinema_room.seat.forEach(seat => {
            //         const rowLetter = seat.seat_name.charAt(0);
            //         if (!seatsByRow[rowLetter]) {
            //             seatsByRow[rowLetter] = [];
            //         }
            //         seatsByRow[rowLetter].push(seat);
            //     });

            //     // Duyệt qua các hàng theo thứ tự mong muốn và xây dựng HTML
            //     let rowCounter = 0;
            //     rowMap.split('').forEach(rowLetter => {
            //         const seats = seatsByRow[rowLetter] || [];
            //         seats.sort((a, b) => a.seat_name.localeCompare(b.seat_name)); 

            //         if (seats.length > 0) {
            //             if (rowCounter % 2 === 0 && currentRow !== null) {
            //                 detailHtml += `</div><div class="seat-row">`;
            //             }

            //             seats.forEach(seat => {
            //                 let seatStatusClass = '';
            //                 if (soldSeats.includes(seat.seat_id)) {
            //                     seatStatusClass = 'sold';
            //                 } else if (reservedSeats.includes(seat.seat_id)) {
            //                     seatStatusClass = 'reserved';
            //                 }

            //                 detailHtml +=
            //                     `<div class="seat ${seatStatusClass}" data-seat-id="${seat.seat_id}">${seat.seat_name}</div>`;
            //             });

            //             currentRow = rowLetter;
            //             rowCounter++;
            //         }
            //     });

            //     if (currentRow !== null) {
            //         detailHtml += `</div>`;
            //     }

            //     detailHtml += `</div><div class="seat-legend">
        //                     <div class="legend-item">
        //                 <div class="seat"></div> Ghế trống
        //                 </div>
        //                 <div class="legend-item">
        //                 <div class="seat selected">A01</div> Ghế đang chọn
        //                 </div>
        //                 <div class="legend-item">
        //                 <div class="seat reserved"></div> Ghế đã đặt
        //                 </div>
        //                 </div>`;

            //     showtimeDetail.innerHTML = detailHtml;

            //     // Xử lý sự kiện click cho ghế
            //     const seats = document.querySelectorAll('.seat');
            //     seats.forEach(seat => {
            //         seat.addEventListener('click', function() {
            //             if (this.classList.contains('sold') || this.classList.contains(
            //                 'reserved')) {
            //                 return; // Không cho chọn ghế đã bán hoặc đã đặt
            //             }

            //             this.classList.toggle('selected');
            //         });
            //     });
            //     const seatMapWidth = document.querySelector('.seat-map').offsetWidth;
            //     document.querySelector('.arc').style.width = seatMapWidth + 'px';
            // } --}}
