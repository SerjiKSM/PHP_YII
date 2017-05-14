/*price range*/

 $('#sl2').slider();

// ksm+
$('.catalog').dcAccordion({
    speed: 300
});

// $('.catalog').dcAccordion();
// ksm-

// ksm+ // for cart



function showCart(cart) {

    $('#cart .modal-body').html(cart);
    $('#cart').modal();

}

function clearCart(){
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');
            // console.log(res);

            showCart(res);

        },
        error: function(){
            alert('Error!');
        }
    });
}

$('.add-to-cart').on('click', function (e) {

    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
        url: '/cart/add',
        data: {id: id},
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');

            //console.log(res);
            showCart(res);
        },
        error: function(){
            alert('Error1!');
        }
    });
});

$('#cart .modal-body').on('click', '.del-item', function () {
    var id = $(this).data('id');
    //console.log(id);

    $.ajax({
        url: '/cart/del-item',
        data: {id: id},
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');
            //console.log(res);
            showCart(res);
        },
        error: function(){
            alert('Error!');
        }
    });

});

function getCart() {
    $.ajax({
        url: '/cart/show-cart',
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');
            //console.log(res);
            showCart(res);
        },
        error: function(){
            alert('Error!');
        }
    });
    return false;
}

function addProductToCart(id) {

    var quantity = $("#quantity").val();

    $.ajax({
        url: '/cart/add',
        data: {quantity: quantity, id:id},
        type: 'GET',
        success: function(res){
            if(!res) alert('Ошибка!');
            //console.log(res);
            showCart(res);
        },
        error: function(){
            alert('Error!');
        }
    });
}

// $(function() { // после загрузки страницы
//
//     init();
//
// });
//
// function init() {
//
//     $(document).on("click", '.del-item',
//         function() { // к какому элементу привязывать отправку
//
//             if (confirm('Вы уверены, что хотите удалить данную строку?')) {
//                 // элемент имеет атрибут data-tiket-id="n",
//                 // где n - ключ удаляемой из базы записи
//
//                 var id = $('table tbody tr').data('id');
//                 alert(id);
//                 // alert($('#tr_2').html());
//
//                  // var controlId = $('tr').data('id');
//                  // alert(controlId);
//
//                 // var data = {'ticket-id': controlId};
//                 //  var url = '/cart/clearRow';   // куда отправлять
//                 //
//                 //  sendAjax(url, data, controlId);
//                 //  return false;
//
//                 ///////////////////////////////////
//                 // $('#tr_2').remove();
//
//             }
//         });
// }
//
// function sendAjax(url, data, controlId)
// {
//     $.ajax({ //  сам запрос
//         type: 'POST',
//         url: url,
//         data: data, // данные которые передаём  серверу
//         dataType: "json" // предполоижтельный формат ответа сервера
//     }).done(function(res) { // если успешно
//
//         console.log('Ответ получен: ', res);
//
//         if (res.success) { // если все хорошо
//             console.log('ОК!)');
//             $('tr#row-' + controlId).removeSmoothly(); // строка имеет id вида "row-17"
//
//         } else { // если не нравится результат
//             console.log('Пришли не те данные!');
//             console.log(res.message);
//         }
//     }).fail(function() { // если ошибка передачи
//         console.log('Ошибка выполнения запроса!');
//     });
// }
// ksm-

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
