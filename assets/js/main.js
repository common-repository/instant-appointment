jQuery(document).ready(function ($) {

    "use strict";
    !function () {
        if ($(".dropdown-menu a.dropdown-toggle").length && $(".dropdown-menu a.dropdown-toggle").on("click", (function (e) {
            return $(this).next().hasClass("show") || $(this).parents(".dropdown-menu").first().find(".show").removeClass("show"),
                $(this).next(".dropdown-menu").toggleClass("show"),
                $(this).parents("li.nav-item.dropdown.show").on("hidden.bs.dropdown", (function (e) {
                    $(".dropdown-submenu .show").removeClass("show")
                }
                )),
                !1
        }
        )),
            $("#nav-toggle").length && $("#nav-toggle").on("click", (function (e) {
                e.preventDefault(),
                    $("#main-wrapper").toggleClass("toggled")
            }
            )),
            $('[data-bs-toggle="tooltip"]').length)
            [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map((function (e) {
                return new bootstrap.Tooltip(e)
            }
            ));
        if ($('[data-bs-toggle="popover"]').length)
            [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map((function (e) {
                return new bootstrap.Popover(e)
            }
            ));
        if ($(".toast").length)
            [].slice.call(document.querySelectorAll(".toast")).map((function (e) {
                return new bootstrap.Toast(e)
            }
            ));
        if ($(".offcanvas").length)
            [].slice.call(document.querySelectorAll(".offcanvas")).map((function (e) {
                return new bootstrap.Offcanvas(e)
            }
            ));


        if ($("#insapp_service_editor").length)
           var quill = new Quill("#insapp_service_editor", {
                modules: {
                    toolbar: [[{
                        header: [1, 2, !1]
                    }], [{
                        font: []
                    }], ["bold", "italic", "underline", "strike"], [{
                        size: ["small", !1, "large", "huge"]
                    }], [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }], [{
                        color: []
                    }, {
                        background: []
                    }, {
                        align: []
                    }], ["link", "image", "code-block", "video"]]
                },
                theme: "snow"
            });
            const limit = 1000;

        if(quill){
            quill.on('text-change', function (delta, old, source) {
                if (quill.getLength() > limit) {
                    quill.deleteText(limit, quill.getLength());
                }
                });
        }

        //   var input = document.querySelector('textarea[name=insapp_tags]'),
        //   tagify = new Tagify(input, {
        //       enforceWhitelist : true,
        //       delimiters       : null,
        //       whitelist        : ["The Shawshank Redemption", "The Godfather", "The Godfather: Part II", "The Dark Knight", "12 Angry Men", "Schindler's List", "Pulp Fiction", "The Lord of the Rings: The Return of the King", "The Good, the Bad and the Ugly", "Fight Club", "The Lord of the Rings: The Fellowship of the Ring", "Star Wars: Episode V - The Empire Strikes Back", "Forrest Gump", "Inception", "The Lord of the Rings: The Two Towers", "One Flew Over the Cuckoo's Nest", "Goodfellas", "The Matrix", "Seven Samurai", "Star Wars: Episode IV - A New Hope", "City of God", "Se7en", "The Silence of the Lambs", "It's a Wonderful Life", "The Usual Suspects", "Life Is Beautiful", "Léon: The Professional", "Spirited Away", "Saving Private Ryan", "La La Land", "Once Upon a Time in the West", "American History X", "Interstellar", "Casablanca", "Psycho", "City Lights", "The Green Mile", "Raiders of the Lost Ark", "The Intouchables", "Modern Times", "Rear Window", "The Pianist", "The Departed", "Terminator 2: Judgment Day", "Back to the Future", "Whiplash", "Gladiator", "Memento", "Apocalypse Now", "The Prestige", "The Lion King", "Alien", "Dr. Strangelove or: How I Learned to Stop Worrying and Love the Bomb", "Sunset Boulevard", "The Great Dictator", "Cinema Paradiso", "The Lives of Others", "Paths of Glory", "Grave of the Fireflies", "Django Unchained", "The Shining", "WALL·E", "American Beauty", "The Dark Knight Rises", "Princess Mononoke", "Aliens", "Oldboy", "Once Upon a Time in America", "Citizen Kane", "Das Boot", "Witness for the Prosecution", "North by Northwest", "Vertigo", "Star Wars: Episode VI - Return of the Jedi", "Reservoir Dogs", "M", "Braveheart", "Amélie", "Requiem for a Dream", "A Clockwork Orange", "Taxi Driver", "Lawrence of Arabia", "Like Stars on Earth", "Double Indemnity", "To Kill a Mockingbird", "Eternal Sunshine of the Spotless Mind", "Toy Story 3", "Amadeus", "My Father and My Son", "Full Metal Jacket", "The Sting", "2001: A Space Odyssey", "Singin' in the Rain", "Bicycle Thieves", "Toy Story", "Dangal", "The Kid", "Inglourious Basterds", "Snatch", "Monty Python and the Holy Grail", "Hacksaw Ridge", "3 Idiots", "L.A. Confidential", "For a Few Dollars More", "Scarface", "Rashomon", "The Apartment", "The Hunt", "Good Will Hunting", "Indiana Jones and the Last Crusade", "A Separation", "Metropolis", "Yojimbo", "All About Eve", "Batman Begins", "Up", "Some Like It Hot", "The Treasure of the Sierra Madre", "Unforgiven", "Downfall", "Raging Bull", "The Third Man", "Die Hard", "Children of Heaven", "The Great Escape", "Heat", "Chinatown", "Inside Out", "Pan's Labyrinth", "Ikiru", "My Neighbor Totoro", "On the Waterfront", "Room", "Ran", "The Gold Rush", "The Secret in Their Eyes", "The Bridge on the River Kwai", "Blade Runner", "Mr. Smith Goes to Washington", "The Seventh Seal", "Howl's Moving Castle", "Lock, Stock and Two Smoking Barrels", "Judgment at Nuremberg", "Casino", "The Bandit", "Incendies", "A Beautiful Mind", "A Wednesday", "The General", "The Elephant Man", "Wild Strawberries", "Arrival", "V for Vendetta", "Warrior", "The Wolf of Wall Street", "Manchester by the Sea", "Sunrise", "The Passion of Joan of Arc", "Gran Torino", "Rang De Basanti", "Trainspotting", "Dial M for Murder", "The Big Lebowski", "The Deer Hunter", "Tokyo Story", "Gone with the Wind", "Fargo", "Finding Nemo", "The Sixth Sense", "The Thing", "Hera Pheri", "Cool Hand Luke", "Andaz Apna Apna", "Rebecca", "No Country for Old Men", "How to Train Your Dragon", "Munna Bhai M.B.B.S.", "Sholay", "Kill Bill: Vol. 1", "Into the Wild", "Mary and Max", "Gone Girl", "There Will Be Blood", "Come and See", "It Happened One Night", "Life of Brian", "Rush", "Hotel Rwanda", "Platoon", "Shutter Island", "Network", "The Wages of Fear", "Stand by Me", "Wild Tales", "In the Name of the Father", "Spotlight", "Star Wars: The Force Awakens", "The Nights of Cabiria", "The 400 Blows", "Butch Cassidy and the Sundance Kid", "Mad Max: Fury Road", "The Maltese Falcon", "12 Years a Slave", "Ben-Hur", "The Grand Budapest Hotel", "Persona", "Million Dollar Baby", "Amores Perros", "Jurassic Park", "The Princess Bride", "Hachi: A Dog's Tale", "Memories of Murder", "Stalker", "Nausicaä of the Valley of the Wind", "Drishyam", "The Truman Show", "The Grapes of Wrath", "Before Sunrise", "Touch of Evil", "Annie Hall", "The Message", "Rocky", "Gandhi", "Harry Potter and the Deathly Hallows: Part 2", "The Bourne Ultimatum", "Diabolique", "Donnie Darko", "Monsters, Inc.", "Prisoners", "8½", "The Terminator", "The Wizard of Oz", "Catch Me If You Can", "Groundhog Day", "Twelve Monkeys", "Zootopia", "La Haine", "Barry Lyndon", "Jaws", "The Best Years of Our Lives", "Infernal Affairs", "Udaan", "The Battle of Algiers", "Strangers on a Train", "Dog Day Afternoon", "Sin City", "Kind Hearts and Coronets", "Gangs of Wasseypur", "The Help"],
        //       callbacks        : {
        //           add    : console.log,  // callback when adding a tag
        //           remove : console.log   // callback when removing a tag
        //       }
        //   });


        // if ($(".flatpickr").length && flatpickr(".flatpickr", {
        //     disableMobile: !0
        // }),



        //     $(".file-input").length && $(".file-input").change((function () {
        //         var e = $(this).parent().parent().find(".image");
        //         console.log(e);
        //         var t = new FileReader;
        //         t.onload = function (t) {
        //             e.attr("src", t.target.result)
        //         }
        //             ,
        //             t.readAsDataURL(this.files[0])
        //     }
        //     )),
        //     $(".product").length)

        //     tns({
        //         container: "#product",
        //         items: 1,
        //         startIndex: 1,
        //         navContainer: "#product-thumbnails",
        //         navAsThumbnails: !0,
        //         autoplay: !1,
        //         autoplayTimeout: 1e3,
        //         swipeAngle: !1,
        //         speed: 400,
        //         controls: !1
        //     });

        if ($("#checkAll").length && $("#checkAll").on("click", (function () {
            $("input:checkbox").not(this).prop("checked", this.checked)
        }
        )),
            $("#do").length && dragula([document.querySelector("#do"), document.querySelector("#progress"), document.querySelector("#review"), document.querySelector("#done")]),
            $("#invoice").length && $("#invoice").find(".print-link").on("click", (function () {
                $.print("#invoice")
            }
            )),
            $(".sidebar-nav-fixed a").length && $(".sidebar-nav-fixed a").on("click", (function (e) {
                if (location.pathname.replace(/^\//, "") == this.pathname.replace(/^\//, "") && location.hostname == this.hostname) {
                    var t = $(this.hash);
                    (t = t.length ? t : $("[name=" + this.hash.slice(1) + "]")).length && (e.preventDefault(),
                        $("html, body").animate({
                            scrollTop: t.offset().top - 90
                        }, 1e3, (function () {
                            var e = $(t);
                            if (e.focus(),
                                e.is(":focus"))
                                return !1;
                            e.attr("tabindex", "-1"),
                                e.focus()
                        }
                        )))
                }
                $(".sidebar-nav-fixed a").each((function () {
                    $(this).removeClass("active")
                }
                )),
                    $(this).addClass("active")
            }
            )),
            $("#liveAlertPlaceholder").length) {
            var e = document.getElementById("liveAlertPlaceholder")
                , t = document.getElementById("liveAlertBtn");
            t && t.addEventListener("click", (function () {
                var t, n, o;
                t = "Nice, you triggered this alert message!",
                    n = "success",
                    (o = document.createElement("div")).innerHTML = '<div class="alert alert-' + n + ' alert-dismissible" role="alert">' + t + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
                    e.append(o)
            }
            ))
        }
        if ($("input[name=tags]").length) {
            var n = document.querySelector("input[name=tags]");
            new Tagify(n)
        }
    }(),
        feather.replace(); 
})