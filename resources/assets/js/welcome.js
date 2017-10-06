$(document).ready(function () {
    var names = ["aleksandra", "anielka", "radek", "joanna", "paulina", "tomasz", "jurek", "damian"],
        i = 0;

    function change() {
        if (i != names.length) {
            $("#isthisweird").removeClass();
            $("#isthisweird").addClass(names[i]);
            $("h1").html(names[i]);
            i++;
        } else {
            $("#isthisweird").removeClass();
            $("#isthisweird").addClass(names[0]);
            $("h1").html(names[0]);
            i = 0;
        }
    };

    var timer = setInterval(function () {
        change()
    }, 350);

    $("#isthisweird").hover(function () {
        clearInterval(timer);
    }, function () {
        timer = setInterval(function () {
            change()
        }, 350);
    });
});

function switchClass(i) {
    var lis = $('#home-news > div');
    lis.eq(i).removeClass('home_header_on');
    lis.eq(i).removeClass('home_header_out');
    lis.eq(i = ++i % lis.length).addClass('home_header_on');
    lis.eq(i = ++i % lis.length).addClass('home_header_out');
    setTimeout(function () {
        switchClass(i);
    }, 3500);
}

$(window).on('load', function () {
    switchClass(-1);
});