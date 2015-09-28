$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        fields: {
            rfid: {
                validators: {
                    notEmpty: {
                        message: 'Gelieve de RFID tag in te voeren'
                    },
                    numeric: {
                        message: 'Dit is een numeriek veld'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: 'Verplicht veld'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Verplicht veld'
                    }
                }
            }
        }
    }),
    $('#registrationForm').bootstrapValidator({
        fields: {
            rfid: {
                validators: {
                    notEmpty: {
                        message: 'Gelieve de RFID tag in te voeren'
                    },
                    numeric: {
                        message: 'Dit is een numeriek veld'
                    }
                }
            },
            name: {
                validators: {
                    notEmpty: {
                        message: 'Verplicht veld'
                    }
                }
            },
            balance: {
                validators: {
                    notEmpty: {
                        message: 'Dit is een numeriek veld'
                    },
                    numeric: {
                        message: 'Dit is een numeriek veld'
                    }
                }
            }
        }
    }),
    $('#reloadForm').bootstrapValidator({
        fields: {
            rfid: {
                validators: {
                    notEmpty: {
                        message: 'Gelieve de RFID tag in te voeren'
                    },
                    numeric: {
                        message: 'Dit is een numeriek veld'
                    }
                }
            },
            balance: {
                validators: {
                    notEmpty: {
                        message: 'Dit is een numeriek veld'
                    },
                    numeric: {
                        message: 'Dit is een numeriek veld'
                    }
                }
            }
        }
    }),
    $('#addUserForm').bootstrapValidator({
        fields: {
            rfid: {
                validators: {
                    notEmpty: {
                        message: 'Gelieve de RFID tag in te voeren'
                    },
                    numeric: {
                        message: 'Dit is een numeriek veld'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: 'Verplicht veld'
                    }
                }
            },
            fname: {
                validators: {
                    notEmpty: {
                        message: 'Verplicht veld'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Verplicht veld'
                    }
                }
            }
        }
    });

    $("#cash-submit").click(function(e){
        e.preventDefault();

        var rfid = $("#rfid").val();
        var totaal = $("#total").val();
        var error, message, balance;

        if(rfid == "")
            return false;

        $.ajax({
            async: false,
            type: 'GET',
            url: "api.php?act=checkbal&id=" + rfid,
            success: function(data) {
                var response = data[0];
                var detail = data[1];
                balance = detail;

                if(response == "Error") {
                    error = true;

                    switch(detail) {
                        case "Unknown ID":
                            message = "De ingegeven ID werd niet herkend door het systeem. (Stuur naar registratie!)";
                            break;

                        case "Access denied":
                            message = "Sessie is vervallen.. (Refresh)";
                            break;

                        default:
                            message = "Er is een generiek error opgetreden.. (Radio Arnaud ASAP!)";
                            break;
                    }
                }
            }
        });

        if(parseFloat(totaal) > parseFloat(balance)) {
            error = true;
            message = "De gebruiker heeft niet genoeg balans..";
        }

        if(error) {
            $("#result").html("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> " + message + "</div>");
            return false;
        }

        $(this).submit();
        return true;
    });
});

function addToPosTotal(name, price) {
    name = name.replace(/(<([^>]+)>)/ig,"");
    
    var total = parseFloat($("#total").val()) + price; 
    $("#total").val(total);
    $("#receipt").append('<tr class="adder" id="adder"><td>' + name + '</td><td id="price">' + price + '</td></tr>');
    $("#rfid").focus().select.trigger('focus').trigger('click');
}

function changeBalance(value) {
    var balanceField = parseFloat($("#balance").val());
    value = parseFloat(value);

    if(balanceField + value < 0)
        return false;

    $("#balance").val(balanceField + value);
}

function contactCardApi() {
    var rfid = $("#rfid").val();
    var totaal = $("#total").val();
    var error, message, balance;

    if(rfid == "")
        return false;

    $.ajax({
        async: false,
        type: 'GET',
        url: "api.php?act=checkbal&id=" + rfid,
        success: function(data) {
            var response = data[0];
            var detail = data[1];
            balance = detail;

            if(response == "Error") {
                error = true;

                switch(detail) {
                    case "Unknown ID":
                        message = "De ingegeven ID werd niet herkend door het systeem. (Stuur naar registratie!)";
                        break;

                    case "Access denied":
                        message = "Sessie is vervallen.. (Refresh)";
                        break;

                    default: 
                        message = "Er is een generiek error opgetreden.. (Radio Arnaud ASAP!)";
                        break;
                }
            }
        }
    });

    if(parseFloat(totaal) > parseFloat(balance)) {
        error = true;
        message = "De gebruiker heeft niet genoeg balans..";
    }

    if(error) {
        $("#result").html('<div class="notice error"><span class="glyphicon glyphicon-cross" aria-hidden="true"></span><strong>Error!</strong> ' + message + '</div>');
        return false;
    }

    return true;
}

function clearPos() {
    $("#total").val("0");
    $("#rfid").val("");
    $("#result").html("");
    $(".adder").remove();
}

function removeLastPos() {
    $("#adder").remove();

}

