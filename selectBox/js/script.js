function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}

var location_data = [];
var ilceler = [];
var semtler = [];
readTextFile("./locations.json", function(text) {
    location_data = JSON.parse(text);
});

function search(key, nameKey, myArray) {
    console.log(myArray);
    for (var i = 0; i < myArray.length; i++) {
        if (myArray[i][key] == nameKey) {
            return myArray[i];
        }
    }
}

$(document).ready(function() {
    setTimeout(() => {
        $.each(location_data, function(index, value) {
            $('#Iller').append($('<option>', {
                value: value.IL_ADI,
                text: value.IL_ADI
            }));
        });
    }, 1000);
    
    $("#Iller").change(function(){
        console.log(this.value);
        ilceler = search("IL_ADI", this.value, location_data);
        setTimeout(() => {
            console.log(ilceler);
            if ($('#Iller').val() != "") {
                $('#Ilceler').html('');
                $('#Ilceler').append($('<option>', {
                    value: 0,
                    text: 'Lütfen bir ilçe seçiniz'
                }));
                $('#Ilceler').prop("disabled", false);
                $.each(ilceler["ILCE"], function(index, value) {
                    $('#Ilceler').append($('<option>', {
                        value: value.ILCE_ADI,
                        text: value.ILCE_ADI
                    }));
                });
                return false;
            }
            $('#Ilceler').prop("disabled", true);
        }, 500);
    });
    $("#Ilceler").change(function(){
        console.log(this.value);
        semtler = search("ILCE_ADI", this.value, ilceler["ILCE"]);
        setTimeout(() => {
            console.log(semtler);
            if ($('#Ilceler').val() != "") {
                $('#Semtler').html('');
                $('#Semtler').append($('<option>', {
                    value: 0,
                    text: 'Lütfen bir semt seçiniz'
                }));
                $('#Semtler').prop("disabled", false);
                $.each(semtler["SEMT"], function(index, value) {
                    $('#Semtler').append($('<option>', {
                        value: value.SEMT_ADI,
                        text: value.SEMT_ADI
                    }));
                });
                return false;
            }
            $('#Semtler').prop("disabled", true);
        }, 500);
    });
});