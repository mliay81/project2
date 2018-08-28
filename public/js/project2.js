$( document ).ready(function() {
    console.log( "ready!" );


// API call to get drinks from external db
$("#submit").click(function() {
    event.preventDefault();
    var drink = $("#drink").val().trim()
    var queryURL = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=" + drink
    $.ajax({
        url: queryURL,
        method: "GET"
    }).then(function(response) {
        console.log(response)
        var drinkListHTML = []
        for (var i=0; i < response.drinks.length; i++) {
            console.log(response.drinks.length)

            var ingredients = []
            var measurements = []
            var instructions = []

            // Pulling values out of specific JSON keys
            Object.keys(response.drinks[i]).forEach(function(key) {
                var currentKeyValue = response.drinks[i][key]

                if (currentKeyValue && key.toLowerCase().includes("ingredient")) {
                    ingredients.push(response.drinks[i][key])
                    // console.log(key)
                }
                if (currentKeyValue && key.toLowerCase().includes("measure")) {
                    //    console.log(key)
                    measurements.push(response.drinks[i][key])
                }

                if (currentKeyValue && key.toLowerCase().includes("instructions")) {
                    instructions.push(response.drinks[i][key])
                }
            })

            var newArray = measurements.map((e, i) => e + " " + ingredients[i])
            var com = newArray.join(", ")



            // Creates the measurement/ingredient list
            function makeUL(array) {
                console.log("whats array:");
                console.log(array);
                array = array.filter(e => !e.match(/undefined/))
                // array = array.filter(e => !!e)
                var list = document.createElement("ul")

                for (var i = 0; i < array.length; i++) {
                    var item = document.createElement("li")

                    item.appendChild(document.createTextNode(array[i]))

                    list.appendChild(item)
                }

                return list

            }

            // Pushes everything to the DOM

            var finalDrink = $("<div id='final'></div>")
            $("#final").empty();

            // Name
            var name = $("<h3>").text(response.drinks[i].strDrink)
            $("#final").append(name)
            // console.log(name)

            // Recipe instructions
            var recipe = $("<p>").text(response.drinks[i].strInstructions)
            $("#final").append(recipe)

            // Image
            var pic = $("<img>").attr("src", response.drinks[i].strDrinkThumb)
            $("#final").append(pic)

            drinkListHTML.push(name, recipe)
            $("#measurements").append(name)
            $("#measurements").append(makeUL(com.split(",")))
            $("#measurements").append(recipe)
            $("#measurements").append(pic)
            $("#measurements").append("<hr>")


        }

    })

});

// })



});