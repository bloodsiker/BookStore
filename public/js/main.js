// Filters
let applyFilter = function (event) {

    let _form = $('form#filter');
    let element = event.target.attributes.name.value;

    let onChangeCountry = false;
    if(element == 'country'){
        $('.load_city').html('<i class="fa fa-spin fa-spinner"></i>');
        onChangeCountry = true;
        _form.find('select#city').html('');
        _form.find('select#store').html('');
    }
    let onChangeCity = false;
    if(element == 'city'){
        $('.load_store').html('<i class="fa fa-spin fa-spinner"></i>');
        onChangeCity = true;
        _form.find('select#store').html('');
    }

    let selectCountry = null;
    let selectCity = null;
    let selectStore = null;
    let changeGenres = null;
    selectCountry = _form.find('select#country').val();
    selectCity = _form.find('select#city').val();
    selectStore = _form.find('select#store').val();

    changeGenres = $('#filter input:checkbox:checked').map(function() { return this.value;}).get().join(',');

    console.log(changeGenres);

    let filter = {country_id: selectCountry, city_id: selectCity, store_id: selectStore, genres: changeGenres};
    console.log(filter);


    $.ajax({
        url: "/filter-ajax",
        type: "POST",
        data: filter,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            if(selectCountry && onChangeCountry){

                var city = "<option value=''></option>";

                for (var i = 0; i < response.cities.length; i++) {
                    var id = response.cities[i].id,
                        city_name = response.cities[i].city_name,
                        country_id = response.cities[i].country_id;

                    city += "<option value='"+id+"' data-country='"+country_id+"'>"+city_name+"</option>";
                }
                _form.find('select#city').html(city);
                _form.find('select#store').html('');
                $('.load_city').html('');
            }

            if(selectCity && onChangeCity){
                var store = "<option value=''></option>";

                for (var i = 0; i < response.stores.length; i++) {
                    var id = response.stores[i].id,
                        store_name = response.stores[i].store_name,
                        city_id = response.stores[i].city_id;

                    store += "<option value='"+id+"' data-city='"+city_id+"'>"+store_name+"</option>";
                }
                _form.find('select#store').html(store);
                $('.load_store').html('');
            }

            let books = "";
            let successBooks = response.books.length;
            if(successBooks > 0){
                for (var i = 0; i < successBooks; i++){
                    var title = response.books[i].title,
                        slug = response.books[i].slug,
                        image = response.books[i].image;
                    books += renderBook(title, slug, image)
                }
            } else {
                books = "<div class='col-md-12 text-center mt-4'><h2>По заданным параметрам книг не найдено</h2></div>";
            }

            $('#list-books').after(preloader);
            setTimeout(function() {
                remove($('.preloader'));
                $('#list-books').html(books);
            }, 1000);
        }
    });
};

// validate Book Title
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


// validate Author
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
    return  `<div class='col-sm-6 col-md-3 mt-4'>
                <div class='card card-inverse card-info'>
                    <a href='/book/${slug}'>
                        <img class='card-img-top' src='${image}' alt='${title}'>
                    </a>
                    <div class='card-block'>
                        <h4 class='card-title'>${title}</h4>
                    </div>
                    <div class='card-footer'>
                        <a href='/book/${slug}' class='btn btn-info float-right btn-sm'>Посмотреть</a>
                    </div>
                </div>
            </div>`
};

/// Remove element
const remove = elem => elem.remove();


// Load preloader
const preloader = "<div class='preloader'><div class='spinner'><i class='fa fa-spin fa-spinner'></i></div></div>";


// Author autosuggest
$( function() {

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
});