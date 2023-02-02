<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- csrf token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Board Exam</title>
  <!-- fontawsome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="/js/jquery-3.6.3.min.js" type="text/javascript"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
</head>

<body>
  <div class="container">
    <div class="row my-5">
      <div class="col-12">
        <label>Name</label>
        <input type="text" class="form-control" id="name">
      </div>
    </div>
    <!-- category select option  -->
    <div class="row my-3">
      <div class="col-12">
        <label>Title</label>
        <input type="text" class="form-control" id="title">
      </div>
    </div>
    <!-- contents -->
    <div class="row mt-5">
      <div class="col-12">
        <div id="editor"></div>
      </div>
    </div>
    <!-- 포스팅만들기 전송  -->
    <div class="row mt-2">
      <div class="col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button class="btn btn-success" type="button" id="submit">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <!--  ajax를 구현하기 위한 jquery cdn  -->
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
  <!-- ckeditor  -->
  <script>
    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });
  </script>
  <!-- ajax process  -->
  <script>
    // document가 전부 로드 되면 작동해라
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
      $('#submit').click(function () {
        let title = $("#title").val();
        let category_id = $("#category_id").val();
        let content = $(".ck-content").html();
        $.ajax({
          type: "POST",
          url: "/store", //요청 할 URL
          data: {
            _token: CSRF_TOKEN,
            title: title,
            category_id: category_id,
            content: content,
          }, //넘길 파라미터
          dataType: "JSON",
          success: function success(data) {
            //통신이 정상적으로 되었을때 실행 할 내용
            console.log(data.result);
            window.loaction.href = '/';
          },
          error: function (response) {
            console.log(response); //에러시 실행 할 내용
          }
        }); //end of ajax
      }); //end of submit
    }); //end of ready
  </script>
</body>

</html>