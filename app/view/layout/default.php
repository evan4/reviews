<?php
use Imy\Core\Router;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Тестовое задание</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
  <main>
    <div class="container py-4">
      <header class="pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
          <span class="fs-4">Jumbotron example</span>
        </a>
      </header>
      <div class="row">
        <div class="col-md-6">
          <form id="form">
              <div class="mb-3">
                  <label for="name" class="form-label">Имя</label>
                  <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                  <label for="message" class="form-label">Отзыв</label>
                  <textarea name="message" class="form-control" id="message" cols="30"></textarea>
              </div>
              <button type="submit" class="btn btn-primary" id="button-submit">
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                Отправить
              </button>
          </form>
        </div>
        <div class="col-md-6">
          <ul class="list-group mt-2" id="list">
          <?php
           foreach ($reviews as $review) { ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
              <div class="ms-2 me-auto">
                <div class="fw-bold"><?=$review->name?></div>
                <span class="float-end"><?=$review->message?></span>
              </div>
              <span class="badge bg-primary rounded-pill"><?php
              $dateFormat = date_create($review->date);
              echo date_format($dateFormat,"d-m-Y");
              ?></span>
            </li>
          <?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </main>
  
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
      <div class="toast-header">
        <strong class="me-auto"></strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
      </div>
      <div class="toast-body"></div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/js/bootstrap.bundle.min.js"></script>
  <script src="/js/main.js"></script>
</body>
</html>
