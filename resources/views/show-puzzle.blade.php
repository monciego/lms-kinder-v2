<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hello {{ Auth::user()->name }} !
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg c-container">
                <div class="bg-white">
                                                    
                                                 
                     <div class="mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h3 class="m-0 font-weight-bold text-primary fw-bold">Puzzle</h3>
                          
                        </div>
                        <ul id="save_errlist"></ul>
                        
                        <div class="card-body relative">
                            <img src="{{ url('uploads/puzzle/'.$puzzle[0]->image) }}" id="puzzle_image" srcset="" class="d-none">
                            
                            <h4 class="text-center">{{  $puzzle[0]->title }} </h4>
                            <p class="text-center text-md m-0">Uploaded: {{ Carbon\carbon::parse($puzzle[0]->created_at)->format('d/m/Y g:i A') }} </p>
                            <p class="text-center text-md m-0 pb-3">Deadline: {{ Carbon\carbon::parse($puzzle[0]->deadline)->format('d/m/Y g:i A') }} </p>
                            @if($count > 0)
                            <p class="text-center text-md m-0 pb-3">Score: {{ $response[0]->score }} </p>
                            @endif
                            <div class="d-flex">
                                <div class="d-flex justify-center items-center flex-column">
                                    <p class="m-0"> Preview </p>
                                    <div id="previews"></div>
                                </div>
                                <div class="d-flex justify-center items-center flex-column">
                                    @if($count == 0)
                                        <p class="m-0"> Puzzle </p>
                                        <div id="canvas"></div>
                                    @else 
                                        <p class="m-0"> Your work </p>
                                        <div id="previews"> <img src="{{ $response[0]->image }}" class="d-block mini"> </div>
                                    @endif
                                </div>
                            </div>
                            @if(Auth::user()->hasRole('student'))
                                @if($count == 0)
                                    <form method="POST" enctype="multipart/form-data" id="store-puzzle-response" action="javascript:void(0)" >
                                        <input type="hidden" name="puzzle_id" id="puzzle_id">
                                        <input type="hidden" name="puzzle_image" id="puzzle_image">
                                        <button type="submit" class="btn btn-primary w-full px-5 submit-response" value="{{ $puzzle[0]->id }}">Submit </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                    <!-- /table -->
                    
                </div>
            </div>
        </div>
    </div>

<style>
    #canvas {
        width: 336px;
        height: 335px;
        border: 1px solid gray;
        background-color: black; 
        margin: 0 3rem 3rem 3rem;
    }
    #canvas #windiv {
        display: none; 
    }
    #canvas .banner {
        width: 370px;
        font-size: 50px;
        background-color: #f5f5dc;
        position: relative;
        text-align: center;
        top: -60px;
        box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.55);
        left: -15px;
        z-index: 2; 
    }
    #canvas .innerSquare {
        width: 110px;
        height: 110px;
        float: left; 
    }
    #canvas .innerSquare.imageSquare {
        font-size: 24px;
        text-align: center;
        border: 1px outset  black; 
    }
    #canvas .innerSquare.imageSquare:hover {
        background-color: lightgray; 
    }
    #canvas .innerSquare.clickable:hover {
        opacity: 0.4;
        filter: alpha(opacity=40); 
    }
    #canvas .innerSquare.blank {
        border: 1px inset black; 
    }
    #previews {
        display: flex; 
        width: fit-content;
        height: fit-content;
        max-width: 100%; 
        max-height: 100%; 
        margin: 0 3rem 3rem 3rem;
    }
    #previews .mini {
        width: 335px;
        height: 335px;
    }


</style>

