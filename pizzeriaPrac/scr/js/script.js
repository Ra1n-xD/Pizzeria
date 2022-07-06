$(document).ready(function () {
    // Админ-панель
    function setFormHTML(data) {
        return `
        <form id="editDbItem">
            <h3>Обновление продукта ${data.NAME} </h3>
            <p>Новое название
                <input type='text' class="newName" value='${data.NAME}' />
                <input type='hidden' class="previousName" value='${data.NAME}' />

            </p>
            <p>Новая стоимость
                <input type='text' class="newCost" value='${data.PRICE}' />
                <input type='hidden' class="previousCost" value='${data.PRICE}' />
            </p>
            <input class="btn btn-success btnSave" type='submit' value='Сохранить' />
        </form>
        <div id="error"></div>
        `;
    }

    $('body').on('click', '.btnUpdate', function (e) {
        let itemName = $(this).parent().parent().find('.itemName').text().trim();
        let data = new FormData();
        data.append('itemName', itemName);
        $.ajax({
            data: data,
            type: 'POST',
            url: '../php/getProduct.php',
            contentType: false,
            processData: false,
            success: function (getData) {
                let parsedData = jQuery.parseJSON(getData);
                let formHTML = setFormHTML(parsedData);
                $('#updateForm').html(formHTML);
            },
        });
    });

    $('body').on('submit', '#editDbItem', function (e) {
        e.preventDefault();

        let newName = $(this).find('.newName').val();
        let newCost = $(this).find('.newCost').val();
        let previousCost = $("#editDbItem").find('.previousCost').val();
        let previousName = $("#editDbItem").find('.previousName').val();

        let data = new FormData();
        data.append('newName', newName);
        data.append('newCost', newCost);
        data.append('previousName', previousName);
        data.append('previousCost', previousCost);

        $.ajax({
            data: data,
            type: 'POST',
            url: '../php/updateProduct.php',
            contentType: false,
            processData: false,

            beforeSend: function () {
                $('#error').text("");
            },

            success: function (getData) {
                let parsedData = jQuery.parseJSON(getData);
                if (parsedData.status == 'success') {
                    location.reload();
                } else {
                    $('#error').html('<div class="alert mt-2 alert-danger">Ошибка, введите название услуги!!!</div>');
                }
            },
        });
    });

    $('body').on('click', '.btnDelete', function (e) {
        e.preventDefault();

        let itemId = +$(this).parent().parent().parent().find('.itemId').text().trim();
        let data = new FormData();
        console.log(itemId);
        data.append('itemId', itemId);

        $.ajax({
            data: data,
            type: 'POST',
            url: '../php/deleteProduct.php',
            contentType: false,
            processData: false,
            success: function (getData) {
                location.reload();
            },
        });
    });

    $(".btnAdd").click(function (e) {
        e.preventDefault();

        let addName = $(this).parent().find('.addName').val();
        let addCost = $(this).parent().find('.addCost').val();

        let data = new FormData();
        data.append('addName', addName);
        data.append('addCost', addCost);

        $.ajax({
            data: data,
            type: 'POST',
            url: '../php/addProduct.php',
            contentType: false,
            processData: false,
            success: function (getData) {
                location.reload();
            },
        });
    });

    // Карусель
    $('.owl-carousel').owlCarousel({
        loop: true,
        center: true,
        autoWidth: true,
        margin: 20,
        nav: false,
        items: 1,
    });

    // Ргеитрация\авторизация
    $('.login-btn').click(function (e) {
        e.preventDefault();
        let emailAuth = $('input[name="emailAuth"]').val(),
            passwordAuth = $('input[name="passwordAuth"]').val();

        $.ajax({
            url: '../php/signin.php',
            type: 'POST',
            dataType: 'json',
            data: {
                emailAuth: emailAuth,
                passwordAuth: passwordAuth,
            },
            success(data) {
                if (data.status === 'user') {
                    // $('.messege-auth').text("ne admin");
                    document.location.href = 'index.php';
                } else if (data.status === 'admin') {
                    // $('.messege-auth').text("admin");
                    document.location.href = 'index.php';
                } else {
                    $('.messege-auth').text(data.message);
                    $('input[name="passwordAuth"]').val("");
                }
            }
        });
    });

    $('.register-btn').click(function (e) {
        e.preventDefault();
        let email = $('input[name="email"]').val(),
            password = $('input[name="password"]').val(),
            passwordConfirm = $('input[name="passwordConfirm"]').val(),
            name = $('input[name="name"]').val();

        $.ajax({
            url: '../php/signup.php',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password,
                passwordConfirm: passwordConfirm,
                name: name,
            },
            success(data) {
                if (data.status) {
                    console.log(data);
                    document.location.href = 'login.php';
                    $(".messege-regi").addClass("text-primary");
                    $('.messege-regi').text(data.message);
                } else {
                    $(".messege-regi").addClass("text-danger");
                    $('.messege-regi').text(data.message);
                    $('input[name="password"]').val("");
                    $('input[name="passwordConfirm"]').val("");
                }
            }
        });
    });

    // Работа с заказом
    $('.final-order').click(function (e) {
        e.preventDefault();
        let adress = $('input[name="adress"]').val();
        let isPaied = 1;
        console.log(adress);
        $.ajax({
            url: '../php/create-order.php',
            type: 'POST',
            dataType: 'json',
            data: {
                adress: adress,
                isPaied: isPaied,
            },
            success: function () {
                document.location.href = 'profile.php';
            }
        });
    });

    // Работа с карзиной
    function showCart(cart) {
        $('#cart-modal .modal-cart-content').html(cart);
        // $('#cart-modal').modal();
        let cartQty = $('#modal-cart-qty').text() ? $('#modal-cart-qty').text() : "";

        if (cartQty == "") {
            $('.mini-cart-qty').text(``);
        } else {
            $('.mini-cart-qty').text(` | ${cartQty}`);
        }
    }

    $('.check-receipt').on('click', function (e) {
        e.preventDefault();
        console.log($(this).text());
        // $.ajax({
        //     url: '../php/cart.php',
        //     type: 'GET',
        //     data: {
        //         cart: 'show',
        //     },
        //     success: function (res) {
        //         showCart(res);
        //     },
        //     error: function () {
        //         alert('Error');
        //     }
        // });
    });

    $('.add-to-cart').on('click', function () {
        // e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '../php/cart.php',
            type: 'GET',
            data: {
                cart: 'add',
                id: id
            },
            dataType: 'json',
            success: function (res) {
                // console.log(res);
                if (res.code == 'ok') {
                    showCart(res.answer);
                } else {
                    alert(res.answer);
                }
            },
            error: function () {
                alert('Error');
            }
        });
    });

    $('#get-cart').on('click', function (e) {
        e.preventDefault();

        $.ajax({
            url: '../php/cart.php',
            type: 'GET',
            data: {
                cart: 'show',
            },
            success: function (res) {
                showCart(res);
            },
            error: function () {
                alert('Error');
            }
        });
    });

    $('#cart-modal .modal-cart-content').on('click', '#clear-cart', function (e) {
        e.preventDefault();

        $.ajax({
            url: '../php/cart.php',
            type: 'GET',
            data: {
                cart: 'clear',
            },
            success: function (res) {
                console.log(res);
                showCart(res);
            },
            error: function () {
                alert('Error');
            }
        });
    });


});

// action="singin.php" method="POST"