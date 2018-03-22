let changeCountry = (country) => {
    let country_id = country.value;
    $('.load_city').html('<i class="fa fa-spin fa-spinner"></i>');
    $('.load_store').html('<i class="fa fa-spin fa-spinner"></i>');

    let selectStore = $('form#filter').find('select#store');

    $.ajax({
        url: "/filter-ajax",
        type: "POST",
        data: {country_id : country_id, action : 'get_city_list'},
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var city = "<option value=''></option>";
            var books = "";

            for (var i = 0; i < response.cities.length; i++) {
                var id = response.cities[i].id,
                    city_name = response.cities[i].city_name,
                    country_id = response.cities[i].country_id;

                city += "<option value='"+id+"' data-country='"+country_id+"'>"+city_name+"</option>";
            }

            for (var i = 0; i < response.books.length; i++){
                var title = response.books[i].title,
                    slug = response.books[i].slug,
                    image = response.books[i].image;
                books += renderBook(title, slug, image)
            }

            $('form#filter').find('select#city').html(city);
            selectStore.html('');
            $('.load_city').html('');
            $('.load_store').html('');
            $('#list-books').after(preloader);
            setTimeout(function() {
                remove($('.preloader'));
                $('#list-books').html(books);
                }, 1000);
        }
    });
    return false;
};

let changeCity = (city) => {
    let city_id = city.value;
    $('.load_store').html('<i class="fa fa-spin fa-spinner"></i>');

    $.ajax({
        url: "/filter-ajax",
        type: "POST",
        data: {city_id : city_id, action : 'get_store_list'},
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var store = "<option value=''></option>";
            var books = "";
            for (var i = 0; i < response.stores.length; i++) {
                var id = response.stores[i].id,
                    store_name = response.stores[i].store_name,
                    city_id = response.stores[i].city_id;

                store += "<option value='"+id+"' data-city='"+city_id+"'>"+store_name+"</option>";
            }

            for (var i = 0; i < response.books.length; i++){
                var title = response.books[i].title,
                    slug = response.books[i].slug,
                    image = response.books[i].image;
                books += renderBook(title, slug, image)
            }

            $('form#filter').find('select#store').html(store);
            $('.load_store').html('');
            $('#list-books').after(preloader);
            setTimeout(function() {
                remove($('.preloader'));
                $('#list-books').html(books);
            }, 1000);
        }
    });
    return false;
};

let changeStore = (store) => {
    let store_id = store.value;
    $('.load_store').html('<i class="fa fa-spin fa-spinner"></i>');

    $.ajax({
        url: "/filter-ajax",
        type: "POST",
        data: {store_id : store_id, action : 'get_store_books'},
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var books = "";
            for (var i = 0; i < response.books.length; i++){
                var title = response.books[i].title,
                    slug = response.books[i].slug,
                    image = response.books[i].image;
                books += renderBook(title, slug, image)
            }
            $('.load_store').html('');
            $('#list-books').after(preloader);
            setTimeout(function() {
                remove($('.preloader'));
                $('#list-books').html(books);
            }, 1000);
        }
    });
    return false;
};



let changeGenre = function (event) {

    let genres = $('#filter input:checkbox:checked').map(function() {return this.value;}).get();

    genres = genres.join(',');

    $.ajax({
        url: "/filter-ajax",
        type: "POST",
        data: {genres : genres, action : 'get_genres_books'},
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            var books = "";
            for (var i = 0; i < response.books.length; i++){
                var title = response.books[i].title,
                    slug = response.books[i].slug,
                    image = response.books[i].image;
                books += renderBook(title, slug, image)
            }
            $('.load_store').html('');
            $('#list-books').after(preloader);
            setTimeout(function() {
                remove($('.preloader'));
                $('#list-books').html(books);
            }, 1000);
        }
    });
};

$('#find-title').submit(function (e) {
    e.preventDefault();
    var book_title = $('#find-title').find('input[name=book_title]').val();
    if(book_title.length < 4){
        $('#title-error').text('* В названии должно быть больше 3 символов');
    } else {
        $('#title-error').text('');
        e.target.submit();
    }
});

$('#find-author').submit(function (e) {
    e.preventDefault();
    var book_title = $('#find-author').find('input[name=author]').val();
    if(book_title.length < 4){
        $('#author-error').text('* В имени автора должно быть больше 3 символов');
    } else {
        $('#author-error').text('');
        e.target.submit();
    }
});



//Render card book
let renderBook = (title, slug, image) => {
    let book_card;
    return book_card = "<div class='col-sm-6 col-md-3 mt-4'>" +
        "                            <div class='card card-inverse card-info'>" +
        "                                <a href='/book/" +  slug + "'>" +
        "                                    <img class='card-img-top' src='" +  image + "' alt='" +  title + "'>" +
        "                                </a>" +
        "                                <div class='card-block'>" +
        "                                    <h4 class='card-title'>" +  title + "</h4>" +
        "                                </div>" +
        "                                <div class='card-footer'>" +
        "                                    <a href='/book/" +  slug + "' class='btn btn-info float-right btn-sm'>Посмотреть</a>" +
        "                                </div>" +
        "                            </div>" +
        "                        </div>"
};

/// Remove element
let remove = (elem) =>{
    elem.remove();
};


// Load preloader
var preloader = "<div class='preloader'><div class='spinner'><i class='fa fa-spin fa-spinner'></i></div></div>";


// Author autosuggest
$( function() {
    $(document).on('keyup', '#author', function (event) {
        console.log(event.target.value.length);
        if (event.target.value.length < 1) {
            return false;
        } else {
            var author = $('#author').val();

            $.ajax({
                url: "/search-author",
                type: "POST",
                data: {author: author},
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    let author_list = response.map(function(value) {return value.author_name;});
                    if (author_list.length > 0) {
                        $("#author").autocomplete({
                            source: author_list
                        });
                    }
                }
            });
        }
    });
});
