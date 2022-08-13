$('#js-ajax-test').click(() => {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'test'
        },
        success: function (msg) {
            alert(msg.message);
        }
    })
});


$(function ($) {
    "use strict";
  
    $.ajaxSetup({
      dataType: "json",
    });
  
    
    $('#form').on('submit', function (e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        data.push(
          { name: "action", value: 'test' }
        );

        $.ajax({
            url: '/api/comments/create',
            method: "POST",
            data,
            beforeSend:  () => {
              $(this).find("button[type=submit]")
              .prop('disabled', true)
              .find('span')
              .removeClass('d-none')
            }
          })
            .done((res) => {
              
              if (res.success) {
                toast('Успешно', res.success)
                $('#list').prepend(`
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                      <div class="fw-bold">${res.name}</div>
                      <span class="float-end">${res.msg}</span>
                    </div>
                    <span class="badge bg-primary rounded-pill">${res.date}</span>
                  </li>
                `)
                $(this)[0].reset();
              }else{
                toast('Ошибка', res.error)
              }

              $(this).find("button[type=submit]")
                .prop('disabled', false)
                .find('span')
                .addClass('d-none')
            })
            .fail( (error) => {
              $(this).find("button[type=submit]")
                .prop('disabled', false)
                .find('span')
                .addClass('d-none')
              toast('Ошибка', 'Произошла ошибка')
            });
        
    });

});

function toast(title, message) {
  $('#liveToast').toast('show')
  .find('.me-auto').text(title)
  .end().find('.toast-body').text(message)
}