@section('scripts')
<script>   
    $(document).ready(function () {
        (function() {
            var Blank, Puzzle, Tile,
                __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

                Puzzle = (function() {
                function Puzzle(images) {
                var i, image, t, x, y, _i, _j, _len, _ref,
                    _this = this;
                this.images = images;
                this.changeImage = __bind(this.changeImage, this);
                this.switchTwo = __bind(this.switchTwo, this);
                this.renderBoard = __bind(this.renderBoard, this);
                this.blankPosition = __bind(this.blankPosition, this);
                this.checkIfWon = __bind(this.checkIfWon, this);
                this.mixup = __bind(this.mixup, this);
                this.places = [];
                this.initialPlaces = [];
                _ref = this.images;
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    image = _ref[_i];
                    $('#previews').append('<img src="' + image + '" class="mini"/>');
                }
                this.image = this.images[0];
                $('.mini').bind('click', function(event) {
                    return _this.changeImage(event.target.src);
                });
                for (i = _j = 0; _j <= 7; i = ++_j) {
                    x = Math.floor(i % 3) * 110;
                    y = Math.floor(i / 3) * 110;
                    t = new Tile(i, 110, 110, x, y, this.image);
                    this.places.push(t);
                }
                this.places.push(new Blank(8));
                this.initialPlaces = this.places.slice(0);
                this.mixup();
                }

                Puzzle.prototype.mixup = function() {
                var blankpos, i, randomNum, _i, _results;
                blankpos = 8;
                _results = [];
                for (i = _i = 0; _i <= 10; i = ++_i) {
                    randomNum = Math.floor(Math.random() * 9);
                    this.switchTwo(randomNum, blankpos);
                    _results.push(blankpos = randomNum);
                }
                return _results;
                };

                Puzzle.prototype.checkIfWon = function() {
                var i, _i;
                for (i = _i = 0; _i <= 8; i = ++_i) {
                    if (this.places[i] === this.initialPlaces[i]) {
                    continue;
                    } else {
                    return false;
                    }
                }
                return true;
                };

                Puzzle.prototype.blankPosition = function() {
                var place, pos, _i, _len, _ref;
                _ref = this.places;
                for (pos = _i = 0, _len = _ref.length; _i < _len; pos = ++_i) {
                    place = _ref[pos];
                    if (place["class"] === 'Blank') {
                    return pos;
                    }
                }
                };

                Puzzle.prototype.renderBoard = function() {
                var blank, t, _i, _len, _ref,
                    _this = this;
                blank = this.blankPosition();
                $('#canvas').html('');
                if (this.checkIfWon()) {
                    $('#canvas').append('<span id="windiv"><img style="width: 336px; height: 335px; display: block;" src="' + this.image + '"/><div class="banner"> You Won!</div></span>');
                    return $('#windiv').show('slow');
                } else {
                    _ref = this.places;
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    t = _ref[_i];
                    t.show(blank);
                    }
                    return $('.clickable').bind('click', function(event) {
                    var toSwitch;
                    toSwitch = parseInt(event.target.id);
                    return _this.switchTwo(toSwitch, _this.blankPosition());
                    });
                }
                };

                Puzzle.prototype.switchTwo = function(pos1, pos2) {
                var x, y;
                x = this.places[pos1];
                y = this.places[pos2];
                this.places[pos2] = x;
                this.places[pos1] = y;
                this.places[pos2].position = pos2;
                return this.renderBoard();
                };

                Puzzle.prototype.changeImage = function(image) {
                var panel, _i, _len, _ref;
                this.image = image;
                _ref = this.places;
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    panel = _ref[_i];
                    if (panel["class"] !== 'Blank') {
                    panel.image = image;
                    }
                }
                return this.renderBoard();
                };

                return Puzzle;

            })();

            Tile = (function() {
                function Tile(position, width, height, x, y, image) {
                this.position = position;
                this.width = width;
                this.height = height;
                this.x = x;
                this.y = y;
                this.image = image;
                this["class"] = 'Tile';
                }

                Tile.prototype.show = function(blankPosition) {
                if (this.isAdjacent(blankPosition)) {
                    $('#canvas').append('<div id="' + this.position + '" class="innerSquare imageSquare clickable"></div>');
                } else {
                    $('#canvas').append('<div id="' + this.position + '" class="innerSquare imageSquare"></div>');
                }
                $("#" + this.position).css('background-position', '-' + this.x + 'px -' + this.y + 'px');
                return $("#" + this.position).css('background-image', 'url(' + this.image + ')');
                };

                Tile.prototype.isAdjacent = function(blanksPosition) {
                if (blanksPosition - 1 === this.position && (blanksPosition % 3) > 0 || blanksPosition + 1 === this.position && (blanksPosition % 3) < 2 || blanksPosition + 3 === this.position && (blanksPosition / 3) < 2 || blanksPosition - 3 === this.position && (blanksPosition / 3) > 0) {
                    return true;
                }
                return false;
                };

                Tile.prototype.setImage = function(image) {
                return this.image = image;
                };

                return Tile;

            })();

            Blank = (function() {
                function Blank(position) {
                this.position = position;
                this["class"] = 'Blank';
                }

                Blank.prototype.show = function() {
                return $('#canvas').append('<div class="innerSquare blank"></div>');
                };

                return Blank;

            })();

            $(document).ready(function() {
                var imgs, puzzle;
                imgs = [$('#puzzle_image').attr('src')];
                return puzzle = new Puzzle(imgs);
            });

        }).call(this);
        
        
        $(document).on('click', '.innerSquare', function (e) {
            e.preventDefault();
            html2canvas($('#canvas')[0]).then(function (canvas) { 
                
                $('#puzzle_image').val(canvas.toDataURL("image/png"));
                
            });
        });
        
        
        
        $(document).on('submit', '#store-puzzle-response', function (e) {
            e.preventDefault();
            
            $('#puzzle_id').val($('.submit-response').val());
            
             // ajax
                
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                
            // var formData = new FormData($('#store-puzzle-response')[0]);
            var data = { 
                'puzzle_image': $('#puzzle_image').val(), 
                'puzzle_id': $('#puzzle_id').val(),
            }   
            
            var url = '{{ route("store-puzzle-responses") }}';
            $.ajax({
                type: "POST",
                url: url, 
                data: data,
                dataType: "json",
                success: function (response) {
                        console.log(response);
                        if(response.status == 400) { 
                            // $('#save_errlist').html("");
                            // $('#save_errlist').addClass("alert alert-danger mx-5 mt-4");
                            // $.each(response.errors, function (key, error_values) { 
                            //     $('#save_errlist').append('<li>'+ error_values +'</li>')
                            // });
                        }
                        else { 
                            $('#save_errlist').html("");
                            $('#save_errlist').removeClass("alert alert-danger mx-5 mt-4");
                            Swal.fire(
                                'Good job!',
                                response.message,
                                'success'
                            )
                            window.location.reload();
                        }
                }
            });
            
            // ajax
            
            
        });
    
    });
</script>
@endsection
</x-app-layout>

